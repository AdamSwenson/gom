
//The name of the tested component
var compName = 'exam-card';
//The path to the tested component

var Component = require(  '../../../../resources/assets/js/development/components/cards/exam-card.vue');
require( '../../injectglobals' );


import { mount, shallow, createLocalVue } from 'vue-test-utils';
// import { see } from '../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let exam;

    beforeEach( (  ) => {

        getters = {   };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        exam = factories.examFactory();
        wrapper = shallow( Component, {
            store, localVue, propsData : {exam}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
