//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as students from '../../../../../resources/assets/js/store/modules/grade.students';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from './helpers';
import {makeRootState} from './helpers';
import {testAction} from './helpers';
import {description} from './helpers';



describe("store | modules | ", () => {
    describe("grade.students | ", () => {
        describe("mutations | ", () => {
            describe(description(mTypes.populateStudents), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
            describe(description(mTypes.setStudent), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("actions | ", () => {
            describe(description(aTypes.loadStudents), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
            describe(description(aTypes.addStudent), () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });

        describe("getters | ", () => {
            describe("getStudent | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
            describe("getStudents | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });
    });
});
