/**
 * Created by adam on 5/19/16.
 */


/**
 * TODO Rename this or the instance as store so will be easier to use with vue data
 * Main data storage object for grading page
 * @constructor
 */
function Data() {
    this.activeStudent = null,
        
    this.elementScores = null,
    this.elementComments = null,

    /**
     * examGrades[] keeps a persistent total of the exam score for each student.
     * Exams without grades have a value of -1, because dealing with null and NaN
     * is unpredictable across js and PHP.
     * This shouldn't be an issue, as the DB has no notion of exam grades, they're
     * only used here as a shorthand to store and quickly find information about
     * the exam state.
     */
    this.examGrades = null,

    this.examGradingTimes = null,
    this.numQuestions = null,
    this.questionScores = null,
    this.stockComments = null,

    this.valences = [ 0, 1, 2, 3 ],

    /**
     * 
     */
    this.loadStockComments = function ( stockComments ) {
        this.stockComments = stockComments;
    }

    this.loadElementComments = function ( studentElementComments ) {
        this.elementComments = studentElementComments;
    }
    this.loadElementScores = function ( studentElementScores ) {
        this.elementScores = studentElementScores;
    }
    this.loadExamGrades = function ( studentGrades ) {
        this.examGrades = studentGrades;
    }

    this.loadNumberQuestions = function ( numberQuestions ) {
        this.numQuestions = numberQuestions;
    }

    this.loadQuestionScores = function ( studentQuestionScores ) {
        this.questionScores = studentQuestionScores;
    }

    /**
     * Sets the grading time data from the server
     * @param examGradingTimes JSON object
     */
    this.loadGradingTimes = function ( examGradingTimes ) {
        this.examGradingTimes = examGradingTimes;
    }


    /**
     * Stores a student's score on a particular element
     * @param activeStudent
     * @param elementIndex
     * @param score
     */
    this.storeElementScore = function ( activeStudent, elementIndex, score ) {
        this.elementScores[ activeStudent ][ elementIndex ] = score;
    }

    /**
     * Retrieves element score for a student
     * Original: data.elementScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param elementIndex
     * @returns {*}
     */
    this.getElementScore = function ( activeStudent, elementIndex ) {
        return this.elementScores[ activeStudent ][ elementIndex ];
    }


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
    }


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
            return this.stockComments[ elementIndex ][ valence ];
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
    }


    /**
     * Saves a question score for the student
     * Original: data.questionScores[ Roster.activeStudent ][ qNumber - 1 ] = score;
     * @param activeStudent
     * @param questionIndex 0-based index of the question (i.e., questionNumber - 1
     * @param score
     */
    this.storeQuestionScore = function ( activeStudent, questionIndex, score ) {
        this.questionScores[ activeStudent ][ questionIndex ] = score;

    }

    /**
     * Returns student score for question
     * Old way: data.questionScores[ Roster.activeStudent ][ index ];
     * @param activeStudent
     * @param questionIndex
     */
    this.getQuestionScore = function ( activeStudent, questionIndex ) {
        return this.questionScores[ activeStudent ][ questionIndex ];
    }


    /**
     * Stores a new time for the student.
     * Overwrites any existing value.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.storeStudentGradingTime = function ( activeStudent, activeStudentTime ) {
        this.examGradingTimes[ activeStudent ] = activeStudentTime;
    }

    /**
     * Increases the stored time for a student by the specified
     * amount.
     * Original: data.examGradingTimes[ Roster.activeStudent ];
     */
    this.increaseStudentGradingTime = function ( activeStudent, timeToAdd ) {
        this.examGradingTimes[ activeStudent ] += timeToAdd;
    }


    /**
     * Original: data.examGradingTimes[ Roster.activeStudent ]
     * @param activeStudent
     * @returns {*}
     */
    this.getStudentGradingTime = function ( activeStudent ) {
        return this.examGradingTimes[ activeStudent ];
    }


    /**
     * Updates the stored total exam score for the student
     * The first time it runs, it will set the total score to 0
     * if no questions have been graded.
     *
     * Previous version:
     *
     *
     for ( var i = 0; i < data.questionScores.length; i ++ ) {
                    var totalScore = null;
                    data.questionScores[ i ].forEach( function ( gradeEntry ) {
                        if ( gradeEntry !== null && gradeEntry >= 0 ) {
                            if ( totalScore === null ) {
                                totalScore = 0;
                            }
                            totalScore += parseFloat( gradeEntry );
                        }
                    } );
                    if ( totalScore != null ) {
                        data.examGrades[ i ] = totalScore.toPrecision( 3 );
                    }
                    else {
                        data.examGrades[ i ] = - 1;
                    }
                     */
    this.updateExamGrade = function ( activeStudent ) {
        var totalScore = null;
        for ( var i = 0; i < Object.keys( this.questionScores[ activeStudent ] ).length; i ++ ) {
            var v = this.questionScores[ activeStudent ][ i ];
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
            this.examGrades[ activeStudent ] = totalScore.toPrecision( 3 );
        } else {
            this.examGrades[ activeStudent ] = - 1;
        }
    }


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
    }


    /**
     * Returns the number of exams that have been graded
     */
    this.getNumberGraded = function () {
        var graded = 0;
        if ( typeof this.examGrades != 'undefined' ) {
            for ( var i = 0; i < Object.keys( this.examGrades ).length; i ++ ) {
                this.updateExamGrade( i );
                //this will be the string 'letter grade' if
                //no grade has been entered. Thus we check
                //whether it is a number 0 or greater
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
    this.getTotalExams = function () {
        if ( typeof this.examGrades == 'undefined' ) {
            var total = 0;
        } else {
            var total = Object.keys( this.examGrades ).length;
        }

        return total;
    }

}