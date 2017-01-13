require('jasmine-jquery');
require('sinon');

//Dependencies
import * as grades from '../../../../../resources/assets/js/store/modules/grade.grades';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from '../../../helpers/vuex.spec.helpers';
import {makeRootState} from '../../../helpers/vuex.spec.helpers';
import {testAction} from '../../../helpers/vuex.spec.helpers';
import {description} from '../../../helpers/vuex.spec.helpers';


describe("store | modules | ", () => {
    describe("grade.grades | ", () => {

        describe("mutations | ", () => {
            describe(description(mTypes.populateExamGrades) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(mTypes.populateStandardGrades) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(mTypes.setGrade) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

        });

        describe("actions | ", () => {

            describe(description(aTypes.loadExamGrades) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });


            describe(description(aTypes.loadStandardGrades) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });


            describe(description(aTypes.updateExamGrade) , () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

        });

        
        describe("getters | ", () => {
            describe("getExamGrade | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe("getStandardGrades | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
            
            describe("getGrade | ", () => {
                xit("happy path | ", () => {
                    //wrapper around getStandardGrades
                    //todo
                });
            });
            describe("getExamGradeForActiveStudent | ", () => {
                xit("happy path | ", () => {
                    //todo
                });
            });
        });
    });
});