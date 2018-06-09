
//The name of the tested component
var compName = 'kumi-editing-modal';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/kumi/kumi-editing-modal.vue');


require( '../../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    let listOfValues, showLetter, grade;
    let payload, test;

    beforeEach( () => {

        getters = {
        };

        mutations = {
            toggleEditKumiModal: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe("methods", (  ) => {
        it(" calls for the correct mutation when done is clicked", (  ) => {
            wrapper.find('.done-button').trigger('click');
            expect(mutations.toggleEditKumiModal.calledOnce).toBe(true);
        });
    })


});
