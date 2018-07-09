//test libraries
require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;
//
// let sinon = require( 'sinon' );
// let faker = require( 'faker' );
//
// import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment';

import Item from '../../../../../../resources/assets/js/models/Item';
import Student from '../../../../../../resources/assets/js/models/Student';
import Exam from '../../../../../../resources/assets/js/models/Exam';


import {
    sliderSettings,
    checkInRange,
    makeCutoffsFromMaxScore,
    isSameValence,
    getValenceIndexForScore,
    getValenceIndex
} from '../../../../../../resources/assets/js/store/modules/scores/commentHelpers';


describe( "commentHelpers | ", function () {
    let sliderScore;


    beforeEach( function () {

    } );


    describe( " makeCutoffsFromMaxScore", () => {
        it( " creates the expected values ", () => {
            let numberLabels = sliderSettings.valenceLabels.length;
            let maxScore = 100;
            let expectedStep = maxScore / numberLabels;

            let result = makeCutoffsFromMaxScore( maxScore, numberLabels );

            //check
            expect( result.length ).toBe( numberLabels );
            expect( result[ 0 ]).toBe( 0 ) ; //min score is 0
            expect(result[numberLabels - 1]).toBe(maxScore); //max score is item max

            let i = 0;
            _.forEach(sliderSettings.valenceLabelPositions, function ( vlp ) {
                expect(result[i]).toBe((vlp * .01) * maxScore);
                i++;
            });

        } );
    } );

    describe( " getValenceForScore", () => {

        it( " happy path using default settings ", () => {
            let testScore = sliderSettings.valenceCutoffs[ sliderSettings.valenceCutoffs.length - 1 ];
            let expectedValence = sliderSettings.valenceCutoffs.length  - 1;
            let result = getValenceIndexForScore( testScore );

            expect( result ).toBe( expectedValence );
        } );

        it( " happy path using max score ", () => {
            let expectedValence = 2;
            let testScore = 200;
            let maxScore = 600;

            let result = getValenceIndexForScore( testScore, maxScore );

            expect( result ).toBe( expectedValence );
        } );

        it( " throws error on null score ", () => {
            expect( function () {
                getValenceIndexForScore( null );
            } ).toThrow();
        } );

        it( " throws error when score is less than the least cutoff ", () => {
            expect( function () {
                getValenceIndexForScore( -12 );
            } ).toThrow();
        } );

    } );

    describe( " checkInRange ", () => {

        it( " returns true when score greater than the least cutoff ", () => {
            let cutoffs = [ 0, 2, 56, 23 ];
            let result = checkInRange( 3, cutoffs );
            expect( result ).toBe( true );
        } );

        it( " throws error when score less than the least cutoff ", () => {
            let cutoffs = [ 0, 2, 56, 23 ];
            expect( function () {
                checkInRange( -2, cutoffs );
            } ).toThrow();
        } );

    } );

    describe( " getValenceIndex ", () => {

        it( " happy path ", () => {
            let cutoffs = [ 0, 4, 23, 56 ];
            let testVal = faker.random.arrayElement( cutoffs )
            let testIndex = cutoffs.indexOf( testVal );

            //call
            let result = getValenceIndex( testVal, cutoffs );

            //check
            expect( result ).toBe( testIndex );
        } );
    } );

    describe( " isSameValence", () => {

        it( " returns true when old and new are equal ", () => {
            let oldScore = 5;
            let newScore = 5;
            let maxScore = 10;

            let result = isSameValence( oldScore, newScore, maxScore );

            expect( result ).toBe( true );
        } );


        it( " returns false when old > new ", () => {
            let oldScore = 9;
            let newScore = 5;
            let maxScore = 10;

            let result = isSameValence( oldScore, newScore, maxScore );

            expect( result ).toBe( false );
        } );


        it( " returns false when old < new ", () => {
            let oldScore = 1;
            let newScore = 5;
            let maxScore = 10;

            let result = isSameValence( oldScore, newScore, maxScore );

            expect( result ).toBe( false );
        } );


        it( " returns false when old is undefined ", () => {
            let oldScore;
            let newScore = 5;
            let maxScore = 10;

            let result = isSameValence( oldScore, newScore, maxScore );

            expect( result ).toBe( false );
        } );


    } );

} );
