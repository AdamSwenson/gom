import Kumi from "../../../models/Kumi";
import Payload from "../../../models/Payload";


export function filterExamAssociations ( state, prop, val )  {
    return state.examKumiAssociations.filter( ( i ) => {
        if ( i[ prop ] === val ) {
            return i;
        }
    } );
};


export const filterStudentAssociations = ( state, prop, val ) => {
    return state.studentKumiAssociations.filter( ( i ) => {
        if ( i[ prop ] === val ) {
            return i;
        }
    } );
};

export function filterKumis ( state, prop, val ) {
    return state.kumis.filter( ( i ) => {
        if ( i[ prop ] === val ) {
            return i;
        }
    } );
};

export function getKumiById ( state, kumiId ) {
    let r = filterKumis( state, 'id', kumiId );
    return r[ 0 ];
};


export function getKumiBySerialNumber( state, ksn )  {
    let r = filterKumis( state, 'serialNumber', ksn );
    return r[ 0 ];
};

export const processKumiFromJson = function ( state, kumiData, exam ) {
    _.forEach( kumiData, function ( d, i ) {
        //first make a kumi from the loaded data
        let kumi = Kumi.factory( { d } );
        let pl = Payload.factory( {
            obj: kumi,
            examId: exam.id,
            kumiId: kumi.id,
            mutateSilently: true
        } );

        // push it into storage
        // state.commit('addKumi', pl);
        state.kumis.push( kumi );

        if ( i === 0 ) {
            //set the first kumi as the one to display
            //this needs to happen before associate exam is called
            state.commit( 'toggleKumi', pl )
        }

        //Now associate the kumi with the exam
        state.commit( 'associateExamWithKumi', pl );


    } );
};