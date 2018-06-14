//The name of the tested component
import * as mTypes from "../../../../../../resources/assets/js/store/mutation-types";

var compName = 'exams.mutations';
//The path to the tested component
import mutations from '../../../../../../resources/assets/js/store/modules/exams/exams.mutations.js' ;
import Payload from "../../../../../../resources/assets/js/models/Payload";


require( '../../../../injectglobals' );

//tested object

describe( compName, () => {
    let listOfValues, test;
    let state, payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        state = {
            exams: {}
        };
        exam = factories.examFactory();
    } );


    describe(  mTypes.addExam , () => {
        it( 'adds the exam to store', () => {
            mutations[mTypes.addExam](state, Payload.factory({obj: exam}));
            expect(state.exams[exam.id]).toMatchObject(exam);
        } );
    } );

    describe( mTypes.loadExams, () => {
        it( 'overwrites the existing exams object', () => {
            let obj = {taco : 'dog'};
            mutations[mTypes.loadExams](state, Payload.factory({obj: obj}));
            expect(state.exams).toMatchObject(obj);
        } );
    } );

} );
