/**
 * Created by adam on 10/7/16.
 */


import * as mTypes from '../mutation-types'
import * as aTypes from '../action-types'
import Payload from '../../models/Payload'

const state = {
    /**
     * This holds the assigned comments for students
     */
    elementComments: {},

    /**
     * This holds the default comments
     */
    stockComments: {},

    /** Standard valences */
    valences: [ 0, 1, 2, 3 ]

};

const isElementCommentsEmpty = ( state ) => {
    if ( Object.keys(state.elementComments).length > 0 ) {
        return false;
    }
    return true;
};

const mutations = {
    /**
     * Update the text of an element comment for a student
     * @param state
     * @param rootState
     * @param payload
     */
        [mTypes.setElementComment]( state, payload )
    {
        Payload.checkIfPayload(payload);

        let commentText = payload.str;
        let studentIndex = payload.index;
        let elementIndex = payload.index2;

        state.elementComments[ studentIndex ][ elementIndex ] = commentText;
    },

    /**
     * Consume a json object and populate the elementComments store
     * @param state
     * @param rootState
     * @param elementCommentsJSON
     */
        [mTypes.loadElementComments]( state, payload )
    {
        Payload.checkIfPayload(payload);
        state.elementComments = payload.obj;
        // state.elementComments = elementCommentsJSON;
    },

    /**
     * Consume a json object and populate the stockComments store.
     * @param state
     * @param rootState
     * @param stockCommentsJSON
     */
        [mTypes.loadStockComments]( state, payload )
    {
        Payload.checkIfPayload(payload);
        state.stockComments = payload.obj;
    },

    /**
     * Update the text of an element comment for a student
     * @param state
     * @param rootState
     * @param payload
     */
        [mTypes.updateCommentText]( state, payload )
    {
        Payload.checkIfPayload(payload);

        let commentText = payload.str;
        let studentIndex = payload.index;
        let elementIndex = payload.index2;

        state.elementComments[ studentIndex ][ elementIndex ] = commentText;
    },


};

const actions = {

    /**
     * Store the comment text for an element.
     *
     * If on the first slider move, the incoming commentText
     * will be an empty string. That's okay. The initial value
     * of the comment in the data object is an empty string.
     * So we save it anyway. The stock comment will be
     * retrieved on the call to getCommentText.
     *
     * Payload expected to have keys:
     *      studentIndex
     *      elementIndex
     *      commentText
     * @param state
     * @param commit
     * @param payload
     */
    [aTypes.storeCommentText]: ( {state, commit}, payload ) => {

        let pl = Payload.factory({
            index: payload.studentIndex,
            index2: payload.elementIndex,
            str: payload.commentText
        });

        commit(mTypes.setElementComment, pl);

        // let studentIndex = payload.studentIndex;
        // let elementIndex = payload.elementIndex;
        // let commentText = payload.commentText;
        // commit( mTypes.setElementComment, payload );
        // state.elementComments[studentIndex][elementIndex] = commentText;
    }

    //
    // /**
    //  * Shortcut to avoid having to look up the active student from elsewhere
    //  * @param elementIndex
    //  * @param commentText
    //  */
    //     [aTypes.storeCommentTextForActiveStudent]( {state, commit}, payload )
    // {
    //     //add the student index
    //     payload.studentIndex = state.activeStudentIndex;
    //
    //     commit( types.setElementComment, payload );
    //
    //     // let elementIndex = payload.elementIndex;
    //     // let commentText = payload.commentText;
    //     // state.elementComments[  ][ elementIndex ] = commentText;
    // }


};

const getters = {
    /**
     * Retrieves an element comment by student index and element index
     *
     * @param state
     * @param getters
     * @param rootState
     * @param studentIndex
     * @param elementIndex
     * @returns {*}
     */
    getElementComment: ( state, getters, rootState, studentIndex, elementIndex ) => {
        if ( isElementCommentsEmpty(state) ) {
            return false;
        }
        ;

        return state.elementComments[ studentIndex ][ elementIndex ];

    },


    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment.
     *
     * Original: data.this.elementComments[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param elementIndex
     * @param valence
     * @returns {*}
     */
    getCommentText: ( state, getters, rootState, studentIndex, elementIndex, valence ) => {
        if ( isElementCommentsEmpty(state) ) {
            return false;
        }
        ;

        //First check for a pre-existing comment. This could be a stock comment
        //or it could be custom.
        let comment = state.elementComments[ studentIndex ][ elementIndex ];
        if ( comment == "" ) {
            //If no comment is set, we're going to go with the stock comment
            return state.stockComments[ elementIndex ][ valence ];
        }
        //now for the fun part. If the user had previously moved the
        //slider, this.elementComments will have a stock text value.
        //We don't want to wipe out the stored value if it was customized.
        //But if they didn't customize the text (i.e., if there is
        //just a stock text value set), then we do want to switch to
        //the stock text corresponding to the new slider value.
        //So we first check whether the existing comment is custom
        let isCustom = true;
        let i = 0;
        //loop through the stock comments and look for a match
        //TODO should this be < ?
        while (isCustom && i <= state.valences.length) {
            var stock = state.stockComments[ elementIndex ][ i ];
            if ( stock == comment ) {
                isCustom = false;
            }
            i++;
        }
        //If it turns out that the previous comment was stock, then return the
        //new stock comment corresponding to the valence
        if ( !isCustom ) {
            return state.stockComments[ elementIndex ][ valence ];
        }
        //If it was custom, return the custom text
        return comment;
    },


    /**
     * Mainly used for testing. Though is used by gradeVue currently.
     * This gets the stored comment, which might be
     * an empty string if the exam hasn't been graded.
     * (The usual getter will return stock text in those cases)
     * @param studentIndex
     * @param elementIndex
     * @private
     */
    getStoredCommentText: ( state, getters, rootState, studentIndex, elementIndex ) => {
        if ( isElementCommentsEmpty(state) ) {
            return false;
        }
        ;

        return state.elementComments[ studentIndex ][ elementIndex ];
    }


};

export default {
    actions,
    getters,
    mutations,
    state,
}