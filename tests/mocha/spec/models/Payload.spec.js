//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );

const faker = require( 'faker' );

//tested stuff
import Payload from  "../../../../resources/assets/js/models/Payload.js" ;


describe( " models.Payload | ", function () {

    describe( " factory | ", function () {
        describe( "happy path | ", function () {


            it( "no aliases | ", function () {
                let a = {
                    id: faker.random.number(),
                    index: faker.random.number(),
                    num: faker.random.number(),
                    obj: {taco: 'taco'}
                };

                let result = Payload.factory( a );
                console.log( result );
                expect( result instanceof Payload ).toBe( true );
                expect( result.id ).toBe( a.id );
                expect( result.index ).toBe( a.index );
                expect( result.num ).toBe( a.num );
                expect( result.obj ).toBe( a.obj );
            } );

            it( "with aliases | ", function () {
                let a = {
                    id: faker.random.number(),
                    index: faker.random.number(),
                    studentId: faker.random.number(),
                    studentIndex: faker.random.number(),
                    num: faker.random.number(),
                    obj: {taco: 'taco'}
                };

                let result = Payload.factory( a );
                expect( result instanceof Payload ).toBe( true );
                expect( result.id ).toBe( a.studentId );
                expect( result.index ).toBe( a.studentIndex );
                expect( result.num ).toBe( a.num );
                expect( result.obj ).toBe( a.obj );
            } );


        } );
    } );
} );