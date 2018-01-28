//test libraries

import * as nggTypes from "../../../../../../resources/assets/js/store/new-grading-getter-types";

let sinon = require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//Dependencies
import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as ngmTypes from '../../../../../../resources/assets/js/store/new-grading-mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/action-types';
import * as ngaTypes from '../../../../../../resources/assets/js/store/new-grading-action-types';
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

import PayloadScore from '../../../../../../resources/assets/js/models/PayloadScore';
import ItemScore from '../../../../../../resources/assets/js/models/ItemScore';
import Item from '../../../../../../resources/assets/js/models/Item';
import Student from '../../../../../../resources/assets/js/models/Student';
import Exam from '../../../../../../resources/assets/js/models/Exam';


import mutations from '../../../../../../resources/assets/js/store/modules/scores/itemscores.mutations';

import { itemscores } from "../../../../helpers/state-factories";
let { makePopulatedState, makeState } = itemscores;


//tested methods

describe( "itemscores | mutations  ", function () {
    let state;
    let testExam;
    let testItem;
    let testStudent;
    let testScore;
    let testText;

    beforeEach( function () {
        testExam = factories.examFactory();
        testItem = factories.itemFactory();
        testStudent = factories.studentFactory();
        testScore = faker.random.number();
        testText = faker.company.bs();
    } );

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
            expect( state.scores[ 0 ].itemId ).toBe( pl.item.id );
            expect( state.scores[ 0 ].studentId ).toBe( pl.student.id );
            expect( state.scores[ 0 ].examId ).toBe( pl.exam.id );

            expect( state.scores[ 0 ].score ).toBe( pl.score );
        } );

        it( " updates values on existing score object ", function () {
            let number = 4;
            let testIndex = 2;
            state = makePopulatedState( number );

            //the object that we are going to alter
            let obj = state.scores[ testIndex ];

            let pl = PayloadScore.factory( {
                item: Item.factory( { id: obj.itemId } ),
                exam: Exam.factory( { id: obj.examId } ),
                student: Student.factory( { id: obj.studentId } ),
                score: testScore
            } );

            //call
            mutations[ ngmTypes.updateScore ]( state, pl );

            //check
            expect( state.scores.length ).toBe( number );

            //make sure these haven't changed
            expect( state.scores[ testIndex ].itemId ).toBe( pl.item.id );
            expect( state.scores[ testIndex ].studentId ).toBe( pl.student.id );
            expect( state.scores[ testIndex ].examId ).toBe( pl.exam.id );
            //check the set value
            expect( state.scores[ testIndex ].score ).toBe( pl.score );

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
            expect( state.scores[ 0 ].itemId ).toBe( pl.item.id );
            expect( state.scores[ 0 ].studentId ).toBe( pl.student.id );
            expect( state.scores[ 0 ].examId ).toBe( pl.exam.id );
            //check the set value
            expect( state.scores[ 0 ].text ).toBe( pl.text );
        } );

        it( " updates text value on existing score object ", function () {
            let number = 4;
            let testIndex = 2;
            state = makePopulatedState( number );
            let testText = faker.company.bs();

            //the object that we are going to alter
            let obj = state.scores[ testIndex ];

            let pl = PayloadScore.factory( {
                item: Item.factory( { id: obj.itemId } ),
                exam: Exam.factory( { id: obj.examId } ),
                student: Student.factory( { id: obj.studentId } ),
                text: testText
            } );

            expect( pl.text ).toBe( testText );

            //call
            mutations[ ngmTypes.updateText ]( state, pl );

            //check
            expect( state.scores.length ).toBe( number );
            //make sure these haven't changed
            expect( state.scores[ testIndex ].itemId ).toBe( pl.item.id );
            expect( state.scores[ testIndex ].studentId ).toBe( pl.student.id );
            expect( state.scores[ testIndex ].examId ).toBe( pl.exam.id );
            //check the set value
            expect( state.scores[ testIndex ].text ).toBe( pl.text );

        } );
    } );
} );
