require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;

//tested object
import getters from '../../../../../../resources/assets/js/store/modules/roster/kumis.getters';

import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

// let getters = Component;

import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )


describe( "kumi.getters  ", function () {

    let gettersStub, students, kumis, exam, kumi, state;
    let numberStudentsAndKumis = 2;
    let expectedMutations;
    let store;

    beforeEach( function () {
        state = {
            kumis: [],
            studentKumiAssociations: [],
            examKumiAssociations: []
        };

        exam = factories.examFactory();
        kumi = factories.kumiFactory();

        students = factories.makeStudents(numberStudentsAndKumis);
        kumis = factories.makeKumis(numberStudentsAndKumis);

        store = new Vuex.Store({
            state, getters
        });
    } );

    describe('areKumiAndExamAssociated', (  ) => {
        it('returns true when associated', (  ) => {
            state.examKumiAssociations.push({
                examId: exam.id,
                kumiId: kumi.id
            });
            expect(state.examKumiAssociations.length).toBe(1);

            store = new Vuex.Store({
                state, getters
            });

            //call
            let result = store.getters.areKumiAndExamAssociated({ exam, kumi});
            expect(result).toBe(true);

        });
        it('returns false when not associated', (  ) => {
            let numKumis = 3;
            let kumis = factories.makeKumis(numKumis);
            _.forEach(kumis, function(k){
                let ex = factories.examFactory();
                let o = {examId: ex.id, kumiId: k.id};
                state.examKumiAssociations.push(o);
            });
            expect(state.examKumiAssociations.length).toBe(numKumis);

            store = new Vuex.Store({
                state, getters
            });
            //call
            let result = store.getters.areKumiAndExamAssociated( { exam, kumi});
            expect(result).toBe(false);
        });
    });

    describe( description( "getRootKumi" ), () => {
        it( "happy path", () => {
            let testKumi = faker.random.arrayElement( kumis );
            testKumi.isRoster = true;
            let state = {
                kumis: kumis
            };

            let result = getters.getRootKumi( state, {} );

            expect( result ).toBe( testKumi );
        } );
    } );


    describe( 'getKumiBySerialNumber', function () {
        it.skip( 'happy path', () => {

        } );
    } );

    describe( 'getKumiById', function () {
        it.skip( 'happy path', () => {

        } );
    } );

    describe( gTypes.getKumisForExam, function () {
        it.skip( 'happy path', () => {

        } );
    } );

    describe( 'getKumiExams', function () {
        it.skip( 'happy path', () => {

        } );
    } );

    describe( 'getStudentsForKumi', function () {
        it.skip( 'happy path', () => {

        } );
    } );

    describe( gTypes.getKumiCount, function () {
        it.skip( 'happy path', () => {

        } );
    } );

} );

