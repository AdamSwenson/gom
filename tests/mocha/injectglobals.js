//This has to be required by the individual test cases
//so that webpack will properly import everything

global.factories = require('./helpers/factories');
global.helpers = require('./helpers/test-helpers');
global.assertions = require('./helpers/assertions');

//really commonly used stuff
global.assertExpectedDivIsDisplayed = global.assertions.assertExpectedDivIsDisplayed;

global.gTypes = require('../../resources/assets/js/store/getter-types');
global.nggTypes = require('../../resources/assets/js/store/new-grading-getter-types');
global.aTypes = require('../../resources/assets/js/store/action-types');
global.ngaTypes = require('../../resources/assets/js/store/new-grading-action-types');
global.mTypes = require("../../resources/assets/js/store/mutation-types");
global.ngmTypes = require("../../resources/assets/js/store/new-grading-mutation-types");


global.Payload = require('../../resources/assets/js/models/Payload');
