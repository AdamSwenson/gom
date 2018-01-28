//
// require( 'sinon' );
// let faker = require( 'faker' );
//
// //Dependencies
// import * as gTypes from "../../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";
// import * as mTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
// import * as aTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';
//
// import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';
//
// //tested object
// import * as Component from '../../../../../../resources/assets/js/store/modules/roster/kumis.actions';
// let obj = Component.default;
// //tested methods
// let { actions } = obj;
//
//
// describe( "kumis.actions  | ", function () {
//
//     beforeEach( function () {
//
//     } );
//
//
//     describe( "mutations  ", function () {
//
//
//         describe( description(" createKumi ", (  ) => {
//            it(" happy path ", (  ) => {
//                 let exam = getters[ gTypes.getActiveExam ];
//             let kumi = new Kumi();
//             createKumiRequest( kumi, exam )
//                 .then( function ( data ) {
//                     kumi.id = data.id;
//                     commit( mTypes.addKumi, Payload.factory( {
//                         obj: kumi,
//                         mutateSilently: true
//                     } ) );
//
//         } );
//
//     });
// });
// //
// //         describe( description(" ", (  ) => {
// //             it(" happy path ", (  ) => {
// //
// //                 processKumiFromJson( { state, dispatch, commit, getters } ) {
// //         let exam = getters.getCurrentExam;
// //         let kumiData = JSON.parse( document.getElementById( KUMIS_JSON_NAME ).getAttribute( 'data' ) );
// //
// //         _.forEach( kumiData, function ( d, i ) {
// //             //first make a kumi from the loaded data and push it into storage
// //             let kumi = Kumi.factory( { d } );
// //             //Now associate the kumi with the exam
// //             let pl = Payload.factory( {
// //                 obj: kumi,
// //                 kumi: kumi,
// //                 examId: exam.id,
// //                 kumiId: kumi.id,
// //                 mutateSilently: true
// //             } );
// //             commit( 'addKumi', pl );
// //             commit( 'associateExamWithKumi', pl );
// //             if ( i === 0 ) {
// //                 //set the first kumi as the one to display
// //                 commit( 'toggleKumi', pl )
// //             }
// //         } );
// //     },
// //
// //             });
// //         });
// //                 describe( description(" ", (  ) => {
// //                     it(" happy path ", (  ) => {
// //
// //                         /**
// //      * Removes all associations between an exam and a kumi.
// //      * Also removes all student associations with the kumi
// //      *
// //      * @param state
// //      * @param dispatch
// //      * @param commit
// //      * @param getters
// //      * @param payload
// //      */
// //     removeKumi( { state, dispatch, commit, getters }, payload ) {
// //         let { kumi, exam } = payload;
// //         disassociateKumiAndExam( kumi, exam )
// //             .then( function () {
// //                 commit( mTypes.disassociateExamFromKumi, payload );
// //             } );
// //     }
// //
// //                     });
// //                 });
// // };
// //
