
require('../../injectglobals');
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/setup/comment-setup-panel.vue" );


describe( "comment-setup-panel  ", () => {

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null }, path: 'taco' };
    let wrapper;
    let routeSerialNumber, $parent;
    let testTextString = "test text for ";


    beforeEach( () => {
        item = factories.itemFactory();
        routeSerialNumber = item.serialNumber;

        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => item
        };

        mutations = {
            [ mTypes.updateComment ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );


        $route.params.serialNumber = item.serialNumber;
        $parent = { serialNumber: item.serialNumber};

        wrapper = mount( Component, {
            store, localVue,
            // stubs: [ 'router-link', 'router-view' ],
            // mocks: {
            //     $route,
            //     $parent
            // }
        } );

    } );

    describe( " loads into expected default state for testing ", () => {
        it( 'properly displays the component', () => {
            // expect( wrapper.exists() ).toBe( true);
            expect( wrapper.find( 'div' ).exists() ).toBe( true );
        });
        //
        // // wrapper.setProps( { dataSerialNumber: item.serialNumber } );
        // expect( wrapper.vm.serialNumber).toBe( 99 );
        // } );

        it( " has serial number from route ", () => {
            expect( wrapper.vm.serialNumber ).toBe( item.serialNumber );
        } );

        it( 'displays the expected default on first load', () => {
            expect( wrapper.find( '.comment-setup-panel' ).isEmpty() ).toBe( false );
            expect( wrapper.vm.displayed ).toBe( 'stock' )

        } );

        it( ' changes the shouldPrePopulate state when the control is toggled ', () => {
            wrapper.find( '#prepopulationControl' ).element

        } );

    } );

    describe( " displays appropriate comment text in response to events   ", () => {
        let expected = {};

        beforeEach( () => {
            item = factories.itemFactory();

            getters = {
                getItemBySerialNumber: ( v ) => ( v ) => item
            };


            store = new Vuex.Store( {
                getters,
                mutations
            } );

            $route.params.serialNumber = item.serialNumber;

            //start by populating the comment text of the item
            //and storing it in the expected object
            _.forEach( Comment.valences, function ( valence ) {
                let text = faker.company.bs();
                item.addComment( valence, Comment.factory( { text, valence } ) );
                expected[ valence ] = text;
            } );

            wrapper = shallow( Component, {
                store, localVue,
                stubs: [ 'router-link', 'router-view' ],
                mocks: {
                    $route,
                    $parent
                }
            } );

            // setupForItem( item );

        } );

        it( " displays the expected comment text when the displayed valence value changes ", () => {

            _.forEach( Comment.valences, function ( valence ) {
                //manually update the displayed valence
                wrapper.vm.displayed = valence;

                //Check that all the internal properties
                //updated themselves properly
                expect( wrapper.vm.displayed ).toBe( valence );
                expect( wrapper.vm.displayedValence ).toBe( valence );
                expect( wrapper.vm.item ).toBe( item );
                expect( wrapper.vm.commentText ).toBe( expected[ valence ] );
                //force the component to update
                wrapper.update();
                //check that it is displayed
                expect( wrapper.find( '.comment-text' ).element.value ).toBe( expected[ valence ] );
            } );
        } );
    } );

    describe( " haveCommentsBeenCustomized behaves properly", () => {
        beforeEach( () => {
        } );

        it( " returns true when any one comment is not stock based ", () => {
            let stock = faker.company.bs();

            _.forEach( global.Comment.valences, function ( valence ) {
                if ( valence === 'stock' ) {
                    item.addComment( valence, Comment.factory( { valence: valence, text: stock } ) );
                } else {
                    item.addComment( valence, Comment.factory( {
                        valence: valence,
                        text: Comment.makePrePopulatedContent( valence, stock )
                    } ) );
                }
            } );

            //choose one valence randomly
            //and update its text
            let toChange = getRandomNonStockValence();
            let comment = Comment.factory( { valence: toChange, text: faker.company.bs() } );
            item.addComment( toChange, comment );
            //check that it worked
            expect( item.getComment( toChange ) ).toBe( comment );

            // setupForItem( item );

            wrapper.update();

            //test the function
            expect( wrapper.vm.haveCommentsBeenCustomized ).toBe( true );

        } );

        it( " returns false when all comments are unset  ", () => {
            setupForItem( item );
            expect( wrapper.vm.haveCommentsBeenCustomized ).toBe( false );
        } );

        it( " returns false when all comments are stock-based ", () => {
            let stock = faker.company.bs();
            _.forEach( Comment.valences, function ( valence ) {
                if ( valence !== 'stock' ) {
                    item.addComment( valence, Comment.factory( { text: Comment.makePrePopulatedContent( valence, stock ) } ) );
                }
            } );
            expect( wrapper.vm.haveCommentsBeenCustomized ).toBe( false );
        } );
    } );

    describe( " prepopulation and handling of user edited text ", () => {

        beforeEach( () => {
            item = factories.itemFactory();
            // setupForItem( item );
        } );


        it( " updates the stored comments with prepopulated content when the stock comment is populated ", () => {
            let newText = faker.company.bs();
            type( '.comment-text', newText );

            // Since the component has not been installed normally
            // vuex won't do its job. Thus we just want to check that
            // the expected mutations were called.
            //To save our fingers, let's grab the mutation spy
            let spy = mutations[ mTypes.updateComment ];

            //The first set of tests are for whether the call
            //went out to update the stock comment.
            //We start by checking that it was called at least once
            expect( spy.called ).toBe( true );
            //Then we check that the mutation was called with
            //the correct payload
            //Remember, it thinks the spy is a getter so it passes
            // the state as first arg to the spy.
            // Thus spy.args[0] is [{}, payload]
            let pl = spy.args[ 0 ][ 1 ];
            // window.console.log( 'comment-setup-panel.test', '', 122, pl );
            expect( Payload.checkIfPayload( pl ) ).toBe( true );
            expect( pl.obj ).toBe( item );
            expect( pl.updateValence ).toBe( 'stock' );
            expect( pl.updateVal ).toBe( newText );

            //The next set of tests cover the
            //prepopulation process.
            //If things went as planned, the mutation
            //should have been called once for each valence
            expect( mutations[ mTypes.updateComment ].callCount ).toBe( _.size( Comment.valences ) );
            //Each of those calls should've had the prepopulated text
            //in its payload.
            let i = 0;
            _.forEach( Comment.valences, function ( valence ) {
                if ( i >= 1 ) { //skipping over stock since that won't have been pre-populated
                    let pl2 = spy.args[ i ][ 1 ];
                    expect( Payload.checkIfPayload( pl2 ) ).toBe( true );
                    expect( pl2.obj ).toBe( item );
                    expect( pl2.updateValence ).toBe( valence );
                    expect( pl2.updateVal ).toBe( Comment.makePrePopulatedContent( valence, newText ) );
                    i++;
                }
            } );
        } );

        it( " refuses to prepopulate from stock when shouldPrePopulate is false  ", () => {

            //set var to false
            wrapper.vm.shouldPrePopulate = false;
            wrapper.update();

            //enter in text
            let newText = faker.company.bs();
            type( '.comment-text', newText );

            // Since the component has not been installed normally
            // vuex won't do its job. Thus we just want to check that
            // the expected mutations were called.
            //To save our fingers, let's grab the mutation spy
            let spy = mutations[ mTypes.updateComment ];

            //The spy should have been called exactly once
            // i.e., when the stock was updated.
            expect( spy.callCount ).toBe( 1 );
        } )

        it( "refuses to change content that has been edited by the user without the user explictly intending that to happen " );


    } );

    //keeping the below in scope....
