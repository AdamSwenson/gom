var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
// require( 'sinon' );
var faker = require('faker');

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/ajax.tools.js" );

//Dependencies
require( '../../../resources/assets/js/data/Data.js' );


describe( "AjaxTools | ", function () {
    var object;

    beforeEach( function () {
        this.object = testedComponent;
    } );


    describe( "Request objects | ", function () {

        describe( "questionScoreRequest  | ", function () {
            it( "w/o time ", function () {
                let qaid = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let R = new this.object.requests.questionScoreRequest( studentId, qaid, score );
                expect( typeof R ).toBe( 'object' );
                expect( R.question_assignment_id ).toBe( qaid );
                expect( R.student_id ).toBe( studentId );
                expect( R.score ).toBe( score );
            } );

            it( "w time ", function () {
                let qaid = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let time = faker.random.number()

                //call
                let R = new this.object.requests.questionScoreRequest( studentId, qaid, score, time );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.question_assignment_id ).toBe( qaid );
                expect( R.student_id ).toBe( studentId );
                expect( R.score ).toBe( score );
                expect( R.time ).toBe( time );
            } );

        } );

        describe( "elementScoreRequest  | ", function () {
            it( "w/o time ", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();

                //call
                let R = new this.object.requests.elementScoreRequest( studentId, id, score );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.score ).toBe( score );
            } );

            it( "w time ", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let time = faker.random.number()

                //call
                let R = new this.object.requests.elementScoreRequest( studentId, id, score, time );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.score ).toBe( score );
                expect( R.time ).toBe( time );
            } );

        } );

        describe( "commentRequest  | ", function () {
            it( "w/o score | w/o time", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let text = faker.lorem.text();

                //call
                let R = new this.object.requests.commentRequest( studentId, id, text );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.comment_text ).toBe( text );
                // expect( R.score ).toBe( score );
            } );

            it( "w score | w/o time ", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let text = faker.lorem.text();

                //call
                let R = new this.object.requests.commentRequest( studentId, id, text, score );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.comment_text ).toBe( text );
                expect( R.score ).toBe( score );
            } );

            it( "w score | w time ", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let time = faker.random.number();
                let text = faker.lorem.text();

                //call
                let R = new this.object.requests.commentRequest( studentId, id, text, score, time );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.comment_text ).toBe( text );
                expect( R.score ).toBe( score );
                expect( R.time ).toBe( time );
            } );

            it( "w/o score | w time ", function () {
                let id = faker.random.number();
                let studentId = faker.random.number();
                let score = faker.random.number();
                let time = faker.random.number();
                let text = faker.lorem.text();

                //call
                let R = new this.object.requests.commentRequest( studentId, id, text, null, time );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.element_id ).toBe( id );
                expect( R.student_id ).toBe( studentId );
                expect( R.comment_text ).toBe( text );
                expect( R.score ).not.toBe( null );
                expect( R.time ).toBe( time );
            } );


        } );


        describe( "timeRequest  | ", function () {
            it( "standard", function () {
                let studentId = faker.random.number();
                let time = faker.random.number();

                //call
                let R = new this.object.requests.timeRequest( studentId, time );

                //check
                expect( typeof R ).toBe( 'object' );
                expect( R.student_id ).toBe( studentId );
                expect( R.time ).toBe( time );
                // expect( R.score ).toBe( score );
            } );

        } );
    });

} );