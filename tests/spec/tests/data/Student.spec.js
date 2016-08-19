var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

var Faker = require( 'faker' );

//helpers
var DataHelper = require( '../../helpers/dataObject.helper' );

//tested stuff
import Student from  "../../../../resources/assets/js/data/Student.js" ;


describe( "Data.Student | ", function () {

    beforeEach( function () {
//runs before each test
    } );


    describe( "factory | ", function () {
        beforeEach( function () {
            this.studentId = Faker.random.number();
            this.studentIndex = Faker.random.number();
            this.studentIdentifier = Faker.random.number();
            this.firstName = Faker.name.firstName();
            this.lastName = Faker.name.lastName();
            this.dataJson = {
                studentId: this.studentId,
                studentIndex: this.studentIndex,
                studentIdentifier: this.studentIdentifier,
                firstName: this.firstName,
                lastName: this.lastName
            }
            this.student = Student.factory( this.dataJson );
        } );

        it( "isObject ", function () {
            expect( typeof this.student ).toBe( 'object' );
        } );

        it( "is Student ", function () {
            expect( this.student instanceof Student ).toBe( true );
        } );

        it( "has id ", function () {
            window.console.log( this.student );
            expect( this.student.studentId ).toBe( this.studentId );
        } );

        it( "properties ", function () {
            let me = this;
            $.each( this.dataJson, function ( k, v ) {
                window.console.log(k, v);
                expect( me.student[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );


} );