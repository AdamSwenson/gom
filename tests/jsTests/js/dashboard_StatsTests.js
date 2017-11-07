/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


module('StatsData Data handlers for stats ajax', {
    setup: function () {
        var st = new StatsData();
        var formatter = new Formatter();
        st.setFormatter(formatter);
    }
});
test('receiveAveragePPM', function () {
    var goodvalue = 44.4;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receiveAveragePPM(goodvalue);
    equal(st.avgPPM, goodvalue, "AveragePPM processes incoming correctly");
});
test('StatsData receiveAverageExam', function () {
    var goodvalue = 120;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receiveAverageExam(goodvalue);
    equal(st.avgExam, 2, "Average exam1 converted to minutes");
});
test('StatsData receiveGradeRemaining', function () {
    var goodvalue = 120;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.receiveGradeRemaining(goodvalue);
    equal(st.gradeRemaining, "00:02", "Stats.receiveGradeRemaining stores 2 when given 120");
});
test('StatsData receiveGradeElapsed', function () {
    var goodvalue = 120;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receiveGradeElapsed(goodvalue);
    equal(st.gradeElapsed, "00:02", "Stats.receiveGradeElapsed stores 2 when given 120");
});

test('StatsData receiveWorkRemaining', function () {
    var goodvalue = 120;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receiveWorkRemaining(goodvalue);
    equal(st.workRemaining, "00:02", "Stats.receiveWorkRemaining stores 2 when given 120");
});

test('StatsData receiveWorkElapsed', function () {
    var goodvalue = 120;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receiveWorkElapsed(goodvalue);
    equal(st.workElapsed, "00:02", "Stats.receiveWorkElapsed stores 2 when given 120");
});
test('StatsData calcPctGrading', function () {
    var gradeElapsed = 100;
    var workElapsed = 200;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.calcPctGrading(gradeElapsed, workElapsed);
    equal(st.pctGrading, 50, "Stats.calcPctGrading returned correct");
});
test('StatsData receivePctComplete', function () {
    var goodvalue = .5;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);

    st.receivePctComplete(goodvalue);
    equal(st.pctComplete, 50, "Stats.receivePctComplete stores 50 when given 0.5");
});
test('StatsData receiveExamsGraded', function () {
    var goodvalue = 50;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.receiveExamsGraded(goodvalue);
    equal(st.numGraded, 50, "Stats.receiveExamsGrade stores 50 when given 50");
});
test('StatsData receiveUngraded', function () {
    var goodvalue = 50;
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.receiveUngraded(goodvalue);
    equal(st.examsUngraded, goodvalue, "Stats.receiveUngraded stores 50 when given 50");
});

test('StatsData receivePPMData', function () {
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    var lastexamppm = "10.10";
    var ppmtest = [{"gradedOrder": "97", "ppm": lastexamppm},
        {"gradedOrder": "23", "ppm": "52.28"},
        {"gradedOrder": "20", "ppm": "18.69"},
        {"gradedOrder": "3", "ppm": "3.56"}];
    st.receivePPMData(ppmtest);
    equal(st.lastExamPPM, lastexamppm, "StatsData.receivePPMData stores correct value as lastExamPPM");
    equal(st.ppmData.length, ppmtest.length, "StatsData.receivePPMData stores correct length array");
});

