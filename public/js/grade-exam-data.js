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
    this.examId = null;

    /** The db id of the student currently being graded */
    this.activeStudentId = null;

    /**
     * The index of the student currently being graded
     */
    this.activeStudentIndex = null;

    /** Integer count of questions on the exam */
    this.numberQuestions = null;


    /** The time spent grading the current student */
    this.activeStudentTime = null;

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

    /**
     * Json of the maximum possible scores for each question.
     * Keys are questionIndexes
     * Format: { questionIndex : maxScore, ... }
     */
    this.maxQuestionScores = {};

    this.stockComments = {};

    /**
     * Json of students
     * Format:
     *      { studentIndex : { studentId: int, firstName: str, lastName: str, studentIdentifier: str }, ....}
     * @type {{}}
     */
    this.students = {};

    /* -------------------------------- Initialization ------------------------ */


    this.loadNumberQuestions = function ( numberQuestionsOnExam ) {
        this.numberQuestions = numberQuestionsOnExam;
    };


    /* ------------------ Active student ------------------- */
    this.setActiveStudent = function ( studentIndex, studentId ) {
        this.activeStudentIndex = studentIndex;
        this.activeStudentId = studentId;
    };

    this.getActiveStudentId = function () {
        return this.activeStudentId;
    };

    this.getActiveStudentIndex = function(){
      return this.activeStudentIndex;
    };

    this.getActiveStudent = function(){
        return this.getactiveStudentIndex();
    };

    /* ------------------ Exam grades ------------ */
    this.loadExamGrades = function ( studentGrades ) {
        this.examGrades = studentGrades;
    };

    this.getExamGrade = function(studentIndex){
        return this.examGrades[studentIndex];
    };

    this.getExamGradeForActiveStudent = function(){
        if(this.activeStudentIndex == null) return '';
        return this.examGrades[this.activeStudentIndex];
    };


    /**
     * Mostly used for testing
     * @param studentIndex
     * @private
     */
    this._setExamGrade = function(studentIndex, score){
        this.examGrades[studentIndex] = score;
    }


    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     **/
    this.updateExamGrade = function ( studentIndex ) {
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
    };


    /* ------------------ Getters and setters for other simple properties ------------------- */
    this.getExamId = function () {
        return this.examId;
    };
    this.setExamId = function ( examIdToSet ) {
        this.examId = examIdToSet;
    };


    /* ------------------ Grading time ------------------- */

    /**
     * Sets the grading time data from the server
     * @param this.examGradingTimes JSON object
     */
    this.loadGradingTimes = function ( examGradingTimesJSON ) {
        this.examGradingTimes = examGradingTimesJSON;
    };

    /**
     * Returns the total amount of time spent grading in seconds
     * @returns {number}
     */
    this.getTotalGradingTime = function(){
        var totalTime = 0;
        for(var i=0; i < Object.keys(this.examGradingTimes).length; i++){
            totalTime += this.examGradingTimes[i];
        }
        return totalTime;
    };

    /**
     * Original: data.this.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    this.getStudentGradingTime = function ( activeStudent ) {
        return this.examGradingTimes[ activeStudent ];
    };

    /**
     * Convenience method for getting the grading time of the student presently
     * being graded
     * @returns {*}
     */
    this.getActiveStudentGradingTime = function () {
        // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
        if(this.activeStudentIndex == null) return '';

        return this.getStudentGradingTime( this.activeStudentIndex );
    };

    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    this.storeStudentGradingTime = function ( studentIndex, activeStudentTime ) {
        this.examGradingTimes[ studentIndex ] = activeStudentTime;
    };

    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseStudentGradingTime = function ( studentIndex, timeToAdd ) {
        this.examGradingTimes[ studentIndex ] += timeToAdd;
    };

    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.this.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseActiveStudentGradingTime = function ( timeToAdd ) {
        this.examGradingTimes[ this.activeStudentIndex ] += timeToAdd;
    };

    /* ------------------ Element scores  ------------ */

    this.loadElementScores = function ( studentElementScores ) {
        this.elementScores = studentElementScores;
    };

    /**
     * Stores a student's score on a particular element
     * @param studentIndex
     * @param elementIndex
     * @param score
     */
    this.storeElementScore = function ( studentIndex, elementIndex, score ) {
        this.elementScores[ studentIndex ][ elementIndex ] = score;
    };
    this.storeElementScoreForActiveStudent = function ( elementIndex, score ) {
        this.storeElementScore(this.activeStudentIndex, elementIndex, score);
    };


    /**
     * Retrieves element score for a student
     * Original: data.this.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getElementScore = function ( studentIndex, elementIndex ) {
        return this.elementScores[ studentIndex ][ elementIndex ];
    };
    this.getElementScoreForActiveStudent = function ( elementIndex ) {
        if(this.activeStudentIndex == null) return '';
        return this.elementScores[ this.activeStudentIndex ][ elementIndex ];
    };


    /* ------------------ Comments  ------------ */
    /**
     * Takes a json from the server of the stock comments and stores it internally.
     */
    this.loadStockComments = function ( stockCommentsJSON ) {
        this.stockComments = stockCommentsJSON;
    };

    this.loadElementComments = function ( elementCommentsJSON ) {
        this.elementComments = elementCommentsJSON;
    };

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
    this.storeCommentText = function ( studentIndex, elementIndex, commentText ) {
        this.elementComments[ studentIndex ][ elementIndex ] = commentText;
    };
    this.storeCommentTextForActiveStudent = function (elementIndex, commentText ) {
        this.elementComments[ this.activeStudentIndex ][ elementIndex ] = commentText;
    };

    /**
     * Retrieve comment text for a student.
     * If no customized text is set, then return stockComment.
     *
     * Original: data.this.elementComments[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getCommentText = function ( studentIndex, elementIndex, valence ) {
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
        return this.elementComments[ studentIndex ][ elementIndex ];
    };

    this.getCommentTextForActiveStudent = function ( elementIndex, valence ) {
        if(this.activeStudentIndex == null) return '';
        return this.getCommentText(this.activeStudentIndex, elementIndex, valence);
    };


    /* ------------------ Max question scores ------------ */
    /**
     * Initially loads a json of max scores into the object
     * Format: { questionIndex: maxScore, ....}
     * @param maxScores
     */
    this.loadMaxQuestionScores = function ( maxScores ) {
        this.maxQuestionScores = maxScores;
    };

    /**
     * Returns the maximum possible score for a given question
     * @param questionIndex
     * @returns {*}
     */
    this.getMaxQuestionScore = function(questionIndex){
        return this.maxQuestionScores[questionIndex];
    };


    /* ------------------ Questions  ------------ */
    /**
     * Loads a json object of questions.
     * @param .questionsJSON
     */
    this.loadQuestions = function ( questionsJSON ) {
      this.questions = questionsJSON;
    };

    /**
     * Returns a question object.
     * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
     * @param questionIndex
     * @returns {*}
     */
    this.getQuestion = function(questionIndex){
        return this.questions[questionIndex];
    }



        /* ------------------ Question scores  ------------ */
    /**
     * Loads a json object of question scores.
     * @param .questionScoresJSON
     */
    this.loadQuestionScores = function ( questionScoresJSON ) {
        this.questionScores = questionScoresJSON;
    };

    /**
     * Saves a question score for the student
     * Original: data.this.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param studentIndex
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    this.storeQuestionScore = function ( studentIndex, questionIndex, score ) {
        this.questionScores[ studentIndex ][ questionIndex ] = score;
    };

    this.storeQuestionScoreForActiveStudent = function ( questionIndex, score ) {
        window.console.log('store called', this.activeStudentIndex, questionIndex, score);
        this.questionScores[ this.activeStudentIndex ][ questionIndex ] = score;
    };


    /**
     * Returns student score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param studentIndex
     * @param questionIndex
     */
    this.getQuestionScore = function ( studentIndex, questionIndex ) {
        return this.questionScores[ studentIndex ][ questionIndex ];
    };

    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    this.getQuestionScoreForActiveStudent = function ( questionIndex ) {
        // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
        if(this.activeStudentIndex == null) return '';
        return this.getQuestionScore( this.activeStudentIndex, questionIndex );
    };

    /* ----------------------------------- Students ----------------------- */
   this.loadStudents = function(studentJson){
       this.students = studentJson;
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
       return this.students[studentIndex];
   };


    /* ----------------------------------- Shortcuts ----------------------- */
    /**
     * Saves the trouble of other methods having to figure out whether a student
     * is set as active student (which can run into trouble if, for example, the
     * active student has index 0 and the consuming method interprets this as false).
     */
    this.isActive = function () {
        if ( typeof this.activeStudentIndex == 'undefined' ) return false;
        if ( this.activeStudentIndex === null ) return false;
        if ( this.activeStudentIndex >= 0 ) {
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
        if ( this.examGrades[ studentIndex ] != "Letter grade" && this.examGrades[ studentIndex ] >= 0 ) {
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
        let total = 0;
        if ( Object.keys( this.examGrades ).length > 0 ) {
            total = Object.keys( this.examGrades ).length;
        }

        return total;
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
      return Data[propertyName];
    };
};
//# sourceMappingURL=grade-exam-data.js.map
