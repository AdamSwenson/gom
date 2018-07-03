
//The name of the tested component
var compName = 'feedback-page';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/feedback/feedback-page.vue');


import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
// import { factories } from '../../helpers/vuex.spec.helpers';
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

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let actions
    let wrapper;

    beforeEach( (  ) => {

        getters = {   };

        mutations = {};
        actions = {
            loadExamFromPageJson: sinon.spy(),
            loadStudentsFromPageJson: sinon.spy()
        }

        store = new Vuex.Store( {
            getters,
            mutations,
            actions
        } );

        wrapper = shallow( Component, {
            store, localVue
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
