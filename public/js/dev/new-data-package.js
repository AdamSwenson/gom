(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }(); /**
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      * Created by adam on 5/19/16.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      */

var _Student = require('./Student');

var _Student2 = _interopRequireDefault(_Student);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Main data storage object for grading page
 */

var Store = function () {
    function Store() {
        _classCallCheck(this, Store);

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
        this.valences = [0, 1, 2, 3];
        /* ----------------------------- Objects/ arrays ------------------------ */
    }

    /* -------------------------------- Initialization ------------------------ */

    _createClass(Store, [{
        key: 'loadElementComments',
        value: function loadElementComments(elementCommentsJSON) {
            this.elementComments = elementCommentsJSON;
        }
    }, {
        key: 'loadElementScores',
        value: function loadElementScores(studentElementScores) {
            this.elementScores = studentElementScores;
        }
    }, {
        key: 'loadExamGrades',
        value: function loadExamGrades(studentGrades) {
            this.examGrades = studentGrades;
        }

        /**
         * Sets the standard grades
         * @param gradesJson
         */

    }, {
        key: 'loadGrade',
        value: function loadGrade(gradesJson) {
            if (typeof gradesJson == 'string') {
                gradesJson = JSON.parse(gradesJson);
            }
            this.grades = gradesJson;
        }

        /**
         * Sets the grading time data from the server
         * @param this.examGradingTimes JSON object
         */

    }, {
        key: 'loadGradingTimes',
        value: function loadGradingTimes(examGradingTimesJSON) {
            this.examGradingTimes = examGradingTimesJSON;
        }

        /**
         * Initially loads a json of max scores into the object
         * Format: { questionIndex: maxScore, ....}
         * @param maxScores
         */

    }, {
        key: 'loadMaxQuestionScores',
        value: function loadMaxQuestionScores(maxScores) {
            this.maxQuestionScores = maxScores;
        }
    }, {
        key: 'loadNumberQuestions',
        value: function loadNumberQuestions(numberQuestionsOnExam) {
            this.numberQuestions = numberQuestionsOnExam;
        }

        /**
         * Loads a json object of questions.
         * @param .questionsJSON
         */

    }, {
        key: 'loadQuestions',
        value: function loadQuestions(questionsJSON) {
            this.questions = questionsJSON;
        }

        /**
         * Loads a json object of question scores.
         * @param .questionScoresJSON
         */

    }, {
        key: 'loadQuestionScores',
        value: function loadQuestionScores(questionScoresJSON) {
            this.questionScores = questionScoresJSON;
        }

        /**
         * Takes a json from the server of the stock comments and stores it internally.
         */

    }, {
        key: 'loadStockComments',
        value: function loadStockComments(stockCommentsJSON) {
            this.stockComments = stockCommentsJSON;
        }
    }, {
        key: 'loadStudents',
        value: function loadStudents(studentJson) {
            for (var i = 0; i < Object.keys(studentJson).length; i++) {
                var s = studentJson[Object.keys(studentJson)[i]];
                this.students[s.studentId] = _Student2.default.factory(s);
            }
            //        this.students = studentJson;
        }

        /* ------------------ Active student ------------------- */

    }, {
        key: 'setActiveStudent',
        value: function setActiveStudent(studentIndex, studentId) {
            this.activeStudentIndex = studentIndex;
            if (typeof studentId == 'undefined') {
                var student = this.students[studentIndex];
                studentId = student.studentId;
            }
            this.activeStudentId = studentId;
        }
    }, {
        key: 'getActiveStudentId',
        value: function getActiveStudentId() {
            return this.activeStudentId;
        }
    }, {
        key: 'getActiveStudentIndex',
        value: function getActiveStudentIndex() {
            return this.activeStudentIndex;
        }
    }, {
        key: 'getActiveStudent',
        value: function getActiveStudent() {
            return this.getStudent(this.activeStudentIndex());
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

    }, {
        key: 'storeCommentText',
        value: function storeCommentText(studentIndex, elementIndex, commentText) {
            this.elementComments[studentIndex][elementIndex] = commentText;
        }
    }, {
        key: 'storeCommentTextForActiveStudent',
        value: function storeCommentTextForActiveStudent(elementIndex, commentText) {
            this.elementComments[this.activeStudentIndex][elementIndex] = commentText;
        }

        /**
         * Retrieve comment right for a student.
         * If no customized right is set, then return stockComment.
         *
         * Original: data.this.elementComments[ Roster.activeStudent ][ index ];
         * @param activeStudent
         * @param elementIndex
         * @returns {*}
         */

    }, {
        key: 'getCommentText',
        value: function getCommentText(studentIndex, elementIndex, valence) {
            var comment = this.elementComments[studentIndex][elementIndex];
            if (comment == "") {
                return this.stockComments[elementIndex][valence];
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
            while (isCustom && i <= this.valences.length) {
                var stock = this.stockComments[elementIndex][i];
                if (stock == comment) {
                    isCustom = false;
                }
                i++;
            }
            //If it turns out that the previous comment was stock, then return the
            //new stock comment corresponding to the valence
            if (!isCustom) {
                return this.stockComments[elementIndex][valence];
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
         */

    }, {
        key: 'getStoredCommentText',
        value: function getStoredCommentText(studentIndex, elementIndex) {
            return this.elementComments[studentIndex][elementIndex];
        }
    }, {
        key: 'getCommentTextForActiveStudent',
        value: function getCommentTextForActiveStudent(elementIndex, valence) {
            if (this.activeStudentIndex == null) return '';
            return this.getCommentText(this.activeStudentIndex, elementIndex, valence);
        }

        /* ------------------ Exam grades ------------ */

    }, {
        key: 'getExamGrade',
        value: function getExamGrade(studentIndex) {
            return this.examGrades[studentIndex];
        }
    }, {
        key: 'getExamGradeForActiveStudent',
        value: function getExamGradeForActiveStudent() {
            if (this.activeStudentIndex == null) return '';
            return this.examGrades[this.activeStudent];
        }

        /* ------------------ Getters and setters for other simple properties ------------------- */

    }, {
        key: 'getExamId',
        value: function getExamId() {
            return this.examId;
        }
    }, {
        key: 'setExamId',
        value: function setExamId(examIdToSet) {
            this.examId = examIdToSet;
        }

        /* ------------------ Grades ------------------- */

        /**
         * Returns the standard grades json.
         * NB, this is not the total scores for students
         * @returns {{}}
         */

    }, {
        key: 'getGrade',
        value: function getGrade() {
            return this.grades;
        }

        /* ------------------ Grading time ------------------- */

        /**
         * Returns the total amount of time spent grading in seconds
         * @returns {number}
         */

    }, {
        key: 'getTotalGradingTime',
        value: function getTotalGradingTime() {
            var totalTime = 0;
            for (var i = 0; i < Object.keys(this.examGradingTimes).length; i++) {
                totalTime += this.examGradingTimes[i];
            }
            return totalTime;
        }

        /**
         * Original: data.this.examGradingTimes[ Roster.activeStudent ]
         * @param studentIndex
         * @returns {*}
         */

    }, {
        key: 'getStudentGradingTime',
        value: function getStudentGradingTime(studentIndex) {
            return this.examGradingTimes[studentIndex];
        }

        /**
         * Convenience method for getting the grading time of the student presently
         * being graded
         * @returns {*}
         */

    }, {
        key: 'getActiveStudentGradingTime',
        value: function getActiveStudentGradingTime() {
            // if ( ! this.isActive() ) throw "ERROR: getActiveStudentGradingTime | No active student set ";
            if (this.activeStudentIndex == null) return '';

            return this.getStudentGradingTime(this.activeStudentIndex);
        }

        /**
         * Retrieves element score for a student
         * Original: data.this.elementScores[ Roster.activeStudent ][ index ];
         * @param activeStudent
         * @param elementIndex
         * @returns {*}
         */

    }, {
        key: 'getElementScore',
        value: function getElementScore(studentIndex, elementIndex) {
            return this.elementScores[studentIndex][elementIndex];
        }
    }, {
        key: 'getElementScoreForActiveStudent',
        value: function getElementScoreForActiveStudent(elementIndex) {
            if (this.activeStudentIndex == null) return '';
            return this.elementScores[this.activeStudentIndex][elementIndex];
        }

        /* ------------------ Max question scores ------------ */
        /**
         * Returns a question object.
         * This has keys: questionName, questionNumber, questionAssignmentId, maxScore
         * @param questionIndex
         * @returns {*}
         */

    }, {
        key: 'getQuestion',
        value: function getQuestion(questionIndex) {
            return this.questions[questionIndex];
        }

        /* ------------------ Question scores  ------------ */

        /**
         * Returns student score for question
         * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
         * @param studentIndex
         * @param questionIndex
         */

    }, {
        key: 'getQuestionScore',
        value: function getQuestionScore(studentIndex, questionIndex) {
            return this.questionScores[studentIndex][questionIndex];
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

    }, {
        key: 'getStudents',
        value: function getStudents() {
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

    }, {
        key: 'getStudent',
        value: function getStudent(studentIndex) {
            return this.students[studentIndex];
        }

        /**
         * Convenience function for getting the current student's score for question
         * Old way: data.this.questionScores[ Roster.activeStudent ][ index ];
         * @param activeStudent
         * @param questionIndex
         */

    }, {
        key: 'getQuestionScoreForActiveStudent',
        value: function getQuestionScoreForActiveStudent(questionIndex) {
            // if ( ! this.isActive() ) throw "ERROR: getQuestionScoreForActiveStudent | No active student set ";
            if (this.activeStudentIndex == null) return '';
            return this.getQuestionScore(this.activeStudentIndex, questionIndex);
        }

        /**
         * Returns the maximum possible score for a given question
         * @param questionIndex
         * @returns {*}
         */

    }, {
        key: 'getMaxQuestionScore',
        value: function getMaxQuestionScore(questionIndex) {
            return this.maxQuestionScores[questionIndex];
        }

        /**
         * Stores a new time for the student.
         * Overwrites any existing value.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */

    }, {
        key: 'storeStudentGradingTime',
        value: function storeStudentGradingTime(studentIndex, activeStudentTime) {
            this.examGradingTimes[studentIndex] = activeStudentTime;
        }

        /**
         * Stores a student's score on a particular element
         * @param studentIndex
         * @param elementIndex
         * @param score
         */

    }, {
        key: 'storeElementScore',
        value: function storeElementScore(studentIndex, elementIndex, score) {
            this.elementScores[studentIndex][elementIndex] = score;
        }

        /**
         * Mostly used for testing
         * @param studentIndex
         * @private
         */

    }, {
        key: '_setExamGrade',
        value: function _setExamGrade(studentIndex, score) {
            this.examGrades[studentIndex];
        }

        /**
         * Updates the stored total exam score for the student
         * The first time it runs, it will set the total score to 0
         * if no questions have been graded.
         **/

    }, {
        key: 'updateExamGrade',
        value: function updateExamGrade(studentIndex) {
            var totalScore = null;
            // try {
            // this.checkValid( 'this.questionScores' );
            if (Object.keys(this.questionScores).length > 0) {
                for (var i = 0; i < Object.keys(this.questionScores[studentIndex]).length; i++) {
                    var v = this.questionScores[studentIndex][i];
                    if (v != null) {
                        //at least one question score is non-null
                        //so the total score should be at least 0
                        //first we check whether the totalScore is still null
                        //and set it to 0 if not
                        if (totalScore === null) {
                            totalScore = 0;
                        }
                        //now we can add the question values to it
                        totalScore += parseFloat(v);
                    }
                }
                if (totalScore != null && totalScore >= 0) {
                    //push the total score into exam grades as a string
                    this.examGrades[studentIndex] = totalScore.toPrecision(3);
                } else {
                    //replace 'letter grade' with -1
                    this.examGrades[studentIndex] = -1;
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

    }, {
        key: 'storeQuestionScore',
        value: function storeQuestionScore(studentIndex, questionIndex, score) {
            this.questionScores[studentIndex][questionIndex] = score;
        }
    }, {
        key: 'storeQuestionScoreForActiveStudent',
        value: function storeQuestionScoreForActiveStudent(questionIndex, score) {
            // window.console.log( 'store called', this.activeStudentIndex, questionIndex, score );
            this.questionScores[this.activeStudentIndex][questionIndex] = score;
        }
    }, {
        key: 'storeElementScoreForActiveStudent',
        value: function storeElementScoreForActiveStudent(elementIndex, score) {
            this.storeElementScore(this.activeStudentIndex, elementIndex, score);
        }

        /**
         * Increases the stored time for a student by the specified
         * amount.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */

    }, {
        key: 'increaseStudentGradingTime',
        value: function increaseStudentGradingTime(studentIndex, timeToAdd) {
            this.examGradingTimes[studentIndex] += timeToAdd;
        }

        /**
         * Increases the stored time for the student currently being graded by the specified
         * amount.
         * Original: data.this.examGradingTimes[ Roster.activeStudent ];
         */

    }, {
        key: 'increaseActiveStudentGradingTime',
        value: function increaseActiveStudentGradingTime(timeToAdd) {
            this.examGradingTimes[this.activeStudentIndex] += timeToAdd;
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

    }, {
        key: 'isActive',
        value: function isActive() {
            if (typeof this.activeStudentIndex == 'undefined') return false;
            if (this.activeStudentIndex === null) return false;
            if (this.activeStudentIndex >= 0) {
                return true;
            }
            return false;
        }

        /**
         * Returns true if at least one question has received
         * a score for the student.
         */

    }, {
        key: 'isGraded',
        value: function isGraded(studentIndex) {
            this.updateExamGrade(studentIndex);
            if (this.examGrades[studentIndex] != "Letter grade" && this.examGrades[studentIndex] >= 0) {
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

    }, {
        key: 'getNumberGraded',
        value: function getNumberGraded() {
            var graded = 0;

            if (Object.keys(this.examGrades).length > 0) {
                //Loop through each exam (via studentIndex as key)
                for (var i = 0; i < Object.keys(this.examGrades).length; i++) {
                    //Make sure the stored exam total score is up to date
                    this.updateExamGrade(i);
                    //this will be the string 'letter grade' if
                    //no grade has been entered. Thus we check
                    //whether it is a number 0 or greater
                    //if it is graded, increment the number graded
                    if (this.examGrades[i] >= 0) graded++;
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

    }, {
        key: 'getTotalExams',
        value: function getTotalExams() {
            //memoize
            // if(this.getTotalExams.total && this.getTotalExams.total >= 0) return this.getTotalExams.total;

            //initialize
            var total = 0;
            if (Object.keys(this.examGrades).length > 0) {
                total = Object.keys(this.examGrades).length;
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

    }, {
        key: 'checkValid',
        value: function checkValid(propertyName) {
            if (typeof this[propertyName] != 'undefined') {
                throw propertyName + " is undefined";
            }
            if (this[propertyName] == null) {
                throw propertyName + " is null";
            }
            if (this[propertyName] == {}) {
                throw propertyName + " was empty. Probably because it wasn't initialized";
            }

            return true;
        }
    }], [{
        key: 'init',
        value: function init() {

            if (typeof window.GOM != 'undefined') {
                var GOM = window.GOM;
                GOM.store = new Store();
                // store.setExamId({!! $exam->id !!});
                GOM.store.loadStockComments(GOM.stockComments);
                GOM.store.loadElementComments(GOM.studentElementComments);
                GOM.store.loadElementScores(GOM.studentElementScores);
                GOM.store.loadQuestionScores(GOM.studentQuestionScores);
                GOM.store.loadGradingTimes(GOM.examGradingTimes);
                GOM.store.loadExamGrades(GOM.studentGrades);
                GOM.store.loadNumberQuestions(GOM.numQuestions);
                GOM.store.loadMaxQuestionScores(GOM.maxScores);
                GOM.store.loadStudents(GOM.students);
                GOM.store.loadQuestions(GOM.questions);
                GOM.store.loadGrade(GOM.grades);
            }
        }
    }]);

    return Store;
}();

exports.default = Store;


if (typeof window.GOM != 'undefined') {
    var GOM = window.GOM;
    GOM.store = new Store();
    // store.setExamId({!! $exam->id !!});
    GOM.store.loadStockComments(GOM.stockComments);
    GOM.store.loadElementComments(GOM.studentElementComments);
    GOM.store.loadElementScores(GOM.studentElementScores);
    GOM.store.loadQuestionScores(GOM.studentQuestionScores);
    GOM.store.loadGradingTimes(GOM.examGradingTimes);
    GOM.store.loadExamGrades(GOM.studentGrades);
    GOM.store.loadNumberQuestions(GOM.numQuestions);
    GOM.store.loadMaxQuestionScores(GOM.maxScores);
    GOM.store.loadStudents(GOM.students);
    GOM.store.loadQuestions(GOM.questions);
    GOM.store.loadGrade(GOM.grades);
}

},{"./Student":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

/**
 * Created by adam on 8/15/16.
 */

var Student = function () {
    function Student(studentId) {
        _classCallCheck(this, Student);

        this._email = '';
        this._id = studentId;
        this._index = null;
        this._studentIdentifier = null;
        this._lastName = '';
        this._firstName = '';
    }

    _createClass(Student, [{
        key: 'email',
        get: function get() {
            return this._email;
        },
        set: function set(address) {
            this._email = address;
        }
    }, {
        key: 'firstName',
        get: function get() {
            return this._firstName;
        },
        set: function set(val) {
            this._firstName = val;
        }

        /** Alias for database identifier, i.e., studentId */

    }, {
        key: 'id',
        get: function get() {
            return this.studentId;
        }
    }, {
        key: 'lastName',
        get: function get() {
            return this._lastName;
        },
        set: function set(val) {
            this._lastName = val;
        }

        /**
         * Returns the identifier set by the user.
         * This is not the database id of the student
         * */

    }, {
        key: 'studentIdentifier',
        get: function get() {
            return this._studentIdentifier;
        },
        set: function set(val) {
            this._studentIdentifier = val;
        }
    }, {
        key: 'studentId',
        get: function get() {
            return Number(this._id);
        },
        set: function set(val) {
            this._id = val;
        }
    }, {
        key: 'studentIndex',
        get: function get() {
            return Number(this._index);
        },
        set: function set(val) {
            this._index = val;
        }

        /**
         * Takes the json student object received from the server and
         * returns a Student object
         * @param studentJson
         * @returns {Student}
         */

    }], [{
        key: 'factory',
        value: function factory(studentJson) {
            if (!studentJson || !studentJson.studentId) throw new Error("studentJson had no id");

            var student = new Student(studentJson.studentId);
            // window.console.log( 'factory', student, studentJson.studentId );
            student.firstName = studentJson.firstName;
            student.lastName = studentJson.lastName;
            student.studentIndex = studentJson.studentIndex;
            student.studentIdentifier = studentJson.studentIdentifier;
            // for ( let i = 0; i < Object.keys( student ).length; i ++ ) {
            //     let key = Object.keys( student )[ i ];
            //     student[ key ] = studentJson[ key ];
            // }
            return student;
        }
    }]);

    return Student;
}();

exports.default = Student;

},{}]},{},[1]);

//# sourceMappingURL=new-data-package.js.map
