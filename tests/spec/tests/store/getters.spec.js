//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import * as getters from '../../../../resources/assets/js/store/getters.js';

import {testAction, description, factories, getActiveStudentIndex} from '../../helpers/vuex.spec.helpers';

//Dependencies
import * as mTypes from '../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../resources/assets/js/store/action-types'
import Payload from '../../../../resources/assets/js/store/models/Payload'

describe( "store | getters.js || ", function () {

    describe( "getExamId | ", () => {
        it( "happy path ", function () {
            let examId = 12; //todo add random number
            let state = {activeExam: {id: examId}};
            let {getExamId} = getters;
            expect( getExamId( state ) ).toBe( examId );
        } );
    } );


    describe( "isActive | ", () => {
        describe( "state.activeStudentIndex | undefined ", () => {
            it( "happy path ", function () {
                let state = {};
                let {isActive} = getters;
                expect( isActive( state ) ).toBe( false );
            } );
        } );
        // describe( "state.activeStudentIndex | null ", () => {
        //     it( "happy path ", function () {
        //         let state = {};
        //         state.activeStudentIndex = null;
        //         let {isActive} = getters;
        //         expect( isActive( state ) ).toBe( false );
        //     } );
        // } );
        // describe( "state.activeStudentIndex | 0 ", () => {
        //     it( "happy path  ", function () {
        //         let state = {};
        //         state.activeStudentIndex = 0;
        //         let {isActive} = getters;
        //         expect( isActive( state ) ).toBe( true );
        //     } );
        // } );
        // describe( "state.activeStudentIndex | >0 ", () => {
        //     it( "happy path | ", function () {
        //         let state = {};
        //         state.activeStudentIndex = 5;
        //         let {isActive} = getters;
        //         expect( isActive( state ) ).toBe( true );
        //     } );
        // } );
        // describe( "state.activeStudentIndex | default ", () => {
        //     it( "happy path | ", function () {
        //         let state = false;
        //         let {isActive} = getters;
        //         expect( isActive( state ) ).toBe( false );
        //     } );
        // } );

    } );


    describe( 'getNumberGraded', () => {
        //Todo This requires replacing updateExamGrade method on state
        it( "happy path | ", function () {
        } );

        // it("happy path | ", function () {});
        // it("happy path | ", function () {});
        // it("happy path | ", function () {});it("happy path | ", function () {});
    } );


    describe( "getTotalExams", () => {
        it( "happy path ", function () {
            let {getTotalExams} = getters;
            let state = {
                examGrades: {
                    key1: {},
                    key2: {}
                }
            };
            expect( getTotalExams( state ) ).toBe( 2 );
        } );
    } );

    describe( 'Active Student Aliases || ', function () {


        beforeEach( function () {

            const makeState = ( n = 5 ) => {
                let s = makeRootState();

                for ( let i = 0; i < n; i++ ) {
                    s.questionScores[ i ] = {};
                    s.examGradingTimes[ i ] = {};
                    for ( let k = 0; k < n; k++ ) {
                        s.questionScores[ i ][ k ] = faker.random.number();
                        s.examGradingTimes[ i ] = faker.random.number();
                    }
                }
                ;
                return s;
            };
            const makeRootState = function () {
                return {
                    questionScores: {},
                    examGradingTimes: {}
                };
            };

            const makeTestPayload = function () {
                return {
                    questionIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
                    studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
                    score: faker.random.number()
                };
            };

            const makeMutationPayload = function () {
                let p = new Payload();
                // let s = factories.studentFactory();
                p.index = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
                p.index2 = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
                p.id = faker.random.number();
                p.num = faker.random.number();
                p.obj = {};
                return p;
            };


            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
            this.mutationPayload = makeMutationPayload();

            this.mockGetters = {
                getActiveStudentIndex: function ( idx = this.mutationPayload.index ) {
                    return idx;
                }
            };
        } );

        describe( "getQuestionScoreForActiveStudent | ", function () {

            it( "happy path  ", function () {
                let expected = this.state.questionScores[ this.payload.studentIndex ][ this.payload.questionIndex ];

                this.mockGetters.getQuestionScore = function () {
                    return expected;
                };

                //call
                let result = getters.getQuestionScoreForActiveStudent( this.state, this.mockGetters, this.rootState, this.payload.questionIndex );

                //check
                expect( result ).toBe( expected );
            } );

        } );


        describe( "getActiveStudentGradingTime", function () {
            beforeEach( function () {
                this.testObj = factories.studentFactory( this.payload.studentIndex );
                this.testIndex = this.payload.studentIndex;
                this.expected = this.state.examGradingTimes[ this.payload.studentIndex ];

                //overwrite mock getters
                this.mockGetters = {
                    getActiveStudentIndex: () => {
                    },
                    getStudentGradingTime: () => {
                    },
                };
            } );

            describe( "happy paths | ", function () {
                it( "active student set  ", function () {
                    let expected = faker.random.number();
                    var mock = sinon.mock( this.mockGetters );
                    mock.expects( "getActiveStudentIndex" ).returns( this.testIndex );
                    mock.expects( "getStudentGradingTime" ).once().returns( expected );

                    this.state.activeStudent = this.testObj;

                    //call
                    let result = getters.getActiveStudentGradingTime( this.state, this.mockGetters );

                    //check
                    expect( result ).toBe( expected )
                } );

                it( "No active student set  ", function () {
                    let expected = ''
                    var mock = sinon.mock( this.mockGetters );
                    mock.expects( "getActiveStudentIndex" ).returns( null );
                    mock.expects( "getStudentGradingTime" ).once().returns( expected );

                    this.state.activeStudent = null;

                    //call
                    let result = getters.getActiveStudentGradingTime( this.state, this.mockGetters );

                    //check
                    expect( result ).toBe( expected )
                } );
            } );
        } );

        describe( "getCommentTextForActiveStudent | ", function () {
            beforeEach( function () {

                //overwrite mock getters
                this.mockGetters = {
                    getActiveStudentIndex: () => {
                    },
                    getCommentText: () => {
                    },
                };
            } );

            it( "happy path ", function () {
                //prep
                let expected = faker.random.word();
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( this.testIndex );
                mock.expects( "getCommentText" ).once().returns( expected );

                this.state.activeStudent = this.testObj;

                //call
                let result = getters.getCommentTextForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected )

            } );

            it( "null case  ", function () {
                //prep
                let expected = ''
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( null );
                mock.expects( "getCommentText" ).once().returns( expected );

                this.state.activeStudent = null;

                //call
                let result = getters.getCommentTextForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected );
            } )
        } );


        describe( "getExamGradeForActiveStudent | ", function () {
            beforeEach( function () {

                //overwrite mock getters
                this.mockGetters = {
                    getActiveStudentIndex: () => {
                    },
                    getExamGrade: () => {
                    },
                };
            } );

            it( "happy path ", function () {
                //prep
                let expected = faker.random.word();
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( this.testIndex );
                mock.expects( "getExamGrade" ).once().returns( expected );

                //call
                let result = getters.getExamGradeForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected )
            } );

            it( "null case ", function () {
                //prep
                let expected = ''
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( null );
                mock.expects( "getExamGrade" ).once().returns( expected );

                //call
                let result = getters.getExamGradeForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected );
            } );

        } );

        describe( "getElementScoreForActiveStudent | ", function () {
            beforeEach( function () {

                //overwrite mock getters
                this.mockGetters = {
                    getActiveStudentIndex: () => {
                    },
                    getElementScore: () => {
                    },
                };
            } );
            it( "happy path  ", function () {

                //prep
                let expected = faker.random.number();
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( this.testIndex );
                mock.expects( "getElementScore" ).once().returns( expected );

                //call
                let result = getters.getElementScoreForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected )
            } );


            it( "null case ", function () {
                //prep
                let expected = ''
                var mock = sinon.mock( this.mockGetters );
                mock.expects( "getActiveStudentIndex" ).returns( null );
                mock.expects( "getElementScore" ).once().returns( expected );

                //call
                let result = getters.getElementScoreForActiveStudent( this.state, this.mockGetters );

                //check
                expect( result ).toBe( expected );
            } );

        } );


    } );
} );