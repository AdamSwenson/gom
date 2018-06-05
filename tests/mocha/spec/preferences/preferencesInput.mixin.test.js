
//The name of the tested component
var compName = 'preferencesInput.mixin';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/preferences/preferencesInput.mixin.js');


import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
// import { factories } from '../../../helpers/vuex.spec.helpers';
//
//
// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
// import * as gTypes from "../../../../../resources/assets/js/js/store/getter-types";
// import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff



describe(  compName , () => {
let obj;
    beforeEach( (  ) => {
obj = Component;
    } );


    describe( " loads into expected default state for testing ", () => {
     } );
    
    describe(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
