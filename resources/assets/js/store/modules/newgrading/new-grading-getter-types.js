/**
 * Created by adam on 3/21/17.
 */



// ================================================================
// ======================= GRADING PREFERENCES ====================
// ================================================================
export const areStudentNamesVisible = 'areStudentNamesVisible';


//Grading a student's exam
export const getExamId = 'getExamId'
export const isActive = 'isActive'
export const getNumberGraded = 'getNumberGraded'
export const getTotalExams = 'getTotalExams'
export const getQuestionScoreForActiveStudent = 'getQuestionScoreForActiveStudent'
export const getCommentTextForActiveStudent = 'getCommentTextForActiveStudent'
export const getExamGradeForActiveStudent = 'getExamGradeForActiveStudent'
export const getElementScoreForActiveStudent = 'getElementScoreForActiveStudent'

//time
export const getActiveStudentGradingTime = 'getActiveStudentGradingTimeNew'
export const isTimerRunning = 'isTimerRunning';
export const getActiveStudent = 'getActiveStudentNew';


// ================================================================
// ==================================== EXAMS =====================
// ================================================================
export const getExam = 'getExam'
export const getAllExams = 'getAllExams'
export const getActiveExam = 'getActiveExam'

// ================================================================
// ==================================== ITEMS =====================
// ================================================================

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

 /**
 * Returns the item object. See original for
 * parameters
 * @type {string}
 */
export const getItem = 'getItem'

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
export const getItemBySerialNumber = 'getItemBySerialNumber'

export const getItemCount = 'getItemCount'
export const getStudentCount = 'getStudentCount'
export const getKumiCount = 'getKumiCount'
export const getKumiCountForExam = 'getKumiCountForExam'

/**
 * Returns a node from the itemMap by serial number
 * @type {string}
 */
export const getItemNodeFromOrder = 'getItemNodeFromOrder'

//Node properties
export const getHeightOfNode = 'getHeightOfNode';
export const getDepthOfNode = 'getDepthOfNode';

/**
 * Returns a copy of the itemMap.
 * The copy shouldn't be reactive.
 * This will be a Node instance representing
 * the exam with all the questions and elements in
 * children properties
 * @type {string}
 */
export const getItemMapCopy = 'getItemMapCopy'

//Visibility settings
export const isItemSettingsVisible = 'isItemSettingsVisible'
export const isExamSettingsVisible = 'isExamSettingsVisible';

/**
 * Translates the current map of items into
 * a map with the database ids set as data on the
 * nodes.
 * This is the object which will be sent to sync
 * with the server.
 * @type {string}
 */
export const getSortedIds = 'getSortedIds'

/* ================================================================
   ================== GRADE ASSIGNMENTS       =====================
   ================================================================ */
export const getCutOffsForLetterGrade = 'getCutOffsForLetterGrade';
export const getGradeAssignments = 'getGradeAssignments';
export const getGradeAssignmentsInSortedList ='getGradeAssignmentsInSortedList';
export const getTotalScores = 'getTotalScores';
export const getGradeFrequencies = 'getGradeFrequencies';
export const getGradeAssignmentForScore = 'getGradeAssignmentForScore';
export const getMaxPossibleScore = 'getMaxPossibleScore';
export const getInconsistentCutOffs = 'getInconsistentCutOffs';
export const getListOfGradeValues = 'getListOfGradeValues';