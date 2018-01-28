let sinon = require( 'sinon' );
let faker = require( 'faker' );

import * as factories from '../../helpers/factories';

import Student from "../../../../resources/assets/js/models/Student" ;
import Kumi from "../../../../resources/assets/js/models/Kumi" ;

describe( "models | Student ", function () {
    let student, studentId;
    let studentIndex;
    let studentIdentifier;
    let firstName;
    let lastName;
    let dataJson;

    beforeEach( function () {

        studentId = faker.random.number();
        studentIndex = faker.random.number();
        studentIdentifier = faker.random.number();
        firstName = faker.name.firstName();
        lastName = faker.name.lastName();
        dataJson = {
            studentId: studentId,
            studentIndex: studentIndex,
            studentIdentifier: studentIdentifier,
            firstName: firstName,
            lastName: lastName
        }

    } );

    describe( "isInKumiOrKumiList", () => {
        it( "Returns false when student is in no kumi ", () => {
            student = new Student();
            let kumis = factories.makeKumis( 5 );
            let testKumi = faker.random.arrayElement( kumis );
            //call
            let result = student.isInKumiOrKumiList( testKumi );
            //check
            expect( result ).toBe( false );
        } );

        it( "Returns true when student is in the provided kumi ", () => {
            student = new Student();
            let kumis = factories.makeKumis( 5 );
            student.associatedKumis = kumis;
            let testKumi = faker.random.arrayElement( kumis );

            //call
            let result = student.isInKumiOrKumiList( testKumi );
            //check
            expect( result ).toBe( true );
        } );

        it( "Returns false when student is not in kumi", () => {
            student = new Student();
            let kumis = factories.makeKumis( 5 );
            student.associatedKumis = kumis;
            let testKumi = new Kumi();

            //call
            let result = student.isInKumiOrKumiList( testKumi );
            //check
            expect( result ).toBe( false );
        } );

        it( "Returns true when student is in list of kumi ", () => {
            student = new Student();
            let kumis = factories.makeKumis( 5 );
            student.associatedKumis = kumis;
            let testKumi = faker.random.arrayElement( kumis );

            //call
            let result = student.isInKumiOrKumiList( testKumi );
            //check
            expect( result ).toBe( true );
        } );

        it( "Returns false when student is not in list of kumi", () => {
            student = new Student();
            let kumis = factories.makeKumis( 5 );
            student.associatedKumis = kumis;
            let testKumi = new Kumi();

            //call
            let result = student.isInKumiOrKumiList( testKumi );
            //check
            expect( result ).toBe( false );
        } );
    } );

    describe( "factory | ", function () {

        beforeEach( () => {
            student = Student.factory( dataJson );
        } );

        it( "isObject ", function () {
            expect( typeof student ).toBe( 'object' );
        } );

        it( "is Student ", function () {
            expect( student instanceof Student ).toBe( true );
        } );

        it( "has id ", function () {
            expect( student.studentId ).toBe( studentId );
        } );

        it( "properties ", function () {
            _.forEach( dataJson, function ( k, v ) {
                expect( student[ k ] ).toBe( dataJson[ k ] );
            } );
        } );

    } );


} );