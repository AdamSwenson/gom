require( '../../../../injectglobals' );

//test libraries
// import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';
const description = helpers.description;
const testAction = helpers.testAction;
//Dependencies
// import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
// import * as ngmTypes from '../../../../../../resources/assets/js/store/new-grading-mutation-types';
// import * as aTypes from '../../../../../../resources/assets/js/store/action-types';
// import * as ngaTypes from '../../../../../../resources/assets/js/store/new-grading-action-types';
// import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

import PayloadScore from '../../../../../../resources/assets/js/models/PayloadScore';

import actions from '../../../../../../resources/assets/js/store/modules/scores/itemscores.actions';

import { itemscores } from "../../../../helpers/state-factories";

let { makePopulatedState, makeState } = itemscores;


describe( "itemscores.actions ", function () {
    let state;
    let testExam;
    let testItem;
    let testStudent;
    let testScore;
    let testText;
    let getters = {};

    beforeEach( function () {
        testExam = factories.examFactory();
        testItem = factories.itemFactory();
        testStudent = factories.studentFactory();
        testScore = faker.random.number();
        testText = faker.company.bs();
    } );


    describe( " initializeItemScore ", function () {
        it( " happy path ", () => {
            state = makeState();

            let action = actions.initializeItemScore;

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                mutateSilently: true
            } );

            //nb we can use the expected payload even though it is
            //only expecting an object
            testAction( action, expectedPayload, state, [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            } ], { verbose: false } );

        } );
    } );

    describe( "loadScoresFromServer", () => {
        it( "happy path ", () => {

        } );
    } );
    describe( description( ngaTypes.recordItemScore ), function () {
        it( "updates the score but does not update the comment when old score is undefined  ", function () {
            state = makeState();

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            //  getters[ gTypes.getActiveExamObj ].returns( testExam );

            let action = actions[ ngaTypes.recordItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: testScore
            } );

            testAction( action, expectedPayload, state, [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            } ], { verbose: false, getters: getters } );

        } );

        it( " updates the score but does not update the comment when old and new scores are same valence", () => {
            state = makeState();
            let itemScore = factories.itemScoreFactory();
            itemScore.score = 9;
            testItem.maxScore = 10;

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( itemScore );

            let action = actions[ ngaTypes.recordItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: 10
            } );

            testAction( action, expectedPayload, state, [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            } ], { verbose: false, getters: getters } );

            //This effectively tests that the rest of the
            //method which alters comment text is not called
            //since those operations depend on things which
            //have not been defined here.
        } );

        it( " updates the score but does not update the comment text when the preexisting text is custom (despite the valence being different) ", () => {
            state = makeState();
            let itemScore = factories.itemScoreFactory();
            itemScore.score = 9;
            testItem.maxScore = 10;
            itemScore.isCustomText = true;

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( itemScore );

            let action = actions[ ngaTypes.recordItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: 1
            } );

            testAction( action, expectedPayload, state, [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            } ], { verbose: false, getters: getters } );

        } );

        it( " updates the score and updates the comment when there is no preexisting comment text ", () => {
            state = makeState();
            let itemScore = factories.itemScoreFactory();
            itemScore.score = 9;
            itemScore.text = '';
            itemScore.isCustomText = false;
            testItem.maxScore = 10;

            testItem.comments.set( 'missing', testText );

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( itemScore );

            let action = actions[ ngaTypes.recordItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: 0
            } );

            let expectedPayload2 = {
                exam: testExam,
                item: testItem,
                student: testStudent,
                text: testText
            };

            let expectedMutations = [
                {
                    type: ngmTypes.updateScore,
                    payload: expectedPayload
                },
                {
                    type: ngaTypes.recordCommentText,
                    payload: expectedPayload2
                }
            ];

            testAction( action, expectedPayload, state, expectedMutations, { verbose: false, getters: getters } );

        } );

        it( " updates the score and updates the comment text when the preexisting comment is stock (determined by the boolean isCustomText for now) ", () => {
            state = makeState();
            let itemScore = factories.itemScoreFactory();
            itemScore.score = 9;
            itemScore.isCustomText = false;
            testItem.maxScore = 10;

            testItem.comments.set( 'missing', testText );

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( itemScore );

            let action = actions[ ngaTypes.recordItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: 0
            } );

            let expectedPayload2 = {
                exam: testExam,
                item: testItem,
                student: testStudent,
                text: testText
            };

            let expectedMutations = [
                {
                    type: ngmTypes.updateScore,
                    payload: expectedPayload
                },
                {
                    type: ngaTypes.recordCommentText,
                    payload: expectedPayload2
                }
            ];

            testAction( action, expectedPayload, state, expectedMutations, { verbose: false, getters: getters } );

        } );

    } );

    describe( description( ngaTypes.recordCommentText ), function () {
        it( "happy path ", function () {
            state = makeState();

            let action = actions[ ngaTypes.recordCommentText ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                text: testText
            } );

            testAction( action, expectedPayload, state, [ {
                type: ngmTypes.updateText,
                payload: expectedPayload
            } ], { verbose: false } );

        } );
    } );

    describe( description( ngaTypes.resetItemScore ), function () {
        it( " resets the score to null and clears comment when comment is stock ", () => {
            state = makeState();
            testItem.isCustomText = false;

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( testItem );

            let action = actions[ ngaTypes.resetItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: null
            } );

            let ep2 = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                text: ''
            } );

            let expectedMutations = [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            }, {
                type: ngmTypes.updateText,
                payload: ep2
            }, ];

            testAction( action, expectedPayload, state, expectedMutations, { verbose: false, getters: getters } );

        } );

        it( " resets the score to null but does not clear comment when comment is custom", () => {
            state = makeState();
            testItem.isCustomText = true;

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( testItem );

            let action = actions[ ngaTypes.resetItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: null
            } );


            let expectedMutations = [ {
                type: ngmTypes.updateScore,
                payload: expectedPayload
            }, ];

            testAction( action, expectedPayload, state, expectedMutations, { verbose: false, getters: getters } );

        } );

        it( " takes no action when the score is not set but the comment is ", () => {
            state = makeState();
            testItem.isCustomText = true;
            testItem.score = null;

            getters[ nggTypes.getItemScoreObject ] = sinon.stub();
            getters[ nggTypes.getItemScoreObject ].returns( testItem );

            let action = actions[ ngaTypes.resetItemScore ];

            let expectedPayload = PayloadScore.factory( {
                exam: testExam,
                item: testItem,
                student: testStudent,
                score: null
            } );


            let expectedMutations = [  ];

            testAction( action, expectedPayload, state, expectedMutations, { verbose: false, getters: getters } );
        } );


    } );

} );


