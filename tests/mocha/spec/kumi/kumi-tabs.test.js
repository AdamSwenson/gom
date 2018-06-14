
//The name of the tested component
var compName = 'kumi-tabs';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/kumi/kumi-tabs.vue');



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
        kumis = factories.makeKumis(3);
        exam = factories.examFactory();
        actions = {}

        getters = {
            [ gTypes.getKumisForExam ] : (  ) => (  ) => kumis,
            [ gTypes.getActiveExam] : (  ) => (  ) => exam,
            getKumisToFilterStudentsBy: (  ) => (  ) => kumis,

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

    describe( "methods", () => {
        } )


} );
