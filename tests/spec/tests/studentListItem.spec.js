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
require( 'sinon' )

//helpers
var Helper = require( '../helpers/vueTesting.helper.js' );


//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
// Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/studentListItem" );
require( '../../../resources/assets/js/grade/components/Data.js' );


/**
 * Checks whether student row is set as active.
 * Setting the not parameter to true checks whether
 * the student is inactive
 *
 * @param studentIndex
 * @param not
 */
function assertRowActive( dthis, studentIndex, not = false ) {
    var $row = $( '#studentListItem' + studentIndex );
    expect( $row ).toExist();
    if ( not ) {
        Helper.assertValueIs( dthis, 'isActiveStudent', false );
        Helper.assertValueIs( dthis, 'isUnaltered', true );

        //TODO resurrect when figure out how to test vue display
        // expect($row).not.toHaveClass('activeStudentRow');
    } else {
        // it( "component's isActiveStudent property is set to true", function () {
        Helper.assertValueIs( dthis, 'isActiveStudent', true );
        // });
        // it( "component's isUnaltered property is set to false", function () {
        Helper.assertValueIs( dthis, 'isUnaltered', false );
        // });

        //TODO resurrect when figure out how to test vue display
        // expect($row).toHaveClass('activeStudentRow');
    }
}

function assertRowDefault( dthis, studentIndex, not = false ) {
    var $row = $( '#studentListItem' + studentIndex );
    expect( $row ).toExist();
    if ( not ) {
        Helper.assertValueIs( this, 'isUnaltered', false );

        //TODO resurrect when figure out how to test vue display
        // expect($row).not.toHaveClass('unalteredStudentRow');
    } else {
        Helper.assertValueIs( this, 'isUnaltered', true );

        //TODO resurrect when figure out how to test vue display
        //expect( $row ).toHaveClass( 'unalteredStudentRow' );
    }
}


