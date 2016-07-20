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
require( 'sinon' );

//helpers
var Helper = require( '../helpers/vueTesting.helper.js' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/letterGradeButton.component.js" );
var fixture = 'letterGrade.fixture.html';

//Dependencies
require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "LetterGradeButton component tests | ", function () {
    var $fixture;
    var vm;

    var $gradeDisplay, $button, $gradeList;
    var questionNumber, questionIndex, maxScore;

    beforeEach( function () {
        this.questionNumber = "1";
        this.questionIndex = 0;
        this.maxScore = 100;

        var store = new Data();
        store.activeStudent = 0;
        store.maxQuestionScores = { 0: this.maxScore, 1: this.maxScore };
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

        //set values on the tested component
        // this.vm.$refs.testObject.questionNumber = this.questionNumber;
        //     this.vm.$refs.testObject.grades = {
        //     0: { calcValue: 'A', displayValue: 96 },
        //     1: { calcValue: 'B', displayValue: 85 }
        // };

        this.$gradeDisplay = $( "#letterGradeForQuestion" + this.questionNumber );
        this.$button = $( '#letterGradeButton' + this.questionNumber );
        this.$gradeList = $( "#letterGradeList" );

    } );

    describe( "intact | ", function () {
        it( "displays as expected ", function () {
            expect( this.$gradeDisplay ).toExist();
            expect( this.$button ).toExist();
            expect( this.$gradeList ).toExist();
        } );

        it( "component has expected properties ", function () {
            //prep
            let component = this.vm.$refs.testObject;

            //check
            expect( component.questionIndex ).toBe( this.questionIndex );
            expect( component.questionNumber ).toBe( this.questionNumber );
            expect( component.maxScore ).toBe( this.maxScore );
        } );

        it( "displays list when clicked", function () {
            //expect($(".gradeListItem")).not.toBeVisible();
            //call
            this.$button.click();
            //check
            expect( $( ".gradeListItem" ) ).toBeVisible();
        } );
    } );

    describe( "pre-existing grade | ", function () {
        it( "displays pre-existing", function () {

        } );
    } );

    describe( "event handling |", function () {


        it( 'sends event when called programmatically', function () {
            //prep
            let component = this.vm.$refs.testObject;
            let spy = sinon.spy();
            let testGradeVal = 88;
            this.vm.$on( 'letter-grade-selected', spy );
            component.gradeValue = testGradeVal;
            expect( component.gradeValue ).toBe( testGradeVal );

            //call
            component.notifyLetterGradeSelection();

            //check
            expect( spy.calledOnce ).toBe( true );
            expect( spy.calledWith( {
                questionIndex: this.questionIndex,
                questionNumber: this.questionNumber,
                score: testGradeVal
            } ) ).toBe( true );
        } );

        it( "sends event on click ", function () {

            //prep
            let component = this.vm.$refs.testObject;
            let spy = sinon.spy();
            let testGradeVal = 98; //the first item on the grades list
            this.vm.$on( 'letter-grade-selected', spy );

            $( ".gradeListItem" ).first().click();

            //check
            expect( spy.calledOnce ).toBe( true );
            expect( spy.calledWith( {
                questionIndex: this.questionIndex,
                questionNumber: this.questionNumber,
                score: testGradeVal
            } ) ).toBe( true );

        } );
    } );

    describe( "tooltip | ", function () {

        xit( "inserts tooltip when called programmatically ", function () {
            //prep
            let bootstrapEvent = 'show.bs.tooltip';
            let spy = sinon.spy();
            this.vm.$on( bootstrapEvent, spy );

            let component = this.vm.$refs.testObject;
            let $toolTip = $( "[id^='tooltip']" );
            expect( $toolTip ).not.toExist();

            //call
            component.showGradePopOver(component.targetId, component.displayedgrade, component.gradeValue, component.maxScore);
//            $( ".gradeListItem" ).first().click();

            //check
            expect( spy.calledOnce ).toBe( true );


        } );


        xit( "inserts tooltip on click", function () {
            //prep
            let $toolTip = $( "[id^='tooltip']" );
            expect( $toolTip ).not.toExist();

            //call
            $( ".gradeListItem" ).first().click();

            //check
            expect( $toolTip ).toExist();
        } );

    } );

    describe( "unit tests | ", function () {


        it( "grade calc function", function () {

            let component = this.vm.$refs.testObject;
            let gradeValue = 88;
            let maxScore = 100;

            let result = component.calcGrade( gradeValue, maxScore );
            expect( result ).toBe( 88.00 );

            component.gradeValue = gradeValue;
            expect( component.score ).toBe( 88.00 );
        } );

        it( 'sends event ', function () {
            //prep
            let component = this.vm.$refs.testObject;
            let spy = sinon.spy();
            let testGradeVal = 88;
            this.vm.$on( 'letter-grade-selected', spy );
            component.gradeValue = testGradeVal;
            expect( component.gradeValue ).toBe( testGradeVal );

            //call
            component.notifyLetterGradeSelection();

            //check
            expect( spy.calledOnce ).toBe( true );
            expect( spy.calledWith( {
                questionIndex: this.questionIndex,
                questionNumber: this.questionNumber,
                score: testGradeVal
            } ) ).toBe( true );
        } );

    } );
} );