//de
//     getKumiBySerialNumber: ( state, getters, rootState, serialNumber ) => ( serialNumber ) => {
//         return getKumiBySerialNumber( state, serialNumber );
//     },
//
//
//     /**
//      * Looks up the client side representation of a Kumi object
//      * @param state
//      * @param getters
//      * @param rootState
//      * @param serialNumber
//      */
//     getKumiById: ( state, getters, rootState, kumiId ) => ( kumiId ) => {
//         return getKumiById( state, kumiId );
//     },
//
//     /**
//      * Returns all kumis that have been loaded
//      * @param state
//      * @returns {any[] | _.LoDashImplicitArrayWrapper<T> | _.LoDashImplicitArrayWrapper<any> | _.LoDashExplicitArrayWrapper<T> | _.LoDashExplicitArrayWrapper<any>}
//      */
//     [gTypes.getAllKumis] : function ( state ) {
//         return _.uniq(state.kumis);
//     },
//
//     /**
//      * Returns all kumis associated with the exam
//      * @param examId
//      */
//     [gTypes.getKumisForExam]: ( state, getters, rootState, exam ) => ( exam ) => {
//         let kumiAssocs = filterExamAssociations( state, 'examId', exam.id );
//         let out = [];
//         _.forEach( kumiAssocs, function( i ){
//             //since the associations only have ids,
//             //we add the object for each to our list
//             let kumi = getters.getKumiById( i.kumiId );
//             out.push( kumi );
//         } );
//         return _.uniq(out);
//     },
//
//     /**
//      * Returns all exams associated with the given kumi
//      */
//     getKumiExams: ( state, kumiOrKumiId, returnObjects = false ) => {
//         let objId = kumiOrKumiId;
//         let examIds = filterExamAssociations( state, objId );
//         if ( !returnObjects ) return examIds;
//         //todo return objects
//     },
//
//
//     //Remember students can belong to more than one kumi
//     getStudentsForKumi: ( state, getters, rootState, kumiOrKumiId ) => ( kumiOrKumiId ) => {
//         let kumi = kumiOrKumiId;
//         let studentSerialNumbers = filterStudentAssociations( state, 'serialNumber', kumi.serialNumber );
//         let out = [];
//         _.forEach( studentSerialNumbers, ( i ) => {
//             out.push( getters.getStudentFromRosterBySerialNumber( i ) );
//         } );
//         return out;
//     },
//
//     /**
//      * Returns true if the specified student is in the
//      * presently displayed kumis or, if all kumis are selected.
//      * Returns false otherwise
//      * @param state
//      * @param getters
//      * @param rootState
//      * @param studentOrStudentSN
//      * @returns {boolean}
//      */
//     isStudentInDisplayedKumi: ( state, getters, rootState, studentOrStudentSN ) => ( studentOrStudentSN ) => {
//         try {
//             let selectedKumis = getters.getDisplayedKumis;
//
//             //if the selected kumi is null or empty, then we are to
//             //display all kumi associated with the exam
//             if ( _.isNull( selectedKumis ) || selectedKumis.length === 0 ) return true;
//
//             let student = studentOrStudentSN instanceof Student ? studentOrStudentSN : getters.getStudentFromRosterBySerialNumber( studentOrStudentSN );
//
//             // if(student.associatedKumis.length===0) return false;
//
//             // window.console.log( 'kumis', '', 310, selectedKumis, student);
//             let a = false;
//             _.forEach( selectedKumis, function ( kumi ) {
//                 _.forEach( student.associatedKumis, function ( k ) {
//                     // window.console.log( 'kumis', 'k', 316, kumi, k );
//                     if ( kumi.serialNumber === k.serialNumber )
//                         a = true;
//                 } );
//                 // if(filterStudentAssociations(student, 'serialNumber', kumi.serialNumber)) return true;
//                 // if ( student.associatedKumis.indexOf( kumi ) > -1 ) return true;
//             } );
//
//             return a;
//
//         } catch (Error) {
//             window.console.log( 'kumis', 'isStudentInDisplayedKumi', 325, Error );
//             return false;
//         }
//     },
//
//
//     /**
//      * Returns true if the specified student is in the
//      * presently selected kumi or, if all kumis are selected.
//      * Returns false otherwise
//      * @param state
//      * @param getters
//      * @param rootState
//      * @param studentOrStudentSN
//      * @returns {boolean}
//      */
//     isStudentInSelectedKumi: ( state, getters, rootState, studentOrStudentSN ) => ( studentOrStudentSN ) => {
//         try {
//             let selectedKumis = getters.getSelectedKumis;
//
//             //if the selected kumi is null or empty, then we are to
//             //display all kumi associated with the exam
//             if ( _.isNull( selectedKumis ) || selectedKumis.length === 0 ) return true;
//
//             let student = studentOrStudentSN instanceof Student ? studentOrStudentSN : getters.getStudentFromRosterBySerialNumber( studentOrStudentSN );
//
//             _.forEach( selectedKumis, function ( kumi ) {
//                 if ( student.associatedKumis.indexOf( kumi ) > -1 ) return true;
//             } );
//
//             return false;
// //            return student.associatedKumis.indexOf( kumi ) > -1;
//             //     //if the selected kumi is null, then we are to
//             //     //display all kumi associated with the exam
//             //     if ( _.isNull( kumi ) ) return true;
//             //
//             //     //todo add support for student id
//             //     let student = studentOrStudentId;
//             //     let students = getters.getStudentsForKumi( kumi );
//             //     window.console.log( 'kumis', 'isStudentInSelectedKumi', 222, student, kumi, students );
//             //     if ( students.indexOf( student ) >= 0 ) return true;
//             //     return false;
//
//         } catch (Error) {
//             window.console.log( 'kumis', 'isStudentInSelectedKumi', 209, Error );
//             return false;
//         }
//     },
//
//
//     [ gTypes.getKumiCount ]: ( state, getters, rootState ) => {
//         return _.size( state.kumis );
//     }
//
//     // [gTypes.getKumiCountForExam ]: ( state, getters, rootState, examOrExamId ) => ( examOrExamId ) => {
//     //     return _.size(state.kumis);
//     //
//     //     let exam = _.isUndefined( examOrExamId ) ? this.$store.getters.currentExam : examOrExamId;
//     //     let kumis = getters.getExamKumis(examOrExamId);
//     //     // let objId = exam.id;
//     //     // let kumiIds = filterExamAssociations( state, objId );
//     //
//     //     return _.size(kumis);
//     //
//     // }
//
// };
