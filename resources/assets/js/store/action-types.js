/**
 * Created by adam on 1/10/17.
 */

//parent.actions
// these are actions which involve multiple modules
// they are described in actions.js
export const createExam = 'createExam';
export const updateExam = 'updateExam';
export const createItem = 'createItem';

export const addStudent = 'addStudent';

//activeexam
export const setActiveExam = 'setActiveExam';
export const clearActiveExam = 'clearActiveExam';

//activestudent
export const setActiveStudent = 'setActiveStudent';
export const setActiveStudentId = 'setActiveStudentId';
export const setActiveStudentIndex = 'setActiveStudentIndex';
export const setActiveStudentObject = 'setActiveStudentObject';
export const setActiveStudentTime = 'setActiveStudentTime';
export const setIndex = 'setIndex';
export const setId = 'setId';
export const setTime = 'setTime';
export const setStudentObject = 'setStudentObject';
export const clearActiveStudent = 'clearActiveStudent';

//comments
export const storeCommentTextForActiveStudent = 'storeCommentTextForActiveStudent';
export const storeCommentText = 'storeCommentText';

//escores
export const setElementScore = 'setElementScore';
export const loadElementScores = 'loadElementScores';
export const storeElementScoreForActiveStudent = 'storeElementScoreForActiveStudent';

//exams
export const addNewExam = 'addNewExam';
export const loadExams = 'loadExams';


//grades
export const loadExamGrades = 'loadExamGrades';
export const loadStandardGrades = 'loadStandardGrades';
export const updateExamGrade = 'updateExamGrade';

//qscores
export const loadQuestionScores = 'loadQuestionScores';
export const setQuestionScore = 'setQuestionScore';
export const storeQuestionScoreForActiveStudent = 'storeQuestionScoreForActiveStudent';


//questions
export const loadMaxQuestionScores = 'loadMaxQuestionScores';
export const loadQuestions = 'loadQuestions';
export const loadNumberQuestions = 'loadNumberQuestions';
export const addQuestion = 'addQuestion';

//students
export const loadStudents = 'loadStudents';


//times
export const storeGradingTime = 'storeGradingTime';
export const increaseActiveStudentGradingTime = 'increaseActiveStudentGradingTime';
export const incrementGradingTime = 'incrementGradingTime';
export const loadGradingTimes = 'loadGradingTimes';


//items
export const deleteItem = 'deleteItem';
export const addNewItem = 'addNewItem';
export const loadItems = 'loadItems';
export const updateItemName = 'updateItemName';
export const promoteItem = 'promoteItem';
export const demoteItem = 'demoteItem';
export const cleanupItems = 'cleanupItems';
export const toggleItemPublic = 'toggleItemPublic';
export const addOlderSibling = 'addOlderSibling';
export const addYoungerSibling = 'addYoungerSibling';
export const onUpdate = 'onUpdate';
export const addItemToOrder = 'addItemToOrder';
export const removeItemFromOrder = 'removeItemFromOrder';