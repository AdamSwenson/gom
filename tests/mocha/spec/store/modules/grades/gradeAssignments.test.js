import sinon from 'sinon';

let faker = require( 'faker' );
//
import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//Dependencies
//import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../../resources/assets/js/store/getter-types'
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'


var Component = require( '../../../../../../resources/assets/js/store/modules/grades/gradeAssignments' );

let { getters, actions, mutations } = Component.default;


const makeFakeServerResponse = () => {
    return [
        {
            displayValue: 'A+',
            calcValue: 98,
            minScore: 97,
            group: 0,
            ordinal: 0,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'A',
            calcValue: 95,
            minScore: 93,
            group: 0,
            ordinal: 1,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'A-',
            calcValue: 92,
            minScore: 90,
            group: 0,
            ordinal: 2,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B+',
            calcValue: 88,
            minScore: 87,
            group: 0,
            ordinal: 3,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B',
            calcValue: 85,
            minScore: 83,
            group: 0,
            ordinal: 4,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B-',
            calcValue: 82,
            minScore: 80,
            group: 0,
            ordinal: 5,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C+',
            calcValue: 78,
            minScore: 77,
            group: 0,
            ordinal: 6,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C',
            calcValue: 75,
            minScore: 73,
            group: 0,
            ordinal: 7,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C-',
            calcValue: 72,
            minScore: 70,
            group: 0,
            ordinal: 8,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D+',
            calcValue: 68,
            minScore: 67,
            group: 0,
            ordinal: 9,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D',
            calcValue: 65,
            minScore: 63,
            group: 0,
            ordinal: 10,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D-',
            calcValue: 62,
            minScore: 60,
            group: 0,
            ordinal: 11,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'F',
            calcValue: 55,
            minScore: 50,
            group: 0,
            ordinal: 12,
            id: faker.random.number(),
            gradeId: faker.random.number()
        }
    ];
};

describe.only( "gradeAssignments  ", () => {
    let freq;
    let scores;
    let state;
    let letters;
    // let getters, actions, mutations;

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
            expect( _.isObject( getters ) ).toBe( true );
            expect( _.isObject( actions ) ).toBe( true );
            expect( _.isObject( mutations ) ).toBe( true );
        } );
    } );

    describe( " helpers ", () => {

        describe( " sortTotalScores ", () => {

        } );

        describe( " sortGradeAssignments ", () => {

        } );

        describe( " updateInconsistentList ", () => {

            // beforeEach( () => {
            //     letters = _.keys( state.gradeAssignments );
            // } );

            it( " behaves properly when there are no inconsistencies ", () => {
                Component.updateInconsistentList( state );
                expect( state.inconsistent.length ).toBe( 0 );
            } );

            it( " behaves properly (easy) ", () => {

                let problemKey = faker.random.arrayElement( letters );
                if ( problemKey === 'A+' ) problemKey = 'B-';

                state.gradeAssignments[ problemKey ].minScore = 1000000007;
                Component.updateInconsistentList( state );

                //check
                expect( state.inconsistent.length > 0 ).toBe( true );

            } );


        } );
    } );

    describe( "getters", () => {
        beforeEach( () => {} );

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
                    let result = Component.gradeGetterForScore( state.grade, testScore );
                    // let result = getters.getGradeAssignmentForScore( state, getters, {}, testScore )

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
                let result = getters.getGradeFrequencies( state );
                //check
                expect( _.isObject( result ) ).toBe( true );
                _.forEach( GradeAssignment.defaults, function ( g ) {
                    expect( result[ g.displayValue ] ).toBe( freq );
                } );
            } );


        } );


        describe( gTypes.getInconsistentCutOffs, () => {

            it( " behaves properly when there are no inconsistencies ", () => {
                let result = getters[ gTypes.getInconsistentCutOffs ]( state, getters );
                expect( result.length ).toBe( 0 );
            } );

            it( " behaves properly when there is an inconsistency ", () => {
                let problemKey = faker.random.arrayElement( letters );
                state.inconsistent.push( state.gradeAssignments[ problemKey ] );
                let result = getters[ gTypes.getInconsistentCutOffs ]( state, getters );
                expect( result.length ).toBe( 1 );
                expect( result[ 0 ] ).toBe( state.gradeAssignments[ problemKey] );
            } );
        } );


        describe( gTypes.getListOfGradeValues, () => {

            it( " returns expected list ", () => {
                let origLen = _.size( scores );

                let result = getters.getListOfGradeValues( state );
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
                getters[ gTypes.getAllItems ] = items; // getterStub;

                //call
                let result = getters[ gTypes.getMaxPossibleScore ]( {}, getters, {} );

                //check
                // expect(getterStub.callCount).toBe(1);
                expect( result ).toBe( expectedTotal );
            } );
        } );


    } );//getters


    describe( " actions ", () => {
        beforeEach( () => {
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

    describe( " mutations ", () => {
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
} );
