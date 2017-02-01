
//test libraries
require('jasmine-jquery');
require('sinon');

const faker = require('faker');

//tested stuff
import Exam from  "../../../../../resources/assets/js/store/models/Exam.js" ;


describe(" store.models.Exam | ", function () {

    beforeEach(function () {
        this.examId = faker.random.number();
        this.examIndex = faker.random.number();
        this.name = faker.random.number();
        this.year = 2012;
        this.term = faker.name.lastName();
        this.dataJson = {
            examId: this.examId,
            examIndex: this.examIndex,
            name: this.name,
            year: this.year,
            term: this.term
        }
        this.exam = Exam.factory( this.dataJson );
        this.object = this.exam;
    });


    describe("getters and setters | ", () => {
        xit("happy path | ", () => {
            //todo
        });
    });


    describe( "factory | ", function () {
        beforeEach( function () {

        } );

        it( "isObject ", function () {
            expect( typeof this.exam ).toBe( 'object' );
        } );

        it( "is Exam ", function () {
            expect( this.exam instanceof Exam ).toBe( true );
        } );

        it( "has id ", function () {
            window.console.log( this.exam );
            expect( this.exam.examId ).toBe( this.examId );
        } );

        it( "properties ", function () {
            let me = this;
            $.each( this.dataJson, function ( k, v ) {
                window.console.log(k, v);
                expect( me.exam[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );

    // describe("factory | ", () => {
    //     xit("happy path | ", () => {
    //         //todo
    //     });
    // });

});