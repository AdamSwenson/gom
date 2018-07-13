
//The name of the tested component
var compName = 'confirmation-modal';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/modals/confirmation-modal.vue');

require('../../injectglobals');
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    let mixin;
    let show;
    let spy;

    beforeEach( (  ) => {
        show = true;
        mixin = {
            computed: {
                modalDataObject: () => undefined,
                isErrorModalVisible: () => true,
                isConfirmationModalVisible: () => show,
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
    
    describe("computed", () => {
        it('isModalVisible is determined by mixin method isConfirmationModalVisible', (  ) => {
            wrapper.setComputed({isConfirmationModalVisible: true});
            expect(wrapper.vm.isModalVisible).toBe(true);

            wrapper.setComputed({isConfirmationModalVisible: false});
            expect(wrapper.vm.isModalVisible).toBe(false);
        });
    });


});
