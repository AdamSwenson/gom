import {
    gradeGetterForScore,
    updateInconsistentList
} from "../../../../../../resources/assets/js/store/modules/grades/grades.helpers";

//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'
import Item from '../../../../../../resources/assets/js/models/Item'

require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;


import getters from '../../../../../../resources/assets/js/store/modules/grades/grades.getters' ;

import { createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();
localVue.use( Vuex )


const makeFakeServerResponse = helpers.makeFakeServerResponse;

describe( "grades.getters ", () => {
    let freq;
    let scores;
    let state, store;
    let letters;

    beforeEach( () => {
        //we fill the total scores with two scores of
        //each minimum for a grade. thus all grades
        //will have frequency = 2
        freq = 2;
        scores = [];

        _.forEach( GradeAssignment.defaults, function ( g ) {
            for (let i = 0; i < freq; i++) {
                scores.push( g.calcValue );
            }
        } );
        state = {
            gradeAssignments: GradeAssignment.initialize(),
            totalScores: scores,
            inconsistent: []
        };

        letters = _.keys( state.gradeAssignments );

        store = new Vuex.Store( {
            state, getters
        } );


    } );


    // describe( gTypes.getCutOffsForLetterGrade, () => {
    //
    //     it( "happy path", function () {
    //
    //     } );
    //
    // } );

    describe( gTypes.getGradeAssignmentForScore, () => {
        it( " the underlying helper function returns correct grade object", () => {
            _.forEach( GradeAssignment.defaults, function ( g ) {
                //prep
                let testScore = g.minScore + 1;

                //call
                // let result = gradeGetterForScore( state.grade, testScore );
                let result = store.getters.getGradeAssignmentForScore( testScore )

                //check
                expect( result.calcValue ).toBe( g.calcValue );
                expect( result.displayValue ).toBe( g.displayValue );
                expect( result.minScore ).toBe( g.minScore );
            } );
        } );
    } );


    describe( gTypes.getGradeFrequencies, () => {

        it( " returns an object with the correct structure and values ", () => {
            //call
            let result = store.getters.getGradeFrequencies;
            //check
            expect( _.isObject( result ) ).toBe( true );
            _.forEach( GradeAssignment.defaults, function ( g ) {
                expect( result[ g.displayValue ] ).toBe( freq );
            } );
        } );


    } );


    describe( gTypes.getInconsistentCutOffs, () => {

        it( " behaves properly when there are no inconsistencies ", () => {
            let result = store.getters[ gTypes.getInconsistentCutOffs ];
            expect( result.length ).toBe( 0 );
        } );

        it( " behaves properly when there is an inconsistency ", () => {
            let problemKey = faker.random.arrayElement( letters );
            state.inconsistent.push( state.gradeAssignments[ problemKey ] );
            //call
            let result = store.getters[ gTypes.getInconsistentCutOffs ];
            //check
            expect( result.length ).toBe( 1 );
            expect( result[ 0 ] ).toBe( state.gradeAssignments[ problemKey ] );
        } );
    } );


    describe( gTypes.getListOfGradeValues, () => {

        it( " returns expected list ", () => {
            let origLen = _.size( scores );

            let result = store.getters.getListOfGradeValues;
            expect( _.isArray( result ) ).toBe( true );
            expect( _.size( result ) ).toBe( _.size( scores ) );

            for (let i = 0; i < scores.length; i++) {
                expect( result[ i ] ).toBe( scores[ i ] );
            }
        } );

    } );


    describe( gTypes.getMaxPossibleScore, () => {
        it( " computes the max score from the minScores of all the loaded items ", () => {

            let numItems = 5;
            let expectedTotal = 0;
            let items = [];
            //create items
            for (let i = 0; i < numItems; i++) {
                let max = numItems + i;
                items.push( Item.factory( { maxScore: max } ) );
                expectedTotal += max;
            }
            //we can't stub this because the test is not invoking vue
            //so it doesn't realize the stub is supposed to be a function
            // let getterStub = sinon.stub();
            // getterStub.returns(items);
            getters[ gTypes.getAllItems ] = (  ) => {
                return items;
            } // getterStub;

            store = new Vuex.Store( {
                state, getters
            } );

            //call
            let result = store.getters[ gTypes.getMaxPossibleScore ];

            //check
            // expect(getterStub.callCount).toBe(1);
            expect( result ).toBe( expectedTotal );
        } );
    } );


} );
