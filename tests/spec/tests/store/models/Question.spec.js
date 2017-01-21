//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let Faker = require( 'faker' );

//tested stuff
import Question from  "../../../../../resources/assets/js/store/models/Question.js" ;


describe( "store.models.question | ", function () {
    beforeAll( function () {
//runs once before all tests
    } );

    beforeEach( function () {
//runs before each test
    } );

    afterEach( function () {
//runs after each test
    } );

    describe( "factory | ", function () {
        beforeEach( function () {
            this.questionId = Faker.random.number();
            this.questionIndex = Faker.random.number();
            this.content = Faker.hacker.phrase();
            this.maxScore = Faker.random.number();
            this.questionName = Faker.name.firstName();
            this.questionNumber = Faker.random.number();
            this.questionAssignmentId = Faker.random.number();
            this.dataJson = {
                questionId: this.questionId,
                questionIndex: this.questionIndex,
                content: this.content,
                maxScore: this.maxScore,
                questionName: this.questionName,
                questionNumber: this.questionNumber,
                questionAssignmentId: this.questionAssignmentId
            }
            this.question = Question.factory( this.dataJson );
        } );

        describe( "happy path | ", function () {


            it( "isObject ", function () {
                expect( typeof this.question ).toBe( 'object' );
            } );

            it( "is question ", function () {
                expect( this.question instanceof Question ).toBe( true );
            } );

            it( "has id ", function () {
                window.console.log( this.question );
                expect( this.question.questionId ).toBe( this.questionId );
            } );

            it( "properties ", function () {
                let me = this;
                $.each( this.dataJson, function ( k, v ) {
                    window.console.log( k, v );
                    expect( me.question[ k ] ).toBe( me.dataJson[ k ] );
                } );
            } );
        } );
    } );


    describe( "questionName | ", () => {
        describe( "getters and setters | ", () => {

            describe( "get questionName | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
            describe( "set questionName | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );

        describe( "questionNumber | ", () => {

            describe( "get questionNumber | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( "set questionNumber | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );

        describe( "questionAssignmentId | ", () => {

            describe( "get questionAssignmentId | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( "set questionAssignmentId | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

        } );

        describe( "maxScore | ", () => {

            describe( "get maxScore | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
            describe( "set maxScore | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

        } );
    } );

} );