//test libraries

let sinon = require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//Dependencies
import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as ngmTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/action-types';
import * as ngaTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

import PayloadScore from '../../../../../../resources/assets/js/models/PayloadScore';
import ItemScore from '../../../../../../resources/assets/js/models/ItemScore';
import Item from '../../../../../../resources/assets/js/models/Item';
import Student from '../../../../../../resources/assets/js/models/Student';
import Exam from '../../../../../../resources/assets/js/models/Exam';


import Component from '../../../../../../resources/assets/js/store/modules/scores/itemscores';


//tested methods
let { getters, actions, mutations } = Component;

const makePopulatedState = ( n = 5 ) => {
    // Format: { studentIndex : { elementIndex : elementScore},  ...
    let s = {
        scores: []
    };

    for (let i = 0; i < n; i++) {
        let score = ItemScore.factory( { studentId: i, examId: i, itemId: i } );
        score.score = faker.random.number();
        score.commentText = faker.company.catchPhrase;
        s.scores.push( score );
    }
    return s;
};

const makeState = function () {
    return {
        scores: []
    };
};

describe.only( "itemscores | ", function () {
    let state;
    let testExam;
    let testItem;
    let testStudent;
    let testScore;

    beforeEach( function () {
        testExam = factories.examFactory();
        testItem = factories.itemFactory();
        testStudent = factories.studentFactory();
        testScore = faker.random.number();
    } );

    describe( " helpers ", () => {
        // describe( " itemScoreGetter ", () => {
        //     it( " returns expected objects ", () => {
        //         state = makePopulatedState();
        //         let result = Component.itemScoreGetter( state, 1, 1 );
        //         expect( result.examId ).toBe( i );
        //
        //     } );
        // } );
    } );

    describe( "mutations | ", function () {
        describe( description( ngmTypes.updateScore ), function () {

            it( " creates and sets values when no previously existing score object ", function () {

                state = makeState();

                let pl = PayloadScore.factory( {
                    item: testItem,
                    exam: testExam,
                    student: testStudent,
                    score: testScore
                } );

                //call
                mutations[ ngmTypes.updateScore ]( state, pl );

                //check
                expect( state.scores.length ).toBe( 1 );
                expect(state.scores[0].itemId).toBe(pl.item.id);
                expect(state.scores[0].studentId).toBe(pl.student.id);
                expect(state.scores[0].examId).toBe(pl.exam.id);

                expect(state.scores[0].score).toBe(pl.score);
            } );

            it( " updates values on existing score object ", function () {
                let number = 4;
                let testIndex = 2;
                state = makePopulatedState(number);

                //the object that we are going to alter
                let obj = state.scores[testIndex];

                let pl = PayloadScore.factory( {
                    item: Item.factory({ id: obj.itemId}),
                    exam: Exam.factory({id: obj.examId}),
                    student: Student.factory({ id: obj.studentId}),
                    score: testScore
                } );

                //call
                mutations[ ngmTypes.updateScore ]( state, pl );

                //check
                expect( state.scores.length ).toBe( number );

                //make sure these haven't changed
                expect(state.scores[testIndex].itemId).toBe(pl.item.id);
                expect(state.scores[testIndex].studentId).toBe(pl.student.id);
                expect(state.scores[testIndex].examId).toBe(pl.exam.id);
                //check the set value
                expect(state.scores[testIndex].score).toBe(pl.score);

            } );
        } );
        describe( description( ngmTypes.updateText ), function () {

            it( " creates and sets text value when no previously existing score object ", function () {

                state = makeState();

                let pl = PayloadScore.factory( {
                    item: testItem,
                    exam: testExam,
                    student: testStudent,
                    text: faker.company.bs()
                } );

                //call
                mutations[ ngmTypes.updateText ]( state, pl );

                //check
                expect( state.scores.length ).toBe( 1 );
                expect(state.scores[0].itemId).toBe(pl.item.id);
                expect(state.scores[0].studentId).toBe(pl.student.id);
                expect(state.scores[0].examId).toBe(pl.exam.id);

                expect(state.scores[0].commentText).toBe(pl.text);
            } );

            it( " updates text value on existing score object ", function () {
                let number = 4;
                let testIndex = 2;
                state = makePopulatedState(number);
                let testText = faker.company.bs();

                //the object that we are going to alter
                let obj = state.scores[testIndex];

                let pl = PayloadScore.factory( {
                    item: Item.factory({ id: obj.itemId}),
                    exam: Exam.factory({id: obj.examId}),
                    student: Student.factory({ id: obj.studentId}),
                    text:  testText
                } );

                expect(pl.text).toBe(testText);

                //call
                mutations[ ngmTypes.updateText ]( state, pl );

                //check
                expect( state.scores.length ).toBe( number );

                //make sure these haven't changed
                expect(state.scores[testIndex].itemId).toBe(pl.item.id);
                expect(state.scores[testIndex].studentId).toBe(pl.student.id);
                expect(state.scores[testIndex].examId).toBe(pl.exam.id);
                //check the set value
                expect(state.scores[testIndex].commentText).toBe(pl.text);

            } );
        } );
    } );



    describe( "getters | ", function () {
        describe( "getItemScoreObject | ", function () {
            it( "happy path ", function () {
                state = makePopulatedState();

                let result = getters.getItemScoreObject( state, {}, {}, 1, 1 );
                expect( result.examId ).toBe( 1 );
            } );
        } );
    } );
    // describe( "actions | ", function () {
    //
    //     describe( description( ngaTypes.storeItemScore ), function () {
    //         it( "happy path ", function () {
    //             state = makeState();
    //
    //             getters[ gTypes.getActiveExamObj ] = sinon.stub();
    //             getters[ gTypes.getActiveExamObj ].returns(testExam);
    //
    //             let action = actions[ ngaTypes.storeItemScore ];
    //
    //             let expectedPayload = PayloadScore.factory( {
    //                 exam: testExam,
    //                 item: testItem,
    //                 student: testStudent,
    //                 score: testScore
    //             } );
    //
    //             testAction( action, expectedPayload, state, [ {
    //                 type: ngmTypes.updateScore,
    //                 payload: expectedPayload
    //             } ] , {verbose: true});
    //
    //         } );
    //     } );
    // } );

} );