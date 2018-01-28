// import Student from "../../../models/Student";
// import Payload from "../../../models/Payload";
// import * as mTypes from "../../mutation-types";
//
// import { loadStudentsForExam } from "../../../api/requests/studentRequests";
// import Kumi from "../../../models/Kumi";
// import { loadExamKumi } from "../../../api/requests/kumiRequests";
//
//
// module.exports = {
//     actions: {
//         /**
//          * Process the result of a response where we need to
//          * insert new students into store
//          * @param store
//          * @param response
//          * @returns {Promise}
//          */
//         loadStudentsFromServer( { state, dispatch, commit, getters }, exam ) {
//             return new Promise( function ( resolve, reject ) {
//
//                 let p = loadStudentsForExam( exam );
//                 p.then( function ( data ) {
//                     _.forEach( data, function ( r ) {
//                         // window.console.log( 'studentRequests', 'r', 29, r );
//                         let student = Student.factory( { r } );
//                         student.email = r.email;
//                         student.firstName = r.firstName;
//                         student.id = r.id;
//                         student.identifier = !_.isUndefined( r.identifier ) ? r.identifier : r.studentIdentifier;
//                         student.lastName = r.lastName;
//
//                         let payload = Payload.factory( { obj: student, mutateSilently: true } );
//                         commit( mTypes.addStudentToRoster, payload );
//
//                         if ( r.kumiId ) {
//                             //if the server sent us the id of the associated kumi
//                             //we are going to look up the client side representation
//                             //and then store it in the student object.
//                             //NB, there might not be a kumi id for any number of reasons,
//                             //including that an existing student is being newly associated with
//                             //a kumi.
//                             //Remember also that kumis are just groups now
//                             let kumi = getters.getKumiById( r.kumiId );
//                             if ( _.isUndefined( kumi ) ) {
//                                 //if a kumi object doesn't exist yet with this id
//                                 //figure out what the fuck to do.....
//                                 //the best thing will probably involve
//                                 //having the kumi loader update the kumi id's of
//                                 //existing students when it loads. Thus if each
//                                 //of them (kumi and student loaders) check and update ids
//                                 // when they are done, we should be okay
//                                 //todo add promises to help with this
//                             }
//
//                             //Otherwise we are good, so call the mutation
//                             // this will both add the kumi to the student
//                             //and store the relationship centrally
//                             payload.student = student;
//                             payload.kumi = kumi;
//                             commit( mTypes.associateStudentWithKumi, payload )
//                         }
//                     } );
//                     resolve();
//                 } );
//             } );
//         },
//
//
//         /**
//          * Requests all kumis for the exam
//          * then adds them to the kumi store by calling addKumi
//          * on each object returned;
//          * @param state
//          * @param dispatch
//          * @param commit
//          * @param getters
//          * @param exam
//          * @returns {Promise<any>}
//          */
//         loadKumisForExamFromServer( { state, dispatch, commit, getters }, exam ) {
//             return new Promise( function ( resolve, reject ) {
//                 let p = loadExamKumi( exam );
//                 return p.then( function ( data ) {
//                     _.forEach( data, ( d ) => {
//                         let k = Kumi.factory( d );
//                         let pl = Payload.factory( {
//                             obj: k,
//                             mutateSilently: true
//                         } );
//
//                         commit( mTypes.addKumi, pl );
//                         //associate it with the exam
//                         pl.exam = exam;
//                         pl.kumi = k;
//                         commit (mTypes.associateExamWithKumi, pl);
//                     } );
//                     resolve();
//                 } );
//             } );
//         },
//     }
// }