test('StatsData.processIncoming AveragePPM', function () {
    var testKey = 'AveragePPM';
    var goodvalue = 33.3;
    var testjson = {"data": {"AveragePPM": goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.avgPPM, goodvalue, "AveragePPM processes incoming correctly");
});
test('StatsData.processIncoming avgExam', function () {
    var testKey = 'avgExam';
    var goodvalue = 33.3;
    var testjson = {"data": {"avgExam": goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.avgExam, goodvalue, "avgExam processes incoming correctly");
});
test('StatsData.processIncoming() gradeRemaining', function () {
    var testKey = "gradeRemaining";
    var goodvalue = 120;
    var testjson = {"data": {"gradeRemaining": goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.gradeRemaining, "00:02", "Stats.processIncoming for gradeRemaining  stores 2 when given 120");
});
test('StatsData.processIncoming() gradeElapsed', function () {
    var testKey = 'gradeElapsed';
    var goodvalue = 120;
    var testjson = {"data": {'gradeElapsed': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.gradeElapsed, "00:02", "Stats.processIncoming for gradeElapsed stores 2 when given 120");
});
test('StatsData.processIncoming() workElapsed', function () {
    var testKey = 'workElapsed';
    var goodvalue = 120;
    var testjson = {"data": {'workElapsed': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.workElapsed, "00:02", "Stats.processIncoming for workElapsed stores 2 when given 120");
});
test('StatsData.processIncoming() workRemaining', function () {
    var testKey = 'workRemaining';
    var goodvalue = 120;
    var testjson = {"data": {'workRemaining': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.workRemaining, "00:02", "Stats.processIncoming for workRemaining stores 2 when given 120");
});
test('StatsData.processIncoming() pctComplete', function () {
    var testKey = 'pctComplete';
    var goodvalue = 0.5;
    var testjson = {"data": {'pctComplete': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.pctComplete, 50, "Stats.processIncoming for pctComplete stores 50 when given 0.5");
});
test('StatsData.processIncoming() examsGraded', function () {
    var testKey = 'examsGraded';
    var goodvalue = 50;
    var testjson = {"data": {'examsGraded': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.numGraded, 50, "Stats.processIncoming for examsGraded stores 50 when given 50");
});
test('StatsData.processIncoming() examsUngraded', function () {
    var testKey = 'examsUngraded';
    var goodvalue = 50;
    var testjson = {"data": {'examsUngraded': goodvalue}};
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    st.processIncoming(testjson);
    equal(st.examsUngraded, 50, "Stats.processIncoming for examsUngraded stores 50 when given 50");
});
test('StatsData.processIncoming() ppm', function () {
    var st = new StatsData();
    var formatter = new Formatter();
    st.setFormatter(formatter);
    var lastexamppm = "10.10";
    var testjson = {"data": {"ppm": [{"gradedOrder": "97", "ppm": lastexamppm},
                {"gradedOrder": "23", "ppm": "52.28"},
                {"gradedOrder": "20", "ppm": "18.69"},
                {"gradedOrder": "3", "ppm": "3.56"}]}};
    st.processIncoming(testjson);
    equal(st.lastExamPPM, lastexamppm, "StatsData.processIncoming stores correct value as lastExamPPM");
    equal(st.ppmData.length, testjson.data.ppm.length, "StatsData.processIncoming  stores correct length array");
});

//-----------------------------------------------------******************************************--------------------
module('dashboardStatsScrips.js StatsDisplay Check the display object handling', {
    setup: function () {
        this.object = new StatsData();
        function dummyDisplay() {
            this.called = false;
            this.draw = function (data) {
                this.data = data;
                this.called = true;
            };
        }
        this.display1 = new dummyDisplay();
        this.display2 = new dummyDisplay();
    }
});

test('StatsData.addDisplayManager', function () {
    expect(3);
    this.object.addDisplayManager(this.display1);
    this.object.addDisplayManager(this.display2);
    equal(this.object.displayManagers.length, 2);
    deepEqual(this.object.displayManagers[0], this.display1);
    deepEqual(this.object.displayManagers[1], this.display2);
});

test('StatsData.callDisplayManagers()', function () {
    expect(5);
    this.object.addDisplayManager(this.display1);
    this.object.addDisplayManager(this.display2);
    equal(this.object.displayManagers.length, 2);
    this.object.callDisplayManagers();
    ok(this.display1.called);
    deepEqual(this.display1.data, this.object);
    ok(this.display2.called);
    deepEqual(this.display2.data, this.object);
});

//-----------------------------------------------------******************************************--------------------
module('dashboardStatsScrips.js Formatter Check calculation and formatting utilities', {
    setup: function () {
    }
});
test('Formatter.unitChooser', function () {
    expect(5);
    var formatter = new Formatter();
    QUnit.equal(formatter.unitChooser(0), 'Sec', 'Returns Sec for 0');
    QUnit.equal(formatter.unitChooser(0.11), 'Sec', 'Returns Sec for 0.11');
    QUnit.equal(formatter.unitChooser(1), 'Sec', 'Returns Sec for 1');
    QUnit.equal(formatter.unitChooser(60), 'Min', 'Returns Min for 60');
    QUnit.equal(formatter.unitChooser(100), 'Min', 'Returns Min for 100');
});
test('Formatter.secondsToMinutes', function () {
    expect(6);
    var formatter = new Formatter();
    equal(formatter.secondsToMinutes(0), 0, "Returns 0 for 0");
    equal(formatter.secondsToMinutes(0.1), 0.1, "Returns 0.1 for 0.1");
    equal(formatter.secondsToMinutes(0.1111111), 0.111, "Returns 0.111 for 0.1111111");
    equal(formatter.secondsToMinutes(60), 1, "Returns 1 for 60");
    equal(formatter.secondsToMinutes(65), 1.08, "Returns 1.08 for 65");
    equal(formatter.secondsToMinutes(120), 2, "Returns 2 for 120");
});
test('Formatter.secondsToHours', function () {
    expect(4);
    var formatter = new Formatter();
    equal(formatter.secondsToHours(0), 0, "Returns 0 for 0");
    equal(formatter.secondsToHours(3600), 1, "Returns 1 for 3600");
    equal(formatter.secondsToHours(1800), 0.5, "Returns 0.5 for 1800");
    equal(formatter.secondsToHours(5400), 1.5, "Returns 1.5 for 5400");
});
test('Formatter.addLeadingZero', function () {
    expect(4);
    var formatter = new Formatter();
    equal(formatter.addLeadingZero(0), "00", "Returns 00 for 0");
    equal(formatter.addLeadingZero(5), "05", "Returns 05 for 5");
    equal(formatter.addLeadingZero(10), "10", "Returns 10 for 10");
    equal(formatter.addLeadingZero(15), "15", "Returns 15 for 15");
});
test('Formatter.timeFormat', function () {
    expect(6);
    var formatter = new Formatter();
    equal(formatter.timeFormat(0), "00:00", "Returns 0:0 for 0 ");
    equal(formatter.timeFormat(60), "00:01", "Returns 00:01 for 60 ");
    equal(formatter.timeFormat(120), "00:02", "Returns 00:02 for 120 ");
    equal(formatter.timeFormat(600), "00:10", "Returns 00:10 for 600 ");
    equal(formatter.timeFormat(3600), "01:00", "Returns 01:00 for 3600 ");
    equal(formatter.timeFormat(5400), "01:30", "Returns 01:30 for 5400 ");
});
test('Formatter.calculateElapsedTime', function () {
    var formatter = new Formatter();
    equal(formatter.calculateElapsedTime(1, 1), 0, "Zero elapsed case");
    equal(formatter.calculateElapsedTime(2000, 1000), 1, "1 second elapsed case");
});