/**
 * Creates the store and mounts the
 * component for the given item
 * @param item
 */
let setupForItem = ( item ) => {

    getters = {
        getItemBySerialNumber: ( v ) => ( v ) => {
            return item;
        }
    };

    mutations = {
        [ mTypes.updateComment ]: sinon.spy()
    };

    store = new Vuex.Store( {
        getters,
        mutations
    } );

    $route.params.serialNumber = item.serialNumber;


    wrapper = shallow( Component, {
        store, localVue,
        stubs: [ 'router-link', 'router-view' ],
        mocks: {
            $route
        }
    } );

};


/**
 * Types the text into the field identified by selector
 * @param selector
 * @param text
 */
let type = ( selector, text ) => {
    wrapper.find( selector ).element.value = text;
    wrapper.find( selector ).trigger( 'input' );
};

/**
 * Asserts that the specified text is present within
 * the specified selector or page if no selector is
 * specified
 * @param text
 * @param selector
 */
let see = ( text, selector ) => {
    let wrap = selector ? wrapper.find( selector ) : wrapper;
    expect( wrap.html() ).toContain( text );
};

/**
 * Returns a random element from the Comment.valences
 * array with the exception of stock, which it never returns.
 * @returns string
 */
let getRandomNonStockValence = () => {
    return _.take( _.shuffle( _.drop( Comment.valences ) ) )[ 0 ];

}

} )
;


//
//     beforeEach(  ()=> {
// //runs before each test
// //         let component = mount( commentPanel );
//
//     })

// wrapper.vm // the mounted Vue instance


//
// describe( "computed properties ", () => {
//
//     it( 'displays the expected default on first load',  ()=> {
//        // let component = mount( commentPanel );
//
//         expect( wrapper.vm.displayed ).toBe( 'stock' )
//
//         expect( true ).toBe( true );
//     } );
//
// } );
//
// describe(  "methods" , function () {
//     beforeEach( function () {
//         let component = mount( commentPanel );
//
//     } );
//
//     it( 'prePopulateComments | ', function () {
//         expect( true ).toBe( true );
//     } );
// } );
// } );
