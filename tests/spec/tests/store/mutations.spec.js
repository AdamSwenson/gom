
//test libraries
require('jasmine-jquery');
require('sinon');

//tested stuff

import * as mutations from "../../../../resources/assets/js/store/mutations";


// // destructure assign mutations
const { setExam } = mutations.mutations;


console.log(mutations);
describe(" store.mutations | ", function () {

    beforeEach(function () {

    });

    afterEach(function () {
//runs after each test
    });
    describe("setExam | ", function () {
        describe("happy path | ", function () {

            it("Number input | ", function () {
                let test = 3;
                let state = {examId: null};
                setExam(state, test);

                expect(state.examId).toBe(test);
            });
        });
    });
});

// export const mutations = {
//     increment: state => state.count++
// }
//
// // mutations.spec.js
// import { expect } from 'chai'
// import { mutations } from './store'
//
// // destructure assign mutations
// const { increment } = mutations
//
// describe('mutations', () => {
//     it('INCREMENT', () => {
//         // mock state
//         const state = { count: 0 }
//         // apply mutation
//         increment(state)
//         // assert result
//         expect(state.count).to.equal(1)
//     })
// })
