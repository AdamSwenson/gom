//root mutations for vuex instance
export default {
    setExamId(state, examIdToSet) {
        state.examId = examIdToSet;
        window.console.log('setExamId', state);
    }



}