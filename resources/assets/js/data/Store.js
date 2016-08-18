/**
 * Created by adam on 5/19/16.
 */

import Student from './Student';
/**
 * Main data storage object for grading page
 */

export default class Store {
    constructor() {

        /* ------------------------- Properties --------------------- */
        /** The db id of the student currently being graded */
        this.activeStudentId = null;

        /**
         * The index of the student currently being graded
         */
        this.activeStudentIndex = null;

        /** The time spent grading the current student */
        this.activeStudentTime = null;

        this.examId = null;

        /** Format: { studentIndex : { elementIndex : elementScore},  ... } */
        this.elementScores = {};

        this.elementComments = {};

        /**
         * this.examGrades[] keeps a persistent total of the exam score for each student.
         * Exams without grades have a value of -1, because dealing with null and NaN
         * is unpredictable across js and PHP.
         * This shouldn't be an issue, as the DB has no notion of exam grades, they're
         * only used here as a shorthand to store and quickly find information about
         * the exam state.
         */
        this.examGrades = {};

        /**
         * Format:
         *     { studentIndex : gradingTime, ... }
         */
        this.examGradingTimes = {};


        /**
         * Standard grades
         * Format:
         *  { {calcValue : int, displayValue: string}, .... }
         * @type {{}}
         */
        this.grades = {};

        /**
         * Boolean of whether the student names are hidden.
         * true means that student names are hidden.
         */
        this.isBlind = false;

        /**
         * Json of the maximum possible scores for each question.
         * Keys are questionIndexes
         * Format: { questionIndex : maxScore, ... }
         */
        this.maxQuestionScores = {};

        /** Integer count of questions on the exam */
        this.numberQuestions = null;


        /**
         * Format:
         *      { questionIndex : {questionName, questionNumber, questionAssignmentId, maxScore}, .... }
         * @type {{}}
         */
        this.questions = {};

        /**
         * Object containing empty slots and actual scores for each
         * student on the exam. Structure of items:
         *      {studentIndex : {questionIndex: score}]
     * Use getters and setters to access
     */
        this.questionScores = {};

        this.standardScoring = false;

        this.stockComments = {};

        /**
         * Json of students
         * Format: { studentIndex : { studentId: int, firstName: str, lastName: str, studentIdentifier: str }, ....}
         * @type {{}}
         */
        this.students = {};

        /** Standard valences */
        this.valences = [ 0, 1, 2, 3 ];
        /* ----------------------------- Objects/ arrays ------------------------ */
    }

    /* -------------------------------- Initialization ------------------------ */

    loadElementComments( elementCommentsJSON ) {
        this.elementComments = elementCommentsJSON;
    }


    loadElementScores( studentElementScores ) {
        this.elementScores = studentElementScores;
    }

    loadExamGrades( studentGrades ) {
        this.examGrades = studentGrades;
    }

    /**
     * Sets the standard grades
     * @param gradesJson
     */
    loadGrade( gradesJson ) {
        if ( typeof gradesJson == 'string' ) {
            gradesJson = JSON.parse( gradesJson );
        }
        this.grades = gradesJson;
    }

    /**
     * Sets the grading time data from the server
     * @param this.examGradingTimes JSON object
     */
    loadGradingTimes( examGradingTimesJSON ) {
        this.examGradingTimes = examGradingTimesJSON;
    }

    /**
     * Initially loads a json of max scores into the object
     * Format: { questionIndex: maxScore, ....}
     * @param maxScores
     */
    loadMaxQuestionScores( maxScores ) {
        this.maxQuestionScores = maxScores;
    }

    loadNumberQuestions( numberQuestionsOnExam ) {
        this.numberQuestions = numberQuestionsOnExam;
    }

    /**
     * Loads a json object of questions.
     * @param .questionsJSON
     */
    loadQuestions( questionsJSON ) {
        this.questions = questionsJSON;
    }

    /**
     * Loads a json object of question scores.
     * @param .questionScoresJSON
     */
    loadQuestionScores( questionScoresJSON ) {
        this.questionScores = questionScoresJSON;
    }


    /**
     * Takes a json from the server of the stock comments and stores it internally.
     */
    loadStockComments( stockCommentsJSON ) {
        this.stockComments = stockCommentsJSON;
    }

    loadStudents( studentJson ) {
        for(let i=0; i<Object.keys(studentJson).length; i++){
            let s = studentJson[Object.keys(studentJson)[i]];
            this.students[s.studentId] = Student.factory(s);
        }
//        this.students = studentJson;
    }


