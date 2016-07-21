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
    var activeStudent = null;

    /** Integer count of questions on the exam */
    var numQuestions = null;


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
     *      {
     *          studentIndex : { elementIndex : elementScore},
     *          ...
     *      }
     * @type {null}
     */
    this.elementScores = {};

    this.elementComments = {};

    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN
     * is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
     * only used here as a shorthand to store and quickly find information about
     * the exam state.
     */
    this.examGrades = {};

    /**
     * Format:
     *     {
     *          studentIndex : gradingTime,
     *          ...
     *     }
     *
     * @type {null}
     */
    this.examGradingTimes = {};

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


    /* -------------------------------- Initialization ------------------------ */
    /**
     * Takes a json from the server of the stock comments and stores it internally.
     */
    this.loadStockComments = function ( stockComments ) {
        stockComments = stockComments;
    };

    this.loadElementComments = function ( studentElementComments ) {
        this.elementComments = studentElementComments;
    };

    this.loadElementScores = function ( studentElementScores ) {
        this.elementScores = studentElementScores;
    };

    this.loadMaxQuestionScores = function ( maxScores ) {
        maxQuestionScores = maxScores;
    };

    this.loadExamGrades = function ( studentGrades ) {
        this.examGrades = studentGrades;
    };

    this.loadNumberQuestions = function ( numberQuestions ) {
        this.numQuestions = numberQuestions;
    };


    /**
     * Sets the grading time data from the server
     * @param examGradingTimes JSON object
     */
    this.loadGradingTimes = function ( examGradingTimes ) {
        this.examGradingTimes = examGradingTimes;
    };

    /* ------------------ Active student ------------------- */
    this.setActiveStudent = function ( studentIndex, studentId ) {
        activeStudent = studentIndex;
        activeStudentId = studentId;
    };

    this.getActiveStudentId = function () {
        return activeStudentId;
    };

    this.getActiveStudentIndex = function(){
      return activeStudent;
    };

    /* ------------------ Getters and setters for other simple properties ------------------- */
    this.getExamId = function () {
        return examId;
    };
    this.setExamId = function ( examId ) {
        examId = examId;
    };
    /* ------------------ Grading time ------------------- */

    /**
     * Original: data.examGradingTimes[ Roster.activeStudent ]
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
        if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";

        return this.getStudentGradingTime( this.activeStudent );
    };


    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.storeStudentGradingTime = function ( activeStudent, activeStudentTime ) {
        this.examGradingTimes[ activeStudent ] = activeStudentTime;
    };

    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseStudentGradingTime = function ( activeStudent, timeToAdd ) {
        this.examGradingTimes[ activeStudent ] += timeToAdd;
    };

    /**
     * Increases the stored time for the student currently being graded by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseActiveStudentGradingTime = function ( timeToAdd ) {
        this.examGradingTimes[ this.activeStudent ] += timeToAdd;
    };

    /* ------------------ Element scores  ------------ */
    /**
     * Stores a student's score on a particular element
     * @param activeStudent
     * @param elementIndex
     * @param score
     */
    this.storeElementScore = function ( activeStudent, elementIndex, score ) {
        this.elementScores[ activeStudent ][ elementIndex ] = score;
    };

    /**
     * Retrieves element score for a student
     * Original: data.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getElementScore = function ( activeStudent, elementIndex ) {
        return this.elementScores[ activeStudent ][ elementIndex ];
    };

    /* ------------------ Comments  ------------ */
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
    this.storeCommentText = function ( activeStudent, elementIndex, commentText ) {
        this.elementComments[ activeStudent ][ elementIndex ] = commentText;
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
    this.getCommentText = function ( activeStudent, elementIndex, valence ) {
        var comment = this.elementComments[ activeStudent ][ elementIndex ];
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


    /* ------------------ Question scores and Exam grades ------------ */
    /**
     * Loads a json object of question scores.
     * @param studentQuestionScores
     */
    this.loadQuestionScores = function ( studentQuestionScores ) {
        questionScores = studentQuestionScores;
    };

    /**
     * Saves a question score for the student
     * Original: data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param activeStudent
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    this.storeQuestionScore = function ( activeStudent, questionIndex, score ) {
        questionScores[ activeStudent ][ questionIndex ] = score;
    };

    /**
     * Returns student score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    this.getQuestionScore = function ( activeStudent, questionIndex ) {
        return questionScores[ activeStudent ][ questionIndex ];
    };

    /**
     * Convenience function for getting the current student's score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    this.getQuestionScoreForActiveStudent = function ( questionIndex ) {
        if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
        return this.getQuestionScore( this.activeStudent, questionIndex );
    };

    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     **/
    this.updateExamGrade = function ( activeStudent ) {
        var totalScore = null;
        // try {
        // this.checkValid( 'questionScores' );
        if ( Object.keys( questionScores ).length > 0 ) {
            for ( var i = 0; i < Object.keys( questionScores[ activeStudent ] ).length; i ++ ) {
                var v = questionScores[ activeStudent ][ i ];
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
                this.examGrades[ activeStudent ] = totalScore.toPrecision( 3 );
            } else {
                //replace 'letter grade' with -1
                this.examGrades[ activeStudent ] = - 1;
            }
        }
        // } catch ( err ) {
        //     window.console.log( err );
        // }
    };


//   Previous version:
//
//     for ( var i = 0; i < data.questionScores.length; i ++ ) {
//         var totalScore = null;
//         data.questionScores[ i ].forEach( function ( gradeEntry ) {
//             if ( gradeEntry !== null && gradeEntry >= 0 ) {
//                 if ( totalScore === null ) {
//                     totalScore = 0;
//                 }
//                 totalScore += parseFloat( gradeEntry );
//             }
//             *    } );
//     *     if ( totalScore != null ) {
//         *          data.examGrades[ i ] = totalScore.toPrecision( 3 );
//         *       }
//     *        else {
//         *             data.examGrades[ i ] = - 1;
//         *          }


    /**
     * Saves the trouble of other methods having to figure out whether a student
     * is set as active student (which can run into trouble if, for example, the
     * active student has index 0 and the consuming method interprets this as false).
     */
    this.isActive = function () {
        if ( typeof this.activeStudent == 'undefined' ) return false;
        if ( this.activeStudent === null ) return false;
        if ( this.activeStudent >= 0 ) {
            return true;
        }
        return false;
    };

    /**
     * Returns true if at least one question has received
     * a score for the student.
     */
    this.isGraded = function ( activeStudent ) {
        this.updateExamGrade( activeStudent )
        if ( this.examGrades[ activeStudent ] != "Letter grade" && this.examGrades[ activeStudent ] >= 0 ) {
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
        // try {
        //     this.checkValid( 'examGrades' );

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
        // } catch ( err ) {
        //     window.console.log( err );
        // }finally{
        return graded;
        // }

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
        if ( Object.keys( this.examGrades ).length > 0 ) {
            this.getTotalExams.total = Object.keys( this.examGrades ).length;
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
};
//# sourceMappingURL=grade-exam-data.js.map
