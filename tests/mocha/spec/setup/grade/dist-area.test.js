//The name of the tested component
var compName = 'dist-area';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/grade/dist-area.vue' );


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

        listOfValues = [];
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

        wrapper = shallow( Component, {
            store, localVue,
            propsData: { listOfValues, showLetter }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'computed properties', () => {

        describe( 'sortedValues', () => {
            it( "actually sorts the values ", () => {
                for (let i = 1; i < 100; i++) {
                    expect( wrapper.vm.sortedValues[ i - 1 ] ).toBe( i );
                }
            } );
        } );

        describe( 'median', () => {
            it( "actually calculates the median", () => {
                expect( wrapper.vm.median ).toBe( 50 );
            } );

        } );

        describe( 'standardDeviation', () => {
            it( "actually returns the standard deviation of the list of values", () => {
                expect( wrapper.vm.standardDeviation ).toBe( 28.58 );
            } );
        } );
    } );
} );