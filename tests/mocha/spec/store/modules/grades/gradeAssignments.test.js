// import {
//     gradeGetterForScore,
//     updateInconsistentList
// } from "../../../../../../resources/assets/js/store/modules/grades/grades.helpers";
// //Dependencies
// import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'
//
// require( '../../../../injectglobals' );
//
// const testAction = helpers.testAction;
// const description = helpers.description;
//
//
// var Component = require( '../../../../../../resources/assets/js/store/modules/grades/gradeAssignments' );
//
// let { getters, actions, mutations } = Component.default;
//
//
// const makeFakeServerResponse = helpers.makeFakeServerResponse;
//
// describe ( "gradeAssignments  ", () => {
//     let freq;
//     let scores;
//     let state;
//     let letters;
//
//     beforeEach( () => {
//         //we fill the total scores with two scores of
//         //each minimum for a grade. thus all grades
//         //will have frequency = 2
//         freq = 2;
//         scores = [];
//
//         _.forEach( GradeAssignment.defaults, function ( g ) {
//             for (let i = 0; i < freq; i++) {
//                 scores.push( g.calcValue );
//             }
//         } );
//         state = {
//             gradeAssignments: GradeAssignment.initialize(),
//             totalScores: scores,
//             inconsistent: []
//         };
//
//         letters = _.keys( state.gradeAssignments );
//
//     } );
//
//     describe( " test environment is set up correctly ", () => {
//         it( " correctly imported the test objects ", () => {
//             expect( _.isObject( getters ) ).toBe( true );
//             expect( _.isObject( actions ) ).toBe( true );
//             expect( _.isObject( mutations ) ).toBe( true );
//         } );
//     } );
//
//     describe( " helpers ", () => {
//
//         describe( " sortTotalScores ", () => {
//
//         } );
//
//         describe( " sortGradeAssignments ", () => {
//
//         } );
//
//         describe( " updateInconsistentList ", () => {
//
//             // beforeEach( () => {
//             //     letters = _.keys( state.gradeAssignments );
//             // } );
//
//             it( " behaves properly when there are no inconsistencies ", () => {
//                 updateInconsistentList( state );
//                 expect( state.inconsistent.length ).toBe( 0 );
//             } );
//
//             it( " behaves properly (easy) ", () => {
//
//                 let problemKey = faker.random.arrayElement( letters );
//                 if ( problemKey === 'A+' ) problemKey = 'B-';
//
//                 state.gradeAssignments[ problemKey ].minScore = 1000000007;
//                 updateInconsistentList( state );
//
//                 //check
//                 expect( state.inconsistent.length > 0 ).toBe( true );
//
//             } );
//
//
//         } );
//     } );
//
//     describe( "getters", () => {
//         beforeEach( () => {} );
//
//         // describe( gTypes.getCutOffsForLetterGrade, () => {
//         //
//         //     it( "happy path", function () {
//         //
//         //     } );
//         //
//         // } );
//
//         describe( gTypes.getGradeAssignmentForScore, () => {
//             it( " the underlying helper function returns correct grade object", () => {
//                 _.forEach( GradeAssignment.defaults, function ( g ) {
//                     //prep
//                     let testScore = g.minScore + 1;
//
//                     //call
//                     let result = gradeGetterForScore( state.grade, testScore );
//                     // let result = getters.getGradeAssignmentForScore( state, getters, {}, testScore )
//
//                     //check
//                     expect( result.calcValue ).toBe( g.calcValue );
//                     expect( result.displayValue ).toBe( g.displayValue );
//                     expect( result.minScore ).toBe( g.minScore );
//                 } );
//             } );
//         } );
//
//
//         describe( gTypes.getGradeFrequencies, () => {
//
//             it( " returns an object with the correct structure and values ", () => {
//                 //call
//                 let result = getters.getGradeFrequencies( state );
//                 //check
//                 expect( _.isObject( result ) ).toBe( true );
//                 _.forEach( GradeAssignment.defaults, function ( g ) {
//                     expect( result[ g.displayValue ] ).toBe( freq );
//                 } );
//             } );
//
//
//         } );
//
//
//         describe( gTypes.getInconsistentCutOffs, () => {
//
//             it( " behaves properly when there are no inconsistencies ", () => {
//                 let result = getters[ gTypes.getInconsistentCutOffs ]( state, getters );
//                 expect( result.length ).toBe( 0 );
//             } );
//
//             it( " behaves properly when there is an inconsistency ", () => {
//                 let problemKey = faker.random.arrayElement( letters );
//                 state.inconsistent.push( state.gradeAssignments[ problemKey ] );
//                 let result = getters[ gTypes.getInconsistentCutOffs ]( state, getters );
//                 expect( result.length ).toBe( 1 );
//                 expect( result[ 0 ] ).toBe( state.gradeAssignments[ problemKey] );
//             } );
//         } );
//
//
//         describe( gTypes.getListOfGradeValues, () => {
//
//             it( " returns expected list ", () => {
//                 let origLen = _.size( scores );
//
//                 let result = getters.getListOfGradeValues( state );
//                 expect( _.isArray( result ) ).toBe( true );
//                 expect( _.size( result ) ).toBe( _.size( scores ) );
//
//                 for (let i = 0; i < scores.length; i++) {
//                     expect( result[ i ] ).toBe( scores[ i ] );
//                 }
//             } );
//
//         } );
//
//
//         describe( gTypes.getMaxPossibleScore, () => {
//             it( " computes the max score from the minScores of all the loaded items ", () => {
//
//                 let numItems = 5;
//                 let expectedTotal = 0;
//                 let items = [];
//                 //create items
//                 for (let i = 0; i < numItems; i++) {
//                     let max = numItems + i;
//                     items.push( Item.factory( { maxScore: max } ) );
//                     expectedTotal += max;
//                 }
//                 //we can't stub this because the test is not invoking vue
//                 //so it doesn't realize the stub is supposed to be a function
//                 // let getterStub = sinon.stub();
//                 // getterStub.returns(items);
//                 getters[ gTypes.getAllItems ] = items; // getterStub;
//
//                 //call
//                 let result = getters[ gTypes.getMaxPossibleScore ]( {}, getters, {} );
//
//                 //check
//                 // expect(getterStub.callCount).toBe(1);
//                 expect( result ).toBe( expectedTotal );
//             } );
//         } );
//
//
//     } );//getters
//
//
//     describe( " actions ", () => {
//         beforeEach( () => {
//         } );
//         describe( aTypes.loadGradeAssignmentsFromServerData, () => {
//             it( " correctly parses the data and calls mutations  ", () => {
//                 //prep
//                 let payload = makeFakeServerResponse();
//
//                 //call
//                 testAction( actions[ aTypes.loadGradeAssignmentsFromServerData ], payload, {}, [
//                     { type: 'replaceGradeAssignments' }
//                 ], { verbose: true } );
//
//             } );
//         } );
//
//     } );
//
//     describe( " mutations ", () => {
//         describe( mTypes.updateGradeCutoffs, () => {
//
//             // beforeEach( () => {c} );
//
//             it( " behaves properly when there are no inconsistencies ", () => {
//                 let alteredKey = faker.random.arrayElement( letters );
//                 let obj = state.gradeAssignments[ alteredKey ];
//                 let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: obj.minScore + 1 } )
//
//                 //call
//                 mutations[ mTypes.updateGradeCutoffs ]( state, payload );
//                 //check
//                 //the value updated as expected
//                 expect( obj.minScore ).toBe( payload.updateVal );
//                 //the inconsistent list was not altered
//                 expect( state.inconsistent.length ).toBe( 0 );
//             } );
//
//             it( " behaves properly when there is one inconsistency ( value is too high for position) ", () => {
//                 let problemKey = faker.random.arrayElement( letters );
//                 if ( problemKey === 'A+' ) problemKey = 'B-';
//                 let obj = state.gradeAssignments[ problemKey ];
//                 let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 1000000007 } )
//
//                 //call
//                 mutations[ mTypes.updateGradeCutoffs ]( state, payload );
//
//                 //check
//                 //the mutation itself still happened
//                 expect( obj.minScore ).toBe( payload.updateVal );
//                 //the grade was recorded as inconsistent
//                 expect( state.inconsistent.length === 1 ).toBe( true );
//                 //since the value was too high, the newly inconsistent object
//                 //should be the changed object's higher neighbor. We can check via the
//                 //ordinal property
//                 expect( state.inconsistent[ 0 ].ordinal ).toBe( obj.ordinal - 1 );
//             } );
//
//             it( " behaves properly when there is one inconsistency ( value is too low for position) ", () => {
//                 let problemKey = faker.random.arrayElement( letters );
//                 if ( problemKey === 'A+' ) problemKey = 'B-';
//                 let obj = state.gradeAssignments[ problemKey ];
//                 let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 0 } )
//
//                 //call
//                 mutations[ mTypes.updateGradeCutoffs ]( state, payload );
//
//                 //check
//                 //the mutation itself still happened
//                 expect( obj.minScore ).toBe( payload.updateVal );
//                 //the grade was recorded as inconsistent
//                 expect( state.inconsistent.length === 1 ).toBe( true );
//                 //since the value was too low, the newly inconsistent object
//                 //should be the changed object itself.
//                 expect( state.inconsistent[ 0 ] ).toBe( obj );
//
//             } );
//
//         } );
//
//     } );
// } );
