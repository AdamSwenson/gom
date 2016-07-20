var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );
var faker = require('faker');

//Dependencies
require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "Data.js | ", function () {
    var object, defaults, activeStudent;
    beforeEach( function () {
        this.object = new Data();

        //properties of test data
        this.numberQuestions = 2;
        this.numberStudents = 2;
        this.elementsPerQuestion = 1;

        //test data
        this.activeStudent = 1;

        //stores the initial state that all the various objects
        //would be in if no exams were graded
        this.defaults = {};
        this.defaults.elementComments = {
            0: {
                0: '',
                1: '',
                2: ''
            },
            1: {
                0: '',
                1: '',
                2: ''
            }
        };

        this.defaults.stockComments = {
            0: {
                0: 'e0 missing',
                1: 'e0 poor',
                2: 'e0 fair',
                3: 'e0 excellent'
            },
            1: {
                0: 'e1 missing',
                1: 'e1 poor',
                2: 'e1 fair',
                3: 'e1 excellent'
            }
        };

        this.defaults.examGradingTimes = {
            0: 0,
            1: 0
        };

        this.defaults.elementScores = {
            0: {
                0: null,
                1: null
            },

            1: {
                0: null,
                1: null
            }
        };

        this.defaults.questionScores = {
            0: {
                0: null,
                1: null
            },
            1: {
                0: null,
                1: null
            }
        };

        this.defaults.examGrades = {
            0: 'Letter grade',
            1: 'Letter grade'
        };

    } );


    describe( "Grading time | ", function () {
        beforeEach( function () {
            this.object.activeStudent = 1;
        } );

        describe( "getStudentGradingTime | ", function () {
            describe( "Happy paths | ", function () {
                beforeEach(function(){
                    this.object.examGradingTimes = this.defaults.examGradingTimes;
                });

                it( "initial state", function () {
                    //check
                    expect( this.object.getStudentGradingTime( this.activeStudent ) ).toBe( 0 );
                } );

                it( "after graded ", function () {
                    let newVal = 45;
                    this.object.examGradingTimes[ this.activeStudent ] = newVal;

                    //check
                    expect( this.object.getStudentGradingTime( this.activeStudent ) ).toBe( newVal );
                } );
            } );
        } );

        describe( "storeStudentGradingTime | ", function () {
            describe( "Happy paths | ", function () {
                beforeEach(function(){
                    this.object.examGradingTimes = this.defaults.examGradingTimes;
                });

                it( "initial state", function () {
                    let testVal = 45;

                    //call
                    this.object.storeStudentGradingTime( this.activeStudent, testVal );

                    //check
                    expect( this.object.examGradingTimes[ this.activeStudent ] ).toBe( testVal );
                } );

                it( "after graded ", function () {
                    let existingVal = faker.random.number();
                    this.object.examGradingTimes[ this.activeStudent ] = existingVal;
                    let testVal = faker.random.number();

                    //call
                    this.object.storeStudentGradingTime( this.activeStudent, testVal );

                    //check
                    expect( this.object.examGradingTimes[ this.activeStudent ] ).toBe( testVal );
                } );
            } );

            describe( "increaseStudentGradingTime | ", function () {
                describe( "Happy paths | ", function () {
                    beforeEach(function(){
                        this.object.examGradingTimes = this.defaults.examGradingTimes;
                    });

                    it( "initial state", function () {
                        let testVal = faker.random.number();

                        //call
                        this.object.increaseStudentGradingTime( this.activeStudent, testVal );

                        //check
                        expect( this.object.examGradingTimes[ this.activeStudent ] ).toBe( testVal );
                    } );

                    it( "after graded ", function () {
                        let existingVal = 87;
                        this.object.examGradingTimes[ this.activeStudent ] = existingVal;
                        let testVal = 41;

                        //call
                        this.object.increaseStudentGradingTime( this.activeStudent, testVal );

                        //check
                        expect( this.object.examGradingTimes[ this.activeStudent ] ).toBe( testVal + existingVal );
                    } );
                } );
            } );
        } );
    } );


    xdescribe( "Element scores | ", function () {
        beforeEach( function () {
        } );

        it( " ", function () {
        } );

        it( " ", function () {
        } );

    } );


    describe( "Comments | ", function () {
        beforeEach( function () {
            this.object.elementComments = this.defaults.elementComments;
            this.object.stockComments = this.defaults.stockComments;
        } );

        describe( "getCommentText | ", function () {
            it( "stock comment ", function () {
                let elementIndex = 0;
                let me = this;
                this.object.valences.forEach( function ( i ) {
                    expect( me.object.getCommentText( me.activeStudent, elementIndex, i ) ).toBe( me.defaults.stockComments[ elementIndex ][ i ] );
                } );

            } );

            it( "custom text ", function () {
                let text = 'custom text';
                let elementIndex = 0;
                this.object.elementComments[ this.activeStudent ][ elementIndex ] = text
                let me = this;

                //check
                this.object.valences.forEach( function ( i ) {
                    expect( me.object.getCommentText( me.activeStudent, elementIndex, i ) ).toBe( text );
                } );
            } );

        } );

        xdescribe( "storeCommentText  | ", function () {

            it( "storeCommentText ", function () {
            } );
        } );

    } );


    xdescribe( "Question scores | ", function () {
        beforeEach( function () {
        } );
        it( "getQuestionScore ", function () {
        } );

        it( "storeQuestionScore ", function () {
        } );
    } );


    describe( "Exam grades | ", function () {

        describe( "updateExamGrade | ", function () {

            describe( "Happy paths | ", function () {
                beforeEach( function () {
                    this.object.questionScores = this.defaults.questionScores;
                    this.object.examGrades = this.defaults.examGrades;
                } );

                it( "first run | nothing graded", function () {
                    //total score should be set to -1
                    this.object.updateExamGrade( this.activeStudent );
                    window.console.log( this.object );

                    expect( this.object.examGrades[ this.activeStudent ] ).toBe( - 1 ); //.toBe(this.defaults.examGrades[this.activeStudent]);
                } );

                it( "first run | one question graded | score = 0", function () {
                    let score = 0;
                    this.object.questionScores[ this.activeStudent ][ 0 ] = score;
                    this.object.updateExamGrade( this.activeStudent );
                    window.console.log( this.object );
                    //total score should be 0
                    expect( this.object.examGrades[ this.activeStudent ] ).toBe( score.toPrecision( 3 ) );
                } );

                it( "multiple questions graded ", function () {
                    let score1 = 2;
                    let score2 = 8;
                    this.object.questionScores[ this.activeStudent ][ 0 ] = score1;
                    this.object.questionScores[ this.activeStudent ][ 1 ] = score2;

                    //call
                    this.object.updateExamGrade( this.activeStudent );

                    //check ---total score should be sum of question scores
                    let total = score1 + score2;
                    expect( this.object.examGrades[ this.activeStudent ] ).toBe( total.toPrecision( 3 ) );
                } );

            } );

            describe( "Problem cases | ", function () {
                xit( "No active student set ", function () {
                } );

                xit( "scores not initialized ", function () {
                } );
            } );
        } );
    } );


    describe( "Shortcuts | ", function () {

        describe( "isActive | ", function () {
            describe( "Happy paths | ", function () {
                beforeEach( function () {
                    this.object.questionScores = this.defaults.questionScores;
                    this.object.examGrades = this.defaults.examGrades;
                } );

                it( "null ", function () {
                    this.object.activeStudent = null;
                    expect( this.object.isActive() ).toBe( false );
                } );

                it( "0 ", function () {
                    this.object.activeStudent = 0;
                    expect( this.object.isActive() ).toBe( true );
                } );

                it( ">0 ", function () {
                    this.object.activeStudent = 34;
                    expect( this.object.isActive() ).toBe( true );
                } );
            } );
            xdescribe( "problem cases | ", function () {
                it( " ", function () {
                } );

                it( " ", function () {
                } );

            } );

        } );


        describe( "isGraded | ", function () {
            describe( "Happy paths | ", function () {
                beforeEach( function () {
                    this.object.questionScores = this.defaults.questionScores;
                    this.object.examGrades = this.defaults.examGrades;
                } );

                it( "false ", function () {
                    expect( this.object.isGraded( this.activeStudent ) ).toBe( false );
                } );

                it( "true ", function () {
                    this.object.questionScores[ this.activeStudent ][ 0 ] = 34;
                    window.console.log( this.object.questionScores );
                    expect( this.object.isGraded( this.activeStudent ) ).toBe( true );
                } );
            } );

            xdescribe( "problem cases | ", function () {
                it( " ", function () {
                } );

                it( " ", function () {
                } );

            } );

        } );

        describe( "getNumberGraded | ", function () {
            beforeEach( function () {
                //this makes a call to updateExam scores, so best be ready
                this.object.questionScores = this.defaults.questionScores;
                this.object.examGrades = this.defaults.examGrades;
            } );
            describe( "Happy paths | ", function () {
                it( "0 graded ", function () {
                    expect( this.object.getNumberGraded() ).toBe( 0 )
                } );

                it( ">0 graded ", function () {
                    this.object.questionScores[ this.activeStudent ][ 0 ] = 34;
                    expect( this.object.getNumberGraded() ).toBe( 1 );
                } );
            } );

            xdescribe( "problem cases | ", function () {
                it( " ", function () {
                } );

                it( " ", function () {
                } );

            } );

        } );

        describe( "getTotalExams | ", function () {
            describe( "Happy paths | ", function () {
                beforeEach( function () {
                    this.object.questionScores = this.defaults.questionScores;
                    this.object.examGrades = this.defaults.examGrades;
                } );
                it( "2 exams", function () {
                    expect( this.object.getTotalExams() ).toBe( this.numberStudents );
                } );
            } );

            xdescribe( "problem cases | ", function () {
                it( " ", function () {
                } );

                it( " ", function () {
                } );

            } );
        } );
    } );


} );