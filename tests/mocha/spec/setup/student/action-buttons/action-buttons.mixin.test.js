//The name of the tested component
var compName = 'action-buttons.mixin';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/development/components/setup/student/action-buttons/action-buttons.mixin.js' );


require( '../../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

import mixinComponent from '../../../../helpers/dummy-component';


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;
    let obj;
    let actions;
    let getters;
    let mutations;
    let store;
    let wrapper;
    let actionSpy;
    let actionName = 'testTaco';
    let getterStub;

    let itemScore;
    let item, students, exam, kumis;

    beforeEach( () => {
        students = [ factories.studentFactory() ];
        actionSpy = sinon.stub();
        //actionSpy.returns(new Promise);

        actions = {
            [actionName] : actionSpy,
            toggleKumiSelectVisibility: sinon.spy()
        };

        kumis = factories.makeKumis( 2 );

        getters = {
            [ nggTypes.getSelectedStudents ]: () => students,
            'getSelectedKumis': () => kumis
        };

        mutations = {
            toggleConfirmationModal: sinon.spy(),
            toggleErrorModal: sinon.spy(),
            clearSelectedStudents: sinon.spy(),
            clearSelectedKumis: sinon.spy()
        };

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        //stuff defined on components which use the mixin
        let childStuffMixin = {
            computed: {
                isOperationValid: (  ) => true
            }
        }

        wrapper = shallow( mixinComponent, {
            store, localVue, mixins: [ Component, childStuffMixin ]
        } );

    } );

    describe( " loads into expected default state for testing ", () => {
        it( 'loaded instance', () => {
            expect( wrapper.exists() ).toBe( true );
        } );
    } );

    describe( " computed properties ", () => {
    } );

    describe( 'methods', () => {

        describe( 'handleClick', () => {
            it( ' does not display modal when requiresConfirmation is false', () => {
                // wrapper.setMethods( { isOperationValid: () => true } );
                wrapper.vm.requiresConfirmation =  false;
                wrapper.vm.actionName = actionName;
                //call
                wrapper.vm.handleClick();
                // wrapper.trigger( 'click' );
                //check
                expect( mutations.toggleConfirmationModal.notCalled ).toBe( true );
                //nb this does not test whether it calls handleConfirmation. Doing that
                //would require mocking the mutation to call the callback. Not sure that
                //it is worth doing....
                expect(actionSpy.calledOnce).toBe(true);
            } );

            it( ' displays modal if requiresConfirmation is true', () => {
                wrapper.vm.requiresConfirmation =  true;
                wrapper.vm.actionName = actionName;
                //call
                wrapper.vm.handleClick();
                expect( mutations.toggleConfirmationModal.callCount ).toBe( 1 );
            } );
        } );

        describe( 'handleConfirmation', () => {
            it( ' dispatches the action defined in the data with correct payload ', () => {

                let pl = { tacos: 3 };
                wrapper.setProps( { actionName: actionName, payload: pl } );
                //call
                wrapper.vm.handleConfirmation();
                expect( actionSpy.calledOnce ).toBe( true );
                expect( actionSpy.args[ 0 ][ 1 ] ).toMatchObject( pl );
            } );
        } );

        describe( 'handlesCancellation', () => {
            it( ' calls resetDisplay ', () => {
                // let spy = sinon.spy();
                // wrapper.setMethods({resetDisplay: spy});
                //call
                wrapper.vm.handleCancellation();
                //check
                expect( mutations.clearSelectedStudents.callCount ).toBe( 1 );
                expect( mutations.clearSelectedKumis.callCount ).toBe( 1 );

                // expect(spy.calledCount).toBe(1);
            } );
        } );

        describe( 'resetDisplay', () => {
            it( " calls expected mutations", () => {
                wrapper.vm.resetDisplay();
                //check
                expect( mutations.clearSelectedStudents.callCount ).toBe( 1 );
                expect( mutations.clearSelectedKumis.callCount ).toBe( 1 );
            } );
        } );
    } );


} );
