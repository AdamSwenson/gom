//The name of the tested component
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

var compName = 'exams.getters';
//The path to the tested component
import getters from '../../../../../../resources/assets/js/store/modules/exams/exams.getters.js' ;


require( '../../../../injectglobals' );

import { createLocalVue } from 'vue-test-utils';
import Payload from "../../../../../../resources/assets/js/models/Payload";

const localVue = createLocalVue();
localVue.use( Vuex )

//tested object
describe( compName, () => {
    let listOfValues, test, numExams;
    let payload, exam, item, kumi, kumis, student, grade;
    let store, state;

    beforeEach( () => {
        numExams = 5;

        state = {
            exams: {}
        };

        for (let i = 0; i < numExams; i++) {
            let ex = factories.examFactory();
            state.exams[ ex.id ] = ex;
        }

        store = new Vuex.Store( {
            state, getters
        } );

    } );


    describe( gTypes.getExam, () => {
        it( 'looks up exam by id', () => {
            _.forEach( state.exams.values, function ( exam ) {
                let result = store.getters[ gTypes.getExam ]( Payload.factory( { examId: exam.id } ) );
                expect( result ).toMatchObject( exam );
            } )
        } );
    } );
    // it.skip( 'looks up exam by index', () => {} );


    describe( gTypes.getAllExams, () => {
        it( 'returns all exams ', () => {
            let result = store.getters[ gTypes.getAllExams ];
            expect( result.length ).toBe( numExams );
            _.forEach( state.exams.values, function ( exam ) {
                expect( _.findIndex( result, exam ) ).not.toBe( -1 );
            } )
        } );
    } );

} )
;
