//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as questions from '../../../../../resources/assets/js/store/modules/questions';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import {makeState} from '../../../helpers/vuex.spec.helpers';
import {makeRootState} from '../../../helpers/vuex.spec.helpers';
import {testAction} from '../../../helpers/vuex.spec.helpers';
import {description} from '../../../helpers/vuex.spec.helpers';


describe("store | modules | ", () => {
    describe("grade.questions | ", () => {

        describe("mutations | ", () => {

            describe(description(mTypes.populateQuestions), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });


            describe(description(mTypes.populateMaxQuestionScores), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(mTypes.setQuestion), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("actions | ", () => {

            describe(description(aTypes.addQuestion), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(aTypes.loadMaxQuestionScores), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(aTypes.loadQuestions), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(aTypes.loadNumberQuestions), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

        });

        describe("getters | ", () => {
            describe("getQuestion | ", () => {
            });
            describe("getMaxQuestionScore | ", () => {
            });
        });
    });
});
