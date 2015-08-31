
function Question(questionid) {
    this.questionID = questionid;
}
;
Question.prototype.setQuestionNumber = function (qnum) {
    this.questionNumber = qnum;
};
Question.prototype.setTitle = function (title) {
    this.title = 'Q' + this.questionNumber + ' ' + title;
};
Question.prototype.setScore = function (score) {
    (score === null ? this.score = null : this.score = Number(score));
};
Question.prototype.setAverage = function (average) {
    this.average = Number(average);
};


function QuestionHolder() {
    this.questions = [];
    this.questionNumbers = [];
    this.answeredQuestions = [];
}

QuestionHolder.prototype.loadScores = function (questionJSON) {
    var me = this;
    $.each(questionJSON, function (k, v) {
        var q = new Question(v['questionId']);
        q.setQuestionNumber(v['questionNumber']);
        q.setScore(v['score']);
        q.setTitle(v['questionName']);
        me.questions.push(q);
        me.questionNumbers.push(Number(v['questionNumber']));
    });
};

QuestionHolder.prototype.loadAverages = function (questionAveragesJSON) {
    var me = this;
    $.each(questionAveragesJSON, function (k, v) {
        var qid = v['questionId'];
        var avg = v['average'];
        $.each(me.questions, function () {
            if (this.questionID === qid) {
                this.setAverage(avg);
            }
        });
    });
};

/**
 * Retrieves a question by its ID number
 * @param {type} qid
 * @returns {Question}
 */
QuestionHolder.prototype.getByID = function (qid) {
    var found = null;
    $.each(this.questions, function () {
        if (this.questionID === qid) {
            found = this;
        }
    });
    return found;
};

/**
 * Retrieves the question by its number on the exam
 * @param {type} qnum
 * @returns {Question}
 */
QuestionHolder.prototype.getByNumber = function (qnum) {
    var found = null;
    $.each(this.questions, function () {
        if (this.questionNumber === qnum) {
            found = this;
        }
    });
    return found;
};

/**
 * Determines which questions were answered by the student and puts them in an array
 */
QuestionHolder.prototype.setAnsweredQuestions = function() {
    var me = this;
    $.each(this.questions, function () {
        if (this.score !== null) {
            me.answeredQuestions.push(this.questionNumber);
        }
    });
};

function Element(elementID) {
    this.elementID = elementID;
};
Element.prototype.setQuestionNumber = function (qnum) {
    this.questionNumber = Number(qnum);
};
Element.prototype.setElementAbbr = function (elementAbbr) {
    this.elementAbbr = elementAbbr;
};
Element.prototype.setElementEnglish = function (elementEnglish) {
    this.elementEnglish = elementEnglish;
};
Element.prototype.setScore = function (score) {
    this.score = Number(score);
};
Element.prototype.setSubtask = function (subtask) {
    this.subtask = Number(subtask);
};
Element.prototype.setAverage = function (average) {
    this.average = Number(average);
};

function ElementHolder() {
    this.elements = [];
};

ElementHolder.prototype.loadScores = function (elementJSON) {
    var me = this;
    $.each(elementJSON, function()
    {
        $.each(this.elements, function (k, v) {
            //console.log(v);
            var el = new Element(v['elementId']);
            el.setQuestionNumber(v['questionNumber']);
            el.setElementAbbr(v['elementName']);
            // el.setElementEnglish(v['displayText']);
            el.setScore(v['score']);
            el.setSubtask(v['subtask']);
            el.setAverage(v['average']);
            el.questionNumber = v['questionNumber'];
            me.elements.push(el);
        });
    });
};


ElementHolder.prototype.loadAverages = function (elementAveragesJSON) {
    var me = this;
    $.each(elementAveragesJSON, function() {
        $.each(this.elements, function (k, v) {
            //$.each(elementAveragesJSON.elements, function (k, v) {
            var eid = v['elementId'];
            var avg = v['average'];
            $.each(me.elements, function () {
                if (this.elementID === eid) {
                    this.setAverage(avg);
                    this.questionNumber = v['questionNumber'];
                }
            });
        });
    });
};

ElementHolder.prototype.getByQuestionNumber = function (qnum) {
    var results = [];
    $.each(this.elements, function () {
        if (this.questionNumber === Number(qnum)) {
            results.push(this);
        }
    });
    return results;
};

