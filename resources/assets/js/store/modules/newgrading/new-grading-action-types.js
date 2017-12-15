/**
 * Created by adam on 1/10/17.
 */

//parent.actions

//activeexam -- which exam is being graded, set up, et cetera
export const setExamAsActive = 'setExamAsActive';
export const resetActiveExam = 'resetActiveExam';

//activestudent -- which student is being graded, reviewed, et cetera
export const setStudentAsActive = 'setStudentAsActive';
export const resetActiveStudent = 'resetActiveStudent';

export const setActiveStudentTime = 'setActiveStudentTime';


//comments
export const storeCommentTextForActiveStudent = 'storeCommentTextForActiveStudent';
export const storeCommentText = 'storeCommentTextNew';

//scores
// export const storeItemScore = 'storeItemScore';


//exams
export const addNewExam = 'addNewExam';
export const loadExams = 'loadExams';


//grades
export const loadExamGrades = 'loadExamGrades';
export const loadStandardGrades = 'loadStandardGrades';
export const updateExamGrade = 'updateExamGrade';




//grade assignments
export const updateCutoff = 'updateCutoff';
export const loadGradeAssignmentsFromServerData = 'loadGradeAssignmentsFromServerData';



//questions
// export const loadMaxQuestionScores = 'loadMaxQuestionScores';
// export const loadQuestions = 'loadQuestions';
// export const loadNumberQuestions = 'loadNumberQuestions';
// export const addQuestion = 'addQuestion';
//
// //roster and kumi
// export const handleNewStudentStorageAndAssociation = 'handleNewStudentStorageAndAssociation';


//students
export const loadStudents = 'loadStudents';


//times
export const storeGradingTime = 'storeGradingTime';
export const increaseActiveStudentGradingTime = 'increaseActiveStudentGradingTime';
export const incrementGradingTime = 'incrementGradingTime';
export const loadGradingTimes = 'loadGradingTimes';


export const startExamTimer = 'startExamTimer';
export const stopExamTimer = 'stopExamTimer';