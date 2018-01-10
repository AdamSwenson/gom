
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as nggTypes from "../../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

import * as ngmTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
import * as ngaTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

import Payload from '../../../../../../resources/assets/js/models/Payload';
import PayloadTime from '../../../../../../resources/assets/js/models/PayloadTime';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/grading-times-new';

let obj = Component.default;
//tested methods
let { getters, actions, mutations } = obj;


describe( "grading-times-new  | ", function () {
    let getterStub;
    let getterStub2;
    beforeEach( function () {

    } );


    describe( "mutations  ", function () {
        describe( description( ngmTypes.updateStudentGradingTime ), function () {

            it( " when student has non-zero grading time, it updates to the expected amount ", function () {
                //prep
                let existingTime = faker.random.number();
                let timeToAdd = faker.random.number();
                let expectedTime = timeToAdd;
                let student = factories.studentFactory();
                student.gradingTime = existingTime;
                let payload = PayloadTime.factory( { student: student, time: timeToAdd } );

                //call
                mutations[ ngmTypes.updateStudentGradingTime ]( {}, payload );

                //check
                expect( student.gradingTime ).toBe( expectedTime );
            } );

            it( " when student's grading time is 0, it updates to the expected amount ", function () {
                //prep
                let existingTime = 0;
                let timeToAdd = faker.random.number();
                let expectedTime = timeToAdd;
                let student = factories.studentFactory();
                student.gradingTime = existingTime;
                let payload = PayloadTime.factory( { student: student, time: timeToAdd } );

                //call
                mutations[ ngmTypes.updateStudentGradingTime ]( {}, payload );

                //check
                expect( student.gradingTime ).toBe( expectedTime );
            } );

            it( " when student's grading time is undefined, it updates to the expected amount ", function () {
                //prep
                let timeToAdd = faker.random.number();
                let expectedTime = timeToAdd;
                let student = factories.studentFactory();
                student.gradingTime = undefined;
                let payload = PayloadTime.factory( { student: student, time: timeToAdd } );

                //call
                mutations[ ngmTypes.updateStudentGradingTime ]( {}, payload );

                //check
                expect( student.gradingTime ).toBe( expectedTime );
            } );
        } );


    } );

    describe( "actions  ", function () {
        let exam, student, amount;
        describe( description( ngaTypes.incrementGradingTime ), function () {
            beforeEach( () => {
                exam = factories.examFactory();
                student = factories.studentFactory();
                amount = faker.random.number();

                getterStub = sinon.stub();
                getterStub.returns( student );
                getters[ nggTypes.getActiveStudent ] = (function () {
                    return getterStub();
                })();

                getterStub2 = sinon.stub();
                getterStub2.returns( exam );
                getters[ nggTypes.getActiveExam ] = (function () {
                    return getterStub2();
                })();

            } );

            it( " when student has non-zero grading time, it calls for an update to the expected amount ", function () {
                //prep
                student.gradingTime = faker.random.number() + 5;
                let expectedAmount = amount + student.gradingTime;

                let expectedPayload = PayloadTime.factory( {
                    student: student, exam: exam, time: expectedAmount
                } );

                let action = actions[ ngaTypes.incrementGradingTime ];
                testAction( action, amount, {}, [
                    {
                        type: ngmTypes.updateStudentGradingTime,
                        payload: expectedPayload
                    }
                ], { getters: getters, verbose: true } )

            } );


            it( " when student's grading time is 0, it calls for an update to the expected amount  ", function () {
                //prep
                student.gradingTime = 0;
                let expectedAmount = amount;

                let expectedPayload = PayloadTime.factory( {
                    student: student, exam: exam, time: expectedAmount
                } );

                let action = actions[ ngaTypes.incrementGradingTime ];
                testAction( action, amount, {}, [
                    {
                        type: ngmTypes.updateStudentGradingTime,
                        payload: expectedPayload
                    }
                ], { getters: getters, verbose: true } )

            } );

            it( " when student's grading time is undefined, it calls for an update to the expected amount ", function () {
                //prep
                student.gradingTime = 0;
                let expectedAmount = amount;

                let expectedPayload = PayloadTime.factory( {
                    student: student, exam: exam, time: expectedAmount
                } );

                let action = actions[ ngaTypes.incrementGradingTime ];
                testAction( action, amount, {}, [
                    {
                        type: ngmTypes.updateStudentGradingTime,
                        payload: expectedPayload
                    }
                ], { getters: getters, verbose: true } )

            } );

        } );

        describe( description( ngaTypes.loadTimesFromServer ), function () {

            it( "happy path ", function () {
                // let action = actions[ ngaTypes.loadTimesFromServer ];
                // testAction( action, exam, state, [
                //     {
                //         type: ngmTypes.stopExamTimer
                //     }
                // ], { verbose: true } )

            } );
        } );


    } );

    describe( "getters  ", function () {
        let numberStudents = 5;
        let expectedTime = 0;
        let students = [];

        describe( nggTypes.getTotalGradingTime, () => {
            beforeEach( () => {

                for (let i = 0; i < numberStudents; i++) {
                    let s = factories.studentFactory();
                    let time = faker.random.number();
                    expectedTime += time;
                    s.gradingTime = time;
                    students.push( s );
                }
            } );

            it( " when all students have a grading time, it returns the expected total ", function () {
                //prep
                getterStub = sinon.stub();
                getterStub.returns( students );
                getters[ gTypes.getStudentsFromRoster ] = (function () {return getterStub();})();

                //call
                let result = getters[ nggTypes.getTotalGradingTime ]( {}, getters, {} );

                //check
                expect( getterStub.callCount ).toBe( 1 );
                expect( result ).toBe( expectedTime );
            } );
        } );

        describe( nggTypes.getAverageGradingTime, function () {
            it( "  when all students have a grading time and more than 1 exam has been graded, it returns the expected average ", function () {
                //prep
                let totalTime = faker.random.number() + 2; //make sure not 0
                getterStub = sinon.stub();
                getterStub.returns( totalTime );
                getters[ nggTypes.getTotalGradingTime ] = (function () {
                    return getterStub();
                })();

                let numberGraded = faker.random.number() + 2; //make sure not 0
                getterStub2 = sinon.stub();
                getterStub2.returns( numberGraded );
                getters[ nggTypes.getNumberGraded ] = (function () {
                    return getterStub2();
                })();

                let expectedAverage = totalTime / numberGraded;

                //call
                let result = getters[ nggTypes.getAverageGradingTime ]( {}, getters, {} );

                //check
                expect( getterStub.callCount ).toBe( 1 );
                expect( getterStub2.callCount ).toBe( 1 );
                expect( result ).toBe( expectedAverage );
            } );
        } );

        describe( nggTypes.getRemainingGradingTime, function () {

            it( "returns the expected time when non-0 students have been graded and time remains", () => {

                //prep
                let remainingExams = faker.random.number() + 1;
                //ensure that total is bigger than number graded
                let averageTime = faker.random.number() + 1;
                let expectedRemainingTime = remainingExams * averageTime;

                getterStub = sinon.stub();
                getterStub.returns( remainingExams );
                getters[ nggTypes.getNumberExamsRemaining ] = (function () {
                    return getterStub();
                })();

                getterStub2 = sinon.stub();
                getterStub2.returns( averageTime );
                getters[ nggTypes.getAverageGradingTime ] = (function () {
                    return getterStub2();
                })();

                //call
                let result = getters[ nggTypes.getRemainingGradingTime ]( {}, getters, {} );

                //check
                expect( result ).toBe( expectedRemainingTime );
            } );
        } );

    } );
} );

