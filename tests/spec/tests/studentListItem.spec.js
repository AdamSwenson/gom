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
var testedComponent = require( "../../../resources/assets/js/grade/components/studentListItem.component" );
require( '../../../resources/assets/js/grade/components/Data.js' );
var fixture = 'studentListItem.fixture.html';

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

    beforeEach( function () {
        this.studentIndex = 0;
        this.firstName = 'Jill';
        this.lastName = 'Jillenson';
        this.studentIdentifier = '123456789';
        this.studentId = '1';
        this.placeHolder = "--";
        this.namePlaceholder = 'Name Hidden';

        var students = {
            0 : {firstName: this.firstName,
                lastName: this.lastName,
                studentId: this.studentId,
                studentIdentifier: this.studentIdentifier
        }
        };
        // students[ this.studentIndex ][ 'firstName' ] = this.firstName;
        // students[ this.studentIndex ][ 'lastName' ] = this.lastName;
        // students[ this.studentIndex ][ 'studentId' ] = this.studentId;
        // students[ this.studentIndex ][ 'studentIdentifier' ] = this.studentIdentifier;
        // window.console.log(students[0]);
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
        store.loadStudents( students );
        window.store = store;


        this.$fixture = loadFixtures( fixture );

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

    describe( "Intact | ", function () {

        it( "data store", function () {
            expect( store ).not.toBeUndefined();
            //expect( store.examGrades[ 0 ] ).toBe( 'Letter grade' );
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


        describe( "isActiveStudent | ", function () {

            beforeEach( function () {
            } );

            describe( "Happy paths | ", function () {

                it( "active = true", function () {
                    store.setActiveStudent( this.studentIndex );
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

                    //check
                    assertRowActive( this, this.studentIndex );
                    Helper.assertValueIs( this, 'isActiveStudent', true );
                    Helper.assertValueIs( this, 'isUnaltered', false );

                } );

                it( "active = false", function () {
                    //prep
                    store.setActiveStudent( 300 );
                    this.$fixture = loadFixtures( 'studentListItem.fixture.html' );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

                    //check --starting with active student
                    assertRowActive( this, this.studentIndex, true );
                    Helper.assertValueIs( this, 'isActiveStudent', false );
                    Helper.assertValueIs( this, 'isUnaltered', true );
                } );

            } );

            describe( "Problem cases | ", function () {
                it( "activeStudentIndex = null", function () {
                    //prep
                    store.setActiveStudent( null );

                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

                    //check --starting with active student
                    assertRowActive( this, this.studentIndex, true );
                    Helper.assertValueIs( this, 'isActiveStudent', false );
                    Helper.assertValueIs( this, 'isUnaltered', true );
                } );


            } );

        } );

        // describe( "check that values change properly when set to active | ", function () {
        //
        //     beforeEach( function () {
        //         //call
        //         this.$row.trigger( 'click' );
        //     } );
        //     it( "when clicked, sets the student to active", function () {
        //         assertRowActive( this, this.studentIndex );
        //         //double checking to make sure
        //         Helper.assertValueIs( this, 'isActiveStudent', true );
        //     } );
        //     it( "when clicked, sets the student to not unaltered", function () {
        //         Helper.assertValueIs( this, 'isUnaltered', false ); //because is active
        //     } );
        // } );

    } );


    describe( "examGrade  | ", function () {
        beforeEach( function () {
        } );

        describe( "ungraded student | ", function () {
            beforeEach( function () {
                let d = new Data();
                let st = sinon.stub( d, 'getExamGrade' ).returns( "Letter grade" );
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-timer' );
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


        describe( "graded student | ", function () {
            var gradeVal;
            beforeEach( function () {
                //prep
                this.gradeVal = 55;
                let d = new Data();
                let st = sinon.stub( d, 'getExamGrade' ).returns( this.gradeVal );
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-timer' );
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
                this.gradeVal = 55;
                let d = new Data();
                let st = sinon.stub( d, 'getExamGrade' );
                st.onCall( 0 ).returns( this.gradeVal );
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-timer' );
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
                Helper.assertValueIs( this, 'studentName', this.namePlaceholder, false );
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