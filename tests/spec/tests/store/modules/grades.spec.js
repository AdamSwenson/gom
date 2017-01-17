require('jasmine-jquery');
require('sinon');
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as grades from '../../../../../resources/assets/js/store/modules/grades';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

const makeState = ( n = 5 ) => {

    let s = makeRootState();

    for ( let i = 0; i < n; i++ ) {
        s.examGrades[ i ] = faker.random.number();
        // s.standardGrades[ i ] = i;
    }
    return s;
};

const makeRootState = function () {
    return {
        examGrades: {},
        standardGrades: {}
    };
};

const makeTestPayload = function () {
    return {
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        score: faker.random.number()
    };
};


//tested object
let obj = grades.default;
//tested methods
let {getters, actions, mutations} = obj;


fdescribe("store.modules | ", function() {
    describe("grades | ", function(){
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
        } );

        describe("mutations | ", function() {
            describe(description(mTypes.loadExamGrades) , function(){
                it("happy path | ", function(){
                    let test = 'jjj';
                    mutations[mTypes.loadExamGrades](this.state, this.rootState, test);
                    expect(this.state.examGrades).toBe(test);
                });
            });

            describe(description(mTypes.loadStandardGrades) , function() {
                it("happy path | ", function(){
                    let test = 'jjj';
                    mutations[mTypes.loadStandardGrades](this.state, this.rootState, test);
                    expect(this.state.standardGrades).toBe(test);
                });
            });

            describe(description(mTypes.setGrade) , function() {
                it("happy path | ", function(){
                    mutations[mTypes.setGrade](this.state, this.rootState, this.payload);
                    expect(this.state.examGrades[this.payload.studentIndex]).toBe(this.payload.score);
                });
            });

        });

        describe("actions | ", function(){

            describe(description(aTypes.loadExamGrades) , function(){
                xit("happy path | ", function(){
                    //todo
                });
            });


            describe(description(aTypes.loadStandardGrades) , function(){
                xit("happy path | ", function(){
                    //todo
                });
            });


            describe(description(aTypes.updateExamGrade) , function(){
                xit("happy path | ", function(){
                    //todo
                });
            });

        });

        
        describe("getters | ", function(){
            describe("getExamGrade | ", function(){
                xit("happy path | ", function(){
                    //todo
                });
            });

            describe("getStandardGrades | ", function(){
                xit("happy path | ", function(){
                    //todo
                });
            });
            
            describe("getGrade | ", function(){
                xit("happy path | ", function(){
                    //wrapper around getStandardGrades
                    //todo
                });
            });
            describe("getExamGradeForActiveStudent | ", function(){
                xit("happy path | ", function(){
                    //todo
                });
            });
        });
    });
});