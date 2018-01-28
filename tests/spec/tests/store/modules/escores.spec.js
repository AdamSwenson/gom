//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as escores from '../../../../../resources/assets/js/store/modules/legacy/escores';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/models/Payload'


//valid values for indexes
const studentIndexValues = [ 0, 1, 2, 3, 4 ];
const elementIndexValues = [ 0, 1, 2, 3, 4 ];


const makeState = ( n = 5 ) => {
    // Format: { studentIndex : { elementIndex : elementScore},  ...
    let s = {
        elementScores: {}
    };

    for ( let i = 0; i < n; i++ ) {
        s.elementScores[ i ] = {}
        for ( let k = 0; k < n; k++ ) {
            s.elementScores[ i ][ k ] = faker.random.number();
        }
    }
    return s;
};

const makeRootState = function () {
    return {
        elementScores: {}
    };
};

const makeTestPayload = function () {
    let m = makeMutationPayload();
    return {
        elementIndex: m.index2,
        studentIndex: m.index,
        elementScore: m.num
    };
};


const makeMutationPayload = function () {
    return Payload.factory( {
        index: faker.random.arrayElement( studentIndexValues ),
        index2: faker.random.arrayElement( elementIndexValues ),
        num: faker.random.number(),
        // obj: {test: 'test'}
    } );
};


//tested object
let obj = escores.default;
//tested methods
let {getters, actions, mutations} = obj;

describe( "store | modules | escores | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();

    } );

    describe( "mutations | ", function () {
        describe( description( mTypes.loadElementScores ), function () {

            it( "happy path ", function () {
                this.mutationPayload.obj = {test: 'test'};

                //call
                mutations.loadElementScores( this.state, this.rootState, this.mutationPayload );

                //check
                expect( this.state.elementScores ).toBe( this.mutationPayload.obj );
            } );

        } );

        describe( description( mTypes.setElementScore ), function () {
            it( "happy path  ", function () {
                //call
                mutations.setElementScore( this.state, this.rootState, this.mutationPayload );

                //check
                expect( this.state.elementScores[ this.mutationPayload.index ][ this.mutationPayload.index2 ] )
                    .toBe( this.mutationPayload.num );
            } );
        } );
    } );


    describe( "actions | ", function () {

        describe( description( aTypes.setElementScore ), function () {
            it( "happy path ", function () {
                let action = actions[ aTypes.setElementScore ];
                let p = {
                    studentIndex: this.mutationPayload.index,
                    elementIndex: this.mutationPayload.index2,
                    score: this.mutationPayload.num
                };
                this.mutationPayload.obj = 'undefined';
                testAction( action, p, this.state, [ {
                    type: mTypes.setElementScore,
                    payload: this.mutationPayload
                } ] );

            } );
        } );
    } );

    describe( "getters | ", function () {
        describe( "getElementScore | ", function () {
            it( "happy path ", function () {
                let expected = this.state.elementScores[ this.payload.studentIndex ][ this.payload.elementIndex ];

                //call
                let result = getters.getElementScore( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                //check
                expect( result ).toBe( expected );

            } );
        } );

    } );
} );

