//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as questions from '../../../../../resources/assets/js/store/modules/questions';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

const makeState = ( n = 5 ) => {
    let s = makeRootState();
    //
    for ( let i = 0; i < n; i++ ) {
        s.questions[ i ] = {
            questionIndex: i,
            content: faker.hacker.phrase(),
        };
    }


    return s;
};

const makeRootState = function () {
    return {
        numberQuestions: null,
        maxQuestionScores: {},
        questions: {}
    };
};

const makeTestPayload = function () {
    return {
        questionIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        content: faker.hacker.phrase(),
        questionObject: {}
    };
};


//tested object
let obj = questions.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | ", function () {
    describe( "questions | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
        } );

        describe( "mutations | ", function () {

            describe( description( mTypes.loadQuestions ), function () {
                it( "happy path | ", function () {
                    let pl = {
                        [this.payload.questionIndex]: this.payload
                    };
                    //call
                    mutations[ mTypes.loadQuestions ]( this.state, this.rootState, pl);
                    //check
                    let result = this.state.questions[this.payload.questionIndex];
                    expect( result ).toBe( this.payload);
                } );
            } );

            describe( description( mTypes.loadMaxQuestionScores ), function () {
                it( "happy path | ", function () {
                    //call
                    mutations[ mTypes.loadMaxQuestionScores ]( this.state, this.rootState, this.payload );
                    //check
                    expect( this.state.maxQuestionScores ).toBe( this.payload );
                } );
            } );

            describe( description( mTypes.setQuestion ), function () {
                it( "happy path | ", function () {
                    //call
                    mutations[ mTypes.setQuestion ]( this.state, this.rootState, this.payload );

                    //check
                    //the object will be replaced by test
                    expect( this.state.questions[ this.payload.questionIndex ] ).toBe( this.payload.questionObject );
                } );
                //todo
            } );
        } );


        describe( "actions | ", function () {

            describe( description( aTypes.addQuestion ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.addQuestion ];
                    // console.log( this.payload );
                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setQuestion,
                        // payload: {questionIndex: this.payload.questionIndex, questionObject: this.payload.questionObject}
                    } ] );
                } );
            } );

            describe( description( aTypes.loadMaxQuestionScores ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.loadMaxQuestionScores ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.loadMaxQuestionScores,
                        payload: this.payload
                    } ] );
                } );
            } );

            describe( description( aTypes.loadQuestions ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.loadQuestions ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.loadQuestions,
                        payload: this.payload
                    } ] );
                } );
            } );

            describe( description( aTypes.loadNumberQuestions ), function () {
                it( "happy path | ", function () {
                    let action = actions[ aTypes.loadNumberQuestions ];

                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setNumberQuestions,
                        payload: this.payload
                    } ] );
                } );
            } );

        } );

        describe( "getters | ", function () {
            describe( "getQuestion | ", function () {
                it( "happy path | ", function(){
                    let expected = this.state.questions[ this.payload.questionIndex ];

                    //call
                    let result = getters.getQuestion( this.state, {}, this.rootState, this.payload.questionIndex);

                    //check
                    expect( result ).toBe( expected );
                } );
            } );
            describe( "getMaxQuestionScore | ", function () {
                it( "happy path | ", function(){
                    let expected = this.state.maxQuestionScores[ this.payload.questionIndex ];

                    //call
                    let result = getters.getMaxQuestionScore( this.state, {}, this.rootState, this.payload.questionIndex );

                    //check
                    expect( result ).toBe( expected );

                } );
            } );
        } );
    } );
} )
;
