//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as times from '../../../../../resources/assets/js/store/modules/grade.times';

import * as types from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


describe("store | modules | ", () => {
    describe("grade.times | ", () => {
        beforeAll(function () { //runs once before all tests
        });
        afterEach(function () {//runs after each test
        });

        beforeEach(function () {//runs before each test
        });


        describe("mutations | ", () => {

            if (typeof(payload.studentIndex) != 'undefined' && typeof(payload.timeToAdd) != 'undefined') {
                let studentIndex = payload.studentIndex;
                let timeToAdd = payload.timeToAdd;
                state.examGradingTimes[studentIndex] += timeToAdd;
            }
            //add processing from other allowed input configs
        });

        describe(types.removeGradingTime, () => {
        });

        /**
         * Sets the grading time data from the server
         * @param examGradingTimes JSON object
         */
        describe(types.loadGradingTimes, () => {
        });

        describe(types.increaseActiveStudentGradingTime, () => {
        });
    });

    describe("actions | ", () => {

        describe(types.storeStudentGradingTime, () => {
        });

        describe(types.increaseStudentGradingTime, () => {
        });
    });

    describe("getters | ", () => {

        describe("getTotalGradingTime", () => {
        });

        describe("getStudentGradingTime", () => {
        });

        describe("getActiveStudentGradingTime", () => {
        });
    });

});
