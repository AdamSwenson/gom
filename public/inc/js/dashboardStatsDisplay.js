/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

/*****************************************************DASHBOARD ***********************************************************/

/**
 * Parent class for all statistics display functions
 * 
 * @returns {undefined}
 */
function StatsDisplay() {
    this.data = '';
}

/**
 * Defines interface for StatsData child objects
 * @param {type} StatsData
 * @returns {Boolean}
 */
StatsDisplay.prototype.draw = function (StatsData) {
    return true;
};


/**
 * Load the stored statistics to the statsTemp template
 * @returns {undefined}
 */
function DisplayOverallStats() {
    
    this.draw = function (StatsData) {
        window.console.log('DisplayOverallStats');
        this.data = StatsData;
        if(this.data){
        try {
            $("#statsTemp").tmpl(this.data).appendTo("#statisticsHere");
        } catch (err) {
            window.console.log('displayOverallStats', err);
        }
    }
    };
}

/**
 * Makes the completion stats gauge after data has been loaded
 * @returns {undefined}
 */
function MakeCompletionStatsGauge() {
    
    this.draw = function (StatsData) {
        window.console.log('MakeCompletionStatsGauge');
        this.data = StatsData;
        if (this.data) {
            try {

                $('#pctCompleteHere').empty();
                $('#completedHere').empty();
                var title = 'Graded: ' + this.data.numGraded + ' || ' + 'Remaining: ' + this.data.examsUngraded;
                var options = {
                    label: this.data.pctComplete + '%',
                    min: 0,
                    max: 100,
                    ticks: [0, 20, 40, 60, 80, 100]
                };
                var gauge = $.jqplot('pctCompleteHere', [[this.data.pctComplete]], {
                    title: title,
                    animate: true,
                    animateReplot: true,
                    seriesDefaults: {
                        renderer: $.jqplot.MeterGaugeRenderer,
                        rendererOptions: options
                    }
                });
            } catch (err) {
                window.console.log('completionStatsGauge', err);
            }
        }
    };
}
;

function MakeSpeedGauge() {
    
    this.draw = function (StatsData) {
        window.console.log('MakeSpeedGauge');
        this.data = StatsData;
        if (this.data) {
            try {
                this.chart = $.jqplot('speedGauge', [[this.data.lastExamPPM]], {
                    title: 'PPM',
                    animate: true,
                    animateReplot: true,
                    seriesDefaults: {
                        renderer: $.jqplot.MeterGaugeRenderer,
                        rendererOptions: {
                            min: 0,
                            max: 3,
                            ticks: [0, .5, 1, 1.5, 2, 2.5, 3]
                        }
                    }
                });
            } catch (err) {
                window.console.log('speedGauge error', err);
            }
        }
    };
}
;

/**
 * This makes the speed trend chart after the pagePerMin data has been loaded into this.ppmData
 * @returns {undefined}
 */
function MakeSpeedTrendChart() {
    
    this.draw = function (StatsData) {
        window.console.log("MakeSpeedTrendChart");
        this.data = StatsData;
        if (this.data) {
            try {
                $('#speedChart').empty();
                var plot1 = $.jqplot('speedChart', [this.data.ppmData], {
                    title: 'pages per minute',
                    xaxis: {
                        show: false,
                        showLabel: false
                    }
                });
            } catch (err) {
                window.console.log('speedTrendChart error', err);
            }
        }
    };
}
;