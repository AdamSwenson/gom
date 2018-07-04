//This has to be required by the individual test cases
//so that webpack will properly import everything

global.factories = require('./helpers/factories');
global.helpers = require('./helpers/test-helpers');
global.assertions = require('./helpers/assertions');

//really commonly used stuff
global.assertExpectedDivIsDisplayed = global.assertions.assertExpectedDivIsDisplayed;
//these were imported directly in many older tests, this make it easier
global.testAction = helpers.testAction;
global.description = helpers.description;


//Overly explict imports.... thought would solve a problem due to something else
import * as gTypes from '../../resources/assets/js/store/getter-types';
global.gTypes = gTypes;

import * as nggTypes from '../../resources/assets/js/store/new-grading-getter-types';
global.nggTypes = nggTypes;

import * as aTypes from '../../resources/assets/js/store/action-types';
global.aTypes =aTypes;

import * as ngaTypes from '../../resources/assets/js/store/new-grading-action-types';
global.ngaTypes = ngaTypes;

import * as mTypes from "../../resources/assets/js/store/mutation-types";
global.mTypes = mTypes;

import * as ngmTypes from "../../resources/assets/js/store/new-grading-mutation-types";
global.ngmTypes = ngmTypes;

//models
import Payload from '../../resources/assets/js/models/Payload';
global.Payload = Payload; //doing it this way somehow helps it be available to tests

import Node from '../../resources/assets/js/models/Node';
global.Node = Node;

import Comment from '../../resources/assets/js/models/Comment';
global.Comment = Comment;

// global.Payload = require('../../resources/assets/js/models/Payload');
global.Exam = require('../../resources/assets/js/models/Exam');

global.Student = require('../../resources/assets/js/models/Student');
global.Item = require('../../resources/assets/js/models/Item');
