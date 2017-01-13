//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as times from '../../../../../resources/assets/js/store/modules/grade.times';

import * as types from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from '../../../helpers/vuex.spec.helpers';
import {makeRootState} from '../../../helpers/vuex.spec.helpers';
import {testAction} from '../../../helpers/vuex.spec.helpers';
import {description} from '../../../helpers/vuex.spec.helpers';

describe("store | modules | ", () => {
    describe(description("grade.times"), () => {
        beforeAll(function () { //runs once before all tests
        });
        afterEach(function () {//runs after each test
        });
        beforeEach(function () {//runs before each test
        });


        describe(description("mutations"), () => {
            //
            // if (typeof(payload.studentIndex) != 'undefined' && typeof(payload.timeToAdd) != 'undefined') {
            //     let studentIndex = payload.studentIndex;
            //     let timeToAdd = payload.timeToAdd;
            //     state.examGradingTimes[studentIndex] += timeToAdd;
            // }
            // //add processing from other allowed input configs


            describe(description(types.removeGradingTime), () => {
            });

            /**
             * Sets the grading time data from the server
             * @param examGradingTimes JSON object
             */
            describe(description(types.loadGradingTimes), () => {
            });


        });

        describe("actions | ", () => {

            describe(aTypes.increaseActiveStudentGradingTime, () => {
            });
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
});