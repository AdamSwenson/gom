/**
 * Assertion passes if the div contains some element.
 * Generally, will not work for single inputs
 * @param wrapper
 * @param componentDivId
 */
export const assertExpectedDivIsDisplayed = ( wrapper, componentDivId  ) => {
         expect( wrapper.find( componentDivId ).isEmpty() ).toBe( false );
};

/**
 * Asserts that the element exists.
 * NB, the element must be findable, so if it is
 *
 * See:
 * https://vue-test-utils.vuejs.org/api/wrapper/#exists
 * @param wrapper
 * @param elementSelector
 */
export const assertElementExists = (wrapper, elementSelector) => {
    expect(wrapper.find(elementSelector).exists()).toBe(true);
};

// /**
// NOT SURE WHY NOT WORKING. WAS GIVING ERROR : TypeError: wrapper.find(...).isVisible is not a function
//  * Asserts that the item in the wrapper is visible
//  * Returns false if an ancestor element has display: none or visibility: hidden style.
//  * This can be used to assert that a component is not hidden by v-show.
//  * https://vue-test-utils.vuejs.org/api/wrapper/#isvisible
//  * @param wrapper
//  * @param elementSelector
//  */
// export const assertElementIsVisible = (wrapper, elementSelector) =>{
//     expect( wrapper.find(elementSelector).isVisible() ).toBe(true);
// }