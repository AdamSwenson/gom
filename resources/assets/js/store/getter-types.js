/**
 * Created by adam on 3/21/17.
 */

export const getExam = 'getExam'
export const getAllExams = 'getAllExams'

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