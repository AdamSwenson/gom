//The name of the tested component
import { factories } from "../../../spec/helpers/vuex.spec.helpers";

var compName = 'tags-menu';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/tags/tags-menu.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        item = factories.itemFactory();
        actions = {
            createAndAssociateTag: sinon.spy()
        }

        getters = {
            getItemBySerialNumber: (  ) => (  ) => item
        };

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: {
                objectSerialNumber: 939,
                objectType: 'item'
            }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'async computed properties', () => {
        describe( "tags", () => {
            it.skip( "retrieves the tags async", () => {

            } );
        } )
    } );

    describe( "methods", () => {
        describe( 'filterDisplayedTagsBy', () => {} );

        describe( 'saveNewTag', () => {
            it( 'dispatches expected action', () => {
                wrapper.vm.saveNewTag();
                expect( actions.createAndAssociateTag.calledOnce ).toBe( true );
            } );

        } );
        describe( 'handleNewClick', () => {
            it( 'dispatches actions when clicked', () => {
                wrapper.setData({isNewTagInputVisible: true});
                wrapper.find( '.new-tag-button' ).trigger( 'click' );
                expect( actions.createAndAssociateTag.calledOnce ).toBe( true );
            } );

            it( 'cleans up the edit area', () => {
                wrapper.setData({isNewTagInputVisible: true});

                wrapper.find( '.new-tag-button' ).trigger( 'click' );
                expect(wrapper.vm.newTagText).toBe('');
                expect(wrapper.vm.newTagName).toBe('');
                expect(wrapper.vm.priority).toBe(1);
                expect(wrapper.vm.isNewTagInputVisible).toBe(false);
            } );

        } )

    } )


} );
