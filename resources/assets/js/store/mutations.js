import * as mTypes from './mutation-types';

//root mutations for vuex instance
// export default  {
// const mutations =
/**
 * Sets the current exam id
 *
 * @todo Extend to set from an exam object
 *
 * @param state
 * @param payload
 */
export const mutations = {

    /**
     * Set the current exam
     * @param state
     * @param payload
     */
    [mTypes.setExam]( state, payload ) {
        if ( Number.isInteger( payload ) ) {
            state.examId = payload;
        }
//other allowed payload types
    }
};
