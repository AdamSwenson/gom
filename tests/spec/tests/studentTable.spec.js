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
var DataHelper = require( '../helpers/dataObject.helper' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/studentTable.component" );
var fixture = 'studentTable.fixture.html';


//Dependencies
//require( '../../../resources/assets/js/grade/components/Data.open.js' );
import Data from '../../../resources/assets/js/data/Data.js';


/**
 * Checks whether student row is set as active.
 * Setting the not parameter to true checks whether
 * the student is inactive
 *
 * @param studentIndex
 * @param not
 */
function assertRowActive( dthis, studentIndex, not = false ) {
    let $row = $( '#studentListItem' + studentIndex );

    expect( $row ).toExist();
    if ( not ) {
        expect( $row ).not.toHaveClass( 'activeStudentRow' );
    } else {
        expect( $row ).toHaveClass( 'activeStudentRow' );
    }

}

function assertRowDefault( dthis, studentIndex, not = false ) {
    var $row = $( '#studentListItem' + studentIndex );
    expect( $row ).toExist();
    if ( not ) {
        expect( $row ).not.toHaveClass( 'unalteredStudentRow' );
        // Helper.assertValueIs( this, 'isUnaltered', false );

        //TODO resurrect when figure out how to test vue display
        // expect($row).not.toHaveClass('unalteredStudentRow');
    } else {
        expect( $row ).toHaveClass( 'unalteredStudentRow' );
        // Helper.assertValueIs( this, 'isUnaltered', true );

        //TODO resurrect when figure out how to test vue display
        //expect( $row ).toHaveClass( 'unalteredStudentRow' );
    }
}

function examGradeSelector( studentIndex ) {
    return $( "#examGrade" + studentIndex );
}

function nameSelector( studentIndex ) {
    return $( '#studentName' + studentIndex )
}
function rowSelector( studentIndex ) {
    return $( '#studentListItem' + studentIndex );
}

var students;

describe( "studentTable | ", function () {

    beforeEach( function () {
        this.studentIndex = 0;
        this.firstName = 'Jill';
        this.lastName = 'Jillenson';
        this.studentIdentifier = '123456789';
        this.studentId = '1';
        this.placeHolder = "--";
        this.namePlaceholder = 'Name Hidden';

        students = {
            0: {
                studentIndex: this.studentIndex,
                firstName: this.firstName,
                lastName: this.lastName,
                studentId: this.studentId,
                studentIdentifier: this.studentIdentifier
            }
        };

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
        store.isBlind = false;
        // sinon.spy(store, 'isBlind').returns(true);
        window.store = store;

        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );

        //set selectors
        this.rowIdString = '#studentListItem' + this.studentIndex;
        this.$row = $( this.rowIdString );
        this.$studentName = $( "#studentName" + this.studentIndex );
        this.$studentIdentifier = $( "#studentIdentifier" + this.studentIndex );
        this.$examGrade = $( "#examGrade" + this.studentIndex );
        this.$nameSortButton = $( "#nameHeader" );
        this.$identifierSortButton = $( "#idHeader" );
        this.$gradeSortButton = $( "#gradeHeader" );
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
            //sort buttons
            expect( this.$nameSortButton ).toExist();
            expect( this.$identifierSortButton ).toExist();
            expect( this.$gradeSortButton ).toExist();
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
                    store.activeStudentIndex = this.studentIndex;
                    store.activeStudentId = this.studentId;
                    //store.setActiveStudent( this.studentIndex );
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

                    //check
                    assertRowActive( this, this.studentIndex );
                    //   Helper.assertValueIs( this, 'isActiveStudent', true );
                    //  Helper.assertValueIs( this, 'isUnaltered', false );

                } );

                it( "active = false", function () {
                    //prep
                    store.activeStudentIndex = 300;
                    // store.activeStudentId = this.studentId;
                    // store.setActiveStudent( 300 );
                    this.$fixture = loadFixtures( fixture );
//                    this.$fixture = loadFixtures( 'studentListItem.fixture.html' );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );

                    //check --starting with active student
                    assertRowActive( this, this.studentIndex, true );
                    //      Helper.assertValueIs( this, 'isActiveStudent', false );
                    //     Helper.assertValueIs( this, 'isUnaltered', true );
                } );

            } );

            describe( "Problem cases | ", function () {
                it( "activeStudentIndex = null", function () {
                    //prep
                    store.activeStudentIndex = null;

                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-list-item' );

                    //check --starting with active student
                    assertRowActive( this, this.studentIndex, true );
                    //        Helper.assertValueIs( this, 'isActiveStudent', false );
                    //        Helper.assertValueIs( this, 'isUnaltered', true );
                } );


            } );

        } );

    } );

    describe( "examGrade  | ", function () {
        beforeEach( function () {
        } );

        describe( "Happy paths | ", function () {

            describe( "ungraded student | ", function () {
                beforeEach( function () {
                    let d = new Data();
                    let st = sinon.stub( d, 'getExamGrade' ).returns( "Letter grade" );
                    sinon.stub( d, 'getStudents' ).returns( students );
                    window.store = d;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-timer' );
                } );

                it( "displays placeholder", function () {
                    let grade = $( '#examGrade' + this.studentIndex ).text();
                    expect( grade ).toBe( '--' );
                } );

                it( "row styling", function () {
                    var $row = $( '#studentListItem' + this.studentIndex );
                    expect( $row ).not.toHaveClass( 'gradedStudentRow' );
                    expect( this.$row ).toHaveClass( 'unalteredStudentRow' );
                } );
            } );


            describe( "graded student | ", function () {
                var gradeVal;
                beforeEach( function () {
                    //prep
                    this.gradeVal = '55';
                    let d = new Data();
                    let st = sinon.stub( d, 'getExamGrade' ).returns( this.gradeVal );
                    sinon.stub( d, 'getStudents' ).returns( students );
                    window.console.log( students );
                    window.store = d;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
                } );

                it( "displays score ", function () {
                    let $grade = examGradeSelector( this.studentIndex );
                    expect( $grade.text() ).toBe( this.gradeVal );
                } );

                it( "row styling", function () {
                    let $row = rowSelector( this.studentIndex );
                    expect( $row ).toHaveClass( 'gradedStudentRow' );
                    expect( $row ).not.toHaveClass( 'unalteredStudentRow' );
                } );

            } );

        } );

        describe( "Problem cases | ", function () {
            describe( "graded && active ", function () {
                //If we grade a student and then later select them
                //again, the row should represent them as active
                beforeEach( function () {
                    this.gradeVal = '27';
                    let d = new Data();
                    d.activeStudentIndex = this.studentIndex;
                    d.activeStudentId = this.studentId;
                    sinon.stub( d, "getExamGrade" ).returns( this.gradeVal );
                    sinon.stub( d, "getStudents" ).returns( students );
                    window.store = d;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
                } );

                it( "has correct values", function () {
                    let component = Helper.getComponent( this );
                    expect( component.isActiveStudent( this.studentIndex ) ).toBe( true );
                    expect( component.isGraded( this.studentIndex ) ).toBe( true );
                    //style properties
                    expect( component.isActiveStyle( this.studentIndex ) ).toBe( true );
                    expect( component.isGradedStyle( this.studentIndex ) ).toBe( false );
                    expect( component.isUnalteredStyle( this.studentIndex ) ).toBe( false );
                } );

                it( "displays score ", function () {
                    let $grade = examGradeSelector( this.studentIndex );
                    expect( $grade.text() ).toBe( this.gradeVal );
                } );

                it( "row styling", function () {
                    let $row = rowSelector( this.studentIndex );
                    expect( $row ).toHaveClass( 'activeStudentRow' );
                    expect( $row ).not.toHaveClass( 'gradedStudentRow' );
                    expect( $row ).not.toHaveClass( 'unalteredStudentRow' );
                } );

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
                component.notifyStudentSelectEvent( this.studentIndex );

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
                let d = new Data();
                d.isBlind = true;
                sinon.stub( d, 'getStudents' ).returns( students );
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );

            } );

            it( "displays placeholder", function () {
                let $name = nameSelector( this.studentIndex );
                expect( $name.text() ).toBe( this.namePlaceholder );
            } );

        } );

        describe( "Not blind | ", function () {

            beforeEach( function () {
                let d = new Data();
                d.loadStudents( students );
                d.isBlind = false;
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
            } );

            it( "displays name", function () {
                let component = Helper.getComponent( this );
                let $name = nameSelector( this.studentIndex );
                expect( component.isBlind ).toBe( false );
                expect( $name.text() ).toBe( this.lastName + ', ' + this.firstName );
            } );
        } );
    } );

    describe( "Sort | ", function () {
        var s;
        beforeEach( function () {
            s = {
                0: {
                    studentIndex: 0,
                    firstName: 'aaaa',
                    lastName: 'aaaa',
                    studentId: 0,
                    studentIdentifier: '0000'
                },
                1: {
                    studentIndex: 1,
                    firstName: 'bbbb',
                    lastName: 'bbbb',
                    studentId: 1,
                    studentIdentifier: '1111'
                }
            };
            let d = new Data();
            sinon.stub( d, "getStudents" ).returns( s );
            window.store = d;

            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
        } );

        describe( "component | ", function () {
            let component;
            beforeEach( function () {
                let d = new Data();
                sinon.stub( d, "getStudents" ).returns( s );
                window.store = d;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
                component = Helper.getComponent( this );
                expect( component.sortAsc ).toBe( true );
            } );

            it( "initial", function () {
                let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                expect( $names.length ).toBe( 2 );
                expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                expect( component.sortAsc ).toBe( true );
            } );

            describe( "sort | studentName | ", function () {
                describe( "asc->desc", function () {
                    beforeEach( function () {
                        component.sortRosterBy( 'studentName' );
                    } );
                    it( "property", function () {
                        expect( component.sortAsc ).toBe( false );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    } );

                } );
                describe( "desc->asc", function () {
                    beforeEach( function () {
                        component.sortAsc = false;
                        expect( component.sortAsc ).toBe( false );

                        component.sortRosterBy( 'studentName' );
                    } );
                    it( "property", function () {
                        //check
                        expect( component.sortAsc ).toBe( true );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    } );
                } );
            } );

            describe( "sort | studentIdentifier | ", function () {
                describe( "asc->desc", function () {
                    beforeEach( function () {
                        component.sortRosterBy( 'studentIdentifier' );
                    } );
                    it( "property", function () {
                        expect( component.sortAsc ).toBe( false );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    } );

                } );
                describe( "desc->asc", function () {
                    beforeEach( function () {
                        component.sortAsc = false;
                        expect( component.sortAsc ).toBe( false );

                        component.sortRosterBy( 'studentIdentifier' );
                    } );
                    it( "property", function () {
                        expect( component.sortAsc ).toBe( true );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    } );
                } );
            } );
            describe( "sort | grade | ", function () {
                describe( "asc->desc", function () {
                    beforeEach( function () {
                        component.sortRosterBy( );
                    } );
                    it( "property", function () {
                        expect( component.sortAsc ).toBe( false );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    } );

                } );
                describe( "desc->asc", function () {
                    beforeEach( function () {
                        component.sortAsc = false;
                        expect( component.sortAsc ).toBe( false );

                        component.sortRosterBy( );
                    } );
                    it( "property", function () {
                        //check
                        expect( component.sortAsc ).toBe( true );
                    } );

                    xit( "display", function () {
                        let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                        expect( $names.length ).toBe( 2 );
                        expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                        expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    } );
                } );
            } );

        } );


        describe( "name | ", function () {
            it( "initial", function () {
                let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                expect( $names.length ).toBe( 2 );
                expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                //make sure sort order in correct initial state
                expect( $( "#nameHeader" ) ).toExist();

                let component = Helper.getComponent( this );
                expect( component.sortAsc ).toBe( true );
            } );

            describe( "asc -> desc | ", function () {
                let component;
                beforeEach( function () {
                    let d = new Data();
                    sinon.stub( d, "getStudents" ).returns( s );
                    window.store = d;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'student-table' );
                    component = Helper.getComponent( this );
                    expect( component.sortAsc ).toBe( true );

                    //call
                    $( "#nameHeader" ).trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( false );
                } );

                xit( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                } );
            } );

            describe( "desc -> asc | ", function () {
                let component;
                beforeEach( function () {
                    component = Helper.getComponent( this );
                    component.sortAsc = false;
                    // expect(component.sortAsc).toBe(false);
                    $( "#nameHeader" ).trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( true );
                } );

                it( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                } );
            } );

        } );


        describe( "identifier | ", function () {

            it( "initial", function () {
                let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                expect( $names.length ).toBe( 2 );
                expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                //make sure sort order in correct initial state
                expect( this.$identifierSortButton ).toExist();
                let component = Helper.getComponent( this );
                expect( component.sortAsc ).toBe( true );
            } );

            describe( "asc -> desc | ", function () {
                let component;
                beforeEach( function () {
                    component = Helper.getComponent( this );
                    $( "#idHeader" ).trigger( 'click' ); //this.$identifierSortButton.trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( false );
                } );

                xit( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                } );
            } );

            describe( "desc -> asc | ", function () {
                let component;
                beforeEach( function () {
                    component = Helper.getComponent( this );
                    component.sortAsc = false;
                    $( "#idHeader" ).trigger( 'click' );
//                    this.$identifierSortButton.trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( true );
                } );

                xit( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                } );
            } );
        } );


        describe( "grades ", function () {
            it( "initial", function () {
                let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                expect( $names.length ).toBe( 2 );
                expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                //make sure sort order in correct initial state
                expect( this.$gradeSortButton ).toExist();
                let component = Helper.getComponent( this );
                expect( component.sortAsc ).toBe( true );
            } );

            describe( "asc -> desc | ", function () {
                let component;
                beforeEach( function () {
                    component = Helper.getComponent( this );
                    $( "#gradeHeader" ).trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( false );
                } );

                xit( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                } );
            } );

            describe( "desc -> asc | ", function () {
                let component;
                beforeEach( function () {
                    component = Helper.getComponent( this );
                    component.sortAsc = false;
                    $( "#gradeHeader" ).trigger( 'click' );
                } );

                it( "property", function () {
                    expect( component.sortAsc ).toBe( true );
                } );

                xit( "displayed order", function () {
                    let $names = $( '#studentRosterBody' ).find( '[id^="studentName"]' );
                    expect( $names.length ).toBe( 2 );
                    expect( $( $names[ 0 ] ).attr( 'id' ) ).toBe( 'studentName0' );
                    expect( $( $names[ 1 ] ).attr( 'id' ) ).toBe( 'studentName1' );
                } );
            } );

        } );

    } );

} )
;