/**
 * This will make divs for each of the questions which will hold the element chart for that question.
 * @param {QuestionHolder} QuestionHolder
 * @returns {divMaker}
 */function divMaker(QuestionHolder) {
    $.each(QuestionHolder.answeredQuestions, function () {
        var qnum = this;
        var elDiv = "<h1>Q" + qnum + "</h1><div id='Q" + qnum + "Chart' class='elementChartDiv' style='height:600px; width:800px' > </div>";
        $('#elementCharts').append(elDiv);
    });
}
;

function makeOverallChart(QuestionHolder) {
    var scores = [];
    var averages = [];
    var titles = [];
    $.each(QuestionHolder.answeredQuestions, function (k, v) {
        var q = QuestionHolder.getByNumber(v);
        if (q !== null) {
            scores.push(q.score);
            averages.push(q.average);
            titles.push(q.title);
        }
    });
    chartDrawer('allQuestionsChart', scores, averages, titles);
}

function makeElementCharts(ElementHolder, QuestionHolder) {
    //console.log(ElementHolder, QuestionHolder);
    var numQ = QuestionHolder.answeredQuestions.length;
    var me = this;
    $.each(QuestionHolder.answeredQuestions, function (k, v) {
        var qnum = v;
        var scores = [];
        var averages = [];
        var titles = [];
        //go through the elementScores array and pull out relevant items
        var elements = ElementHolder.getByQuestionNumber(qnum);
        //go through each element and add its properties to the scores, averages, and titles
        if (elements && (elements.length > 0)) {
            $.each(elements, function () {
                window.console.log('iterating elements', this);
                scores.push(this.score);
                titles.push(this.elementAbbr);
                averages.push(this.average); // this looks to be compiling element scores, but we care about questions
            });
        }
        var target = 'Q' + qnum + 'Chart';
        //console.log('target', target , 'scores', scores, 'averages', averages, 'titles', titles);
        chartDrawer(target, scores, averages, titles);
    });
}

function chartDrawer(target, scores, averages, titles) {
    $.jqplot(target, [scores, averages], {
        show: true,
        // title: this.title,
        seriesDefaults: {
            renderer: $.jqplot.BarRenderer
        },
        series: [
            {label: 'Your score'},
            {label: 'Class average'}
        ],
        axesDefaults: {
            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
            tickOptions: {
                angle: -30,
                fontSize: '10pt'
            }
        },
        axes: {
            xaxis: {
                renderer: $.jqplot.CategoryAxisRenderer,
                ticks: titles
            },
            yaxis: {
                label: 'Relative scores',
                showLabel: true,
                showTicks: false,
                showTickMarks: true
            }
        },
        legend: {
            show: true,
            placement: 'outsideGrid',
            location: 'n'
        }

    });

};

/**
 * The php outputs the element score json as [[{d:d, d:d}, {d:d}], [{d:d, d:d}]]. This consolidates all the dicts into one array
 * @param {type} elementScores
 * @returns {Array|consolidateElementScores.result}
 */
function consolidateElementScores(elementScores){
    var result = [];
    $.each(elementScores, function(){
        $.each(this, function(){
           result.push(this); 
        });
    });
    return result;
}


//------------------------------------------------------------------------------------------------- OLD
function QuestionDataObject() {
    this.questionNames = [];
    this.questionNumbers = [];
    this.questionScores = [];
}
/**
 * Loads the question data from an incoming or php provided json and stores internally for other functions to use
 * @param {type} questionJSON
 * @returns {chartScripts_L1.QuestionData}
 */
QuestionDataObject.prototype.load = function (questionJSON) {
    var me = this;
    //Counter for callback    
    this.responses = questionJSON.length;
    this.cnt = 0;
    $.each(questionJSON, function (k, v) {
        me.questionNumbers.push(Number(v['questionNumber']));
        me.questionNames.push(v['questionName']);
        me.questionScores.push(Number(v['score']));
        me.cnt++;
    });
};




function QuestionAverages() {
    this.questionAverages = [];
    this.cnt = 0;
}

QuestionAverages.prototype.load = function (questionAverageJSON) {
    var me = this;
    //Max number for counter
    this.responses = questionAverageJSON.length;
    $.each(questionAverageJSON, function (k, v) {
        me.questionAverages.push(Number(v['average']));
        me.cnt++;
    });
};

