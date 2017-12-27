/**
 * Created by adam on 1/10/17.
 */
/**
 * THESE ARE MUTATIONS USED BY THE OLDER VERSION OF THE GOM
 * AND NOT USED BY THE NEW VERSION
 *
 * https://vuex.vuejs.org/en/mutations.html
 * It is a commonly seen pattern to use constants for mutation types in various Flux implementations. This allow the code to take advantage of tooling like linters, and putting all constants in a single file allows your collaborators to get an at-a-glance view of what mutations are possible in the entire application:
 Whether to use constants is largely a preference - it can be helpful in large projects with many developers, but it's totally optional if you don't like them.

 * @type {string}
 */

//escores
export const loadElementScores = 'loadElementScores';
export const setElementScore = 'setElementScore';


//students
export const setStudent = 'setStudent';
export const removeStudent = 'toggleRemoveControls';
export const updateStudent = 'updateStudent';
export const toggleRemoveControls = 'toggleRemoveControls2';

//qscores                                                            ;
export const setQuestionScore = 'setQuestionScore';
export const removeQuestionScore = 'removeQuestionScore';


//times
export const incrementGradingTime = 'incrementGradingTime';
export const setGradingTime = 'setGradingTime';
export const removeGradingTime = 'removeGradingTime';
export const resetGradingTime = 'resetGradingTime';
