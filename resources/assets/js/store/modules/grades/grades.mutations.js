import * as mTypes from "../../mutation-types";
import Payload from "../../../models/Payload";
import Vue from 'vue';
import { sortTotalScores, updateFrequencies, updateGradeValues, updateInconsistentList } from "./grades.helpers";
// import Vue from "../../../../../../../../Library/Preferences/PhpStorm2018.1/javascript/extLibs/http_github.com_DefinitelyTyped_DefinitelyTyped_raw_master_vue_vue";

module.exports = {
    /**
     * Updates a stored grade assignment with an altered object
     * Also calls for a consistency check
     *
     * @param state
     * @param payload
     */
    [ mTypes.updateGradeCutoffs ]: ( state, payload ) => {
        Payload.checkIfPayload( payload );
        Vue.set( state.gradeAssignments[ payload.obj.displayValue ], payload.updateProp, payload.updateVal );
        updateInconsistentList( state );
        updateFrequencies( state );
        updateGradeValues( state );
    },

    /**
     * Overwrites the existing grade assignments
     * with an new array (usually from server)
     *
     * This is not defined in gTypes because it
     * really shouldn't need to be called except by the action
     * in this file
     *
     * Also calls for a consistency check
     *
     * @param state
     * @param payload
     */
    replaceGradeAssignments: ( state, payload ) => {
        Vue.set( state, 'gradeAssignments', payload.obj );
        updateInconsistentList( state );
        updateFrequencies( state );
        updateGradeValues( state );
    },

    /**
     * Overwrites the existing list of total scores
     * with an incoming array.
     * This will sort them in ascending order before
     * saving them
     *
     * @param state
     * @param payload
     */
    [ mTypes.loadTotalScores ]: ( state, payload ) => {
        state.totalScores = sortTotalScores( payload.updateVal );
    },

};