/**
 * Created by adam on 5/19/16.
 */


/**
 * TODO Rename this or the instance as store so will be easier to use with vue data
 * Main data storage object for grading page
 * @constructor
 */
function Data() {

    /* ------------------------- Properties --------------------- */
    //creating in scope of constructor to make private and
    //only accessible via getters and setters
    var examId = null;

    /** The db id of the student currently being graded */
    var activeStudentId = null;

    /**
     * The index of the student currently being graded
     */
    var activeStudentIndex = null;

    /** Integer count of questions on the exam */
    var numberQuestions = null;


    /** The time spent grading the current student */
    var activeStudentTime = null;

    this.standardScoring = false;


    /**
     * Boolean of whether the student names are hidden.
     * true means that student names are hidden.
     */
    this.isBlind = false;

    this.valences = [ 0, 1, 2, 3 ];

    /* ----------------------------- Objects/ arrays ------------------------ */
    /**
     * Format:
     *      { studentIndex : { elementIndex : elementScore},  ... }
     */
    var elementScores = {};

    var elementComments = {};

    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN
     * is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
     * only used here as a shorthand to store and quickly find information about
     * the exam state.
     */
    var examGrades = {};

    /**
     * Format:
     *     { studentIndex : gradingTime, ... }
     */
    var examGradingTimes = {};

    /**
     * Format:
     *      { questionIndex : {questionName, questionNumber, questionAssignmentId, maxScore}, .... }
     * @type {{}}
     */
    var questions = {};

    /**
     * Object containing empty slots and actual scores for each
     * student on the exam. Structure of items:
     *      {studentIndex : {questionIndex: score}]
     * Use getters and setters to access
     */
    var questionScores = {};

    /**
     * Json of the maximum possible scores for each question.
     * Keys are questionIndexes
     * Format: { questionIndex : maxScore, ... }
     */
    var maxQuestionScores = {};

    var stockComments = {};

    /**
     * Json of students
     * Format:
     *      { studentIndex : { studentId: int, firstName: str, lastName: str, studentIdentifier: str }, ....}
     * @type {{}}
     */
    var students = {};


    /* -------------------------------- Initialization ------------------------ */


    this.loadNumberQuestions = function ( numberQuestionsOnExam ) {
        numberQuestions = numberQuestionsOnExam;
    };


    /* ------------------ Active student ------------------- */
    this.setActiveStudent = function ( studentIndex, studentId ) {
        window.console.log('setting', studentIndex);
        activeStudentIndex = studentIndex;
        activeStudentId = studentId;
    };

    this.getActiveStudentId = function () {
        return activeStudentId;
    };

    this.getActiveStudentIndex = function(){
      return activeStudentIndex;
    };

    this.getActiveStudent = function(){
        return this.getActiveStudentIndex();
    };


        /* ------------------ Getters and setters for other simple properties ------------------- */
    this.getExamId = function () {
        return examId;
    };
    this.setExamId = function ( examIdToSet ) {
        examId = examIdToSet;
    };


    /* ------------------ Grading time ------------------- */

    /**
     * Sets the grading time data from the server
     * @param examGradingTimes JSON object
     */
    this.loadGradingTimes = function ( examGradingTimesJSON ) {
        examGradingTimes = examGradingTimesJSON;
    };

    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    this.getTotalGradingTime = function(){
        var totalTime = 0;
        for(var i=0; i < Object.keys(examGradingTimes).length; i++){
            totalTime += examGradingTimes[i];
        }
        return totalTime;
    };

    /**
     * Original: data.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    this.getStudentGradingTime = function ( activeStudent ) {
        return examGradingTimes[ activeStudent ];
    };

    /**
     * Convenience method for getting the grading time of the student presently
     * being graded
     * @returns {*}
     */
    this.getActiveStudentGradingTime = function () {
        // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
        if(activeStudentIndex == null) return '';

        return this.getStudentGradingTime( activeStudentIndex );
    };

    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.storeStudentGradingTime = function ( studentIndex, activeStudentTime ) {
        examGradingTimes[ studentIndex ] = activeStudentTime;
    };

    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseStudentGradingTime = function ( studentIndex, timeToAdd ) {
        examGradingTimes[ studentIndex ] += timeToAdd;
    };

    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseActiveStudentGradingTime = function ( timeToAdd ) {
        examGradingTimes[ activeStudentIndex ] += timeToAdd;
    };

    /* ------------------ Element scores  ------------ */

    this.loadElementScores = function ( studentElementScores ) {
        elementScores = studentElementScores;
    };

    /**
     * Stores a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
    this.storeElementScore = function ( studentIndex, elementIndex, score ) {
        elementScores[ studentIndex ][ elementIndex ] = score;
    };

    this.storeElementScoreForActiveStudent = function ( elementIndex, score ) {
        this.storeElementScore(activeStudentIndex, elementIndex, score);
    };


    /**
     * Retrieves element score for a student
     * Original: data.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getElementScore = function ( studentIndex, elementIndex ) {
        return elementScores[ studentIndex ][ elementIndex ];
    };

    this.getElementScoreForActiveStudent = function ( elementIndex ) {
        if(activeStudentIndex == null) return '';
        return elementScores[ activeStudentIndex ][ elementIndex ];
    };


    /* ------------------ Comments  ------------ */
    /**
     * Takes a json from the server of the stock comments and stores it internally.
     */
    this.loadStockComments = function ( stockCommentsJSON ) {
        stockComments = stockCommentsJSON;
    };

    this.loadElementComments = function ( studentElementCommentsJSON ) {
        elementComments = studentElementCommentsJSON;
    };

    /**
     * Store the comment text for an element.
     *
     * If on the first slider move, the incoming commentText
     * will be an empty string. That's okay. The initial value
     * of the comment in the data object is an empty string.
     * So we save it anyway. The stock comment will be
     * retrieved on the call to getCommentText.
     *
     @param activeStudent
     * @param elementIndex
     * @param commentText
     */
    this.storeCommentText = function ( studentIndex, elementIndex, commentText ) {
        elementComments[ studentIndex ][ elementIndex ] = commentText;
    };

    this.storeCommentTextForActiveStudent = function (elementIndex, commentText ) {
        elementComments[ activeStudentIndex ][ elementIndex ] = commentText;
    };

    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment.
     *
     * Original: data.elementComments[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getCommentText = function ( studentIndex, elementIndex, valence ) {
        var comment = elementComments[ studentIndex ][ elementIndex ];
        if ( comment == "" ) {
            return stockComments[ elementIndex ][ valence ];
        }
        //now for the fun part. If the user had previously moved the
        //slider, elementComments will have a stock text value.
        //We don't want to wipe out the stored value if it was customized.
        //But if they didn't customize the text (i.e., if there is
        //just a stock text value set), then we do want to switch to
        //the stock text corresponding to the new slider value.
        //So we first check whether the existing comment is custom
        var isCustom = true;
        var i = 0;
        //loop through the stock comments and look for a match
        while ( isCustom && i <= this.valences.length ) {
            var stock = stockComments[ elementIndex ][ i ];
            if ( stock == comment ) {
                isCustom = false;
            }
            i ++;
        }
        //If it turns out that the previous comment was stock, then return the
        //new stock comment corresponding to the valence
        if ( ! isCustom ) {
            return stockComments[ elementIndex ][ valence ];
        }
        //If it was custom, return the same text
        return comment;
    };

    /**
     * Mainly used for testing. This gets the stored comment, which might be
     * an empty string if the exam hasn't been graded.
     * (The usual getter will return stock text in those cases)
     * @param studentIndex
     * @param elementIndex
     * @param valence
     * @private
     */
    this._getStoredCommentText = function ( studentIndex, elementIndex ) {
        return elementComments[ studentIndex ][ elementIndex ];
    };

    this.getCommentTextForActiveStudent = function ( elementIndex, valence ) {
        if(activeStudentIndex == null) return '';
        return this.getCommentText(activeStudentIndex, elementIndex, valence);
    };


    /* ------------------ Questions  ------------ */
    /**
     * Loads a json object of questions.
     * @param .questionsJSON
     */
    this.loadQuestions = function ( questionsJSON ) {
        questions = questionsJSON;
    };

    /**
     * Returns a question object.
     * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
     * @param questionIndex
     * @returns {*}
     */
    this.getQuestion = function(questionIndex){
        return questions[questionIndex];
    }


    /* ------------------ Question scores  ------------ */
    /**
     * Loads a json object of question scores.
     * @param studentQuestionScoresJSON
     */
    this.loadQuestionScores = function ( studentQuestionScoresJSON ) {
        questionScores = studentQuestionScoresJSON;
    };

    /**
     * Saves a question score for the student
     * Original: data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    this.storeQuestionScore = function ( studentIndex, questionIndex, score ) {
        questionScores[ studentIndex ][ questionIndex ] = score;
    };
    this.storeQuestionScoreForActiveStudent = function ( questionIndex, score ) {
        questionScores[ activeStudentIndex ][ questionIndex ] = score;
    };


    /**
     * Returns student score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param questionIndex
     */
    this.getQuestionScore = function ( studentIndex, questionIndex ) {
        return questionScores[ studentIndex ][ questionIndex ];
    };

    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    this.getQuestionScoreForActiveStudent = function ( questionIndex ) {
        // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
        if(activeStudentIndex == null) return '';
        return this.getQuestionScore( activeStudentIndex, questionIndex );
    };

    /* ------------------ Max question scores ------------ */
    /**
     * Initially loads a json of max scores into the object
     * Format: { questionIndex: maxScore, ....}
     * @param maxScores
     */
    this.loadMaxQuestionScores = function ( maxScores ) {
        maxQuestionScores = maxScores;
    };

    /**
     * Returns the maximum possible score for a given question
     * @param questionIndex
     * @returns {*}
     */
    this.getMaxQuestionScore = function(questionIndex){
      return maxQuestionScores[questionIndex];
    };




    /* ------------------ Exam grades ------------ */
    this.loadExamGrades = function ( studentGrades ) {
        examGrades = studentGrades;
    };

    this.getExamGrade = function(studentIndex){
      return examGrades[studentIndex];
    };

    this.getExamGradeForActiveStudent = function(){
        if(activeStudentIndex == null) return '';
        return examGrades[activeStudentIndex];
    };

    /* ----------------------------------- Students ----------------------- */
    this.loadStudents = function(studentJson){
        students = studentJson;
    };

    /**
     * Returns a student object with keys:
     *      studentId
     *      studentIdentifier
     *      firstName
     *      lastName
     * @param studentIndex
     * @returns {*}
     */
    this.getStudent = function(studentIndex){
        return students[studentIndex];
    };

    /**
     * Mostly used for testing
     * @param studentIndex
     * @private
     */
    this._setExamGrade = function(studentIndex, score){
        examGrades[studentIndex] = score;
    }


    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     **/
    this.updateExamGrade = function ( studentIndex ) {
        var totalScore = null;
        // try {
        // this.checkValid( 'questionScores' );
        if ( Object.keys( questionScores ).length > 0 ) {
            for ( var i = 0; i < Object.keys( questionScores[ studentIndex ] ).length; i ++ ) {
                var v = questionScores[ studentIndex ][ i ];
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
                examGrades[ studentIndex ] = totalScore.toPrecision( 3 );
            } else {
                //replace 'letter grade' with -1
                examGrades[ studentIndex ] = - 1;
            }
        }
        // } catch ( err ) {
        //     window.console.log( err );
        // }
    };

    /* ----------------------------------- Shortcuts ----------------------- */
    /**
     * Saves the trouble of other methods having to figure out whether a student
     * is set as active student (which can run into trouble if, for example, the
     * active student has index 0 and the consuming method interprets this as false).
     */
    this.isActive = function () {
        if ( typeof activeStudentIndex == 'undefined' ) return false;
        if ( activeStudentIndex === null ) return false;
        if ( activeStudentIndex >= 0 ) {
            return true;
        }
        return false;
    };

    /**
     * Returns true if at least one question has received
     * a score for the student.
     */
    this.isGraded = function ( studentIndex ) {
        this.updateExamGrade( studentIndex )
        if ( examGrades[ studentIndex ] != "Letter grade" && examGrades[ studentIndex ] >= 0 ) {
            return true;
        }
        return false;
    };


    /**
     * Returns the number of exams that have been graded.
     * NB, before counting them it first goes through and makes
     * sure that each examGrade is set to the sum of graded questions
     * for that exam.
     */
    this.getNumberGraded = function () {
        var graded = 0;

        if ( Object.keys( examGrades ).length > 0 ) {
            //Loop through each exam (via studentIndex as key)
            for ( var i = 0; i < Object.keys( examGrades ).length; i ++ ) {
                //Make sure the stored exam total score is up to date
                this.updateExamGrade( i );
                //this will be the string 'letter grade' if
                //no grade has been entered. Thus we check
                //whether it is a number 0 or greater
                //if it is graded, increment the number graded
                if ( examGrades[ i ] >= 0 ) graded ++;
            }
        }
        return graded;
    };

    /**
     * Returns the total number of exams
     *
     * TODO Store this value after first run
     *
     * @returns {number|Number}
     */
    this.getTotalExams = function () {
        //memoize
        // if(this.getTotalExams.total && this.getTotalExams.total >= 0) return this.getTotalExams.total;

        //initialize
        this.getTotalExams.total = 0;
        if ( Object.keys( examGrades ).length > 0 ) {
            this.getTotalExams.total = Object.keys( examGrades ).length;
        }

        return this.getTotalExams.total;
    };

    /* ------------ Utilities --------------*/

    /**
     * Checks to make sure that a property has had its
     * values loaded before trying to do stuff with it
     *
     * @param propertyName
     */
    this.checkValid = function ( propertyName ) {
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
    };

    this._spy = function(propertyName){
      return DapropertyName;
    };
};