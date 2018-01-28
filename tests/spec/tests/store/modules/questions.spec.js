//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as questions from '../../../../../resources/assets/js/store/modules/legacy/questions';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/models/Payload'


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

    let questionIndex = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    let q = factories.questionFactory( questionIndex );
    return {
        questionIndex: q.questionIndex, //faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        content: q.content, //faker.hacker.phrase(),
        questionObject: q
    };
};


const makeMutationPayload = function () {
    let q = factories.questionFactory();
    q.questionIndex = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    let p = new Payload();
    // let s = factories.studentFactory();
    p.index = q.questionIndex;
    p.id = q.questionId; //faker.random.number();
    p.num = faker.random.number();
    p.obj = q;
    return p;
};


//tested object
let obj = questions.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | questions | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
    } );

    describe( "mutations | ", function () {

        // describe( description( mTypes.loadQuestions ), function () {
        //     it( "happy path  ", function () {
        //         let pl = {
        //             [this.payload.questionIndex]: this.payload
        //         };
        //         //call
        //         mutations[ mTypes.loadQuestions ]( this.state, this.rootState, pl);
        //         //check
        //         let result = this.state.questions[this.payload.questionIndex];
        //         expect( result ).toBe( this.payload);
        //     } );
        // } );

        // describe( description( mTypes.loadMaxQuestionScores ), function () {
        //     it( "happy path  ", function () {
        //         //call
        //         mutations[ mTypes.loadMaxQuestionScores ]( this.state, this.rootState, this.payload );
        //         //check
        //         expect( this.state.maxQuestionScores ).toBe( this.payload );
        //     } );
        // } );


        describe( description( mTypes.setMaxQuestionScore ), function () {
            it( "happy path  ", function () {
                //call
                mutations[ mTypes.setMaxQuestionScore ]( this.state, this.rootState, this.mutationPayload );
                //check
                expect( this.state.maxQuestionScores[ this.mutationPayload.index ] ).toBe( this.mutationPayload.num );
            } );
        } );


        describe( description( mTypes.removeMaxQuestionScore ), function () {
            it( "happy path  ", function () {
                //call
                mutations[ mTypes.removeMaxQuestionScore ]( this.state, this.rootState, this.mutationPayload );
                //check
                //check nor in keys
                let target = this.state.maxQuestionScores[ this.mutationPayload.index ]
                expect( typeof Object.keys( this.state.maxQuestionScores )[ this.mutationPayload.index ] ).toBe( 'undefined' );
                expect( typeof target ).toBe( 'undefined' );
            } );
        } );


        describe( description( mTypes.setQuestion ), function () {
            it( "happy path  ", function () {
                //call
                mutations[ mTypes.setQuestion ]( this.state, this.rootState, this.mutationPayload );
                //check
                expect( this.state.questions[ this.mutationPayload.index ] ).toBe( this.mutationPayload.obj );
            } );
        } );


        describe( description( mTypes.removeQuestion ), function () {
            it( "happy path ", function () {
                //call
                mutations[ mTypes.removeQuestion ]( this.state, this.rootState, this.mutationPayload );
                //check
                //check nor in keys
                let target = this.state.questions[ this.mutationPayload.index ]
                // expect( typeof Object.keys( this.state.questions )[this.mutationPayload.index] ).toBe( 'undefined');
                expect( typeof target ).toBe( 'undefined' );
            } );

        } );
    } );


    describe( "actions | ", function () {

        describe( description( aTypes.addQuestion ), function () {
            it( "happy path | ", function () {
                let action = actions[ aTypes.addQuestion ];
                let expectedMutation = [ {
                    type: mTypes.setQuestion,
                    payload: Payload.factory( this.payload )
                } ];

                testAction( action, this.payload, this.state, expectedMutation );
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
            it( "happy path | ", function () {
                let expected = this.state.questions[ this.payload.questionIndex ];

                //call
                let result = getters.getQuestion( this.state, {}, this.rootState, this.payload.questionIndex );

                //check
                expect( result ).toBe( expected );
            } );
        } );
        describe( "getMaxQuestionScore | ", function () {
            it( "happy path | ", function () {
                let expected = this.state.maxQuestionScores[ this.payload.questionIndex ];

                //call
                let result = getters.getMaxQuestionScore( this.state, {}, this.rootState, this.payload.questionIndex );

                //check
                expect( result ).toBe( expected );

            } );
        } );
    } );
} );

