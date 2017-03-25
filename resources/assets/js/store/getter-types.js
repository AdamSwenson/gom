/**
 * Created by adam on 3/21/17.
 */


//Defined in getters (though the names there do not use the constants)
//Exam
export const getExamId = 'getExamId'
export const isActive = 'isActive'
export const getNumberGraded = 'getNumberGraded'
export const getTotalExams = 'getTotalExams'
export const getQuestionScoreForActiveStudent = 'getQuestionScoreForActiveStudent'
export const getActiveStudentGradingTime = 'getActiveStudentGradingTime'
export const getCommentTextForActiveStudent = 'getCommentTextForActiveStudent'
export const getExamGradeForActiveStudent = 'getExamGradeForActiveStudent'
export const getElementScoreForActiveStudent = 'getElementScoreForActiveStudent'


//Exam(s)
export const getExam = 'getExam'
export const getAllExams = 'getAllExams'
export const getActiveExamObj = 'getActiveExamObj'

//items
export const getItemCount = 'getItemCount'

export const getItem = 'getItem'
/**
 * Returns the item object residing at the
 * given index in the list.
 * This does not guarantee
 * that the item.index property will equal the
 * list index. That could happen if updateOrder has not
 * yet run.
 * @param state
 * @param getters
 * @param rootState
 * @param index
 */
export const getItemByIndex = 'getItemByIndex'

/**
 * Returns the item object with the given id.
 * This is the preferred way of looking up objects.
 * It is immutable across re-sorting and corresponds with
 * the stored db value.
 * Getting an object by this does not guarantee
 * that the item.index property will equal the
 * list index. That could happen if updateOrder has not
 * yet run.
 * @param state
 * @param getters
 * @param rootState
 * @param index
 */
export const getItemById = 'getItemById'

/**
 * Returns list of items objects
 * @param state
 * @param getters
 * @param payload
 * @returns []
 */
export const getAllItems = 'getAllItems'

export const getAllIndexesList = 'getAllIndexesList'

/**
 * Return list of Item objects
 * @param state
 * @param getters
 * @param payload
 * @returns []
 */
export const getAllItemsList = 'getAllItemsList'

//Visibility settings
export const isItemSettingsVisible = 'isItemSettingsVisible'
export const isExamSettingsVisible = 'isExamSettingsVisible'