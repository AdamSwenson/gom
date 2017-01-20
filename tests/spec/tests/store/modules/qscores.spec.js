require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as qscores from '../../../../../resources/assets/js/store/modules/qscores';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

const makeState = ( n = 5 ) => {
    let s = makeRootState();

    for ( let i = 0; i < n; i++ ) {
        s.questionScores[ i ] = {};
        for ( let k = 0; k < n; k++ ) {
            s.questionScores[ i ][ k ] = faker.random.number();
        }
    }
    ;

    return s;
};

const makeRootState = function () {
    return {
        questionScores: {}
    };
};

const makeTestPayload = function () {
    return {
        questionIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        score: faker.random.number()
    };
};


//tested object
let obj = qscores.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | ", function () {
    describe( "qscores | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
        } );

        describe( "mutations | ", function () {
            describe( description( mTypes.loadQuestionScores ), function () {
                it( "happy path | ", function () {
                    //call
                    mutations[ mTypes.loadQuestionScores ]( this.state, this.rootState, this.payload );

                    //check
                    //the object will be replaced by test
                    expect( this.state.questionScores ).toBe( this.payload );
                } );
            } );

            describe( description( mTypes.setQuestionScore ), function () {
                it( "happy path | ", function () {
                    console.log( this.state, this.payload );
                    //call
                    mutations[ mTypes.setQuestionScore ]( this.state, this.rootState, this.payload );

//check
                    let result = this.state.questionScores[ this.payload.studentIndex ][ this.payload.questionIndex ];
                    let expected = this.payload[ this.payload.studentIndex ][ this.payload.questionIndex ];
                    expect( result ).toBe( this.payload );
                } );
            } );
        } );

        describe( "actions | ", function () {

            describe( description( aTypes.loadQuestionScores ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.loadQuestionScores ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.loadQuestionScores,
                        payload: this.payload
                    } ] );

                } );
            } );

            describe( description( aTypes.setQuestionScore ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.setQuestionScore ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setQuestionScore,
                        payload: this.payload
                    } ] );

                } );
            } );

            describe( description( aTypes.storeQuestionScoreForActiveStudent ), function () {
                xit( "happy path | ", function () {
                    //todo
                } );
            } );
        } );

        describe( "getters | ", function () {
            describe( "getQuestionScore | ", function () {
                it( "happy path | ", function () {
                    let expected = this.state.elementScores[ this.payload.studentIndex ][ this.payload.elementIndex ];

                    //call
                    let result = getters.getElementScore( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                    //check
                    expect( result ).toBe( expected );
                } );
            } );

            describe( "getQuestionScoreForActiveStudent | ", function () {
                xit( "happy path | ", function () {
                    //todo
                } );
            } );
        } );

    } );
} );