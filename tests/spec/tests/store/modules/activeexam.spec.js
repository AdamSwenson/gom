//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as activeexam from '../../../../../resources/assets/js/store/modules/activeexam';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import Exam from '../../../../../resources/assets/js/store/models/Exam';

import {makeState, makeRootState, testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//tested object
let obj = activeexam.default;
//tested methods
let {getters, actions, mutations} = obj;

//test data
let exam = factories.examFactory();
let index = exam.examIndex;
let examId = exam.examId;

//mock store
let state = {
    activeExam: {
        id: examId,
        index: index
    }
};


describe( "store | modules | ", () => {
    describe( " activeexam | ", () => {

        describe( "mutations | ", () => {
            describe( description( mTypes.setActiveExam ), () => {

                it( "happy path | ", () => {
                    let state2 = {activeExam: null};
                    let exam2 = factories.examFactory();
                    mutations[mTypes.setActiveExam](state2, {}, exam2);
                    expect(state2.activeExam).toBe(exam2);
                } );
            } );

            describe( description( mTypes.clearActiveExam ), () => {
                it( "happy path | ", () => {
                    let state2 = {activeExam: 'taco'};
                    let exam2 = factories.examFactory();
                    mutations[mTypes.clearActiveExam](state2, {}, exam2);
                    expect(state2.activeExam).toBeNull();
                } );
            } );
        } );

        describe( "actions | ", () => {

            describe( description( aTypes.setActiveExam ), () => {
                describe(" payload is Exam | ", ()=>{
                    it( "happy path | ", () =>{
                        let action = actions[aTypes.setActiveExam];

                        testAction(action, exam, state, [
                            {
                                type: mTypes.setActiveExam,
                                payload: index
                            }
                        ])

                    } );
                });

                describe(" payload Not Exam | ", ()=>{
                    it( "happy path | ", ()=>{
                        let action = actions[aTypes.setActiveExam];
                        let p = {examId: examId, examIndex: index};

                        testAction(action, p, state, [
                            {
                                type: mTypes.setActiveExam,
                                payload: p
                            }
                        ] )
                    } );
                });

            } );

            describe( description( aTypes.clearActiveExam ), function(){
                it( "happy path | ", function(){
                    let action = actions[aTypes.clearActiveExam];

                    testAction(action, state, state.activeExam,  [
                        {
                            type: mTypes.clearActiveExam,
                            payload: index
                        }
                    ] );
                } );
            } );

        } );

        describe( "getters | ", () => {

            describe( "getActiveExamId | ", () => {
                it( "happy path | ", () => {
                    expect( getters.getActiveExamId( state ) ).toBe( examId );
                } );
            } );

            describe( "getActiveExamIndex | ", () => {
                it( "happy path | ", () => {
                    expect( getters.getActiveExamIndex( state ) ).toBe( index );
                } );
            } );

            describe( "getActiveExamObj | ", () => {
                it( "happy path | ", () => {

                    expect( getters.getActiveExamObj( state ) ).toBe( state.activeExam );
                } );
            });
        } );
    } );
} );
