
//The name of the tested component
var compName = 'roster-row';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/roster/roster-row.vue');


import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
// import { factories } from '../../../helpers/vuex.spec.helpers';
//
//
// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
// import * as gTypes from "../../../../../resources/assets/js/js/store/getter-types";
import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff



describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( (  ) => {

        getters = {
        getDepthOfNode : (  ) => (  ) => 4,

            [nggTypes.getGradedStudentIds] : function (  ) {
                return [1, 3]

            }
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );
let student = factories.studentFactory();
        wrapper = shallow( Component, {
            store, localVue, propsData: {student}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe.skip(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
