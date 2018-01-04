/**
 * Created by adam on 3/21/17.
 */




//Grading a student's exam
export const getExamId = 'getExamId'
export const isActive = 'isActive'

//counts
export const getNumberGraded = 'getNumberGradedNew'
export const getTotalExams = 'getTotalExamsNew'
export const getNumberExamsRemaining = 'getNumberExamsRemainingNew'
export const getAllItemScores = 'getAllItemScores';

export const getQuestionScoreForActiveStudent = 'getQuestionScoreForActiveStudent'
export const getCommentTextForActiveStudent = 'getCommentTextForActiveStudent'
export const getExamGradeForActiveStudent = 'getExamGradeForActiveStudent'
export const getElementScoreForActiveStudent = 'getElementScoreForActiveStudent'



// ================================================================
// ==================================== EXAMS =====================
// ================================================================
export const getExam = 'getExam';
export const getAllExams = 'getAllExams';
export const getActiveExam = 'getActiveExamNew';

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
// export const getCutOffsForLetterGrade = 'getCutOffsForLetterGrade';
// export const getGradeAssignments = 'getGradeAssignments';
// export const getGradeAssignmentsInSortedList ='getGradeAssignmentsInSortedList';
// export const getTotalScores = 'getTotalScores';
// export const getGradeFrequencies = 'getGradeFrequencies';
// export const getGradeAssignmentForScore = 'getGradeAssignmentForScore';
// export const getMaxPossibleScore = 'getMaxPossibleScore';
// export const getInconsistentCutOffs = 'getInconsistentCutOffs';
// export const getListOfGradeValues = 'getListOfGradeValues';



/* ================================================================
   ================== PREFERENCES -- GRADE    =====================
   ================================================================ */
export const areGradedStudentRowsVisible = 'areGradedStudentRowsVisible';
export const areStudentNamesVisible = 'areStudentNamesVisible';
export const isLetterGradeButtonUsed = 'isLetterGradeButtonUsed';
export const isSliderUsed = 'isSliderUsed';
export const isScoreDisplayed = 'isScoreDisplayed';
export const shouldDynamicallyCollapseCommentAreas = 'shouldDynamicallyCollapseCommentAreas';
export const getGradingPreference = 'getGradingPreference';

/* ================================================================
   ================== PREFERENCES -- SETUP    =====================
   ================================================================ */
export const getSetupPreferences = 'getSetupPreferences';
export const getSetupPreference = 'getSetupPreference';
/* ================================================================
   ================== PREFERENCES -- USER    =====================
   ================================================================ */
export const getUserPreferences = 'getUserPreferences';
export const getUserPreference = 'getUserPreference';



/* ================================================================
   ================== SCORES        =====================
   ================================================================ */
export const getItemScoreObject =  'getItemScoreObject';
export const getTotalScoreForStudent = 'getTotalScoreForStudent';
export const getGradedStudentIds = 'getGradedStudentIds';

/* ================================================================
   ================== TIMES        =====================
   ================================================================ */
export const getTotalGradingTime = 'getTotalGradingTimeNew';
export const getAverageGradingTime = 'getAverageGradingTimeNew';
export const getRemainingGradingTime = 'getRemainingGradingTimeNew';
export const getActiveStudentGradingTime = 'getActiveStudentGradingTimeNew'
export const isTimerRunning = 'isTimerRunning';
export const getActiveStudent = 'getActiveStudentNew';
