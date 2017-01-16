//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as escores from '../../../../../resources/assets/js/store/modules/escores';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from '../../../helpers/vuex.spec.helpers';
import {makeRootState} from '../../../helpers/vuex.spec.helpers';
import {testAction} from '../../../helpers/vuex.spec.helpers';
import {description} from '../../../helpers/vuex.spec.helpers';

const mutations = escores.default.mutations;

describe("store | modules | ", () => {
    describe("grade.escores | ", () => {


        describe("mutations | ", () => {
            describe(description(mTypes.loadElementScores), () => {
                it("happy path | ", () => {
                    let test = 1
                    let state = { elementScores: {} };
                    mutations.loadElementScores(state)
                    //the object will be replaced by test
                    expect(state.elementScores).toBe(test);
                });

            });


        });

        describe("actions | ", () => {
            describe(description(aTypes.storeElementScoreForActiveStudent), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
            describe(description(aTypes.storeElementScore), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("getters | ", () => {
            describe("getElementScore | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe("getElementScoreForActiveStudent | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });
    });
});

