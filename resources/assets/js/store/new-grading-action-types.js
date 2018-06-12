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
export const recordCommentText = 'recordCommentTextNew';

//scores
export const recordItemScore = 'recordItemScoreNew';
export const resetItemScore = 'resetItemScore';
export const loadScoresFromServer = 'loadScoresFromServer';

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

//preferences
export const loadUserPreferencesFromServer = 'loadUserPreferencesFromServer';
export const loadSetupPreferencesFromServer = 'loadSetupPreferencesFromServer';
export const loadGradePreferencesFromServer = 'loadGradePreferencesFromServer';


//questions
// export const loadMaxQuestionScores = 'loadMaxQuestionScores';
// export const loadQuestions = 'loadQuestions';
// export const loadNumberQuestions = 'loadNumberQuestions';
// export const addQuestion = 'addQuestion';
//
// //roster and kumi
// export const handleNewStudentStorageAndAssociation = 'handleNewStudentStorageAndAssociation';

//stats and progress (counts of graded)
export const loadGradingProgress = 'loadGradingProgress';

//students
export const loadStudents = 'loadStudents';


//times
export const loadTimesFromServer ='loadTimesFromServer';
export const startExamTimer = 'startExamTimer';
export const stopExamTimer = 'stopExamTimer';
export const incrementGradingTime = 'incrementGradingTime';