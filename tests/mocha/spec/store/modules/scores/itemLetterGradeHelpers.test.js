//test libraries

let sinon = require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment';

import Item from '../../../../../../resources/assets/js/models/Item';
import Student from '../../../../../../resources/assets/js/models/Student';
import Exam from '../../../../../../resources/assets/js/models/Exam';


import { calculateItemScoreFromLetterGrade, calculateGradeAssignmentFromItemScore } from '../../../../../../resources/assets/js/store/modules/scores/itemLetterGradeHelpers';


describe( "itemLetterGradeHelpers | ", function () {
    let state;
    let testExam;
    let testItem;
    let testStudent;
    let testScore;

    beforeEach( function () {

    } );

    describe( "calculateItemScoreFromLetterGrade | ", function () {

        it( " happy paths ", function () {
            _.forEach( GradeAssignment.defaults, function ( ga ) {
                let maxScore = 100;
                let result = calculateItemScoreFromLetterGrade( ga, maxScore );
                expect( result ).toBe( ga.calcValue );
            } );
        } );
    } );

    describe( "calculateGradeAssignmentFromItemScore", function () {

        it( " happy paths ", function () {
            _.forEach( GradeAssignment.defaults, function ( ga ) {
                let maxScore = 100;
                let score = ga.minScore;
                let result = calculateGradeAssignmentFromItemScore( score, maxScore );
                expect( result.displayValue ).toBe( ga.displayValue );
            } );

        } );
    } );
} );
