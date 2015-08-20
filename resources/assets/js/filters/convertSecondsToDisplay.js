/**
 * Created by adam on 8/14/15.
 */
//module.exports = function(seconds) {
    Vue.filter('convertTime', function (seconds){

    var seconds = Number(seconds);
    var result = timeFormat(seconds);
    window.console.log(result);
    return result;
    });

    //var numhours = Math.floor(((seconds % 31536000) % 86400) / 3600);
    //window.console.log(numhours);
    //var numminutes = Math.floor((((seconds % 31536000) % 86400) % 3600) / 60);
    //window.console.log(numminutes);
    //var numseconds = (((seconds % 31536000) % 86400) % 3600) % 60;
    //return numhours + ":" + numminutes + ":" + numseconds;
    //


    /**
     * Converts seconds to minutes for display
     * @param {Number} elapsedTime The time to be converted in seconds
     * @returns {Number}
     * @testExists True
     */
    function secondsToMinutes(elapsedTime) {
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
    function unitChooser(elapsedTime) {
        var unit = '';
        if (elapsedTime < 60) {
            unit = 'Sec';
        }
        else if (elapsedTime >= 60) {
            unit = 'Min';
        }
        return unit;
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

//}

