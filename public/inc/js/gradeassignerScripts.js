/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */
/**
 * These are the scripts for the gradeassigner utility
 */
//var lockSliders = true

/**
 * This will move the sliders below the one just set so that they don't exceed the min value of a higher slider
 * @constructor
 */
function SliderUpdater() {
    this.gradenames = ['A', 'Amin', 'Bplus', 'B', 'Bmin', 'Cplus', 'C', 'Cmin', 'Dplus', 'D', 'Dmin', 'F', 'nc'];
}

/**
 * This takes the name of the grade slider just moved and makes a list of the grades that need to be changed
 * @private
 * @param {string} gradename The name of the gradeslider just moved
 * @returns {undefined}
 */
SliderUpdater.prototype.positionDeterminer = function (gradename) {
    var sliderposition = this.gradenames.indexOf(gradename);
    this.remainingGrades = new Array();
    for (var i = sliderposition + 1; i !== this.gradenames.length; i++) {
        this.remainingGrades.push(this.gradenames[i]);
    }
};
/**
 * Sets the sliders [Not called by user]
 * @private
 * @param {string} slidername The name of the grade whose slider to change
 * @param {float} newmax The value to set the max score to
 * @returns {undefined}
 */
SliderUpdater.prototype.maxsetter = function (slidername, newmax) {
    $('#' + slidername + 'Slider').slider("option", "values", [0, newmax]);
};
/**
 * This updates the maximum values on all lower sliders when a grade is set. This is called by user
 * @public
 * @param {string} updatedGrade The grade whose value was just updted by moving a slider
 * @param {float} gradescore The minimum score of that new grade
 * @returns {Array}
 */
SliderUpdater.prototype.update = function (updatedGrade, gradescore) {
    this.positionDeterminer(updatedGrade);
    var remainingMax = gradescore - 0.25;
    for (var i = 0; i < this.remainingGrades.length; i++) {
        this.maxsetter(this.remainingGrades[i], remainingMax);
    }
    ;
};
/**
 * This is used to make sure that grade criteria don't overlap prior to submission
 * @co@constructor
 * @returns {_L2.ConsistencyChecker}
 */
function ConsistencyChecker() {
//    this.gradenames = ['A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F', 'nc'];
    this.gradenames = ['A', 'Amin', 'Bplus', 'B', 'Bmin', 'Cplus', 'C', 'Cmin', 'Dplus', 'D', 'Dmin', 'F', 'nc'];
    this.gradeorder = ['AMaxScore', 'AMinScore',
        'AminMaxScore', 'AminMinScore',
        'BplusMaxScore', 'BplusMinScore',
        'BMaxScore', 'BMinScore',
        'BminMaxScore', 'BminMinScore',
        'CplusMaxScore', 'CplusMinScore',
        'CMaxScore', 'CMinScore',
        'CminMaxScore', 'CminMinScore',
        'DplusMaxScore', 'DplusMinScore',
        'DMaxScore', 'DMinScore',
        'DminMaxScore', 'DminMinScore',
        'FMaxScore', 'FMinScore',
        'ncMaxScore', 'ncMinScore'];
    this.errors = new Array();
}
/**
 * New attempt
 * @returns {undefined}
 */
ConsistencyChecker.prototype.check2 = function (name, score) {
    var position = this.gradeorder.indexOf(name) + 1;
    var errors = new Array();
    var te = this.check4(position, score, errors);
    window.console.log(te);
    return te.length;

};


ConsistencyChecker.prototype.check4 = function (position, score, errors) {
//    for (i = position + 1; i <= CC.gradeorder.length; i++) {
    if (this.holder[this.gradeorder[i]] >= score) {
        errors.push(this.gradeorder[i]); //push the name of the grade that not smaller than onto list
    }
    if (position <= this.gradeorder.length) {
        return this.check4(position++, score, errors);
    } else {
        return errors;
    }


//        }
//}
//    holder[position]
};

ConsistencyChecker.prototype.check5 = function (scores) {
    this.errors = new Array();
    var me = this;

    $.each(scores, function (k, score) {
        var checkingindex = me.gradeorder.indexOf(k);
        var checkit = function (checkingindex) {
            checkingindex += 1;
            if (me.gradeorder[checkingindex] >= score) {
                me.errors.push(me.gradedorder[checkingindex]);
            }
            if (me.gradeorder.length !== checkingindex) {
//                return me.errors;
//            }else{
                return checkit(checkingindex);
            }
            ;
        };
    });
    return this.errors.length;
};

/**
 * New plan: put things in order, check for transitivity
 * @returns {int} Number of errors
 */
