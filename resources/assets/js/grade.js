/**
 * Created by adam on 8/14/15.
 */

var Vue = require('vue');

//require('./filters/convertSecondsToDisplay.js')

//TODO Eventually all this filter stuff should be moved to another file and included here via browserify
Vue.filter('convertTime', function (seconds) {
    var formatter = new Formatter();
    var seconds = Number(seconds);
    var result = formatter.timeFormat(seconds);
    //window.console.log(result);
    return result;
});
/**
 * This object handles all formatting tasks
 * @returns {Formatter}
 */
function Formatter() {
}
;

/**
 * Converts seconds to minutes for display
 * @param {Number} elapsedTime The time to be converted in seconds
 * @returns {Number}
 * @testExists True
 */
Formatter.prototype.secondsToMinutes = function (elapsedTime) {
    var displayTime = '';
    if (elapsedTime === 0) {
        displayTime = 0;
    }
    else if (elapsedTime < 60) {
        var s = new Number(elapsedTime);
        displayTime = s.toPrecision(3);
    }
    else if (elapsedTime >= 60) {
        var m = new Number(elapsedTime / 60);
        displayTime = m.toPrecision(3);
    }
    return displayTime;
};
/**
 * Converts seconds to hours
 * @param {Number} seconds
 * @returns {Number}
 * @testExists True
 */
Formatter.prototype.secondsToHours = function (seconds) {
    var h = new Number((seconds / 60) / 60);
    var hr = h.toPrecision(3);
    return hr;
};

/**
 * This checks the elapsed time and returns either Sec or Min to indicate the appropriate display unit
 * @param {type} elapsedTime
 * @returns {string}
 * @testExists True
 */
Formatter.prototype.unitChooser = function (elapsedTime) {
    var unit = '';
    if (elapsedTime < 60) {
        unit = 'Sec';
    }
    else if (elapsedTime >= 60) {
        unit = 'Min';
    }
    return unit;
};
/**
 * Utility function to calculate the time elapsed (in seconds) between two Date objects
 * @param {Date} stopTime
 * @param {Date} startTime
 * @returns {Number}
 * @testExists False
 */
Formatter.prototype.calculateElapsedTime = function (stopTime, startTime) {
    var elapsed = Math.round((stopTime - startTime) / 1000); //in seconds
    return elapsed;
};


/**
 * Converts seconds into a string with format hour:min
 * @param {type} seconds
 * @returns {String}
 * @testExists True
 */
Formatter.prototype.timeFormat = function (seconds) {
    var hr = this.secondsToHours(seconds);
    var hour = Math.floor(hr);
    var min = Math.round(60 * (hr - hour));
    var hh = this.addLeadingZero(hour);
    var mm = this.addLeadingZero(min);
    return hh + ':' + mm;
};//minorhr

/**
 * Adds a 0 to the front of a value less than 10 (used by stats)
 * @param {type} val
 * @returns {addLeadingZero.vv}
 * @testExists True
 */
Formatter.prototype.addLeadingZero = function (val) {
    if (val < 10) {
        var vv = String(0) + String(val);
        return vv;
    }
    else {
        return val;
    }
};//addleadingzero

/**
 * Element score assignment slider
 */
Vue.component('element-slider', {
    template: require('./components/grade/elementSliderTemplate.html'),

    props: ['elementName', 'elementScore', 'elementAssignmentId'],

    data: function () {
        return {
            elementAssignmentId: this.elementAssignmentId,
            elementName: this.elementName,
            elementScore: this.elementScore
        }
    }
});

Vue.component('question-score', {
    template: require('./components/grade/questionScoreTemplate.html'),

    props: ['questionNumber', 'questionScore', 'questionAssignmentId'],

    data: function () {
        return {
            questionAssignmentId: this.questionAssignmentId,
            questionNumber: this.questionNumber,
            questionScore: this.questionScore
        }
    }
});

/**
 * Populates the table of statistics on grading times
 */
Vue.component('statistics-table', {
    template: require('./components/grade/statisticsTemplate.html'),

    props: ['currentExam', 'averageExam', 'totalElapsed', 'totalRemaining'],

    data: function () {
        return {
            currentExam: this.currentExam,
            averageExam: this.averageExam,
            totalElapsed: this.totalElapsed,
            totalRemaining: this.totalRemaining
            //currentExam: this.convertTime(this.currentExam),
            //averageExam: this.convertTime(this.averageExam),
            //totalElapsed: this.convertTime(this.totalElapsed),
            //totalRemaining: this.convertTime(this.totalRemaining)
        }
    },

    //methods: {
    //    convertTime: require('./filters/convertSecondsToDisplay.js')
    //}
});

/**
 * Bar which shows the number of exams which have been graded
 * and how many are left to grade.
 */
Vue.component('graded-remaining', {
    template: require('./components/grade/numberGradedAndRemainingTemplate.html'),

    props: ['numberExamsGraded', 'numberExamsRemaining'],

    data: function () {
        return {
            numberExamsGraded: this.numberExamsGraded,
            numberExamsRemaining: this.numberExamsRemaining
        }
    }
});


Vue.component('current-student', {
    template: require('./components/grade/currentStudentTemplate.html'),

    props: ['currentStudentId', 'currentStudentIdentifier', 'currentStudentFirstName', 'currentStudentLastName'],

    data: function () {
        this.name = this.currentStudentLastName + ', ' + this.currentStudentFirstName;
      //  parent.setCurrentStudent(this.currentStudentId, this.currentStudentIdentifier, this.name);
        return {
            studentId: this.currentStudentId,
            currentStudentIdentifier: this.currentStudentIdentifier,
            currentStudentName: this.name,
        }

    },

    ready: function () {

    }


});

/**
 * Root vue instance. Bound to app
 */
new Vue({
    el: '#grade-app',

    data: {
        currentQuestion: false,
        //currentStudentName: false,
        //currentStudentIdentifier: false,
        //currentStudentId: false
    },

    methods: {
        setCurrentStudent: function (studentId, studentIdentifier, studentName) {
            this.$set('currentStudentId', studentId);
            this.$set('currentStudentIdentifier', studentIdentifier);
            this.$set('currentStudentName', studentName);

        },

        selectStudentToGrade: function (studentId) {
            window.console.log(studentId);
            $.post('/studentId', {}, function () {
            });
        }
    }
});