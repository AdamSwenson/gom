//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as escores from '../../../../../resources/assets/js/store/modules/grade.escores';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from './helpers';
import {makeRootState} from './helpers';
import {testAction} from './helpers';
import {description} from './helpers';

const mutations = escores.default.mutations;

fdescribe("store | modules | ", () => {
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
        });

        describe("getters | ", () => {
        });
    });
});

