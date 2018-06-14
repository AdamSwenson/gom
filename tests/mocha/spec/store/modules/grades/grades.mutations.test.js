import {
    gradeGetterForScore,
    updateInconsistentList
} from "../../../../../../resources/assets/js/store/modules/grades/grades.helpers";
//Dependencies
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'

require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;


import mutations from '../../../../../../resources/assets/js/store/modules/grades/grades.mutations';


const makeFakeServerResponse = helpers.makeFakeServerResponse;

describe( "gradeAssignments mutations ", () => {
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
    describe( mTypes.updateGradeCutoffs, () => {

        // beforeEach( () => {c} );

        it( " behaves properly when there are no inconsistencies ", () => {
            let alteredKey = faker.random.arrayElement( letters );
            let obj = state.gradeAssignments[ alteredKey ];
            let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: obj.minScore + 1 } )

            //call
            mutations[ mTypes.updateGradeCutoffs ]( state, payload );
            //check
            //the value updated as expected
            expect( obj.minScore ).toBe( payload.updateVal );
            //the inconsistent list was not altered
            expect( state.inconsistent.length ).toBe( 0 );
        } );

        it( " behaves properly when there is one inconsistency ( value is too high for position) ", () => {
            let problemKey = faker.random.arrayElement( letters );
            if ( problemKey === 'A+' ) problemKey = 'B-';
            let obj = state.gradeAssignments[ problemKey ];
            let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 1000000007 } )

            //call
            mutations[ mTypes.updateGradeCutoffs ]( state, payload );

            //check
            //the mutation itself still happened
            expect( obj.minScore ).toBe( payload.updateVal );
            //the grade was recorded as inconsistent
            expect( state.inconsistent.length === 1 ).toBe( true );
            //since the value was too high, the newly inconsistent object
            //should be the changed object's higher neighbor. We can check via the
            //ordinal property
            expect( state.inconsistent[ 0 ].ordinal ).toBe( obj.ordinal - 1 );
        } );

        it( " behaves properly when there is one inconsistency ( value is too low for position) ", () => {
            let problemKey = faker.random.arrayElement( letters );
            if ( problemKey === 'A+' ) problemKey = 'B-';
            let obj = state.gradeAssignments[ problemKey ];
            let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 0 } )

            //call
            mutations[ mTypes.updateGradeCutoffs ]( state, payload );

            //check
            //the mutation itself still happened
            expect( obj.minScore ).toBe( payload.updateVal );
            //the grade was recorded as inconsistent
            expect( state.inconsistent.length === 1 ).toBe( true );
            //since the value was too low, the newly inconsistent object
            //should be the changed object itself.
            expect( state.inconsistent[ 0 ] ).toBe( obj );

        } );

    } );

} );
