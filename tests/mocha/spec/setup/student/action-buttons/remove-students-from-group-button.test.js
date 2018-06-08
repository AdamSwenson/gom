//The name of the tested component
var compName = 'remove-students-from-group-button';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/development/components/setup/student/action-buttons/remove-students-from-group-button.vue' );


require( '../../../../injectglobals' );
import PayloadModal from "../../../../../../resources/assets/js/models/PayloadModal";


import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '#remove-students-from-group-button';

    let actions, getters, mutations;
    let store;
    let wrapper;

    let studentGetterStub;

    let students, kumis;

    let actionName = 'removeStudentsFromRoster';

    beforeEach( () => {
        studentGetterStub = sinon.stub();
        students = [ factories.studentFactory() ];
        studentGetterStub.returns( students );
        kumis = factories.makeKumis(2);

        getters = {
            [ nggTypes.getSelectedStudents ]: () => students,
            'getSelectedKumis': (  ) => kumis

        };

        mutations = {
            toggleConfirmationModal: sinon.spy(),
            toggleErrorModal: sinon.spy(),
            clearSelectedStudents: sinon.spy(),
            clearSelectedKumis: sinon.spy()
        };

        actions = {
            [ actionName ]: sinon.spy()
        }

        store = new Vuex.Store( {
            actions, getters, mutations
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load (actions are tested in mixin)', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " when button is clicked ", () => {
        it( 'displays the confirmation modal', () => {
            wrapper.trigger( 'click' );
            //check
            let pl = PayloadModal.factory( {
                text: wrapper.vm.confirmationModalText,
                confirmationCallback: wrapper.vm.handleConfirmation
            } );

            expect( mutations.toggleConfirmationModal.callCount ).toBe( 1 );
        } );


        it( ' dispatches the appropriate action -- confirm modal disabled', () => {
            //disable the confirm modal
            wrapper.setData( { requiresConfirmation: false } );
            //call
            wrapper.trigger( 'click' );
            expect( actions[ actionName ].callCount ).toBe( 1 );
        } );
    } );

    describe( " when in an error state ", () => {
        it( " displays the correct text in the error modal", () => {
            //set the getter to return an empty list
            getters[ nggTypes.getSelectedStudents ] = () => [];

            store = new Vuex.Store( {
                actions, getters, mutations
            } );

            wrapper = shallow( Component, {
                store, localVue
            } );

            //call
            wrapper.trigger( 'click' );

            //check
            expect( mutations.toggleErrorModal.callCount ).toBe( 1 );
            let pl = PayloadModal.factory( {
                type: 'error',
                text: wrapper.vm.errorModalText
            } );
            expect( mutations.toggleErrorModal.args[ 0 ][ 1 ] ).toMatchObject( pl );
        } );
    } );

} );
