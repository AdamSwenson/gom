import {
    gradeGetterForScore,
    updateInconsistentList
} from "../../../../../../resources/assets/js/store/modules/grades/grades.helpers";
//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'

require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;


import actions from '../../../../../../resources/assets/js/store/modules/grades/grades.actions' ;


const makeFakeServerResponse = helpers.makeFakeServerResponse;

describe( "gradeAssignments actions ", () => {
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

    describe( " test environment is set up correctly ", () => {
        it( " correctly imported the test objects ", () => {
            expect( _.isObject( actions ) ).toBe( true );
        } );
    } );


    describe( aTypes.loadGradeAssignmentsFromServerData, () => {
        it( " correctly parses the data and calls mutations  ", () => {
            //prep
            let payload = makeFakeServerResponse();

            //call
            testAction( actions[ aTypes.loadGradeAssignmentsFromServerData ], payload, {}, [
                { type: 'replaceGradeAssignments' }
            ], { verbose: true } );

        } );
    } );

} );
