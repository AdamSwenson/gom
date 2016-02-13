var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );

var common = require( '../common.js' );


var examScores = strExamScores.map(Number);
examScores.sort(function (a, b) {
    return a - b
});

// when scores are changed, update grade assignments and draw charts
$('input').change(function () {
    if ($(this).val() > examMaxScore) {
        $(this).val(examMaxScore);
    }

    if ($(this).val() < 0) {
        $(this).val(0);
    }
    updateGradeFrequency();
    updateScoreChartData();
    drawCharts();
});

function updateGradeFrequency() {
    // Update gradeCutoffs
    gradeCutoffs = [];
    $('[id^="gradeGroup"]').each(function () {
        gradeCutoffs.push($(this).val());
    });

    // calculate frequency that each letter grade appears.
    // this array is reversed, with gradeFrequency[0] = F, so the table shows grades in the expected ASC order
    gradeFrequency = [];
    examScores.forEach(function (score, i) {
        for (var j = 0; j < gradeCutoffs.length; j++) {
            if (score >= gradeCutoffs[j]) {
                if (gradeFrequency[j])
                    gradeFrequency[j]++;
                else
                    gradeFrequency[j] = 1;
                break;
            }
        }
    });

    freqChartData = [];
    gradeFrequency.forEach(function (freq, i) {
        var barColor = getColorForGrade(gradeCutoffs[i]);
        freqChartData.push([gradeTypes[i], freq, barColor]);
    });
    freqChartData.push(['Grade', 'Frequency', {role: 'style'}]);
    // now reverse the chart data so that "F" is the first column and A+ the furthest right
    freqChartData.reverse();

}

// rebuild scoreChartData with new color values based on current grade cutoffs
function updateScoreChartData() {
    scoreChartData = [];
    scoreChartData.push(['Student', 'Score', {role: 'style'}, {role: 'annotation'}]);

    examScores.forEach(function (score, i) {
        var barColor = getColorForGrade(score);
        var gradeLetter = getLetterForGrade(score);
        scoreChartData.push([(i + 1).toString(), score, '#' + barColor, gradeLetter]);
    });
}

// returns grade letter -- this is shoddy because it does the same loop as getColorForGrade.
function getLetterForGrade(score) {
    for (var i = 0; i < gradeCutoffs.length; i++) {
        if (score >= parseFloat(gradeCutoffs[i])) {
            return gradeTypes[i];
        }
    }
}

// returns hex color -- alg is arbitrary, but needs to have enough variation from one grade group to the next
function getColorForGrade(score) {
    var gradeGroup = 0;
    for (var i = 0; i < gradeCutoffs.length; i++) {
        if (score >= parseFloat(gradeCutoffs[i])) {
            gradeGroup = i;
            break;
        }
    }
    var c1 = "00FF00"; // base color is pure green
    var colorWidth = 4096;
    var color = (colorWidth * gradeGroup);
    var c2 = color.toString(16); // amount to add to base
    return addHexColor(c1, c2, false); // subtract 1000 hex for each grade group
}

// adds c1 to c2. if 'add' is false, values are subtracted
function addHexColor(c1, c2, add) {
    if (add) {
        var hexStr = (parseInt(c1, 16) + parseInt(c2, 16)).toString(16);
    } else {
        var hexStr = (parseInt(c1, 16) - parseInt(c2, 16)).toString(16);
    }
    while (hexStr.length < 6) {
        hexStr = '0' + hexStr;
    }
    return hexStr;
}

// do these 2 on page load
updateGradeFrequency();
updateScoreChartData();

// load and display charts when ready
google.load("visualization", "1.1", {packages: ['corechart', 'bar']});
google.setOnLoadCallback(drawCharts);

function drawCharts() {
    drawFrequencyChart();
    drawScoresChart();
}

// displays the grade frequency chart
function drawFrequencyChart() {
    var data = google.visualization.arrayToDataTable(freqChartData);

    var options = {
        chart: {title: 'Grade Distribution'},
        vAxis: {title: 'Count', format: '#'},
        hAxis: {title: 'Grade'},
        chartArea: {'width': '80%', 'height': '70%'},
        legend: {position: 'none'},
        animation: {
            duration: 600,
            startup: "true"
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('gradeFreqChart'));
    chart.draw(data, options);
}

// displays the bar chart of student scores
function drawScoresChart() {
    var data = google.visualization.arrayToDataTable(scoreChartData);

    var options = {
        chart: {title: 'Student Grades'},
        vAxis: {title: 'Score'},
        hAxis: {title: 'Student #'},
        chartArea: {'width': '80%', 'height': '70%'},
        legend: {position: 'none'},
        animation: {
            duration: 600,
            startup: "true"
        }
    };

    var chart = new google.visualization.ColumnChart(document.getElementById('scoreChart'));

    chart.draw(data, options);
}