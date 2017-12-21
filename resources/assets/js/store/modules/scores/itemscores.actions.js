import * as gTypes from "../../getter-types";
import { getValenceForScore, isSameValence, sliderSettings } from "./commentHelpers";
import PayloadScore from "../../../models/PayloadScore";
import * as ngaTypes from "../newgrading/new-grading-action-types";
import * as nggTypes from "../newgrading/new-grading-getter-types";
import * as ngmTypes from "../newgrading/new-grading-mutation-types";
import scoreRequests from "../../../api/requests/scoreRequests";

module.exports = {

    /**
     * Silently creates an item score record for the student and item
     * without a score or text.
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @param item
     * @param student
     * @returns {Promise<any>}
     */
    initializeItemScore: ( { state, dispatch, commit, getters }, { exam, item, student } ) => {

        return new Promise( function ( resolve, reject ) {
            commit( ngmTypes.updateScore, PayloadScore.factory( { exam, item, student, mutateSilently: true } ) );
            resolve();
        } );
    },

    loadScoresFromServer: ( { state, dispatch, commit, getters }, exam ) => {
        let me = this;
        return new Promise( function ( resolve, reject ) {
            // window.console.log( 'itemscores', '', 193, exam, item, student);
            let p = scoreRequests.getAllScoresForExamRequest( exam );

            p.then( function ( data ) {
                _.forEach( data, function ( d ) {
                    let item = getters[ gTypes.getItemById ]( d.item_id );
                    let student = getters.getStudentFromRosterById( d.student_id );
                    let score = parseFloat( d.score );

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
                } );

                resolve();
            } );


        } );
    },

    /**
     * This handles saving an item score to the server
     * as well as updating the comments and performing
     * any other necessary actions.
     *
     * Any change to the item score (aside from initial load)
     * should happen through this
     *
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param item
     * @param student
     * @param score
     */
    [ ngaTypes.recordItemScore ]: ( { state, dispatch, commit, getters }, { exam, item, student, score } ) => {
        return new Promise( function ( resolve, reject ) {

            //get ready to store the score
            let pl = PayloadScore.factory( {
                exam: exam,
                item: item,
                student: student,
                score: score
            } );

            //before we save the score and thus lose
            // what the previous score was, we need to
            //check whether the valence has changed
            let oldScore = getters[ nggTypes.getItemScoreObject ]( {item : item, student: student} );
            //Similarly, we need to determine whether the presently
            //existing text has been customized by the user. If it has,
            //we don't want changes of the slider and score to overwrite
            //the text
            let customText = oldScore.isCustomText;

            let sameValence = _.isUndefined(oldScore) ? false : isSameValence( oldScore.score, score, item.maxScore );
            // window.console.log( 'itemscores', 'sqmc', 163, oldScore, sameValence);


            let p1 = new Promise( function ( resolve, reject ) {
                commit( ngmTypes.updateScore, pl );
                resolve();
            } );

            p1.then( function () {
                //We only need to alter text if the score has changed valence regions
                //if the valence hasn't changed or if the text is customized, we are done
                if ( sameValence || customText ) resolve();

                //Ok. So the score is in a new valence region and we're using stock
                //comments. Let's get the appropriate stock comment text and update
                // accordingly.
                let newValenceIdx = getValenceForScore( score, item.maxScore );
                let newValenceName = _.lowerCase(sliderSettings.valenceLabels[ newValenceIdx ]);
                let comment = item.comments.get( newValenceName );
                // window.console.log( 'itemscores.actions', 'comment', 126,comment );
                //This needs to be stored / saved
                let pl2 = {
                    exam: exam,
                    item: item,
                    student: student,
                    text: comment.text
                };

                //call the action to record the new comment
                let p2 = dispatch( ngaTypes.recordCommentText, pl2 );
                p2.then( function () {
                    resolve();
                } );

            } );

        } );
    },

    /**
     * This handles saving the comment text to the server.
     * It performs all other relevant tasks. Any change to the
     * comment text should be made using this.
     * @param state
     * @param dispatch
     * @param commit
     * @param getters
     * @param exam
     * @param item
     * @param student
     */
    [ ngaTypes.recordCommentText ]: ( { state, dispatch, commit, getters }, { exam, item, student, text } ) => {
        return new Promise( function ( resolve, reject ) {

            //todo Checks for making sure that the text isn't custom go here

            //store the score
            let pl = PayloadScore.factory( {
                exam: exam,
                item: item,
                student: student,
                text: text
            } );

            commit( ngmTypes.updateText, pl );

            //todo we may need to handle flagging the text as custom here so it won't get overwritten
            resolve();
        } );
    },


};
