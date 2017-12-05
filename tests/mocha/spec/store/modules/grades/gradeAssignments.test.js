require( 'sinon' );
let faker = require( 'faker' );
//
// import { testAction, description, factories } from '../../../../helpers/vuex.spec.helpers';

//Dependencies
//import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../../resources/assets/js/store/getter-types'
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'

// import  { getters, actions, mutations } from '../../../../../../resources/assets/js/store/modules/grades/gradeAssignments';
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
            totalScores: scores
        };
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
    } );

    describe( "getters", () => {
        beforeEach( () => {

        } );

        describe( gTypes.getCutOffsForLetterGrade, () => {

            it( "happy path", function () {

            } );

        } );


        describe( gTypes.getGradeForScore, () => {
            it( " returns correct grade object ", () => {
                _.forEach( GradeAssignment.defaults, function ( g ) {
                    //prep
                    let testScore = g.minScore + 1;

                    //call
                    let result = getters.getGradeForScore( state, getters, state, testScore )

                    //check
                    expect( result.calcValue ).toBe( g.calcValue );
                    expect( result.displayValue ).toBe( g.displayValue );
                    expect( result.minScore ).toBe( g.minScore );
                } );
            } );
        } );


        describe( gTypes.getGradeFrequencies, () => {

            it( " returns the expected object with the correct structure ", () => {
                //call
                let result = getters.getGradeFrequencies( state );
                //check
                expect( _.isObject( result ) ).toBe( true );
                _.forEach( GradeAssignment.defaults, function ( g ) {
                    expect( result[ g.displayValue ] ).toBe( freq );
                } );
            } );

            it( " correctly calculates the frequency values " );

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
            it( " computes the max score from the minScores of all the loaded items " );
        } );


    } );//getters


    describe.only( " actions ", () => {
        let commit;
        beforeEach( () => {
            commit[ 'replaceGradeAssignments' ] = sinon.spy();
        } );
        describe( aTypes.loadGradeAssignmentsFromServerData, () => {
            it( " correctly parses the data and calls mutations  ", () => {
                //prep
                let payload = makeFakeServerResponse();

                //call
                actions[ aTypes.loadGradeAssignmentsFromServerData ]( {}, {}, commit, {}, payload );

                //check
                expect( commit.replaceGradeAssignments.callCount ).toBe( 1 );
                expect( commit.replaceGradeAssignments.args.className ).toBe( 'gradeAssignment' );

            } );
        } );

    } );


} );
//
//     describe( "mutations | ", function () {
//         describe( description( mTypes.setItem ), function () {
//
//             describe( "no preexisting | ", function () {
//                 describe( "payload is Payload | ", function () {
//
//                     //This is the main use case
//                     it( "happy path", function () {
//                         let payload = Payload.factory( { obj: this.item } );
//
//                         //call
//                         mutations[ mTypes.setItem ]( this.state, payload );
//
//                         //check
//                         //expect( state.items[ item.index ] ).toBe( item );
//                         expect( this.state.items[ this.item.index ] ).toBe( this.item );
//                     } );
//
//                     describe( 'unhappy paths | ', function () {
//                         it( "payload.obj not Item | ", function () {
//
//                             // mutations[ mTypes.setItem ]( this.state, this.mutationPayload );
//                             // console.log( 'addItems', this.state.items , this.mutationPayload.index);
//                             // expect( this.state.items[ this.mutationPayload.index] ).toBe( this.mutationPayload.obj );
//                             // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                             // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
//                         } );
//
//
//                     } );
//
//                 } );
//
//                 describe( " payload is Item", function () {
//                     // it( "happy path", function () {
//                     //     //call
//                     //     mutations[ mTypes.setItem ]( this.state, this.item );
//                     //
//                     //     //check
//                     //     expect( this.state.items[ this.item.index ] ).toBe( this.item );
//                     //     // expect( this.state.items[ item.index ] ).toBe( item );
//                     // } );
//                     //
//                     // describe( "unhappy paths | ", function () {
//                     // } );
//                 } );
//
//             } );
//         } );
//         describe( description( mTypes.addItemIndexMapping ), function () {
//             it( "happy path ", function () {
//
//                 //call
//                 mutations[ mTypes.addItemIndexMapping ]( this.state, this.rootState, this.mutationPayload );
//
//                 //check
//                 expect( this.state.indexMap.get( this.mutationPayload.index ) ).toBe( this.mutationPayload.id );
//             } );
//
//             describe( "unhappy paths | ", function () {
//                 xit( "payload does not contain index  | ", function () {
//                     // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                     // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
//                 } );
//
//                 xit( "payload does not contain id  | ", function () {
//                     // mutations[ mTypes.setItem ]( this.state, this.rootState, this.payload );
//                     // expect( this.state.items[ this.payload.obj.id ] ).toBe( this.payload.obj );
//                 } );
//             } );
//         } );
//
//         describe( description( mTypes.loadItems ), function () {
//             xit( "happy path | ", function () {
//                 //todo
//             } );
//         } );
//
//         describe( description( mTypes.addNewItem ), function () {
//             it( "happy path", function () {
//                 let prevLen = this.state.itemsRepo.length;
//                 //call
//                 mutations[ mTypes.addNewItem ]( this.state );
//
//                 //check
//                 //expect( state.items[ item.index ] ).toBe( item );
//                 let r = this.state.itemsRepo[ prevLen + 1 ];
//                 // expect( this.state.itemsRepo.length ).toBe( prevLen + 1 );
//                 expect( r.index ).toBe( prevLen + 1 );
// //                            expect( this.state.items.get( this.item.index ) ).toBe( this.item );
//             } );
//
//             describe( 'unhappy paths | ', function () {
//             } );
//         } );
//     } );
//

