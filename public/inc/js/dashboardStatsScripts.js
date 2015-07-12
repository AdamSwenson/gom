/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */
/**
 * Refactored stats objects
 * 
 * The refactored version has one object which gets, holds, and formats all the stats data. All stats display objects use the data object.
 * 
 * Usage:
 * //first initialize the objects
 * var statsData = new StatsData();
 * 
 * //Set formatting handler object
 * statsData.setFormatter(new Formatter());
 * 
 * //Load whatever display managers are needed for the charts
 * statsData.addDisplayManager(new MakeCompletionStatsGauge());
 * statsData.addDisplayManager(new DisplayOverallStats());
 * statsData.addDisplayManager(new MakeSpeedTrendChart());
 * 
 * //Finally, make the ajax call for server data. This will call the chart makers when the data is returned
 * statsData.loadAllStats(DASHPHP);
 * 
 */
/*****************************************************DASHBOARD ***********************************************************/

/************************************************************* STATISTICS SCRIPTS ***************************/

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
    var hr = secondsToHours(seconds);
    var hour = Math.floor(hr);
    var min = Math.round(60 * (hr - hour));
    var hh = addLeadingZero(hour);
    var mm = addLeadingZero(min);
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

//--------------------------------------------------------- StatsData
/**
 * The statistics data object. 
 * 
 * This handles getting the data from the server and formatting it for other stats objects to use
 * @property {Array} displayManagers Array holding objects which handle displaying of stats data, called when ajax completes
 * @returns {undefined}
 */
function StatsData() {
    this.displayManagers = new Array();
    this.ppmData = new Array();
    this.numGraded = '';
    this.examsUngraded = '';
    this.gradedExams = '';
    this.pctComplete = '';
    this.totalElapsedGrading = '';
    this.totalEstimatedGrading = '';
    this.avgExam = '';
    this.avgPPM = '';
    this.remainingEstimatedGrading = '';
}

/**
 * This adds an object which handles displaying stats to a queue which is called
 * once the data has been loaded
 * @param {StatsDisplay} StatsDisplay
 * @returns {undefined}
 */
StatsData.prototype.addDisplayManager = function (StatsDisplay) {
    this.displayManagers.push(StatsDisplay);
};

/**
 * Loads the formatting handler
 * @param {Formatter} Formatter
 * @returns {undefined}
 */
StatsData.prototype.setFormatter = function (Formatter) {
    this.formatter = Formatter;
};

/**
 * Calls each display manager in turn 
 * @returns {undefined}
 */
StatsData.prototype.callDisplayManagers = function () {
    if (this.displayManagers.length > 0) {
        var me = this;
        $.each(this.displayManagers, function () {
            this.draw(me);
        });
    }
};

/**
 * Makes ajax call to server for statistics then calls display managers
 * 
 * @param {type} processor_address Usually DASHPHP
 * @returns {undefined}
 */
StatsData.prototype.loadAllStats = function (processor_address) {
    var me = this;
    var $jxqr = $.post(processor_address, {'requestType': 'stats', 'task': 'getAllStats'}, function (json) {
        me.processIncoming(json);
        me.callDisplayManagers();
    }, "JSON");

};

/**
 * Controller for handling various json key values
 * @param {type} json
 * @returns {undefined}
 */
StatsData.prototype.processIncoming = function (json) {
    var me = this;
    try {
        $.each(json.data, function (k, v) {
            switch (k) {
                case 'AveragePPM':
                    me.receiveAveragePPM(v);
                    break;
                case "avgExam":
                    me.receiveAverageExam(v);
                    break;
                case "gradeRemaining":
                    me.receiveGradeRemaining(v);
                    break;
                case "gradeElapsed":
                    me.receiveGradeElapsed(v);
                    break;
                case "workElapsed":
                    me.receiveWorkElapsed(v);
                    break;
                case "workRemaining":
                    me.receiveWorkRemaining(v);
                    break;
                case "pctComplete":
                    me.receivePctComplete(v);
                    break;
                case "examsGraded":
                    me.receiveExamsGraded(v);
                    break;
                case "examsUngraded":
                    me.receiveUngraded(v);
                    break;
                case "ppm":
                    me.receivePPMData(v);
                    break
            }
        });
    }
    catch (e) {
        window.console.log("StatsData.processIncoming()", e);
    }
    ;
    try {
        me.calcPctGrading(json.data.gradeElapsed, json.data.workElapsed);
    } catch (err) {
        window.console.log("StatsData.processIncoming() calcPctGrading", err);
    }
    ;
};

StatsData.prototype.receiveAveragePPM = function (averagePPM) {
    this.avgPPM = averagePPM;
};

StatsData.prototype.receiveAverageExam = function (avgExam) {
    this.avgExam = this.formatter.secondsToMinutes(avgExam);
};

StatsData.prototype.receiveGradeRemaining = function (gradeRemaining) {
    this.gradeRemaining = this.formatter.timeFormat(gradeRemaining);
};

StatsData.prototype.receiveGradeElapsed = function (gradeElapsed) {
    this.gradeElapsed = this.formatter.timeFormat(gradeElapsed);
};

StatsData.prototype.receiveWorkRemaining = function (workRemaining) {
    this.workRemaining = this.formatter.timeFormat(workRemaining);
};

StatsData.prototype.receiveWorkElapsed = function (workElapsed) {
    this.workElapsed = this.formatter.timeFormat(workElapsed);
};

StatsData.prototype.calcPctGrading = function (gradeElapsed, workElapsed) {
    this.pctGrading = Math.round((gradeElapsed / workElapsed) * 100);
};

StatsData.prototype.receivePctComplete = function (pctComplete) {
    this.pctComplete = Math.round(pctComplete * 100);
};

StatsData.prototype.receiveExamsGraded = function (examsGraded) {
    this.numGraded = examsGraded;
};

StatsData.prototype.receiveUngraded = function (examsUngraded) {
    this.examsUngraded = examsUngraded;
};

StatsData.prototype.receivePPMData = function (ppm) {
    try {
        if (ppm) {
            this.lastExamPPM = ppm[0]['ppm'];
            var me = this;
            $.each(ppm, function () {
                var j = Number(this['ppm']);
                me.ppmData.push(j);
            });
        }
    } catch (e) {
        window.console.log(e);
    }
};
