//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as times from '../../../../../resources/assets/js/store/modules/legacy/times';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/models/Payload'

const makeState = ( n = 5 ) => {
    let s = makeRootState();
    //
    for ( let i = 0; i < n; i++ ) {
        s.examGradingTimes[ i ] = faker.random.number();
    }

    return s;
};

const makeRootState = function () {
    return {
        examGradingTimes: {}
    };
};

const makeTestPayload = function () {
    return {
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        timeToAdd: faker.random.number()
    };
};

const makeMutationPayload = function () {
    let p = new Payload();
    p.index = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    p.num = faker.random.number();
    return p;
};

//tested object
let obj = times.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | times", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
    } );

    describe( description( "mutations" ), function () {
        beforeEach( function () {
            this.mutationPayload = makeMutationPayload();
        } );

        describe( description( mTypes.setGradingTime ), function () {
            it( "happy path | ", function () {
                let prevVal = this.state[ this.mutationPayload.index ];
                let expected = prevVal + this.mutationPayload.val;
                mutations[ mTypes.setGradingTime ]( this.state, this.mutationPayload );
                //check that overwrites
                expect( this.state[ this.mutationPayload.index ] ).toBe( this.expected );
            } );
        } );

        describe( description( mTypes.incrementGradingTime ), function () {
            it( "happy path | ", function () {
                let prevVal = this.state[ this.mutationPayload.index ];
                let expected = prevVal + this.mutationPayload.val;
                mutations[ mTypes.setGradingTime ]( this.state, this.mutationPayload );
                //check that overwrites
                expect( this.state[ this.mutationPayload.index ] ).toBe( this.expected );
            } );
        } );


        describe( description( mTypes.removeGradingTime ), function () {
            it( "happy path | ", function () {
                mutations[ mTypes.removeGradingTime ]( this.state, this.mutationPayload );
                //check
                expect( this.state[ this.mutationPayload.index ] ).toBe( undefined );
                //  expect( this.state.indexOf(this.mutationPayload.index)).toBe( -1 );
            } );
        } );


        describe( description( mTypes.resetGradingTime ), function () {
            it( "happy path | ", function () {
                mutations[ mTypes.resetGradingTime ]( this.state, this.mutationPayload );
                //check
                expect( this.state.examGradingTimes[ this.mutationPayload.index ] ).toBe( 0 );
            } );
        } );


    } );

    describe( "actions | ", function () {

        describe( description( aTypes.storeGradingTime ), function () {

            xit( "happy path ", function () {
                //todo
            } );
        } );

        describe( description( aTypes.incrementGradingTime ), function () {

            it( "happy path ", function () {
                let pl = makeTestPayload();
                let expected = Payload.factory( {index: pl.studentIndex, num: pl.timeToAdd} );

                // console.log( expected, pl );
                let action = actions[ aTypes.incrementGradingTime ];

                testAction( action, pl, this.state, [
                    {
                        type: mTypes.incrementGradingTime,
                        payload: expected
                    }
                ] );
            } );

        } );

        describe( description( aTypes.loadGradingTimes ), function () {
                it( "happy path  ", function () {
                    let pl = [ makeMutationPayload(), makeMutationPayload() ];
                    pl[ 0 ].index = 0;
                    pl[ 1 ].index = 1;

                    let expectedMutations = [
                        {
                            type: mTypes.setGradingTime,
                            payload: pl[ 0 ]
                        },
                        {
                            type: mTypes.setGradingTime,
                            payload: pl[ 1 ]
                        }
                    ];

                    let action = actions[ aTypes.loadGradingTimes ]

                    testAction( action, pl, this.state, expectedMutations );
            } );
        } );
    } );

    describe( "getters | ", function () {
        beforeEach( function () {
            this.testIndex = 2;
            this.testTime = faker.random.number();
            this.get = {
                getActiveStudentIndex: () => {
                    return this.testIndex;
                }, getStudentGradingTime: () => {

                    // console.log( 'gsgt', this.testTime );
                    return this.testTime;
                }
            };
            this.getters = {
                getStudentGradingTime: () => {
                    // console.log( 'gsgt', this.testTime );
                    return this.testTime;
                }
            };
        } );

        describe( description( "getTotalGradingTime" ), function () {

            xit( "happy path | ", function () {
                //todo
            } );
        } );

        describe( description( "getStudentGradingTime" ), function () {

            it( "happy path | ", function () {
                //call
                let result = getters.getStudentGradingTime( this.state, {}, this.testIndex );
                //check
                let expected = this.state.examGradingTimes[ this.testIndex ];
                expect( result ).toBe( expected );
            } );
        } );

    } );

} );
