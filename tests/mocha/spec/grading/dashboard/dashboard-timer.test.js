import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';
import faker from 'faker';

//helpers
import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
import { factories } from '../../../../spec/helpers/vuex.spec.helpers';


import Exam from "../../../../../resources/assets/js/models/Exam";
import Comment from "../../../../../resources/assets/js/models/Comment";
import Payload from "../../../../../resources/assets/js/models/Payload";
import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "../../../../../resources/assets/js/store/getter-types";

import * as nggTypes from "../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/grading/dashboard/dashboard-timer.vue" );


describe.only( " dashboard-timer ", () => {
    let componentDivIdentifier = '#dashboard-timer';

    let getters;
    let mutations;
    let store;
    let exam;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let student;
    let numGraded;
    let totalTime;
    let gradingTime;
    let visibility = true;

    beforeEach( () => {
        student = factories.studentFactory();
        gradingTime = 120;
        student.gradingTime = gradingTime;

        getters = {
            [ nggTypes.getActiveStudent ]: ( v ) => ( v ) => {
                return student;
            },
            [ nggTypes.isTimerRunning ]: ( v ) => ( v ) => {
                return visibility;
            },
            [ gTypes.getNumberUngraded ]: ( v ) => ( v ) => {
                return numGraded;
            },
            [ gTypes.getNumberGraded ]: ( v ) => ( v ) => {
                return numGraded;
            },
            getTotalGradingTime: ( v ) => ( v ) => {
                return totalTime;
            },
        };

        mutations = {};

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
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );


    describe( " values  display as expected    ", () => {
        let expected = {};

        it("has student displayed", (  ) => {
            expect(wrapper.vm.isStudentSelected).toBe(true);
        });

        it( " current exam time ", () => {
            see( wrapper, "02:00", '.current-exam-time' );
        } );

        it( " remaining exam time ", () => {
            gradingTime = faker.random.number();
            student.gradingTime = gradingTime;
            see( wrapper, gradingTime, '.remaining-grading-time' );
        } );

        it( " average exam time ", () => {
            numGraded = 100;
            totalTime = 100;
            see( wrapper, "01:00", '.average-grading-time' );
        } );

        it( " total exam time ", () => {
            totalTime = 122;
            see( wrapper, "02:02", '.total-grading-time' );
        } );
    } );

    describe( " Starting timer  ", () => {
        it( "Styling changes", () => {

        } );

        it( " Makes expected request to store ", () => {

        } );

        it( " Does not request timer start if no student is selected" )
    } );

    describe( " Stopping timer  ", () => {
        it( "Happy path" );

        it( " Makes expected request to store ", () => {

        } );

        it( " Does not request timer stop if no student is selected" )

    } );

} );

