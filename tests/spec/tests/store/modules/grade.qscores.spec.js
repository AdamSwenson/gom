require('jasmine-jquery');
require('sinon');

//Dependencies
import * as qscores from '../../../../../resources/assets/js/store/modules/grade.qscores';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from './helpers';
import {makeRootState} from './helpers';
import {testAction} from './helpers';
import {description} from './helpers';

describe("store | modules | ", () => {
    describe("grade.qscores | ", () => {

        describe("mutations | ", () => {
            describe(description(mTypes.populateQuestionScores), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(mTypes.storeQuestionScore), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("actions | ", () => {

            describe(description(aTypes.loadQuestionScores), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });


            describe(description(aTypes.storeQuestionScoreForActiveStudent), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("getters | ", () => {
            describe("getQuestionScore | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe("getQuestionScoreForActiveStudent | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });
    });
});
