import * as gTypes from "../../getter-types";
import { getValenceIndexForScore, isSameValence, sliderSettings } from "./commentHelpers";
import PayloadScore from "../../../models/PayloadScore";
import * as ngaTypes from "../../new-grading-action-types";
import * as nggTypes from "../../new-grading-getter-types";
import * as ngmTypes from "../../new-grading-mutation-types";
import scoreRequests from "../../../api/requests/scoreRequests";
import { readJsonFromPageString } from "../../utlities/JsonHelpers";

/**
 * This handles all means of obtaining item scores from
 * the server.
 *
 * @type {{actions: {processAndStoreLoadedScores: function({state: *, dispatch: *, commit?: *, getters?: *}, *=)}}}
 */
module.exports = {
    actions: {
        [ ngaTypes.loadScoresFromServer ]: ( { state, dispatch, commit, getters }, exam ) => {
            return new Promise( function ( resolve, reject ) {
                // window.console.log( 'itemscores', '', 193, exam, item, student);
                scoreRequests.getAllScoresForExamRequest( exam )
                    .then( function ( data ) {
                        dispatch( 'processAndStoreLoadedScores', {
                            exam: exam,
                            scoreData: data
                        } )
                            .then( function () {
                                resolve();
                            } );
                    } );
            } );
        },

        /**
         * Reads item scores from a json object on the page.
         * The location of the data should be defined in jsonLocations.scores
         * @param state
         * @param commit
         * @param dispatch
         * @param getters
         * @param jsonLocations
         * @returns {Promise<any>}
         */
        loadScoresFromPageJson: ( { state, commit, dispatch, getters }, jsonLocations ) => {
            return new Promise( function ( resolve, reject ) {

                let scoreJson = readJsonFromPageString( jsonLocations.scores );
                let exam = getters.getActiveExam;
                dispatch( 'processAndStoreLoadedScores', {
                    exam: exam,
                    scoreData: scoreJson
                } ).then( function () {
                    resolve();
                } );
            } );
        },


        /**
         * Once a score data json containing multiple scores has
         * been obtained from the server or page json, this handles
         * the actual processing and storage.
         *
         * @param state
         * @param dispatch
         * @param commit
         * @param getters
         * @param obj {exam, scoreData}
         * @returns {Promise<any>}
         */
        processAndStoreLoadedScores: ( { state, dispatch, commit, getters }, obj ) => {
            return new Promise( function ( resolve, reject ) {

                let { exam, scoreData } = obj;
                window.console.log( 'itemscores.loaders', 'scoreData', 75, scoreData );

                _.forEach( scoreData, function ( d ) {
                    let item = getters[ gTypes.getItemById ]( d.item_id );
                    let student = getters.getStudentFromRosterById( d.student_id );
                    let score = parseFloat( d.score );

                    //Identified under GOM-417
                    //this takes care of what happens if an item is removed from the exam
                    //but we don't totally delete it. The score will remain in the db and thus load, but
                    //there will be no corresponding item.
                    if (! _.isUndefined(item)) {

                        window.console.log( 'itemscores.loaders processAndStoreLoadedScores', 'item id:', d.item_id, 'score:', score, item, student );
                        //record the score (this will initialize the object too)
                        commit( ngmTypes.updateScore, PayloadScore.factory( {
                            exam: exam,
                            item: item,
                            student: student,
                            score: score,
                            mutateSilently: true
                        } ) );

                        //record the comment text
                        commit( ngmTypes.updateText, PayloadScore.factory( {
                            exam: exam,
                            item: item,
                            student: student,
                            text: d.comment_text,
                            mutateSilently: true
                        } ) );
                    }
                } );
                resolve();

            } );
        }
    }

};
