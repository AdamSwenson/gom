require( '../../injectglobals' );

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from '../../helpers/item-test-helpers'

//tested stuff
import Exam from "../../../../resources/assets/js/models/Exam.js" ;

describe( " Exam  ", function () {
    let examId, examIndex, name, year, term, dataJson, exam, object;
    beforeEach( function () {
        examId = faker.random.number();
        examIndex = faker.random.number();
        name = faker.random.number();
        year = 2012;
        term = faker.name.lastName();
        dataJson = {
            examId: examId,
            examIndex: examIndex,
            name: name,
            year: year,
            term: term
        }
        exam = Exam.factory( dataJson );
        object = exam;
    } );



    describe( "factory ", function () {
        beforeEach( function () {

        } );

        it( "isObject ", function () {
            expect( typeof exam ).toBe( 'object' );
        } );

        it( "is Exam ", function () {
            expect( exam instanceof Exam ).toBe( true );
        } );

        it( "has default id of newly created exam (-1)  ", function () {
            window.console.log( exam );
            expect( exam.examId ).toBe( -1 );
        } );

        it( "properties ", function () {
            _.forEach( dataJson, function ( k, v ) {
                window.console.log( k, v );
                expect( exam[ k ] ).toBe( dataJson[ k ] );
            } );
        } );

    } );


    //
    // describe("getters and setters | ", () => {
    //     xit("happy path | ", () => {
    //         //todo
    //     });
    // });

} );