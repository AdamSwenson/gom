
//The name of the tested component
var compName = 'frequency-chart';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/grade/frequency-chart.vue');


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

        listOfValues = [{grade: 'a', freq: 20}];
        for (let i = 1; i < 100; i++) {
            listOfValues.push( i );
        }
        listOfValues = _.shuffle( listOfValues );

        showLetter = 'Q';
        grade = new GradeAssignment();

        getters = {
            [ gTypes.getGradeAssignmentForScore ]: () => ()=> grade
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = mount( Component, {
            store, localVue,
            propsData: { listOfValues, showLetter }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        //todo Webpack messes up google charts, so this doesn't load properly
        it.skip( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

});
