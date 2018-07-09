/**
 * Created by adam on 1/10/17.
 */
/**
 * https://vuex.vuejs.org/en/mutations.html
 * It is a commonly seen pattern to use constants for mutation types in various Flux implementations. This allow the code to take advantage of tooling like linters, and putting all constants in a single file allows your collaborators to get an at-a-glance view of what mutations are possible in the entire application:
 Whether to use constants is largely a preference - it can be helpful in large projects with many developers, but it's totally optional if you don't like them.

 * @type {string}
 */

// ------------------------------ New grading


//active exam
export const setActiveExam = 'setActiveExam';
export const clearActiveExam = 'clearActiveExam'
export const updateActiveExamProp = 'updateActiveExamProp'

//activestudent
export const setActiveStudent = 'setActiveStudentNew'
export const clearActiveStudent = 'clearActiveStudent'
export const setActiveStudentTime = 'setActiveStudentTimeNew'
export const startExamTimer = 'startExamTimer';
export const stopExamTimer = 'stopExamTimer';

//preferences for grading
export const toggleGradedStudentRowVisibility = 'toggleGradedStudentRowVisibility';
export const toggleStudentNameVisibility = 'toggleStudentNameVisibility';
export const loadExams = 'loadExams';
export const updateGradingPreference = 'updateGradingPreference';

//preferences for setup
export const updateSetupPreference = 'updateSetupPreference';

//preferences for user and account
export const updateUserPreference = 'updateUserPreference';

//times
export const incrementGradingTime = 'incrementGradingTime';
export const setGradingTime = 'setGradingTime';
export const removeGradingTime = 'removeGradingTime';
export const resetGradingTime = 'resetGradingTime';


export const setExam = 'setExam';



//Initialization
export const loadInitialData = 'loadInitialData';


//scores
export const createScore = 'createScore';
export const updateScore = 'updateScore';
export const updateText = 'updateText';

export const setItemScore = 'setItemScore';
export const removeItemScore = 'removeItemScore';

export const loadTotalScores = 'loadTotalScores';


//time
export const updateStudentGradingTime = 'updateStudentGradingTime';