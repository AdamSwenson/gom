/**
 * Created by adam on 7/7/17.
 */
import Vue from 'vue';
import * as gTypes from '../../getter-types'
import * as mTypes from '../../mutation-types'
import * as ngmTypes from '../../modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../action-types'
import * as ngaTypes from '../../modules/newgrading/new-grading-action-types';
import * as nggTypes from '../../modules/newgrading/new-grading-getter-types';

import scoreRequests from "../../../api/requests/scoreRequests";

import { isSameValence, getValenceForScore, sliderSettings } from "./commentHelpers";

import PayloadScore from '../../../models/PayloadScore';
import ItemScore from '../../../models/ItemScore';

const state = {
    //Array of Score objects
    scores: []
};

import actions from './itemscores.actions';
import getters from './itemscores.getters';
import mutations from './itemscores.mutations';

export default {
    actions,
    getters,
    mutations,
    state,
}