describe( "StudentListItem | ", function () {
    var vm;
    var $fixtures;
    var helper;

    var $studentName;
    var $studentIdentifier;
    var $examGrade;

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

        this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

        //set selectors
        this.rowIdString = '#studentListItem' + this.studentIndex;
        this.$row = $( this.rowIdString );
        this.$studentName = $( "#studentName" + this.studentIndex );
        this.$studentIdentifier = $( "#studentIdentifier" + this.studentIndex );
        this.$examGrade = $( "#examGrade" + this.studentIndex );
    } );
    afterEach( function () {
        // this.vm.$destroy();
        //  this.helper = '';
    } );

    describe( "integrity check | ", function () {

        it( "checks that the data store is valid and accessible", function () {
            expect( store ).not.toBeUndefined();
            expect( store.examGrades[ 0 ] ).toBe( 'Letter grade' );
        } );


        it( "checks that the component is intact", function () {
            expect( this.$row ).toExist();
            expect( this.$row ).toHaveClass( 'studentListItem' );
            expect( this.$studentName ).toExist();
            expect( this.$studentIdentifier ).toExist();
            expect( this.$examGrade ).toExist();
            //check has data
            expect( this.$studentName.text() ).toBe( this.lastName + ', ' + this.firstName );
            expect( this.$studentIdentifier.text() ).toBe( this.studentIdentifier );

            // expect(this.$row).toHaveClass('unalteredStudentRow');
        } );
    } );

    describe( "active student display | ", function () {

        describe( "initial state | ", function () {
            it( "initial state of the row ", function () {
                //default class
                expect( this.$row ).toHaveClass( 'unalteredStudentRow' );
                expect( this.$row ).not.toHaveClass( 'activeStudentRow' );
                expect( this.$row ).not.toHaveClass( 'gradedStudentRow' );
            } );
        } );

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

        describe( "student is active | ", function () {

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

                this.$fixture = loadFixtures( 'studentListItem.fixture.html' );

                this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );
            } );

            it( "designates the active student by setting a class", function () {
                //prep
                expect( store.activeStudent ).toBe( this.studentIndex );

                //check
                assertRowActive( this, this.studentIndex );
                Helper.assertValueIs( this, 'isActiveStudent', true );
                Helper.assertValueIs( this, 'isUnaltered', false );
                // assertRowActive(this.studentIndex);
            } );

            it( "when the student is no longer active, the row lacks the active student class", function () {
                //prep
                assertRowActive( this, this.studentIndex );

                //call
                store.activeStudent = null;

                //check --starting with active student
                assertRowActive( this, this.studentIndex, not = true );
                Helper.assertValueIs( this, 'isActiveStudent', false );
                Helper.assertValueIs( this, 'isUnaltered', true );
            } );

        } );

        describe( "check that values change properly when set to active | ", function () {

            beforeEach( function () {
                //call
                this.$row.trigger( 'click' );
            } );
            it( "when clicked, sets the student to active", function () {
                assertRowActive( this, this.studentIndex );
                //double checking to make sure
                Helper.assertValueIs( this, 'isActiveStudent', true );
            } );
            it( "when clicked, sets the student to not unaltered", function () {
                Helper.assertValueIs( this, 'isUnaltered', false ); //because is active
            } );
        } );

    } );


    describe( "student grade  | ", function () {
        beforeEach( function () {
            store.activeStudent = this.studentIndex;
        } );

        describe( " ungraded student | ", function () {
            beforeEach( function () {
                store.examGrades[ this.studentIndex ] = "letterGrade";
            } );

            it( "displays a placeholder for the grade of an ungraded student", function () {
                Helper.assertValueIs( this, 'examGrade', '--' );
            } );

            it( "the properties which govern styling are set for an ungraded student", function () {
                Helper.assertValueIs( this, 'isGraded', false );
            } );

            xit( " and the row has the correct styling", function () {
                expect( this.$row ).toHaveClass( 'unalteredStudentRow' );
            } );
        } );


        describe( " graded student | ", function () {
            var gradeVal;
            beforeEach( function () {
                //prep
                this.gradeVal = 55;
                store.examGrades[ this.studentIndex ] = this.gradeVal;
            } );

            it( "displays the score for a graded student ", function () {
                //expect( this.$examGrade.val() ).toBe( this.gradeVal );
                Helper.assertValueIs( this, 'examGrade', this.gradeVal );
            } );

            it( "the properties which govern styling are set for a graded student", function () {
                Helper.assertValueIs( this, 'isGraded', true );
            } );

            xit( "has the appropriate visible styling for a graded student", function () {
                //TODO resurrect when figure out vue display testing
                var me = this;
                Helper.asyncAssert( this, function () {
                    return expect( $( "#studentListItem0" ) ).toHaveClass( 'gradedStudentRow' );
                } );
                Helper.asyncAssert( this, function () {
                    return expect( me.$examGrade.val() ).toBe( me.gradeVal );
                } );
                //
            } );
        } );

        describe( "change graded state | ", function () {
            var gradeVal;

            beforeEach( function () {
                //prep
                store.examGrades[ this.studentIndex ] = "letterGrade";
                this.gradeVal = 55;
            } );

            it( "when a grade is recorded for a student, the placeholder is replaced with the actual grade", function () {
                //make sure starting with placeholder
                Helper.assertValueIs( this, 'examGrade', '--' );

                //call --student is graded
                store.examGrades[ this.studentIndex ] = this.gradeVal;

                //check --see grade and graded
                Helper.assertValueIs( this, 'examGrade', this.gradeVal );
                Helper.assertValueIs( this, 'isGraded', true );
                var me = this;
                //expect(me.$examGrade.val() ).toBe( me.gradeVal );

            } );

            xit( "when a grade is recorded for a student, the visible styling is updated", function () {
                //TODO resurrect when figure out vue display testing

                //prep
                var gradeVal = 55;
                store.examGrades[ this.activeStudent ] = "letterGrade";

                //check --see placeholder
                expect( this.$row ).toHaveClass( 'unalteredStudentRow' );

                //call --student is graded
                store.examGrades[ this.activeStudent ] = gradeVal;

                //check --see grade
                expect( this.$row ).toHaveClass( 'gradedStudentRow' );
            } );

        } );
    } );

    describe( "Events | ", function () {
        describe( "student-select-event | ", function () {

            it( "programmatically called", function () {
                //prep
                let me = this;
                let component = Helper.getComponent( this );
                let spy = Helper.createEventSpy( this, 'student-select-event' );

                //call
                component.notifyStudentSelectEvent();

                //check
                expect( spy.calledOnce ).toBe( true );
                expect( spy.calledWith( {
                    studentName: this.lastName + ", " + this.firstName,
                    studentIdentifier: this.studentIdentifier
                } ) ).toBe( true );

            } );


            it( "on click", function () {
                //prep
                let component = Helper.getComponent( this );
                let spy = Helper.createEventSpy( this, 'student-select-event' );

                //call
                this.$row.trigger( 'click' );

                //check
                expect( spy.calledOnce ).toBe( true );
                expect( spy.calledWith( {
                    studentName: this.lastName + ", " + this.firstName,
                    studentIdentifier: this.studentIdentifier
                } ) ).toBe( true );
            } );

        } );

    } );

    describe( "Student name visibility | ", function () {


        describe( "Blind | ", function () {

            beforeEach( function () {
                store.isBlind = true;
            } );

            it( "displays a placeholder rather than the student name if the exam is being graded blind", function () {
                Helper.assertValueIs( this, 'studentName', this.placeHolder, false );
                // expect( this.$studentName.text() ).toBe( this.placeHolder );
            } );

        } );

        describe( "Student name visibility | Not blind | ", function () {

            beforeEach( function () {
                store.isBlind = false;
            } );
            it( "displays the student's name", function () {

                Helper.assertValueIs( this, 'studentName', this.lastName + ', ' + this.firstName, false );
                // expect( this.$studentName.text() ).toBe( this.lastName + ', ' + this.firstName );
            } );
        } );
    } );
} );