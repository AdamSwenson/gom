
//The name of the tested component
var compName = 'edit-kumi-control';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/kumi/edit-kumi-control.vue');



import GradeAssignment from '../../../../../resources/assets/js/models/GradeAssignment';


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
        it("calls for the correct mutation when clicked", (  ) => {
            wrapper.trigger('click');
            expect(mutations.toggleEditKumiModal.calledOnce).toBe(true);
        });
    })


});
