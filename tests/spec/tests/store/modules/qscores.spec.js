require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as qscores from '../../../../../resources/assets/js/store/modules/qscores';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/store/models/Payload'


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

const makeMutationPayload = function () {
    let p = new Payload();
    // let s = factories.studentFactory();
    p.index = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    p.index2 = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    p.id = faker.random.number();
    p.num = faker.random.number();
    p.obj = {};
    return p;
};


//tested object
let obj = qscores.default;
//tested methods
let {getters, actions, mutations} = obj;

fdescribe( "store | modules | ", function () {
    describe( "qscores | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
            this.mutationPayload = makeMutationPayload();
        } );

        describe( "mutations | ", function () {
            describe( description( mTypes.setQuestionScore ), function () {
                it( "happy path ", function () {
                    // console.log( 'spec.setQuestionScore', this.state, this.mutationPayload );

                    let studentIndex = this.mutationPayload.index;
                    let questionIndex = this.mutationPayload.index2;

                    //call
                    mutations[ mTypes.setQuestionScore ]( this.state, this.rootState, this.mutationPayload );
                    let result = this.state.questionScores[ studentIndex ][ questionIndex ];

                    //check
                    expect( result ).toBe( this.mutationPayload.num );
                } );
            } );
        } );

        describe( "actions | ", function () {
            describe( description( aTypes.loadQuestionScores ), function () {
                describe( "happy path | ", function () {
                    it( "1 score to set", function () {
                        let action = actions[ aTypes.loadQuestionScores ];
                        let pay1 = makeTestPayload();
                        console.log( 'pa1', pay1 );
                        let pl1 = new Payload();
                        pl1.index = pay1.studentIndex;
                        pl1.index2 = pay1.questionIndex;
                        pl1.num = pay1.score;

                        testAction( action, [pay1], this.state, [ {
                            type: mTypes.setQuestionScore,
                            payload: pl1
                        } ] );
                    } );

                    it( "multiple scores to set", function () {
                        let action = actions[ aTypes.loadQuestionScores ];

                        let pay1 = makeTestPayload();
                        console.log( 'pa1', pay1 );
                        let pl1 = new Payload();
                        pl1.index = pay1.studentIndex;
                        pl1.index2 = pay1.questionIndex;
                        pl1.num = pay1.score;

                        let pay2 = makeTestPayload();
                        let pl2 = new Payload();
                        pl2.index = pay2.studentIndex;
                        pl2.index2 = pay2.questionIndex;
                        pl2.num = pay2.score;

                        testAction( action, [pay1, pay2], this.state,
                            [
                                {
                                    type: mTypes.setQuestionScore,
                                    payload: pl1
                                },
                                {
                                    type: mTypes.setQuestionScore,
                                    payload: pl2
                                }
                            ] );
                    } );

                } );

            } );

            describe( description( aTypes.setQuestionScore ), function () {
                it( "happy path ", function () {
                    let action = actions[ aTypes.setQuestionScore ];

                    let pl = new Payload();
                    pl.index = this.payload.studentIndex;
                    pl.index2 = this.payload.questionIndex;
                    pl.num = this.payload.score;

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setQuestionScore,
                        payload: pl
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
                    let expected = this.state.questionScores[ this.payload.studentIndex ][ this.payload.questionIndex ];

                    //call
                    let result = getters.getQuestionScore( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.questionIndex );

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