
require( '../../injectglobals' );

const Faker = global.faker;
//tested stuff
import Student from  "../../../../resources/assets/js/models/Student" ;


describe( "Student", function () {

    beforeEach( function () {
//runs before each test
    } );


    describe( "factory  ", function () {
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
            expect( this.student.studentId ).toBe( this.studentId );
        } );

        it( "properties ", function () {
            let me = this;
            _.forEach( this.dataJson, function ( k, v ) {
                expect( me.student[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );


} );