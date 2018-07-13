//The name of the tested component
var compName = 'auto-closing-modal';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/modals/auto-closing-modal.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let mixin;
    let show;
    let spy;
    beforeEach( () => {
        show = true;
        mixin = {
            computed: {
                isModalVisible: () => show,
                modalDataObject: () => undefined,
                isErrorModalVisible: () => true,
                isConfirmationModalVisible: () => true,
            },

        }

        mutations = {
            toggleErrorModal : sinon.spy()
        }
        store = new Vuex.Store( {
            mutations
        } );


        wrapper = shallow( Component, {
            store, localVue, mixins: [ mixin ]
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " watcher", () => {
        it( 'starts the timer when isModalVisible changes from false to true', () => {
            wrapper.setComputed( { isModalVisible: false } );
            let spy = sinon.stub();
            wrapper.setMethods( { setAutoCloseDelayTimer: spy } );

            //check setup
            expect( wrapper.vm.isModalVisible ).toBeFalsy();

            //change the shown value
            wrapper.setComputed( { isModalVisible: true } );

            //check
            expect( spy.callCount ).toBe( 1 );
        } );

        it( 'does not start the timer when isModalVisible goes from visible to non-visible', () => {
            wrapper.setComputed( { isModalVisible: true } );
            let spy = sinon.stub();
            wrapper.setMethods( { setAutoCloseDelayTimer: spy } );

            //check setup
            expect( wrapper.vm.isModalVisible ).toBeTruthy();

            //change the shown value
            wrapper.setComputed( { isModalVisible: false } );

            //check
            expect( spy.callCount ).toBe( 0 );

        } )
    } );

    describe( "methods", () => {
        it( "close modal overrides the delay timer", () => {
            //check starting state
            expect( wrapper.vm.timer ).toBeFalsy();
            //start the timer
            wrapper.vm.setAutoCloseDelayTimer();
            //check that the timer stared
            expect( wrapper.vm.timer ).not.toBeFalsy();
            //manually close modal
            wrapper.vm.closeModal();
            //check that timer stopped
            expect( wrapper.vm.timer ).toBeFalsy();
            //check that our spy was called
            expect(mutations.toggleErrorModal.callCount).toBe(1);
        } );
    } )


} );
