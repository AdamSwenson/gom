//The name of the tested component
var compName = 'note-object';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/notes/note-object.vue' );


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
        actions = {};
        getters = {
            getItemBySerialNumber: () => () => factories.itemFactory()
        };

        mutations = {
            [ mTypes.updateNote ]: sinon.spy(),
            [ mTypes.destroyNote ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue,
            propsData: {
                serialNumber: 8763,
                useCentralStore: true,
                object: note,
                note: note
            }
        } );

        wrapper.setData( { isEditable: true } )
    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "computed properties", () => {
        describe( 'name', () => {
            it( "calls expected mutation when text entered", () => {
                let text = 'taco';
                wrapper.vm.name = text;
                // helpers.type( wrapper, '.note-name', text );
                // check
                expect( mutations[ mTypes.updateNote ].calledOnce ).toBe( true );
            } );
        } );

        describe( 'note', () => {

        } );
        describe( 'priority', () => {

        } );
        describe( 'props', () => {

        } );
        describe( "text", () => {
            it( "calls expected mutation when text entered", () => {
                let text = 'taco';
                wrapper.vm.text = text;

                // expect(wrapper.find('.note-text').exists()).toBe(true);
                // wrapper.find( '.note-text' ).element.value = text;
                // wrapper.find( '.note-text' ).trigger( 'input' );
                // helpers.type( wrapper, '.note-text', text );
                // // check
                expect( mutations[ mTypes.updateNote ].calledOnce ).toBe( true );
            } );
        } );

    } )

    describe( "methods", () => {

        it( "calls for correct mutation when delete clicked", () => {
            wrapper.setData( { isEditable: false } )

            wrapper.find( '.delete-note' ).trigger( 'click' );
            expect( mutations[ mTypes.destroyNote ].calledOnce ).toBe( true );
        } )
    } )


} );
