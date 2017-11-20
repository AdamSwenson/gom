

/**
 * These are assertions and action shortcuts
 * to assist in running mocha tests
 */



/**
 * Types the text into the field identified by selector
 * @param selector
 * @param text
 */
export const type = ( selector, text ) => {
    wrapper.find( selector ).element.value = text;
    wrapper.find( selector ).trigger( 'input' );
};

/**
 * Asserts that the specified text is present within
 * the specified selector or page if no selector is
 * specified
 * @param text
 * @param selector
 */
export const see = ( text, selector ) => {
    let wrap = selector ? wrapper.find( selector ) : wrapper;
    expect( wrap.html() ).toContain( text );
};
