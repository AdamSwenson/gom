import * as aTypes from "../../action-types";
import { getGradeAssignments } from "../../../api/requests/gradeAssignmentRequests";
import GradeAssignment from "../../../models/GradeAssignment";
import Payload from "../../../models/Payload";

module.exports = {

    /**
     * Makes a request to the server for grade assignment data
     * and then dispatches loadGradeAssignmentsFromServerData.
     * Triggers resolve once all data is loaded.
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @returns {Promise<any>}
     */
    [ aTypes.loadGradeAssignmentsFromServer ]: ( { state, dispatch, commit, getters }, exam ) => {
        return new Promise( function ( resolve, reject ) {
            let me = this;
            let p = getGradeAssignments( exam );
            p.then( function ( data ) {
                let p2 = dispatch( aTypes.loadGradeAssignmentsFromServerData, data );
                p2.then( function () {
                    resolve();
                } );
            } );

        } );
    },

    /**
     * Processes the result of a request for grade assignment data
     * from the server.
     *
     * When using axios, payload should be response.data
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param payload
     */
    [ aTypes.loadGradeAssignmentsFromServerData ]: ( { state, dispatch, commit, getters }, payload ) => {
        return new Promise( function ( resolve, reject ) {
            let newData = {};
            _.forEach( payload, function ( d ) {
                //create new grade assignment object
                let g = GradeAssignment.factory( {
                    calcValue: d.calcValue,
                    displayValue: d.displayValue,
                    gradeId: d.gradeId,
                    group: d.group,
                    id: d.id,
                    minScore: d.minScore,
                    ordinal: d.ordinal
                } );
                newData[ g.displayValue ] = g;
                commit( 'replaceGradeAssignments', Payload.factory( { obj: newData, mutateSilently: true } ) );
            } );

            resolve();
        } );
    },

    /*
    [ aTypes.updateCutoff ]: ( { state, dispatch, commit, getters }, payload ) => {
       // NEITHER USED NOR FUNCTIONAL; HERE IN CASE WE NEED IT IN FUTURE

        //validate that adding this value won't mess
        //up the proper ordering of the scores

        if ( validateOrderingChange( payload ) ) {
            //Call the mutation
            commit( mTypes.updateGradeCutoffs, payload );

        } else {
            //error handling
        }
    }
*/

};