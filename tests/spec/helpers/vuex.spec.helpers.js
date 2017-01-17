/**
 * Created by adam on 1/11/17.
 */
//
// export const PATH_TO_STORE_FROM_TEST_MODULES = '../../../../../resources/assets/js/store/';


let faker = require('faker');

/**
 * Wrapper around faker so I don't have to keep remembering
 * how to call it
 */
export const randomInteger = () =>{
    return faker.random.number();
};

export const makeState = () => {
    return {Index: null, Id: null, student: null};
};

export const makeRootState = () => {
    return {Index: null, Id: null, student: null};
};

export const description = (text) =>{
    return `${text} | `;
};

/**
 * helper for testing action with expected mutations
 * see https://vuex.vuejs.org/en/testing.html
 */

export const testAction = (action, payload, state, expectedMutations, done) => {
    let count = 0

    // mock commit
    const commit = (type, payload) => {
        const mutation = expectedMutations[count]
        expect(mutation.type).toBe(type)
        if (payload) {
            expect(mutation.payload).toBe(payload)
        }
        count++
        if (count >= expectedMutations.length) {
            // done()
        }
    }

    // call the action with mocked store and arguments
    action({commit, state}, payload)

    // check if no mutations should have been dispatched
    if (expectedMutations.length === 0) {
        expect(count).toBe(0)
        // done()
    }
}
