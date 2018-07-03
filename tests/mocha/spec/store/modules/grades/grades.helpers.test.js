import {
    gradeGetterForScore,
    updateInconsistentList
} from "../../../../../../resources/assets/js/store/modules/grades/grades.helpers";
//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'

require( '../../../../injectglobals' );
const makeFakeServerResponse = helpers.makeFakeServerResponse;

const testAction = helpers.testAction;
const description = helpers.description;


import * as helpers from '../../../../../../resources/assets/js/store/modules/grades/grades.helpers' ;



describe( "grades.helpers  ", () => {
    let freq;
    let scores;
    let state;
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

    } );


    describe( " sortTotalScores ", () => {

    } );

    describe( " sortGradeAssignments ", () => {

    } );

    describe( " updateInconsistentList ", () => {

        // beforeEach( () => {
        //     letters = _.keys( state.gradeAssignments );
        // } );

        it( " behaves properly when there are no inconsistencies ", () => {
            helpers.updateInconsistentList( state );
            expect( state.inconsistent.length ).toBe( 0 );
        } );

        it( " behaves properly (easy) ", () => {

            let problemKey = faker.random.arrayElement( letters );
            if ( problemKey === 'A+' ) problemKey = 'B-';

            state.gradeAssignments[ problemKey ].minScore = 1000000007;
            helpers.updateInconsistentList( state );

            //check
            expect( state.inconsistent.length > 0 ).toBe( true );

        } );


    } );
} );
