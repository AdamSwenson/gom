/**
 * Created by adam on 1/10/17.
 */
/**
 * https://vuex.vuejs.org/en/mutations.html
 * It is a commonly seen pattern to use constants for mutation types in various Flux implementations. This allow the code to take advantage of tooling like linters, and putting all constants in a single file allows your collaborators to get an at-a-glance view of what mutations are possible in the entire application:
 Whether to use constants is largely a preference - it can be helpful in large projects with many developers, but it's totally optional if you don't like them.

 * @type {string}
 */


//active exam
export const setActiveExam = 'setActiveExam';
export const clearActiveExam = 'clearActiveExam'
export const updateActiveExamProp = 'updateActiveExamProp'

//activestudent
export const setActiveStudent = 'setActiveStudent'
export const clearActiveStudent = 'clearActiveStudent'
export const setActiveStudentTime = 'setActiveStudentTime'


//comments
export const setElementComment = 'setElementComment';
export const loadElementComments = 'loadElementComments'
export const loadStockComments = 'loadStockComments'


//exams
export const addExam = 'addExam';

export const addIndexMapping = 'addIndexMapping';
export const loadExams = 'loadExams';

//escores
export const loadElementScores = 'loadElementScores';
export const setElementScore = 'setElementScore';


//kumi
export const  updateKumi = 'updateKumi';

//grades
export const loadExamGrades = 'loadExamGrades';
export const loadStandardGrades = 'loadStandardGrades';
export const setGrade = 'setGrade';

//qscores                                                            ;
export const setQuestionScore = 'setQuestionScore';
export const removeQuestionScore = 'removeQuestionScore';

//questions                                                          ;
export const setMaxQuestionScore = 'setMaxQuestionScore';
export const removeMaxQuestionScore = 'removeMaxQuestionScore';
// export const loadMaxQuestionScores = 'loadMaxQuestionScores'      ;
export const setQuestion = 'setQuestion';
export const removeQuestion = 'removeQuestion';
export const setNumberQuestions = 'setNumberQuestions';

//students
export const setStudent = 'setStudent';
export const removeStudent = 'toggleRemoveControls';
//dev
export const updateStudent = 'updateStudent';
export const addStudentToRoster = 'addStudentToRoster';

//times
export const incrementGradingTime = 'incrementGradingTime';
export const setGradingTime = 'setGradingTime';
export const removeGradingTime = 'removeGradingTime';
export const resetGradingTime = 'resetGradingTime';


export const setExam = 'setExam';


//items
export const addNewItem = 'addNewItem';
export const setItem = 'setItem';
export const addItemIndexMapping = 'addItemIndexMapping';
export const loadItems = 'loadItems';
export const updateOrder = 'updateOrder';

//item.order
export const insertNodeIntoOrder = 'insertNodeIntoOrder';
export const removeNodeFromOrder = 'removeNodeFromOrder';

export const updateItemName = 'updateItemName';
export const updateItem = 'updateItem';
export const updateItemSilently = 'updateItemSilently';
export const setItemNameByIndex = 'setItemNameByIndex';
// export const updateItemNameByIndex = 'updateItemNameByIndex'

export const updateComment = 'updateComment';

//settings
export const toggleDeleteButtonVisibility = 'toggleDeleteButtonVisibility';
export const toggleReorderMode = 'toggleReorderMode';
export const toggleSampleFeedback = 'toggleSampleFeedback';

//item settings
export const showItemSettings = 'showItemSettings';
export const hideItemSettings = 'hideItemSettings';
export const toggleExamSettings = 'toggleExamSettings';

