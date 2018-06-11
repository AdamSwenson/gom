
//The name of the tested component
var compName = 'exam-properties';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/stats/exam-properties.vue');



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
        actions = {}

        getters = {
            [gTypes.getItemCount]: (  ) => (  ) => 3,
            [gTypes.getStudentCount]: (  ) => (  ) => 3,
            [gTypes.getKumiCount]: (  ) => (  ) => 3,

        };

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
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


} );
