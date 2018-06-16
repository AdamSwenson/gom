//The name of the tested component
var compName = 'tag-menu';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/tags/tag-menu.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


import requests, { loadTagsForItemRequest } from '../../../../resources/assets/js/api/requests/tagRequests';
//tested object


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade, tag, tags, numTags, requestStub;

    requestStub = sinon.stub( requests, 'loadAllUserTagsRequest' );
    requestStub.resolves( tags );

    beforeEach( () => {
        numTags = 5;
        item = factories.itemFactory();
        tags = factories.makeTags(5);

        actions = {
            loadAllUserTagsFromServer: sinon.stub(),
            createAndAssociateTag: sinon.stub()
        }
        actions.loadAllUserTagsFromServer.resolves(true);

        getters = {
            getItemBySerialNumber: (  ) => (  ) => item,
            [gTypes.getAllTags] : sinon.stub()
        };
        getters[gTypes.getAllTags].returns(tags);

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: {
                object : item
            },
            sync: false
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'async computed properties', () => {
        describe( "tags", () => {
            it( "dispatches the expected action ", (done) => {
                expect(actions.loadAllUserTagsFromServer.callCount).toBe(1);
                expect(wrapper.vm.tags).toBe(tags);
                done();
            } );
        } )
    } );

    describe( "methods", () => {
        describe( 'filterDisplayedTagsBy', () => {} );

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

        } );

        describe( 'filterDisplayedTagsBy', function () {

        } );

        describe( 'handleSearch', function () {

        } );

        describe( 'saveNewTag', () => {
            it( 'dispatches expected action', () => {
                wrapper.vm.saveNewTag();
                expect( actions.createAndAssociateTag.calledOnce ).toBe( true );
            } );

        } );

    } )


} );