ConsistencyChecker.prototype.check = function () {
    var checklist = new Array();
    for (var i = 0; i < this.gradeorder.length; i++) {
        var currentGrade = this.holder[this.gradeorder[i]];
        checklist.push(currentGrade);
        //make sure full
    }
    //window.console.log(checklist);
    var everythingCool = true;
    for (var i = 0; i <= checklist.length; i++) {
        if (i === 0) {
            var bigger = checklist[0];
            var smaller = checklist[1];
        }
        else {
            var bigger = checklist[i - 1];
            var smaller = checklist[i];
        }
        if (bigger <= smaller) {
            everythingCool = false;
            break;
        }
    }
    if (everythingCool === false) {
        var problemspot = i;
        var firstproblem = this.gradeorder[i];
        var error = "<p class='errorMessage'>" + firstproblem + " overlaps " + firstproblem + "</p>";
        this.errors.push(error);
//        window.console.log('newcheck error', error);
    }
    if (this.errors.length > 0) {
        for (var i = 0; i <= this.errors.length; i++) {
            $('#errorHolder').append(this.errors[i]);
        }
    }
    return this.errors.length;
};



/**
 * When called, this loads the values into this.holder
 * @returns {undefined}                             
 * */
ConsistencyChecker.prototype.loadScores = function () {
    //                                this.holder = testobject;
    this.holder = new Object();
    var me = this;
    $('.scoreCell').each(function () {
        var scoreid = $(this).attr('id');
        me.holder[scoreid] = $(this).val();
    });
};

/**
 * Sets initial slider positions to scores for current exam. Call on page load
 * @param {json} tdata
 * @returns {undefined}
 */
function setSliderPositions(tdata) {
    $.each(tdata, function () {
        var gl = this.gradeLetter;
        $('#' + gl + 'MinScore').val(this.minScore);
        $('#' + gl + 'MaxScore').val(this.maxScore);
        $('#' + gl + 'Slider').slider('values', [this.minScore, this.maxScore]);
    });
    
}

$('.gradeSlider').slider({
    min: EXAMMIN,
    max: EXAMMAX,
    //smooth: true,
    animate: 'fast',
    range: true,
    step: 0.25,
    slide: function (event, ui) {
        var gradename = $(this).attr('data');
        $('#' + gradename + 'MinScore').val(ui.values[0]);
        $('#' + gradename + 'MaxScore').val(ui.values[1]);
    },
    change: function (event, ui) {
        if (lockSliders === true) {
            var gradename = $(this).attr('data');
            if (ui.values[0] > 0) {
                var SE = new SliderUpdater();
                SE.update(gradename, ui.values[0]);
            }
        }
    }
});

function setSliderLock() {
    $("#lockSliders").prop('checked', 'true');
    lockSliders = true;
}


function buildRecordRequest(dthis) {
    var Send = new Object;
    Send.task = 'recordGradeAssignment';
    Send.classIDs = new Array();
    Send.examID = $('#currentExamID').val();
    //disabling the checks for now and just recording for all classes at once
    $.each($("input[class='classSelectChecks']"), function () {
        Send.classIDs.push($(dthis).attr('data'));
    });
//    $.each($("input[class='classSelectChecks']:checked"), function() {
//        Send.classIDs.push($(this).attr('data'));
//    });

    $('.scoreCell').each(function () {
        var scoreid = $(this).attr('id');
        if ($(this).val()) {
            Send[scoreid] = $(this).val();
        }
    });
    return Send;
}

function bindSliderListeners() {

    $('#verify').bind('click', function () {
        var CC = new ConsistencyChecker();
        CC.loadScores();
        CC.check();
    });

//Record the assignments
    $('#recordAssign').bind('click', function () {
        var Send = buildRecordRequest(this);
        $.post(GRADEAPI, Send, function (response) {
            //temporarily disabling because giving weird behavior
            //responseHandler(response);
                    location.reload(true);
        }, "JSON");
    });

    //lock and unlock sliders
    $("#lockSliders").bind("click", function () {
        var v = $(this).prop('checked');
        lockSliders = v;
        window.console.log(lockSliders);
        // return lockSliders;
    });

}
;

$("#allClassSelect").bind('change', function () {
//    window.console.log('j');
//    $('.classSelectChecks').prop('checked', 'checked');
});

//    $('#gradesComplete').bind('click', function () {
//        var examid = $('#currentExamID').val();
//        var Send = {'examID': examid, 'task': 'gradesComplete',
//            'complete': true};
//        $.post(GRADEAPI, Send, function () {
//            responseHandler();
//        }, 'JSON');
//    });
//    
////Set examid
//    $("#examTarget").bind("change", function () {
//        var currExamID = $("#examTarget :selected").attr("value");
//        $('.currExamID').val(currExamID);
//        setExamCookie(COOKIE_PAGENAME);
//    });