    /* ------------------ Active student ------------------- */
    setActiveStudent( studentIndex, studentId ) {
        this.activeStudentIndex = studentIndex;
        if ( typeof studentId == 'undefined' ) {
            let student = this.students[ studentIndex ];
            studentId = student.studentId;
        }
        this.activeStudentId = studentId;
    }

    getActiveStudentId() {
        return this.activeStudentId;
    }

    getActiveStudentIndex() {
        return this.activeStudentIndex;
    }

    getActiveStudent() {
        return this.getStudent( this.activeStudentIndex() );
    }


    /* ------------------ Comments  ------------ */

    /**
     * Store the comment text for an element.
     *
     * If on the first slider move, the incoming commentText
     * will be an empty string. That's okay. The initial value
     * of the comment in the data object is an empty string.
     * So we save it anyway. The stock comment will be
     * retrieved on the call to getCommentText.
     * @param studentIndex
     * @param elementIndex
     * @param commentText
     */
    storeCommentText( studentIndex, elementIndex, commentText ) {
        this.elementComments[ studentIndex ][ elementIndex ] = commentText;
    }

    storeCommentTextForActiveStudent( elementIndex, commentText ) {
        this.elementComments[ this.activeStudentIndex ][ elementIndex ] = commentText;
    }

    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment.
     *
     * Original: data.this.elementComments[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getCommentText( studentIndex, elementIndex, valence ) {
        var comment = this.elementComments[ studentIndex ][ elementIndex ];
        if ( comment == "" ) {
            return this.stockComments[ elementIndex ][ valence ];
        }
        //now for the fun part. If the user had previously moved the
        //slider, this.elementComments will have a stock text value.
        //We don't want to wipe out the stored value if it was customized.
        //But if they didn't customize the text (i.e., if there is
        //just a stock text value set), then we do want to switch to
        //the stock text corresponding to the new slider value.
        //So we first check whether the existing comment is custom
        var isCustom = true;
        var i = 0;
        //loop through the stock comments and look for a match
        while ( isCustom && i <= this.valences.length ) {
            var stock = this.stockComments[ elementIndex ][ i ];
            if ( stock == comment ) {
                isCustom = false;
            }
            i ++;
        }
        //If it turns out that the previous comment was stock, then return the
        //new stock comment corresponding to the valence
        if ( ! isCustom ) {
            return this.stockComments[ elementIndex ][ valence ];
        }
        //If it was custom, return the same text
        return comment;
    }


    /**
     * Mainly used for testing. This gets the stored comment, which might be
     * an empty string if the exam hasn't been graded.
     * (The usual getter will return stock text in those cases)
     * @param studentIndex
     * @param elementIndex
     * @param valence
     * @private
     */
    _getStoredCommentText( studentIndex, elementIndex ) {
        return this.elementComments[ studentIndex ][ elementIndex ];
    }

    getCommentTextForActiveStudent( elementIndex, valence ) {
        if ( this.activeStudentIndex == null ) return '';
        return this.getCommentText( this.activeStudentIndex, elementIndex, valence );
    }

    /* ------------------ Exam grades ------------ */

    getExamGrade( studentIndex ) {
        return this.examGrades[ studentIndex ];
    }

    getExamGradeForActiveStudent() {
        if ( this.activeStudentIndex == null ) return '';
        return this.examGrades[ this.activeStudent ];
    }


    /* ------------------ Getters and setters for other simple properties ------------------- */

    getExamId() {
        return this.examId;
    }

    setExamId( examIdToSet ) {
        this.examId = examIdToSet;
    }

    /* ------------------ Grades ------------------- */


    /**
     * Returns the standard grades json.
     * NB, this is not the total scores for students
     * @returns {{}}
     */
    getGrade() {
        return this.grades;
    }


    /* ------------------ Grading time ------------------- */

    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    getTotalGradingTime() {
        var totalTime = 0;
        for ( var i = 0; i < Object.keys( this.examGradingTimes ).length; i ++ ) {
            totalTime += this.examGradingTimes[ i ];
        }
        return totalTime;
    }

    /**
     * Original: data.this.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    getStudentGradingTime( activeStudent ) {
        return this.examGradingTimes[ activeStudent ];
    }

    /**
     * Convenience method for getting the grading time of the student presently
     * being graded
     * @returns {*}
     */
    getActiveStudentGradingTime() {
        // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
        if ( this.activeStudentIndex == null ) return '';

        return this.getStudentGradingTime( this.activeStudentIndex );
    }


    /**
     * Retrieves element score for a student
     * Original: data.this.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    getElementScore( studentIndex, elementIndex ) {
        return this.elementScores[ studentIndex ][ elementIndex ];
    }

    getElementScoreForActiveStudent( elementIndex ) {
        if ( this.activeStudentIndex == null ) return '';
        return this.elementScores[ this.activeStudentIndex ][ elementIndex ];
    }

    /* ------------------ Max question scores ------------ */
    /**
     * Returns a question object.
     * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
     * @param questionIndex
     * @returns {*}
     */
    getQuestion( questionIndex ) {
        return this.questions[ questionIndex ];
    }

    /* ------------------ Question scores  ------------ */

    /**
     * Returns student score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param questionIndex
     */
    getQuestionScore( studentIndex, questionIndex ) {
        return this.questionScores[ studentIndex ][ questionIndex ];
    }

    /**
     * Returns a json containing student objects with student indexes as keys.
     * The contained object has the keys:
     *      studentId
     *      studentIdentifier
     *      firstName
     *      lastName
     * @returns {*}
     */
    getStudents() {
        return this.students;
    }

    /**
     * Returns a student object with keys:
     *      studentId
     *      studentIdentifier
     *      firstName
     *      lastName
     * @param studentIndex
     * @returns {*}
     */
    getStudent( studentIndex ) {
        return this.students[ studentIndex ];
    }


    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    getQuestionScoreForActiveStudent( questionIndex ) {
        // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
        if ( this.activeStudentIndex == null ) return '';
        return this.getQuestionScore( this.activeStudentIndex, questionIndex );
    }


    /**
     * Returns the maximum possible score for a given question
     * @param questionIndex
     * @returns {*}
     */
    getMaxQuestionScore( questionIndex ) {
        return this.maxQuestionScores[ questionIndex ];
    }

    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    storeStudentGradingTime( studentIndex, activeStudentTime ) {
        this.examGradingTimes[ studentIndex ] = activeStudentTime;
    }

    /**
     * Stores a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
    storeElementScore( studentIndex, elementIndex, score ) {
        this.elementScores[ studentIndex ][ elementIndex ] = score;
    }


    /**
     * Mostly used for testing
     * @param studentIndex
     * @private
     */
    _setExamGrade( studentIndex, score ) {
        this.examGrades[ studentIndex ];
    }

    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     **/
    updateExamGrade( studentIndex ) {
        var totalScore = null;
        // try {
        // this.checkValid( 'this.questionScores' );
        if ( Object.keys( this.questionScores ).length > 0 ) {
            for ( var i = 0; i < Object.keys( this.questionScores[ studentIndex ] ).length; i ++ ) {
                var v = this.questionScores[ studentIndex ][ i ];
                if ( v != null ) {
                    //at least one question score is non-null
                    //so the total score should be at least 0
                    //first we check whether the totalScore is still null
                    //and set it to 0 if not
                    if ( totalScore === null ) {
                        totalScore = 0;
                    }
                    //now we can add the question values to it
                    totalScore += parseFloat( v );
                }
            }
            if ( totalScore != null && totalScore >= 0 ) {
                //push the total score into exam grades as a string
                this.examGrades[ studentIndex ] = totalScore.toPrecision( 3 );
            } else {
                //replace 'letter grade' with -1
                this.examGrades[ studentIndex ] = - 1;
            }
        }
        // } catch ( err ) {
        //     window.console.log( err );
        // }
    }

    /**
     * Saves a question score for the student
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    storeQuestionScore( studentIndex, questionIndex, score ) {
        this.questionScores[ studentIndex ][ questionIndex ] = score;
    }

    storeQuestionScoreForActiveStudent( questionIndex, score ) {
        // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
        this.questionScores[ this.activeStudentIndex ][ questionIndex ] = score;
    }

    storeElementScoreForActiveStudent( elementIndex, score ) {
        this.storeElementScore( this.activeStudentIndex, elementIndex, score );
    }


    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    increaseStudentGradingTime( studentIndex, timeToAdd ) {
        this.examGradingTimes[ studentIndex ] += timeToAdd;
    }

    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    increaseActiveStudentGradingTime( timeToAdd ) {
        this.examGradingTimes[ this.activeStudentIndex ] += timeToAdd;
    }

    /* ------------------ Element scores  ------------ */
    /* ------------------ Questions  ------------ */
    /* ----------------------------------- Students ----------------------- */

    /* ----------------------------------- Shortcuts ----------------------- */
    /**
     * Saves the trouble of other methods having to figure out whether a student
     * is set as active student (which can run into trouble if, for example, the
     * active student has index 0 and the consuming method interprets this as false).
     */
    isActive() {
        if ( typeof this.activeStudentIndex == 'undefined' ) return false;
        if ( this.activeStudentIndex === null ) return false;
        if ( this.activeStudentIndex >= 0 ) {
            return true;
        }
        return false;
    }

    /**
     * Returns true if at least one question has received
     * a score for the student.
     */
    isGraded( studentIndex ) {
        this.updateExamGrade( studentIndex )
        if ( this.examGrades[ studentIndex ] != "Letter grade" && this.examGrades[ studentIndex ] >= 0 ) {
            return true;
        }
        return false;
    }


    /**
     * Returns the number of exams that have been graded.
     * NB, before counting them it first goes through and makes
     * sure that each examGrade is set to the sum of graded questions
     * for that exam.
     */
    getNumberGraded() {
        var graded = 0;

        if ( Object.keys( this.examGrades ).length > 0 ) {
            //Loop through each exam (via studentIndex as key)
            for ( var i = 0; i < Object.keys( this.examGrades ).length; i ++ ) {
                //Make sure the stored exam total score is up to date
                this.updateExamGrade( i );
                //this will be the string 'letter grade' if
                //no grade has been entered. Thus we check
                //whether it is a number 0 or greater
                //if it is graded, increment the number graded
                if ( this.examGrades[ i ] >= 0 ) graded ++;
            }
        }
        return graded;
    }


    /**
     * Returns the total number of exams
     *
     * TODO Store this value after first run
     *
     * @returns {number|Number}
     */
    getTotalExams() {
        //memoize
        // if(this.getTotalExams.total && this.getTotalExams.total >= 0) return this.getTotalExams.total;

        //initialize
        let total = 0;
        if ( Object.keys( this.examGrades ).length > 0 ) {
            total = Object.keys( this.examGrades ).length;
        }

        return total;
    }


    /* ------------ Utilities --------------*/

    /**
     * Checks to make sure that a property has had its
     * values loaded before trying to do stuff with it
     *
     * @param propertyName
     */
    checkValid( propertyName ) {
        if ( typeof this[ propertyName ] != 'undefined' ) {
            throw propertyName + " is undefined";
        }
        if ( this[ propertyName ] == null ) {
            throw propertyName + " is null";
        }
        if ( this[ propertyName ] == {} ) {
            throw propertyName + " was empty. Probably because it wasn't initialized";
        }

        return true;
    }


    static init(){

        if ( typeof window.GOM != 'undefined' ) {
            let GOM = window.GOM;
            GOM.store = new Store();
            // store.setExamId({!! $exam->id !!});
            GOM.store.loadStockComments( GOM.stockComments );
            GOM.store.loadElementComments( GOM.studentElementComments );
            GOM.store.loadElementScores( GOM.studentElementScores );
            GOM.store.loadQuestionScores( GOM.studentQuestionScores );
            GOM.store.loadGradingTimes( GOM.examGradingTimes );
            GOM.store.loadExamGrades( GOM.studentGrades );
            GOM.store.loadNumberQuestions( GOM.numQuestions );
            GOM.store.loadMaxQuestionScores( GOM.maxScores );
            GOM.store.loadStudents( GOM.students );
            GOM.store.loadQuestions( GOM.questions )
            GOM.store.loadGrade( GOM.grades )
        }

    }

}




if ( typeof window.GOM != 'undefined' ) {
    let GOM = window.GOM;
    GOM.store = new Store();
    // store.setExamId({!! $exam->id !!});
    GOM.store.loadStockComments( GOM.stockComments );
    GOM.store.loadElementComments( GOM.studentElementComments );
    GOM.store.loadElementScores( GOM.studentElementScores );
    GOM.store.loadQuestionScores( GOM.studentQuestionScores );
    GOM.store.loadGradingTimes( GOM.examGradingTimes );
    GOM.store.loadExamGrades( GOM.studentGrades );
    GOM.store.loadNumberQuestions( GOM.numQuestions );
    GOM.store.loadMaxQuestionScores( GOM.maxScores );
    GOM.store.loadStudents( GOM.students );
    GOM.store.loadQuestions( GOM.questions )
    GOM.store.loadGrade( GOM.grades )
}
