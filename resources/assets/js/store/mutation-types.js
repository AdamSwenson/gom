/**
 * Created by adam on 1/10/17.
 */
/**
 * https://vuex.vuejs.org/en/mutations.html
 * It is a commonly seen pattern to use constants for mutation types in various Flux implementations. This allow the code to take advantage of tooling like linters, and putting all constants in a single file allows your collaborators to get an at-a-glance view of what mutations are possible in the entire application:
 Whether to use constants is largely a preference - it can be helpful in large projects with many developers, but it's totally optional if you don't like them.

 * @type {string}
 */

//grade.activestudent
export const setIndex = 'setIndex'
export const setId = 'setId'
export const setTime = 'setTime'
export const setStudentObject  = 'setStudentObject'

//grade.comments
export const loadElementComments = 'loadElementComments'
export const loadStockComments = 'loadStockComments'
export const storeCommentText = 'storeCommentText'
export const storeCommentTextForActiveStudent = 'storeCommentTextForActiveStudent'

//grade.escores
export const loadElementScores = 'loadElementScores'
export const storeElementScore = 'storeElementScoreForActiveStudent'
export const storeElementScoreForActiveStudent = 'storeElementScoreForActiveStudent'

//grade.grades
export const loadExamGrades = 'loadExamGrades'
export const loadGrades = 'loadGrades'
export const _setExamGrade = 'loadGrades'

//grade.qscores
export const loadQuestionScores = 'loadQuestionScores'
export const storeQuestionScore = 'storeQuestionScore'
export const storeQuestionScoreForActiveStudent = 'storeQuestionScoreForActiveStudent'

//grade.questions
export const loadMaxQuestionScores = 'loadMaxQuestionScores'
export const loadQuestions = 'loadQuestions'
export const loadNumberQuestions = 'loadNumberQuestions'

//grade.students
export const loadStudents = 'loadStudents'

//grade.times
export const storeStudentGradingTime = 'storeStudentGradingTime'
export const loadGradingTimes = 'loadGradingTimes'
export const increaseStudentGradingTime = 'increaseStudentGradingTime'
export const increaseActiveStudentGradingTime = 'increaseActiveStudentGradingTime'

export const addGradingTime = 'addGradingTime'
export const removeGradingTime = 'removeGradingTime'

export const setExam = 'setExam';