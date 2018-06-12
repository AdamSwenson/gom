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

/**
 * Checks that the spy (usually a mutation or action) was passed the correct
 * payload object.
 * The offset defaults to 1, which is the location of the payload for the first
 * time the spy was called (because sinon is stupid like that). To check the
 * payload of the second time the spy was called, update offset to 2 and so on.
 * @param wrapper
 * @param spy
 * @param expectedPayload
 * @param offset
 * @returns {*}
 */
export const assertPayloadWasCorrect = (spy, expectedPayload, offset=1) =>{
  return expect(spy.args[0][offset]).toMatchObject(expectedPayload);
};
/**
 * Asserts that the specified text is present within
 * the specified selector or page if no selector is
 * specified
 * @param text
 * @param selector
 */
export const assertThatSeeText = ( wrapper, text, selector ) => {
    let wrap = selector ? wrapper.find( selector ) : wrapper;
    expect( wrap.html() ).toContain( text );
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