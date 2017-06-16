import * as mTypes from './mutation-types';
module.exports = {
//root mutations for vuex instance
// export default  {
// const mutations =


    /**
     * Set the current exam
     * @param state
     * @param payload
     */
    [mTypes.setExam]: function ( state, payload ) {
        if ( Number.isInteger( payload ) ) {
            state.examId = payload;
        }
//other allowed payload types
    }
};
