//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );


const makeState = ( n = 5 ) => {
    // Format: { studentIndex : { elementIndex : elementScore},  ...
    let s = {
        elementScores: {}
    };

    for ( let i = 0; i < n; i++ ) {
        s.elementScores[ i ] = {}
        for ( let k = 0; k < n; k++ ) {
            s.elementScores[ i ][ k ] = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
        }
    }
    return s;
};

const makeRootState = () => {
    return {
        elementScores: {}
    };
};

const makeTestPayload = () => {
    return {
        elementIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        elementScore: faker.random.number()
    };
};


import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as escores from '../../../../../resources/assets/js/store/modules/escores';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

//tested object
let obj = escores.default;
//tested methods
let {getters, actions, mutations} = obj;

describe( "store | modules | ", function () {
    describe( "escores | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
        } );

        describe( "mutations | ", function () {
            describe( description( mTypes.loadElementScores ), () => {

                it( "happy path | ", function () {
                    //call
                    mutations.loadElementScores( this.state, this.rootState, this.payload );

                    //check
                    //the object will be replaced by test
                    expect( this.state.elementScores ).toBe( this.payload );
                } );

            } );

            describe( description( mTypes.setElementScore ), function () {
                it( "happy path | ", function () {
                    //call
                    mutations.setElementScore( this.state, this.rootState, this.payload );

                    //check
                    //the object will be replaced by test
                    expect( this.state.elementScores[ this.payload.studentIndex ][ this.payload.elementIndex ] )
                        .toBe( this.payload.elementScore );
                } );
            } );


        } );

        describe( "actions | ", function () {
            describe( description( aTypes.storeElementScoreForActiveStudent ), function () {
                xit( "happy path | ", function () {
                    //todo
                } );
            } );

            describe( description( aTypes.storeElementScore ), () => {
                it( "happy path | ", () => {
                    let action = actions[ aTypes.storeElementScore ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setElementScore,
                        payload: this.payload
                    } ] );

                } );
            } );
        } );

        describe( "getters | ", function() {
            describe( "getElementScore | ", function(){
                it( "happy path | ", function(){
                    let expected = this.state.elementScores[ this.payload.studentIndex ][ this.payload.elementIndex ];

                    //call
                    let result = getters.getElementScore( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                    //check
                    expect( result ).toBe( expected );

                } );
            } );

            describe( "getElementScoreForActiveStudent | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );
    } );
} );

