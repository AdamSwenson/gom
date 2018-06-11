//The name of the tested component
var compName = 'notes-panel';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/notes/notes-panel.vue' );


require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade, note;

    beforeEach( () => {
        note = factories.noteFactory();
        item = factories.itemFactory();

        let $route = { params: { serialNumber: 44 } };

        actions = { createNewNote: sinon.spy() }

        getters = {
            getNewNote: () => () => note,
            getItemBySerialNumber: () => () => item,
        };

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue, mocks: { $route }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'asyncComputed', () => {
        it.skip( "async gets notes", () => {

        } );

        it.skip( "refreshes the notes store when loadTrigger is incremented", () => {

        } );
    } );


    describe( "methods", () => {
        describe( 'addNewNote', () => {
            it( " calls for the correct action when called programmatically", () => {
                wrapper.vm.addNewNote();
                expect( actions.createNewNote.calledOnce ).toBeTruthy();
            } );
        } );

        describe( 'saveNewNote', () => {
            it.skip( " calls for the correct mutation when called programmatically", () => {
            } );
        } );

        describe( 'clearNewNote', () => {
        } );


    } )


} );
