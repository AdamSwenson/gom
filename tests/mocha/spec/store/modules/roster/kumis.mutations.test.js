
require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;
//
// let sinon = require( 'sinon' );
// let faker = require( 'faker' );
//
// //Dependencies
// import * as nggTypes from "../../../../../../resources/assets/js/store/new-grading-getter-types";
// import * as ngmTypes from '../../../../../../resources/assets/js/store/new-grading-mutation-types';
// import * as ngaTypes from '../../../../../../resources/assets/js/store/new-grading-action-types';
// import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";
// import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types';
// import * as aTypes from '../../../../../../resources/assets/js/store/action-types';
//
// import { testAction, description , factories} from '../../../../../spec/helpers/vuex.spec.helpers';
import {makeKumis} from '../../../../helpers/factories';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/roster/kumis.mutations';
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

let  mutations = Component;


describe( "kumi | mutations ", function () {
    let state, student;
    let payload;
    let gettersStub, students, kumis, kumi;

    beforeEach( function () {
        state= {
            kumis : [],
            studentKumiAssociations: []
        };
        kumis = makeKumis(3);
        kumi = faker.random.arrayElement(kumis);
        student = factories.studentFactory();
    } );

    describe( description( mTypes.addKumi ), () => {
        it( "Adds kumi to store when kumi doesn't already exist in store" , (  ) => {
            payload = Payload.factory({obj: kumi});
            //call
            mutations[mTypes.addKumi](state, payload );
            //check
            expect(state.kumis.length).toBe(1);
            expect(state.kumis[0]).toBe(kumi);
        });

        it( "Does not add kumi to store when kumi is already in store", (  ) => {
            payload = Payload.factory({obj: kumi});
            state.kumis.push(kumi);
            //call
            mutations[mTypes.addKumi](state, payload );
            //check
            expect(state.kumis.length).toBe(1);
            expect(state.kumis[0]).toBe(kumi);
        } );
    } );

    describe(description(mTypes.associateStudentWithKumi), (  ) => {
       it("Creates the student-kumi association when none existed", (  ) => {
           payload = Payload.factory({student: student, kumi: kumi});
           //call
           mutations[mTypes.associateStudentWithKumi](state, payload);
           //check
           expect(student.associatedKumis.length).toBe(1);
           expect(student.associatedKumis[0]).toBe(kumi);
       });

       it("Silently does not create a new association when one already exists", (  ) => {
           student.associatedKumis.push( kumi );
           payload = Payload.factory( { student: student, kumi: kumi } );
           //call
           mutations[ mTypes.associateStudentWithKumi ]( state, payload );
           //check
           expect( student.associatedKumis.length ).toBe( 1 );
           expect( student.associatedKumis[ 0 ] ).toBe( kumi );
       });
    });

    describe(description(mTypes.disassociateStudentFromKumi), (  ) => {
        it("Removes the student-kumi association when one exists", (  ) => {
            student.associatedKumis.push(kumi);
            payload = Payload.factory({student: student, kumi: kumi});
            //call
            mutations[mTypes.disassociateStudentFromKumi](state, payload);
            //check
            expect(student.associatedKumis.length).toBe(0);
        });

        it("Silently fails to remove a non-existent association", (  ) => {
            payload = Payload.factory({student: student, kumi: kumi});
            //call
            mutations[mTypes.disassociateStudentFromKumi](state, payload);
            //check
            expect(student.associatedKumis.length).toBe(0);

        });

    });

});

//     /**
//      * Alter properties of a kumi
//      * @param state
//      * @param payload
//      */
//     [mTypes.updateKumi]: ( state, payload ) => {
//         Payload.checkIfPayload( payload );
//         let kumi = getKumiBySerialNumber( state, payload.obj.serialNumber );
//         Vue.set( kumi, payload.updateProp, payload.updateVal );
//      },
//
//     /**
//      * Adds an exam to the list of exams the
//      * kumi is associated with
//      * @param examId
//      */
//     [mTypes.associateExamWithKumi] : ( state, payload ) => {
// //todo Should check that not duplicating?
//         let examId = payload.exam.id;
//         let kumiId = payload.kumi.id;
//         state.examKumiAssociations.push( { examId: examId, kumiId: kumiId } );
//     },
//
//     /**
//      * Removes the association between a kumi and exam
//      * @param examId
//      */
//     [mTypes.disassociateExamFromKumi]: ( state, payload ) => {
//         let examId = payload.exam.id;
//         let kumiId = payload.kumi.id;
//         let r = filterExamAssociations( state, kumiId, examId );
//         let index = state.examKumiAssociations.indexOf( r[ 0 ] );
//         state.examKumiAssociations.splice( index, 1 );
//     },
//
//     /**
//      * Creates a relationship between a student and a group (kumi)
//      *
//      * @param state
//      * @param kumiId
//      * @param studentId
//      */
//     [mTypes.associateStudentWithKumi]: ( state, payload ) => {
//         let student = payload.student;
//         let kumi = payload.kumi;
//
//         //store on the student object
//         student.associatedKumis.push( kumi );
//         //Now, redundantly store it centrally
//         //Why? No idea.... Not even sure if anything uses
//         //the central store
//         // todo Should check that not duplicating?
//         state.studentKumiAssociations.push( {
//             studentSerialNumber: student.serialNumber,
//             kumiSerialNumber: kumi.serialNumber
//         } );
//     },
//
//     /**
//      * Removes the association between the student and a group
//      * @param studentId
//      */
//     [mTypes.disassociateStudentFromKumi]: ( state, payload ) => {
//         let student = payload.student;
//         let kumi = payload.kumi;
//         let index = state.studentKumiAssociations.indexOf( r[ 0 ] );
//         state.studentKumiAssociations.splice( index, 1 );
//         //remove kumi from array stored in student
//         student.associatedKumis.splice( student.associatedKumis.indexOf( kumi ) );
//     },
//
// };
