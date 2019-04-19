/**
 * Created by adam on 12/1/17.
 */

import GradeAssignment from '../../../models/GradeAssignment';
import { sortGradeAssignments } from "./grades.helpers";


import a from './grades.actions';
import g from './grades.getters';
import m from './grades.mutations';

const state = {

    /**
     * This holds the objects defining which scores receive
     * which grades.
     *
     * It is an object with letter grade strings as keys and
     * GradeAssignment objects for its values.
     */
    gradeAssignments: (function () {
        return sortGradeAssignments( GradeAssignment.initialize() );
    })(),

    /**
     * A list of unidentifiable student total scores
     * on the exam.
     */
    totalScores: [],

    /**
     * A list of the calcValues of each grade
     * based on a score and the current distribution.
     * This is used for statistical computations about
     * the grade distribution
     */
    gradeValues: [],

    /**
     * Holds the count of each grade with the GradeAssignment.displayValue
     * as keys.
     * This had to be moved here so it could be updated with every mutation
     * rather than doing it via getter which wasn't responding to changes.
     */
    gradeFrequencies : {},

    /**
     * The list of inconsistent grade assignments are kept here
     *
     */
    inconsistent: []

};


const mutations = {
    ...m
};

const getters = {
    ...g,
};

const actions = {
    ...a,
};

export default {
    actions,
    getters,
    mutations,
    state
}
