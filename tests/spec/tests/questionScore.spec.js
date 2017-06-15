/**
 * Created by adam on 7/18/16.
 */
/**
 * Created by adam on 7/18/16.
 */


var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';

//helpers
var Helper = require( '../helpers/vueTesting.helper.js' );
var DataHelper = require( '../helpers/dataObject.helper' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );


//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/questionScore.component.js" );
var fixture = 'questionScore.fixture.html';

//Dependencies
// require( '../../../resources/assets/js/grade/components/Data.js' );
import Data from '../../../resources/assets/js/data/Data.js';


describe( "QuestionScoreComponent | ", function () {
    var $fixture;
    var vm;

    var questionIndex, questionNumber;
    var $maxScore, $questionScore;
    var maxScoreIdString;

    function questionScoreIdString( qNum ) {
        return "#questionScore" + qNum;
    }

    function updateScore( questionNumber, newScore ) {
        var event = jQuery.Event( "blur" );
//        event.value = newVal;
        //       event.type = "slideStop";
        $( '#questionScore' + questionNumber ).val( newScore ).trigger( event );

    }

    beforeEach( function () {
        this.questionIndex = 0;
        this.questionNumber = 1;
        this.questionAssignmentId = 1;
        this.studentIndex = 0;
        this.maxScore = 100;

        var store = new Data();
        this.activeStudentIndex = 0;
        store.students[ this.activeStudentIndex ] = DataHelper.makeStudent();
        store.activeStudentIndex = this.activeStudentIndex;


        store.loadMaxQuestionScores( { 0: this.maxScore, 1: 52 } );
        store.loadQuestionScores( { 0: { 0: null, 1: null }, 1: { 0: null, 1: null } } );
        store.loadQuestions({ 0: { questionIndex: this.questionIndex, questionAssignmentId: this.questionAssignmentId, questionNumber: this.questionNumber}});
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'question-score' );

        this.maxScoreIdString = "#maxScore" + this.questionNumber;
        this.$maxScore = $( this.maxScoreIdString );

        this.$questionScore = $( questionScoreIdString( this.questionNumber ) );
    } );

    describe( "Integrity check | ", function () {

        it( "data store ", function () {
            expect( store ).not.toBeUndefined();
            // expect( store.getActiveStudent() ).toBe( 0 );
        } );

        it( "component displays", function () {
            //score field present
            expect( this.$questionScore ).toExist();
            //max score present
            expect( this.$maxScore ).toExist();
        } );

    } );

    describe( "Pre-existing score | ", function () {
        beforeEach( function () {
            this.testScore = 34;
            store.loadQuestionScores( { 0: { 0: this.testScore, 1: null }, 1: { 0: null, 1: null } } );
        } );

        it( "component has the pre-existing score set", function () {
            expect( store.getQuestionScore( 0, 0 ) ).toBe( this.testScore );
            //Helper.assertValueIs(this, 'questionScore', this.testScore);
        } );

        xit( "displays the pre-existing score", function () {
            expect( this.$questionScore.val() ).toBe( this.testScore );
        } );
    } );

    describe( "updates store when changed | ", function () {
        beforeEach( function () {
            this.prevScore = 39;
            this.newScore = 56;
            store.loadQuestionScores( { 0: { 0: this.prevScore, 1: null }, 1: { 0: null, 1: null } } );
            // Vue.nextTick( function () {
            // } );
        } );

        it( "stored score updates", function () {
            let component = Helper.getComponent(this);
            var me = this;

            //prep ---make sure has initial value
           expect( store.getQuestionScore(0,0) ).toBe( this.prevScore );
            var event = jQuery.Event( "blur" );

            //call
            component.questionScore = this.newScore;
            //It sure would be nice to manipulate the dom to to this...
            //document.getElementById('questionScore1').value =this.newScore;
            //or this
            // $( '#questionScore' + questionNumber ).val( this.newScore );

            //check
            expect( store.getQuestionScore( 0, 0 ) ).toBe( me.newScore );
            //Helper.assertValueIs( me, 'questionScore', me.newScore );

        } );

        it( "emits a notification to update the score on the server", function () {
            let component = this.vm.$refs.testObject;
            let spy = sinon.spy();
            this.vm.$on( 'store-question-score-request', spy );

            //call
            component.questionScore = 34;

            window.console.log(spy.args);
            //check
            expect( spy.calledOnce ).toBe( true );
            expect( spy.calledWith( {
                questionIndex: this.questionIndex,
                studentIndex: this.studentIndex,
                questionAssignmentId: this.questionAssignmentId
            } ) ).toBe( true );
        } );
    } );
} );
