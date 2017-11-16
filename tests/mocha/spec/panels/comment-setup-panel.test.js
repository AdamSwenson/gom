import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import Item from "./../../../../resources/assets/js/models/Item";
import Comment from "./../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../resources/assets/js/store/mutation-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/panels/comment-setup-panel.vue" );


describe( "comment-setup-panel  ", () => {

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let testTextString = "test text for ";

    beforeEach( () => {
        item = new Item();


        routeSerialNumber = item.serialNumber;
        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            }
        };

        mutations = {
            [mTypes.updateComment]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = routeSerialNumber;

        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );


    } );

    it( "checks test has been set up properly ", () => {
        expect( store.getters.getItemBySerialNumber() ).toBe( item );
    } );

    // it( 'has the serial number passed in as a prop ', () => {
    //
    // $route.params.serialNumber= ()=> 99;
    //
    // let wrapper = shallow( Component, {
    //     store, localVue,
    //     stubs: ['router-link', 'router-view'],
    //     mocks: {
    //         $route
    //     }
    // } );
    //
    // // wrapper.setProps( { dataSerialNumber: item.serialNumber } );
    // expect( wrapper.vm.serialNumber).toBe( 99 );
    // } );

    it( " has serial number from route ", () => {
        expect( wrapper.vm.serialNumber ).toBe( item.serialNumber );
    } );

    it( 'displays the expected default on first load', () => {
        expect( wrapper.vm.displayed ).toBe( 'stock' )
    } );

    it.skip( " displays the intended text when the valence buttons are clicked ", () => {
        _.forEach( Comment.valences, function ( valence ) {
            item.comments[ valence ] = testTextString + valence;
        } );
        _.forEach( Comment.valences, function ( valence ) {
            wrapper.vm.displayed = valence;
            wrapper.trigger( 'input' );
            expect( wrapper.html() ).toContain( testTextString + valence );
        } );
    } );

    it( " updates the stored comments with prepopulated content when the stock comment is populated ", () => {
        let newText = Faker.company.bs();
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
        let pl = spy.args[0][1];
        // window.console.log( 'comment-setup-panel.test', '', 122, pl );
        expect(Payload.checkIfPayload(pl)).toBe(true);
        expect(pl.obj).toBe(item);
        expect(pl.updateValence).toBe('stock');
        expect(pl.updateVal).toBe(newText);

        //The next set of tests cover the
        //prepopulation process.
        //If things went as planned, the mutation
        //should have been called once for each valence
        expect( mutations[ mTypes.updateComment ].callCount ).toBe( _.size( Comment.valences ));
        //Each of those calls should've had the prepopulated text
        //in its payload.
        let i = 0;
        _.forEach(Comment.valences, function ( valence ) {
            if(i >= 1 ) { //skipping over stock since that won't have been pre-populated
                let pl2 = spy.args[ i ][ 1 ];
                expect( Payload.checkIfPayload( pl2 ) ).toBe( true );
                expect( pl2.obj ).toBe( item );
                expect( pl2.updateValence ).toBe( valence );
                expect( pl2.updateVal ).toBe( Comment.makePrePopulatedContent( valence, newText ) );
                i++;
            }
        });


    } );


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


} );


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
