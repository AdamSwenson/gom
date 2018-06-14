// import Vue
//     from "../../../../../../../../Library/Preferences/PhpStorm2018.1/javascript/extLibs/http_github.com_DefinitelyTyped_DefinitelyTyped_raw_master_vue_vue";

import Vue from 'vue';
/**
 * Takes the totalScores array
 * and returns a new sorted array
 * @param totalScores
 * @returns {Array}
 */
export const sortTotalScores = ( totalScores, ascending = true ) => {
    let newList = [];

    _.forEach( totalScores, function ( score ) {
        //Get the index of where it should go
        let idx = _.sortedIndex( newList, score );
        //push it into the new array
        newList.splice( idx, 0, score );
    } );

    if ( !ascending ) newList = _.reverse( newList );

    return newList;
}
/**
 * Sorts the grade assignments object
 * by calc value and returns an array of assignments
 * in the selected sort order
 *
 * @param gradeAssignments
 * @param ascending
 */
export const sortGradeAssignments = ( gradeAssignments, ascending = true ) => {
    return (function ( gradeAssignments, ascending ) {

        let list = [];

        _.forEach( gradeAssignments, function ( assign ) {
            //Get the index of where it should go
            let idx = _.sortedIndexBy( list, assign, 'calcValue' );
            //push it into the new array
            list.splice( idx, 0, assign );
        } );

        if ( !ascending ) list = _.reverse( list );

        return list;
    })( gradeAssignments, ascending )
}
/**
 * Looks up the appropriate grade assignment for a given score
 * @param gradeAssignments
 * @param score
 */
export const gradeGetterForScore = ( gradeAssignments, score ) => {
    return (function ( gradeAssignments, score ) {
        let assignments = sortGradeAssignments( gradeAssignments, false );

        for (var j = 0; j < assignments.length; j++) {
            let assign = assignments[ j ];

            if ( score >= assign.minScore ) {
                //if the score clears the cut off,
                // add the calc value to the list
                return assign;
//                list.push( assign.calcValue );
                //once we've recorded it, we skip to the next score
            }
        }
    })( gradeAssignments, score )
}
/**
 * Checks whether the grade assignments are consistent.
 * If any grade assignment has a higher minimum score
 * than the next lowest grade assignment, this will
 * push it into state.inconsistent
 *
 * @param state
 */
export const updateInconsistentList = ( state ) => {
    let inconsistent = [];
    // let sortedAssignments = sortGradeAssignments(state.gradeAssignments);
    // let assignments = _.values( sortedAssignments  );
    let assignments = _.values( state.gradeAssignments );
    assignments = _.sortBy( state.gradeAssignments, 'ordinal' );
    for (let i = 0; i < assignments.length - 1; i++) { //note that we need to stop before the last one (F)
        let current = assignments[ i ];
        let nextLower = assignments[ i + 1 ];
        if ( nextLower.minScore > current.minScore ) inconsistent.push( current );
    }
    Vue.set( state, 'inconsistent', inconsistent );
};