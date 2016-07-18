/**
 * Created by adam on 7/15/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';

//helpers
var Helper = require('./helpers/vueTestingHelpers.js');


//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
// Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/studentListItem" );
require( '../../../resources/assets/js/grade/components/Data.js' );

function loadComponent(testedComponent, componentName) {
    //declare
    var MyComponent = Vue.extend( testedComponent );
    // register
    Vue.component(  componentName, MyComponent )

    // create a root instance
    var vm = new Vue( {
        el: '#app'
    } ).$mount();

    return vm;
    // compile off-document and append afterwards:
    // new MyComponent().$mount().$appendTo( '#app' )
}


function assertRowActive(studentIndex, not=false){
    var $row = $('#studentListItem' + studentIndex);
    expect($row).toExist();
    if(not){
        expect($row).not.toHaveClass('activeStudentRow');
    }else{
        expect($row).toHaveClass('activeStudentRow');
    }
}

function assertRowDefault(studentIndex, not=false){
    var $row = $('#studentListItem' + studentIndex);
    expect($row).toExist();
    if(not){
        expect($row).not.toHaveClass('unalteredStudentRow');
    }else{
        expect($row).toHaveClass('unalteredStudentRow');
    }
}

describe( "StudentListItem | ", function () {
    var $studentName;
    var $studentIdentifier;
    var $examGrade;
    var $fixtures;
    var $row;
    var studentIndex;
    var placeHolder;

    beforeEach( function () {
        this.studentIndex = 0;
        this.firstName = 'Jill';
        this.lastName = 'Jillenson';
        this.studentIdentifier = '123456789';
        this.studentId = '1';
        this.placeHolder = "--";

        var store = new Data();
        store.loadQuestionScores( {
            0: {
                0: null,
                1: null,
                2: null
            },
            1: {
                0: null,
                1: null,
                2: null,
            }
        } );
        store.loadGradingTimes( {} );
        store.loadExamGrades( {
            0: 'Letter grade',
            1: 'Letter grade',
            2: 'Letter grade'
        } );
        store.loadNumberQuestions( 2 );
        window.store = store;

        this.$fixture = loadFixtures( 'studentListItem.fixture.html' );

        // var fixture = '<div id="app">' +
        //     '<table>' +
        //     '<tr is="student-list-item"' +
        //     ':student-index="' + this.studentIndex + '" ' +
        //     'first-name="' + this.firstName + '" ' +
        //     'last-name="' + this.lastName + '" ' +
        //     'student-identifier="' + this.studentIdentifier + '" ' +
        //     'student-id="' + this.studentId + '" ' +
        //     'exam-grade="' + this.examGrade + '" ' +
        //     '></tr>'
        // '</table>' +
        // '</div>'
        // this.$fixture = setFixtures(fixture);
        // appendSetStyleFixtures(".activeStudentRow{}");

        Helper.loadVueComponent(testedComponent, 'student-list-item');

        //set selectors
        this.rowIdString = '#studentListItem' + this.studentIndex;
        this.$row = $(this.rowIdString);
        this.$studentName = $( "#studentName" + this.studentIndex );
        this.$studentIdentifier = $( "#studentIdentifier" + this.studentIndex );
        this.$examGrade = $( "#examGrade" + this.studentIndex );
    } );

    describe( "integrity check | ", function () {
        window.console.log('-------- integrity check --------');

        it( "checks that the data store is valid and accessible", function () {
            expect( store ).not.toBeUndefined();
            expect( store.examGrades[ 0 ] ).toBe( 'Letter grade' );
        } );


        it( "checks that the component is intact", function () {
            expect(this.$row).toExist();
            expect(this.$row).toHaveClass('studentListItem');
            expect(this.$studentName).toExist();
            expect(this.$studentIdentifier).toExist();
            expect(this.$examGrade).toExist();
            //check has data
            expect(this.$studentName.text()).toBe(this.lastName + ', ' + this.firstName);
            expect(this.$studentIdentifier.text()).toBe(this.studentIdentifier);
            //default class
            window.console.log('row', this.$row);
            // expect(this.$row).toHaveClass('unalteredStudentRow');
        } );
    } );


    describe( "active student display | ", function () {
        window.console.log('-------- active student display --------');

        it("checks the initial state of the row ", function(){
            //default class
            expect(this.$row).toHaveClass('unalteredStudentRow');
            expect(this.$row).not.toHaveClass('activeStudentRow');
            expect(this.$row).not.toHaveClass('gradedStudentRow');
        });

//         it( "designates the active student by setting a class", function (done) {
//
//             //call
//             store.activeStudent = this.studentIndex;
//
//                 setTimeout(function() {
//                     done();
//                 }, 5000);
//
//             var row = document.getElementById('studentListItem' + this.studentIndex);
//             window.console.log('row classList', row.classList);
//             window.console.log('classList', row.classList.item(1).value);
//             expect(row.classList[1]).toBe('activeStudentRow');
//
// // setTimeout(function(){}, 5);
//             expect(this.$row).toExist();
//             // window.console.log('class', row.className);
//             // window.console.log('class2', row.getProperty('class'));
//             // expect(this.$row).not.toHaveAttr('class', 'studentListItem unalteredStudentRow');
//             // expect(this.$row.attr('class')).not.toBe('studentListItem unalteredStudentRow');
//             // expect(this.$row.attr('class')).not.toBe('studentListItem gradedStudentRow');
//             // expect(this.$row.attr('class')).toBe('studentListItem activeStudentRow');
//             // expect(this.$row).toHaveAttr('class', 'studentListItem activeStudentRow');
//             // expect(this.$row).not.toHaveClass('unalteredStudentRow');
//             // expect(this.$row).not.toHaveClass('gradedStudentRow');
//            // expect(this.$row).toHaveClass('activeStudentRow');
//            //  expect(row).toHaveAttr('class', 'activeStudentRow');
//         } );



    } );

    describe( "active student functions | ", function () {
        window.console.log('-------- active student functions --------');

        it( "when clicked, sets the student to active and emits a notification event", function () {
            //prep
            // store.activeStudent = null;
            // var spyEvent = spyOnEvent( this.rowIdString, 'student-select-event' );

            //call
            this.$row.trigger( 'click' );

            //check
            // expect( 'student-select-event' ).toHaveBeenTriggeredOn( this.rowIdString );
            // expect( spyEvent ).toHaveBeenTriggered();
            expect( store.activeStudent ).toBe( this.studentIndex );
            assertRowActive(this.studentIndex);

        } );
    });

    describe( "student grade functions | ", function () {
        window.console.log('-------- student grade functions --------');

        it( "displays a placeholder for the grade of an ungraded student and the row has the correct styling", function () {
            window.console.log('grade placeholder');
            //prep
            store.examGrades[this.activeStudent] = "letterGrade";
            //check
            expect(this.$examGrade.text()).toBe('--');
            expect(this.$row).toHaveClass('unalteredStudentRow');
        } );


        it( "displays the score and styling of a graded student ", function () {
            //prep
            var gradeVal = 55;
            store.examGrades[this.activeStudent] = gradeVal;

            //check
            expect(this.$examGrade.val()).toBe(gradeVal);
            expect(this.$row).toHaveClass('gradedStudentRow');
        } );


        it( "when a grade is recorded for a student the placeholder is replaced with the actual grade and the styling is updated", function () {
            //prep
            var gradeVal = 55;
            store.examGrades[this.activeStudent] = "letterGrade";

            //check --see placeholder
            expect(this.$examGrade.val()).toBe('--');
            expect(this.$row).toHaveClass('unalteredStudentRow');

            //call --student is graded
            store.examGrades[this.activeStudent] = gradeVal;

            //check --see grade
            expect(this.$examGrade.val()).toBe(gradeVal);
            expect(this.$row).toHaveClass('gradedStudentRow');
        } );

    } );



    describe( "grading blind functions | ", function () {
        window.console.log('-------- grading blind functions --------');


        it( "displays a placeholder rather than the student name if the exam is being graded blind", function () {
            //prep
            store.isBlind = true;

            //check
            expect( this.$studentName.text() ).toBe( this.placeHolder );
        } );

        it( "displays the student's name if the exam is not being graded blind", function () {
            //prep
            store.isBlind = false;

            //check
            expect( this.$studentName.text() ).toBe( this.lastName + ', ' + this.firstName );
        } );
    } );


} );

describe("student is active | ", function() {

    beforeEach( function () {
        this.studentIndex = 0;
        this.firstName = 'Jill';
        this.lastName = 'Jillenson';
        this.studentIdentifier = '123456789';
        this.studentId = '1';
        this.placeHolder = "--";

        var store = new Data();
        store.activeStudent = this.studentIndex;
        store.loadQuestionScores( {
            0: {
                0: null,
                1: null,
                2: null
            },
            1: {
                0: null,
                1: null,
                2: null,
            }
        } );
        store.loadGradingTimes( {} );
        store.loadExamGrades( {
            0: 'Letter grade',
            1: 'Letter grade',
            2: 'Letter grade'
        } );
        store.loadNumberQuestions( 2 );
        window.store = store;

        this.rowIdString = '#studentListItem' + this.studentIndex;
        window.console.log('initial active student', store.activeStudent);

        this.$fixture = loadFixtures( 'studentListItem.fixture.html' );

        Helper.loadVueComponent(testedComponent, 'student-list-item');
    } );

    it( "designates the active student by setting a class", function (  ) {
        window.console.log('-------- %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%');
        window.console.log('active', store.activeStudent);

        expect(store.activeStudent).toBe(this.studentIndex);

        assertRowActive(this.studentIndex);
    } );

    it( "when the student is no longer active, the row lacks the active student class", function () {
        //prep
        assertRowActive(this.studentIndex);

        //call
        store.activeStudent = null;
        window.console.log('active post', store.activeStudent);

        //check --starting with active student
        assertRowActive(this.studentIndex, true);
        assertRowDefault(this.studentIndex);
    } );
});
