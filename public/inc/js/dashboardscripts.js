/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


/*****************************************************DASHBOARD ***********************************************************/
/*****************************************************DASHBOARD ***********************************************************/
//Utilities
/**
 * Converts seconds to minutes for display
 * @param {Number} elapsedTime The time to be converted in seconds
 * @returns {Number}
 * @testExists True
 */
function secondsToMinutes(elapsedTime) {
    var displayTime = '';
    if(elapsedTime === 0){
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
function secondsToHours(seconds) {
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
function unitChooser(elapsedTime){
    var unit = '';
    if(elapsedTime < 60){
        unit = 'Sec';
    }
    else if(elapsedTime >= 60){
        unit = 'Min';
    }
    return unit;    
}
/**
 * Utility function to calculate the time elapsed (in seconds) between two Date objects
 * @param {Date} stopTime
 * @param {Date} startTime
 * @returns {Number}
 * @testExists False
 */
function calculateElapsedTime(stopTime, startTime){
    var elapsed = Math.round((stopTime - startTime) / 1000); //in seconds
    return elapsed;
}


/**
 * Converts seconds into a string with format hour:min
 * @param {type} seconds
 * @returns {String}
 * @testExists True
 */
function timeFormat(seconds) {
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
function addLeadingZero(val) {
    if (val < 10) {
        var vv = String(0) + String(val);
        return vv;
    }
    else {
        return val;
    }
};//addleadingzero


/**
 * This handles posting the time to the server
 * @param {type} Send
 * @param {type} checkvalue The value expected to be returned from the server as currentTime
 * @returns {undefined}
 */
function sendTimerUpdate(Send, checkvalue){
    $.post('api.php', Send, function(reply) {
        if (reply && (reply.currentTime === checkvalue)) {
       //     window.console.log('jip');
        }
        else {
         //   console.log('error at set examTme');
        }
    },"JSON");
}

/**
 * This checks the cookie and groupNumber field for a ongoing group, returns false otherwise
 * @returns {checkCurrentGroup.cookieGN|jQuery|Boolean}
 */
function checkCurrentGroup(){
    var fieldGN = $('#groupNumber').val();
    var cookieGN = $.cookie('groupNumber');
    if (fieldGN) { //if there is a group currently going on
        var groupNumber = fieldGN;
        $.cookie('groupNumber', groupNumber); //Number in field trumps cookie, so set cookie
        return groupNumber;
        }
    else if(cookieGN) {
        var groupNumber = cookieGN;
        $('#groupNumber').val(groupNumber);//set field from cookie
        return groupNumber;
        }
    else{
        return false;
    }
}

function autorunGroup(groupDisplay, groupRecord) {
    if(checkCurrentGroup()){
//    var cookieGN = $.cookie('groupNumber');
//    if (cookieGN) {
        groupDisplay.start();
        groupRecord.start();
    }
//    else {
//        alert('Group number is empty. Please set group number before proceeding');
        //maybe have the group number box highlight
//    }
};//autorun


//_____________________________________________________________________________________________________Timer Record
/**
 * This sends an elapsed interval to the server (in seconds) while the timer is running
 * @param {string} timerType String 'exam' or 'group'
 * @returns {TimerRecord}
 */
function TimerRecord(timerType) {
    var me = this;
    var intervalTime;
    this.elapsedTime;
    this.currentTime = 0;
    this.toAdd = 0;
    this.timerType = timerType;
    if (this.timerType === 'exam') {
        this.startButton = 'startExam';
        this.stopButton = 'stopExam';
    }
    else if (this.timerType === 'group') {
        this.startButton = 'startGroup';
        this.stopButton = 'stopGroup';
    }
    //behaviors
    $('#' + this.startButton).bind("click", function() { me.start(); });
    $('#' + this.stopButton).bind("click", function() { me.stop(); });
}//Timer record

TimerRecord.prototype.start = function() {
    this.startTime = Date.now();
    this.intervalUpdate();
};
TimerRecord.prototype.stop = function() {
    clearInterval(this.intervalID);
    this.updateTime();
};

TimerRecord.prototype.intervalUpdate = function() {
    var me = this;
    this.intervalID = setInterval(function() {
        me.updateTime();
    }, 60000);
};


/**
 * Sets the current time as rightNow, then calls calculateElapsedTime, sends the result, and updates starttime
 * @returns {undefined}
 */
TimerRecord.prototype.updateTime = function() {
    this.rightNow = Date.now();
    var Send = new Object();
    Send.toAdd = calculateElapsedTime(this.rightNow, this.startTime);
    this.startTime = Date.now();
    Send.requestType = 'timer';
    if (this.timerType === 'exam') {
        Send.please = 'setExamTime';
        Send.sid = $("#sid").val();
    }
    else if (this.timerType === 'group') {
        Send.please = 'setGroupTime';
        Send.groupNumber = $('#groupNumber').val();
    }
    sendTimerUpdate(Send, Send.toAdd);
};



//__________________________________________________________________________________________ Display
/**
 * This handles the display of times for the user as a timer runs. It is a separate process from the recorder.
 * @param {string} timerType
 * @returns {TimerDisplay}
 */
function TimerDisplay(timerType) {
    var unit;
    var me = this;
    this.displayTime = 0;//this is separate so that can change units as necessary
    this.elapsedTime = 0;
    this.timerType = timerType;
    this.timeChecked = false;
    if (this.timerType === 'exam') {
        this.startButton = 'startExam';
        this.stopButton = 'stopExam';
        this.statusBar = 'curExStatus';
        this.location = 'currentTimeGauge';
    }
    else if (this.timerType === 'group') {
        this.startButton = 'startGroup';
        this.stopButton = 'stopGroup';
        this.statusBar = 'curGroupStatus';
        this.location = 'currentGroupGauge';
        this.checkGroupInProgress();
        //if group number has been located, check for time. Otherwise wait until start is pressed.
        if (this.groupNumber > 0) {
            this.getServerTime();
        }
    }
    $('#' + this.startButton).bind("click", function() { me.start(); });
    $('#' + this.stopButton).bind("click", function() { me.stop(); });
};

/**
 * Converts seconds to minutes for display
 * @returns {undefined}
 */
TimerDisplay.prototype.secToMin = function() {
    this.displayTime = secondsToMinutes(this.elapsedTime);
    this.unit = unitChooser(this.elapsedTime);
};

TimerDisplay.prototype.start = function() {
    if (this.timerType === 'exam') {
        this.sid = $("#sid").val();
    }
    else if(this.timerType === 'group') {
        this.checkGroupInProgress();
    }
    this.getServerTime();
    this.setCurrentTimeBox();
    this.startTime = Date.now();
    this.gameOn();
    this.runTimer();
};

TimerDisplay.prototype.runTimer = function() {
    var me = this;
    this.intervalID = setInterval(function() {
        me.updateGauge();
    }, 2000);
};

TimerDisplay.prototype.stop = function() {
    clearInterval(this.intervalID);
    this.updateGauge();
    this.gameOff();
};

TimerDisplay.prototype.gameOn = function() {
    $('#' + this.statusBar).removeClass('blank').removeClass('pause').addClass('go');
};

TimerDisplay.prototype.gameOff = function() {
    $('#' + this.statusBar).removeClass('go').addClass('pause');
};


/**
 * This queries the server for the time elapsed on a given exam or group
 * @returns {undefined}
 */
TimerDisplay.prototype.getServerTime = function() {
    var me = this;
    if (this.timerType === 'exam') { //only allow this to run for exams
        var Send = {'requestType': 'timer', 'please': 'getExamTime', 'sid': this.sid};
    }else if(this.timerType === 'group'){
        var Send = {'requestType': 'timer', 'please': 'getGroupTime', 'groupNumber': this.groupNumber};
    }
    $.post('api.php', Send, function(reply){
            if (reply && reply.time > 0) {
                me.elapsedTime = Number(reply.data.time);
            } else {
             //   me.elapsedTime = 0;
            }
        }, "JSON");              
};
/**
 * This formats and calculates the elapsed time for display 
 */
 TimerDisplay.prototype.makeDisplayTimeFromElapsedTime = function(){
    return secondsToMinutes(this.elapsedTime) + ' ' + unitChooser(this.elapsedTime);
};
/**
 * Sets value of currentTimeGaugeBox or currentGroupGaugeBox depending on the type
 * @testExists True
 * @returns {undefined}
 */
TimerDisplay.prototype.setCurrentTimeBox = function(){
    var toSet = this.makeDisplayTimeFromElapsedTime();
    $('#' + this.location + 'Box').val('').val(toSet);
};

//___________________________________________________________ Specific to group timers
/**
 * Checks the input field and cookie for group number
 * @returns {undefined}
 */
TimerDisplay.prototype.checkGroupInProgress = function() {
    if (this.timerType === 'group') {
        this.groupNumber = this.checkCurrentGroup();
        if(!this.groupNumber){
            alert('Group number is empty. Please set group number before proceeding');
            //maybe have the group number box highlight
        }
    }//if group
};//in progress

TimerDisplay.prototype.checkCurrentGroup = checkCurrentGroup;
//TimerDisplay.prototype.checkCurrentGroup = function(){
//    var fieldGN = $('#groupNumber').val();
//    var cookieGN = $.cookie('groupNumber');
//    if (fieldGN) { //if there is a group currently going on
//        var groupNumber = fieldGN;
//        $.cookie('groupNumber', groupNumber); //Number in field trumps cookie, so set cookie
//        return groupNumber;
//        }
//    else if(cookieGN) {
//        var groupNumber = cookieGN;
//        $('#groupNumber').val(groupNumber);//set field from cookie
//        return groupNumber;
//        }
//    else{
//        return false;
//    }
//};

/**
 * Creates gauge for current time
 * @todo This needs to be fixed to use the avg times in setting min and max
 * @returns {undefined}
 */
TimerDisplay.prototype.createGauge = function() {
    //this.minValue = Math.floor(stats.avgElapsedGrading) - 2;
    //this.maxValue = Math.round(stats.avgElapsedGrading) + 2;
    this.secToMin();
    if (this.timerType === 'exam') {
        this.title = 'Exam time';
        this.options = {
            intervalOuterRadius: 40,
            ticks: [0, 5, 10, 15, 20],
            intervals: [8, 15, 20],
            min: 0,
            max: 20,
            intervalColors: ['#66cc66', '#E7E658', '#cc6666']
        };
    } else if (this.timerType === 'group') {
        this.title = 'Group time';
        this.options = {
            ticks: [0, 20, 40, 60, 80]
        };
    }

    this.gauge = $.jqplot(this.location, [[this.displayTime]], {
        title: this.title,
        animate: true,
        animateReplot: true,
        seriesDefaults: {
            renderer: $.jqplot.MeterGaugeRenderer,
            rendererOptions: this.options
        }
    });
    $('#' + this.location + 'Box').val('').val(this.displayTime + ' ' + this.unit);
};//make currentTime gauge

TimerDisplay.prototype.updateGauge = function() {
    this.rightNow = Date.now();
    this.interval = (this.rightNow - this.startTime) / 1000; //in seconds
    this.elapsedTime += this.interval;
    this.startTime = '';
    this.startTime = Date.now();
    this.secToMin();
    this.gauge.rendererOptions = {label: this.unit};
    this.gauge.series[0].data = [[1, this.displayTime]];
    this.gauge.replot();
    $('#' + this.location + 'Box').val('').val(this.displayTime + ' ' + this.unit);
};

/**
 * This handles tasks related to getting and setting timer cookies
 * @returns {TimerCookie}
 */
function TimerCookie() {
    this.type;
    this.name = '';
    this.valueToSet = '';
    this.valueToGet = '';
    this.valueRead = '';
}
;

TimerCookie.prototype.updateCookie = function(nameToSet, valueToSet) {
    this.name = nameToSet;
    this.valueToSet = valueToSet;
    $.cookie(this.name, this.valueToSet);
};//update cookie

TimerRecord.prototype.readCookie = function(cookieToRead) {
    this.valueRead = $.cookie(cookieToRead);
};//read cookie

TimerRecord.prototype.clearCookie = function(cookieToClear) {
    $.cookie(cookieToClear, null);
};

//
////-----------------------------------------------------------------------------------------------------------------------------------------
///*
// PAGE CHANGES and EVENTS
// */

//____________________________________________________ Initialize
/**
 * Sets handlers for newRecord button click. This function should be called on page load
 * @returns {undefined}
 */
//function bindHandlersToNewRecordButton(){
//    $('#newRecord').bind("click", function() {
//        window.reload();
//        emptyFields();
//        var exam = new Exam();
//        $("#statisticsHere").empty();
//        var ttr = new TimerRecord('exam');
//        var ttd = new TimerDisplay('exam');
//        var stats = new Stats();
//        ttd.createGauge();
//
//        if (AUTOSTARTEXAM) {
//            console.log('autostart exam set');
//            $(".qSelect").bind('click', function() {
//    //		$("#sid").bind('change', function(){
//                ttr.start();
//                ttd.start();
//                $('#pagesSelect').bind("click", function() {
//                    ttr.stop();
//                    ttd.stop();
//                });
//            });
//
//        }
//    });
//}