//function Chart() {
//    this.questionNumbers = new Array();
//    this.questionAverages = new Array();
//    this.questionScores = new Array();
//    this.questionNames = new Array();
//    this.chartData = new Array();
//    //Holds element chart data
//    this.elementAverages = new Array();
//    this.elementScores = new Array();
//    this.elementChartData = new Array();
//
//    //Will be true once all the scores have been loaded ---changed by callback
//    this.scoresLoaded = false;
//    //Will be true once all averages loaded --changed by callback
//    this.avgLoaded = false;
//    //Will be true once element scores have all been loaded --changed by callback
//    this.elementScoresLoaded = false;
//    //Will be tue once element averages have all been loaded --changed by callback
//    this.elementAveragesLoaded = false;
//
//    this.numQ = '';
//
//}
//
//
//
//Chart.prototype.makeQuestionChart = function (QuestionHolder, ElementHolder) {
//    var me = this;
//    //Get question data for individual student
//    $.getJSON(OUTPUTLINK, {'task': 'getQuestionScores', 'sendAll': true}, function (response) {
//        QuestionHolder.loadScores(response.data);
////Max number for counter
////        var responses = response.data.length;
////        //Counter for callback    
////        var cnt = 0;
////        $.each(response.data, function(k, v){
////            me.questionNumbers.push(Number(v['questionNumber']));
////            me.questionNames.push(v['questionTitle']);
////            me.questionScores.push(Number(v['questionScore']));
////            cnt++;
////            me.checkdone(cnt, responses, 'scores');
////        });
//    }, "JSON");
//
//    //Get averages
//    $.getJSON(OUTPUTLINK, {'task': 'getQuestionAverages'}, function (response) {
//        QuestionHolder.loadAverages(response.data);
////        //Max number for counter
////        var responses = response.data.length;
////        //Counter for callback    
////        var cnt = 0;
////        $.each(response.data, function(k, v){
////            me.questionAverages.push(Number(v['questionAverage']));
////            cnt++;
////            me.checkdone(cnt, responses, 'averages');
////        });//each
//    }, "JSON");
//
//    $.getJSON(OUTPUTLINK, {'task': 'getElementScores'}, function (response) {
//        ElementHolder.loadScores(response.data);
////        //Max number for counter
////        var responses = response.data.length;
////        //Counter for callback    
////        var cnt = 0;
////        var data = [];
////
////        $.each(response.data, function (k, v) {
////            $.each(v, function (y, x) {
////                data.push(x);
////                me.elementScores.push(x);
////            });
////            cnt++;
////            me.checkdone(cnt, responses, 'elementScores');
////        });
//    });//element avgs
//    $.getJSON(OUTPUTLINK, {'task': 'getElementAverages'}, function (response) {	 //Max number for counter
//        ElementHolder.loadAverages(response.data);
////        var responses = response.data.length;
////        //Counter for callback    
////        var cnt = 0;
////        $.each(response.data, function (k, v) {
////            var dt = new Object();
////            dt.qnum = v['questionNumber'];
////            dt.elementAbbr = v['elementAbbr'];
////            dt.elementAverage = v['elementAverage'];
////            me.elementAverages.push(dt);
////            cnt++;
////            me.checkdone(cnt, responses, 'elementAverages');
////        });
//    });//element avgs
//
//
//};
//
////This acts as a controller. It is passed in as a callback to make sure that all the data from the ajax request has loaded before proceeding
//Chart.prototype.checkdone = function (cnt, responses, type) {
//    //If every response has been covered, move on to the next task
//    if (cnt === responses) {
//        switch (type) {
//            case 'scores' :
//                //If this is being executed by the score getter, mark the score loading as complete
//                this.scoresLoaded = true;
//                //set the number of questions
//                this.numQ = this.questionNumbers.length;
//                this.drawControl('questions');
//                break;
//
//            case 'averages' :
//                //If this is being executed by the average getter, mark the average loading as complete
//                this.avgLoaded = true;
//                this.drawControl('questions');
//                break;
//
//            case 'elementScores' :
//                this.elementScoresLoaded = true;
//                this.drawControl('elements');
//                break;
//
//            case 'elementAverages' :
//                this.elementAveragesLoaded = true;
//                this.drawControl('elements');
//                break;
//
//        }
//    }
//
//};
//
//Chart.prototype.drawControl = function (charttype) {
//    //After a ajax call has completed, this checks whether all calls for the type of chart have finished 
//    //If they have, it draws the corresponding chart
//    var scores = [];
//    var averages = [];
//    var titles = [];
//    switch (charttype) {
//        case 'questions' :
//            //Check whether this completes the question score load processes
//            if ((this.avgLoaded === true) && (this.scoresLoaded === true)) {
//                //Once everything is loaded, assemble the data object 
//                this.assembleQuestionDataObject();
//                //Draw the chart
//                $.each(this.chartData, function () {
//                    scores.push(this.qdata[0]);
//                    averages.push(this.qdata[1]);
//                    titles.push(this.title);
//                });
//                this.chartDrawer('allQuestionsChart', scores, averages, titles);
//            }
//            break;
//        case 'elements':
//            if ((this.elementScoresLoaded === true) && (this.elementAveragesLoaded === true)) {
//                //Create the target divs
//                this.divMaker();
//                //Once everything is loaded, assemble the data object and draw the chart 
//                this.drawElementDataChart();
//            }
//            break;
//    }//switch
//};
//
//Chart.prototype.assembleQuestionDataObject = function () {
//    for (i = 0; i < this.numQ; i++) {
//        var score = this.questionScores[i];
//        var avg = this.questionAverages[i];
//        if ((score >= 0) && (avg >= 0)) {
//            var qnum = this.questionNumbers[i];
//            var title = this.questionNames[i];
//            var qdata = new Array(score, avg);
//            var update = new Object();
//            update.qnum = qnum;
//            update.title = 'Q' + qnum + ' ' + title;
//            update.qdata = qdata;
//            this.chartData.push(update);
//        }
//    }
//};
//
//Chart.prototype.drawElementDataChart = function () {
//    var numQ = this.questionNumbers.length;
//    var me = this;
//    $.each(me.questionNumbers, function (k, v) {
//        var qnum = v;
//        me.scores = [];
//        me.averages = [];
//        me.titles = [];
//        //go through the elementScores array and pull out relevant items
//        $.each(me.elementScores, function (k, v) {
//            window.console.log(v);
//            if (v.questionNumber == qnum) {
//                me.scores.push(Number(v['elementScore']));
//                me.titles.push(v['elementEnglish']);
//                var abbr = v['elementAbbr'];
//                //go through the element averages array and pull out the average corresponding to the element
//                $.each(me.elementAverages, function (k, v) {
//                    if (v.elementAbbr == abbr) {
//                        me.averages.push(Number(v.elementAverage));
//                    }
//                });
//
//            }
//        });
//
//        if (me.scores.length > 0) {
//            var include = false;
//            var inc = $.inArray(qnum, me.answeredQuestions);
//            window.console.log(inc);
//            if (inc >= 0) {
//                var target = 'Q' + qnum + 'Chart';
//                me.chartDrawer(target, me.scores, me.averages, me.titles);
//            }
//        }
//
//    });//each question number
//
//};
//
//
//Chart.prototype.questionDraw = function () {
//    var scores = [];
//    var averages = [];
//    var titles = [];
//    $.each(this.chartData, function () {
//        scores.push(this.qdata[0]);
//        averages.push(this.qdata[1]);
//        titles.push(this.title);
//    });
//
//    this.chartDrawer('allQuestionsChart', scores, averages, titles);
//};//draw
//
//
//
//Chart.prototype.chartDrawer = function (target, scores, averages, titles) {
//    $.jqplot(target, [scores, averages], {
//        show: true,
//        // title: this.title,
//        seriesDefaults: {
//            renderer: $.jqplot.BarRenderer
//        },
//        series: [
//            {label: 'Your score'},
//            {label: 'Class average'}
//        ],
//        axesDefaults: {
//            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
//            tickOptions: {
//                angle: -30,
//                fontSize: '10pt'
//            }
//        },
//        axes: {
//            xaxis: {
//                renderer: $.jqplot.CategoryAxisRenderer,
//                ticks: titles
//            },
//            yaxis: {
//                label: 'Relative scores',
//                showLabel: true,
//                showTicks: false,
//                showTickMarks: true
//            }
//        },
//        legend: {
//            show: true,
//            placement: 'outsideGrid',
//            location: 'n'
//        }
//
//    });//end chartmaker
////End chartdrawer
//};
//
//Chart.prototype.divMaker = function () {
//    //This will make divs for each of the questions which will hold the element chart for that question. Also fills the answeredQuestions array
//    this.answeredQuestions = new Array();
//    for (i = 0; i < this.numQ; i++) {
//        var score = this.questionScores[i];
//        if ((score > 0)) {
//            var qnum = this.questionNumbers[i];
//            this.answeredQuestions.push(qnum);
//            var elDiv = "<h1>Q" + qnum + "</h1><div id='Q" + qnum + "Chart' class='elementChartDiv' style='height:600px; width:800px' > </div>";
//            $('#elementCharts').append(elDiv);
//        }
//    }
//};
//
//


//fin
//});