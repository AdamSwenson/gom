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
var faker = require( 'faker' );

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
require( '../../../resources/assets/js/grade/components/Data.open.js' );


describe( "LetterGradeButton.component  | ", function () {
    var store;
    beforeEach( function () {
        this.questionNumber = "1";
        this.questionIndex = 0;
        this.maxScore = 100;
        this.questionAssignmentId = 2;
        store = new Data();
        store.loadQuestions( {
            0: {
                questionIndex: this.questionIndex,
                questionAssignmentId: this.questionAssignmentId,
                questionNumber: this.questionNumber
            }
        } );
        store.loadGrades( {
            0: { displayValue: 'A+', calcValue: 98 },
            1: { displayValue: 'A', calcValue: 95 },
            2: { displayValue: 'A-', calcValue: 92 },
            3: { displayValue: 'B+', calcValue: 88 },
            4: { displayValue: 'B', calcValue: 85 },
            5: { displayValue: 'B-', calcValue: 82 },
            6: { displayValue: 'C+', calcValue: 78 },
            7: { displayValue: 'C', calcValue: 75 },
            8: { displayValue: 'C-', calcValue: 72 },
            9: { displayValue: 'D+', calcValue: 68 },
            10: { displayValue: 'D', calcValue: 65 },
            11: { displayValue: 'D-', calcValue: 62 },
            12: { displayValue: 'F', calcValue: 55 }
        } );
    } );

    describe( "intact | ", function () {
        beforeEach( function () {
            // var store = new Data();
            // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
            //     displayValue: 'A',
            //     calcValue: 95
            // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
            //     displayValue: 'B',
            //     calcValue: 85
            // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
            //     displayValue: 'C',
            //     calcValue: 75
            // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
            //     displayValue: 'D',
            //     calcValue: 65
            // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );
            // store.loadQuestions( {
            //     0: {
            //         questionIndex: this.questionIndex,
            //         questionAssignmentId: this.questionAssignmentId,
            //         questionNumber: this.questionNumber
            //     }
            // } );
            let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( this.maxScore );
            window.store = store;

            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

            this.$gradeDisplay = $( "#letterGradeForQuestion" + this.questionNumber );
            this.$button = $( '#letterGradeButton' + this.questionNumber );
            this.$gradeList = $( "#letterGradeList" );
        } );

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


    describe( "interactions w store | ", function () {
        describe( "score | ", function () {
            it( "get", function () {
                let testScore = faker.random.number();
                // var store = new Data();
                // store.loadQuestions( {
                //     0: {
                //         questionIndex: this.questionIndex,
                //         questionAssignmentId: this.questionAssignmentId,
                //         questionNumber: this.questionNumber
                //     }
                // } );
                // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                //     displayValue: 'A',
                //     calcValue: 95
                // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
                //     displayValue: 'B',
                //     calcValue: 85
                // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
                //     displayValue: 'C',
                //     calcValue: 75
                // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
                //     displayValue: 'D',
                //     calcValue: 65
                // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );

                sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testScore );
                window.store = store;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

                let component = Helper.getComponent( this );
                expect( component.score ).toBe( testScore );
            } );

            it( "set", function () {
                let testScore = faker.random.number();
                // var store = new Data();
                // store.loadQuestions( {
                //     0: {
                //         questionIndex: this.questionIndex,
                //         questionAssignmentId: this.questionAssignmentId,
                //         questionNumber: this.questionNumber
                //     }
                // } );
                // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                //     displayValue: 'A',
                //     calcValue: 95
                // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
                //     displayValue: 'B',
                //     calcValue: 85
                // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
                //     displayValue: 'C',
                //     calcValue: 75
                // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
                //     displayValue: 'D',
                //     calcValue: 65
                // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );

                store.setActiveStudent( 0 );
                store.loadQuestionScores( { 0: { 0: null, 1: 'taco' } } ); //replicate the data array
                window.store = store;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

                //call
                let component = Helper.getComponent( this );
                component.score = testScore;
                //check
                // expect( store.getQuestionScoreForActiveStudent() ).toBe( testScore );
                //this will fail if using data rather than data.open
                expect( store.getQuestionScore( 0, 0 ) ).toBe( testScore );
            } );
        } );

        it( "maxScore ", function () {
            let maxScore = 22;
            // var store = new Data();
            // store.loadQuestions( {
            //     0: {
            //         questionIndex: this.questionIndex,
            //         questionAssignmentId: this.questionAssignmentId,
            //         questionNumber: this.questionNumber
            //     }
            // } );
            // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
            //     displayValue: 'A',
            //     calcValue: 95
            // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
            //     displayValue: 'B',
            //     calcValue: 85
            // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
            //     displayValue: 'C',
            //     calcValue: 75
            // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
            //     displayValue: 'D',
            //     calcValue: 65
            // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );

            sinon.stub( store, 'getMaxQuestionScore' ).returns( maxScore );
            window.store = store;
            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

            let component = Helper.getComponent( this );
            expect( component.maxScore ).toBe( maxScore );
        } );

    } );

    describe( "value displayed on button | ", function () {

        describe( "no pre-existing score | ", function () {
            // it( "fucker", function () {
            //     let testMax = 100;
            //     let testScore = 84;
            //     let expectedGrade = 'B-';
            //     var store = new Data();
            //     let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( 45 );
            //     let st2 = sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( 22 );
            //     window.store = store;
            //
            //     expect( store.getMaxQuestionScore() ).toBe( 45 );
            //     expect( store.getQuestionScoreForActiveStudent() ).toBe( 22 );
            //     expect( store.getMaxQuestionScore() ).not.toBe( 22 );
            // } );


            it( "default ", function () {
                let testMax = 100;
                let testScore = null;
                let expectedGrade = 'Letter grade';
                // var store = new Data();
                // store.loadQuestions( {
                //     0: {
                //         questionIndex: this.questionIndex,
                //         questionAssignmentId: this.questionAssignmentId,
                //         questionNumber: this.questionNumber
                //     }
                // } );
                // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                //     displayValue: 'A',
                //     calcValue: 95
                // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
                //     displayValue: 'B',
                //     calcValue: 85
                // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
                //     displayValue: 'C',
                //     calcValue: 75
                // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
                //     displayValue: 'D',
                //     calcValue: 65
                // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );

                sinon.stub( store, 'getMaxQuestionScore' ).returns( testScore );
                sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testMax );
                window.store = store;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

                let component = Helper.getComponent( this );
                expect( component.displayedGrade ).toBe( expectedGrade );
            } );

        } );


        describe( "pre-existing grade | ", function () {

            describe( "Happy paths | ", function () {
                it( ">", function () {
                    let testMax = 100;
                    let testScore = 86;
                    let expectedGrade = 'B';
                    // var store = new Data();
                    // store.loadQuestions( {
                    //     0: {
                    //         questionIndex: this.questionIndex,
                    //         questionAssignmentId: this.questionAssignmentId,
                    //         questionNumber: this.questionNumber
                    //     }
                    // } );
                    // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                    //     displayValue: 'A',
                    //     calcValue: 95
                    // }, { displayValue: 'A-', calcValue: 92 }, {
                    //     displayValue: 'B+',
                    //     calcValue: 88
                    // }, { displayValue: 'B', calcValue: 85 }, {
                    //     displayValue: 'B-',
                    //     calcValue: 82
                    // }, { displayValue: 'C+', calcValue: 78 }, {
                    //     displayValue: 'C',
                    //     calcValue: 75
                    // }, { displayValue: 'C-', calcValue: 72 }, {
                    //     displayValue: 'D+',
                    //     calcValue: 68
                    // }, { displayValue: 'D', calcValue: 65 }, { displayValue: 'D-', calcValue: 62 }, {
                    //     displayValue: 'F',
                    //     calcValue: 55
                    // } ] );

                    let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( testScore );
                    let st2 = sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testMax );
                    window.store = store;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );
                    // window.console.log(storeMock);
                    let component = Helper.getComponent( this );
                    expect( component.displayedGrade ).toBe( expectedGrade );
// st.verify();
//                     st.restore();
                    // storeMock.verify();
                    // storeMock.restore();
                } );

                it( " < ", function () {
                    let testMax = 100;
                    let testScore = 84;
                    let expectedGrade = 'B-';
                    // var store = new Data();
                    // store.loadQuestions( {
                    //     0: {
                    //         questionIndex: this.questionIndex,
                    //         questionAssignmentId: this.questionAssignmentId,
                    //         questionNumber: this.questionNumber
                    //     }
                    // } );
                    // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                    //     displayValue: 'A',
                    //     calcValue: 95
                    // }, { displayValue: 'A-', calcValue: 92 }, {
                    //     displayValue: 'B+',
                    //     calcValue: 88
                    // }, { displayValue: 'B', calcValue: 85 }, {
                    //     displayValue: 'B-',
                    //     calcValue: 82
                    // }, { displayValue: 'C+', calcValue: 78 }, {
                    //     displayValue: 'C',
                    //     calcValue: 75
                    // }, { displayValue: 'C-', calcValue: 72 }, {
                    //     displayValue: 'D+',
                    //     calcValue: 68
                    // }, { displayValue: 'D', calcValue: 65 }, { displayValue: 'D-', calcValue: 62 }, {
                    //     displayValue: 'F',
                    //     calcValue: 55
                    // } ] );

                    let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( testScore );
                    let st2 = sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testMax );
                    window.store = store;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );
                    // window.console.log(storeMock);
                    let component = Helper.getComponent( this );
                    expect( component.displayedGrade ).toBe( expectedGrade );
                } );

                it( " = ", function () {
                    let testMax = 100;
                    let testScore = 85;
                    let expectedGrade = 'B';
                    // var store = new Data();
                    // store.loadQuestions( {
                    //     0: {
                    //         questionIndex: this.questionIndex,
                    //         questionAssignmentId: this.questionAssignmentId,
                    //         questionNumber: this.questionNumber
                    //     }
                    // } );
                    // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                    //     displayValue: 'A',
                    //     calcValue: 95
                    // }, { displayValue: 'A-', calcValue: 92 }, {
                    //     displayValue: 'B+',
                    //     calcValue: 88
                    // }, { displayValue: 'B', calcValue: 85 }, {
                    //     displayValue: 'B-',
                    //     calcValue: 82
                    // }, { displayValue: 'C+', calcValue: 78 }, {
                    //     displayValue: 'C',
                    //     calcValue: 75
                    // }, { displayValue: 'C-', calcValue: 72 }, {
                    //     displayValue: 'D+',
                    //     calcValue: 68
                    // }, { displayValue: 'D', calcValue: 65 }, { displayValue: 'D-', calcValue: 62 }, {
                    //     displayValue: 'F',
                    //     calcValue: 55
                    // } ] );

                    let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( testScore );
                    let st2 = sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testMax );
                    window.store = store;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );
                    // window.console.log(storeMock);
                    let component = Helper.getComponent( this );
                    expect( component.displayedGrade ).toBe( expectedGrade );
                } );

            } );


            describe( "Problem cases | ", function () {
                it( " no active student | ", function () {
                    let testMax = 100;
                    let testScore = 86;
                    let expectedGrade = 'B';
                    // var store = new Data();
                    // store.loadQuestions( {
                    //     0: {
                    //         questionIndex: this.questionIndex,
                    //         questionAssignmentId: this.questionAssignmentId,
                    //         questionNumber: this.questionNumber
                    //     }
                    // } );
                    // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
                    //     displayValue: 'A',
                    //     calcValue: 95
                    // }, { displayValue: 'A-', calcValue: 92 }, {
                    //     displayValue: 'B+',
                    //     calcValue: 88
                    // }, { displayValue: 'B', calcValue: 85 }, {
                    //     displayValue: 'B-',
                    //     calcValue: 82
                    // }, { displayValue: 'C+', calcValue: 78 }, {
                    //     displayValue: 'C',
                    //     calcValue: 75
                    // }, { displayValue: 'C-', calcValue: 72 }, {
                    //     displayValue: 'D+',
                    //     calcValue: 68
                    // }, { displayValue: 'D', calcValue: 65 }, { displayValue: 'D-', calcValue: 62 }, {
                    //     displayValue: 'F',
                    //     calcValue: 55
                    // } ] );

                    let st = sinon.stub( store, 'getMaxQuestionScore' ).returns( testScore );
                    let st2 = sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testMax );
                    window.store = store;

                    //prep the page
                    this.$fixture = loadFixtures( fixture );
                    this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );
                    // window.console.log(storeMock);
                    let component = Helper.getComponent( this );
                    expect( component.displayedGrade ).toBe( expectedGrade );

                } );

                it( "no score | ", function () {
                } );

            } );


        } );
    } );

    describe( "event handling |", function () {
        var testScore;
        describe( "outbound |  ", function () {


            beforeEach( function () {
                var maxScore = faker.random.number();
                testScore = faker.random.number();
                // var store = new Data();
                // store.loadQuestions( {
                //     0: {
                //         questionIndex: this.questionIndex,
                //         questionAssignmentId: this.questionAssignmentId,
                //         questionNumber: this.questionNumber
                //     }
                // } );
                // store.loadGrades( {
                //     0: { displayValue: 'A+', calcValue: 98 },
                //     1: { displayValue: 'A', calcValue: 95 },
                //     2: { displayValue: 'A-', calcValue: 92 },
                //     3: { displayValue: 'B+', calcValue: 88 },
                //     4: { displayValue: 'B', calcValue: 85 },
                //     5: { displayValue: 'B-', calcValue: 82 },
                //     6: { displayValue: 'C+', calcValue: 78 },
                //     7: { displayValue: 'C', calcValue: 75 },
                //     8: { displayValue: 'C-', calcValue: 72 },
                //     9: { displayValue: 'D+', calcValue: 68 },
                //     10: { displayValue: 'D', calcValue: 65 },
                //     11: { displayValue: 'D-', calcValue: 62 },
                //     12: { displayValue: 'F', calcValue: 55 }
                // } );
                sinon.stub( store, 'getMaxQuestionScore' ).returns( maxScore );
                sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testScore );
                sinon.stub( store, 'storeQuestionScoreForActiveStudent' );
                window.store = store;

                //prep the page
                this.$fixture = loadFixtures( fixture );
                this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );
            } );

            it( 'sends event | called programmatically', function () {
                //prep
                let component = this.vm.$refs.testObject;
                let spy = sinon.spy();
                this.vm.$on( 'letter-grade-selected', spy );

                //call
                component.notifyLetterGradeSelection();

                //check
                expect( spy.calledOnce ).toBe( true );
                expect( spy.calledWith( {
                    questionIndex: this.questionIndex,
                    questionNumber: this.questionNumber,
                    score: testScore
                } ) ).toBe( true );
            } );

            it( "sends event | on click ", function () {
                //prep
                let component = this.vm.$refs.testObject;
                let spy = sinon.spy();
                let testGradeVal = 98; //the first item on the grades list
                this.vm.$on( 'letter-grade-selected', spy );

                //call
                this.$button = $( '#letterGradeButton' + this.questionNumber );
                this.$button.click();
                let button = $( ".gradeListItem > a" ).first();
                window.console.log( button );
                button[ 0 ].click();

                //check
                expect( spy.called ).toBe( true );
                //not testing content. already did that where it was easier to set the score
            } );
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
            component.showGradePopOver( component.targetId, component.displayedgrade, component.gradeValue, component.maxScore );
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
        beforeEach( function () {
        } );

        it( "calcGrade", function () {
            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

            let component = this.vm.$refs.testObject;
            let gradeValue = 88;
            let maxScore = 100;

            //call
            let result = component.calcGrade( gradeValue, maxScore );

            //check
            expect( result ).toBe( 88.00 );
        } );

        it( "calcLetter", function () {
            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

            let component = Helper.getComponent( this );

            expect( component.calcLetter( 85, 100 ) ).toBe( 'B' );
            expect( component.calcLetter( 84, 100 ) ).toBe( 'B-' );
            expect( component.calcLetter( 90, 100 ) ).toBe( 'B+' );
        } );

        it( 'sends event ', function () {
            //prep
            let testScore = faker.random.number();
            // let store = new Data();
            // store.loadQuestions( {
            //     0: {
            //         questionIndex: this.questionIndex,
            //         questionAssignmentId: this.questionAssignmentId,
            //         questionNumber: this.questionNumber
            //     }
            // } );
            // store.loadGrades( [ { displayValue: 'A+', calcValue: 98 }, {
            //     displayValue: 'A',
            //     calcValue: 95
            // }, { displayValue: 'A-', calcValue: 92 }, { displayValue: 'B+', calcValue: 88 }, {
            //     displayValue: 'B',
            //     calcValue: 85
            // }, { displayValue: 'B-', calcValue: 82 }, { displayValue: 'C+', calcValue: 78 }, {
            //     displayValue: 'C',
            //     calcValue: 75
            // }, { displayValue: 'C-', calcValue: 72 }, { displayValue: 'D+', calcValue: 68 }, {
            //     displayValue: 'D',
            //     calcValue: 65
            // }, { displayValue: 'D-', calcValue: 62 }, { displayValue: 'F', calcValue: 55 } ] );

            sinon.stub( store, 'getQuestionScoreForActiveStudent' ).returns( testScore );
            window.store = store;

            //prep the page
            this.$fixture = loadFixtures( fixture );
            this.vm = Helper.loadVueComponent( testedComponent, 'letter-grade-button' );

            //attach spy
            let spy = sinon.spy();
            this.vm.$on( 'letter-grade-selected', spy );

            //call
            let component = this.vm.$refs.testObject;
            component.notifyLetterGradeSelection();

            //check
            expect( spy.calledOnce ).toBe( true );
            expect( spy.calledWith( {
                questionIndex: this.questionIndex,
                questionNumber: this.questionNumber,
                score: testScore
            } ) ).toBe( true );
        } );

    } );
} );
