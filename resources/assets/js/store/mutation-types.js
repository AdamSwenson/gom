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
export const setElementComment = 'setElementComment';
export const loadElementComments = 'loadElementComments'
export const loadStockComments = 'loadStockComments'



//grade.escores
export const loadElementScores = 'loadElementScores'
export const setElementScore = 'setElementScore'


//grade.grades
export const populateExamGrades = 'populateExamGrades'
export const populateStandardGrades = 'populateStandardGrades'
export const setGrade = 'setGrade'

//grade.qscores
export const populateQuestionScores = 'populateQuestionScores'
export const storeQuestionScore = 'storeQuestionScore'


//grade.questions
export const populateQuestions = 'populateQuestions'
export const populateMaxQuestionScores = 'populateMaxQuestionScores'
export const setQuestion = 'setQuestion'

//grade.students
export const populateStudents = 'populateStudents'
export const setStudent = 'setStudent'

//grade.times
export const loadGradingTimes = 'loadGradingTimes'
export const increaseStudentGradingTime = 'increaseStudentGradingTime'


export const addGradingTime = 'addGradingTime'
export const removeGradingTime = 'removeGradingTime'

export const setExam = 'setExam';