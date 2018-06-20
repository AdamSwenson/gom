//The name of the tested component
var compName = 'tag-display';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/tags/tag-display.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test, numTags;
    let payload, exam, item, kumi, kumis, student, grade, tag, tags;

    beforeEach( () => {
        numTags = 5;
        item = factories.itemFactory();
        tags = factories.makeTags( numTags );

        actions = {
            createAndAssociateTag: sinon.spy()
        }

        getters = {
            getItemBySerialNumber: () => () => item
        };

        mutations = {
            [ mTypes.associateTag ]: sinon.spy(),
                [ mTypes.disassociateTag ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        //not a shallow mount because we need to see the tag objects
        wrapper = mount( Component, {
            store, localVue
        } );
        item.tags = tags;
        wrapper.setProps( { object: item } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "computed properties -- tags", () => {
        let elementSelector = '.object-tag-list';
        it( "displays the tags stored on the object", ( done ) => {

            //not a shallow mount because we need to see the tag objects
            // wrapper = mount( Component, {
            //     store, localVue, propsData: {
            //         object : item
            //     }
            // } );
            //
            _.forEach( tags, function ( tag ) {
                assertions.assertThatSeeText( wrapper, tag.name, elementSelector );
            } )
            done();
        } );
        it( 'displays nothing (and does not freak out) if no tags stored on item', () => {
            item.tags = [];
            expect( wrapper.find( 'tag-object' ).exists() ).toBe( false );

        } )
    } )

    describe( "methods", () => {
        describe( 'filterDisplayedTagsBy', () => {
        } );


        describe( 'handleEditClick', () => {
            it( 'shows the tag menu when clicked', () => {
                wrapper.setData({showTagMenu: false});
                //check that starting with menu invisible
                // expect( wrapper.contains('.tag-menu')).toBe(false); //.not.toContain( 'tag-menu' );

                // wrapper.setData({isNewTagInputVisible: true});
                wrapper.find( '.edit-tag-button' ).trigger( 'click' );
                expect(wrapper.vm.showTagMenu).toBe(true);
                // expect( wrapper.contains('div.tag-menu')).toBe(true);
                // expect( wrapper.classes()).toContain( 'tag-menu' );

            } );


        } );

        describe( 'handleDeleteClick', function () {
            it( 'commits correct mutation', () => {
                let t = tags[ 1 ];
                wrapper.vm.handleRemoveClick( t );
                expect( mutations[ mTypes.disassociateTag ].callCount ).toBe( 1 );
            } );
        } );


        describe( 'handleTagToggle', function () {
            it( 'commits mutation to associate if not already associated', () => {
                tag = factories.tagFactory();
                wrapper.vm.handleTagToggle(tag);
                expect(mutations[mTypes.associateTag].callCount).toBe(1);
            } );

            it( 'commits mutation to disassociate if already associated', () => {
                tag = tags[1];
                wrapper.vm.handleTagToggle(tag);
                expect(mutations[mTypes.disassociateTag].callCount).toBe(1);
            } );
        } );


    } )


} );
