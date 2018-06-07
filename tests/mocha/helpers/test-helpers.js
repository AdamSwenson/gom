/**
 * These are assertions and action shortcuts
 * to assist in running mocha tests
 */

let faker= require('faker');
import GradeAssignment from "../../../resources/assets/js/models/GradeAssignment";


/**
 * Types the text into the field identified by selector
 * @param selector
 * @param text
 */
export const type = ( wrapper, selector, text ) => {
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
export const see = ( wrapper, text, selector ) => {
    let wrap = selector ? wrapper.find( selector ) : wrapper;
    expect( wrap.html() ).toContain( text );
};


/**
 * Wrapper around faker so I don't have to keep remembering
 * how to call it
 */
export const randomInteger = () => {
    return faker.random.number();
};

// export const makeState = () => {
//     return {Index: null, Id: null, student: null};
// };
//
// export const makeRootState = () => {
//     return {Index: null, Id: null, student: null};
// };

export const description = ( text ) => {
    return `${text} | `;
};

/**
 * helper for testing action with expected mutations
 * see https://vuex.vuejs.org/en/testing.html
 * @param action
 * @param payload
 * @param state
 * @param expectedMutations
 * @param done Callback
 */
export const testAction = ( action, payload, state, expectedMutations, ...kwargs ) => {
    let count = 0
    let {verbose = false, getters={} } = kwargs[0];
    // if ( typeof kwargs[ 0 ] != 'undefined' && typeof kwargs[ 0 ][ 'verbose' ] != 'undefined' ) {
    //     verbose = kwargs[ 0 ].verbose;
    // }

    if ( verbose ) {
        console.log( 'verbose', verbose, kwargs );
    }

    // window.console.log( 'vuex.spec.helpers', 'getters', 115, getters);
    const dispatch =(type, payload)=>{};

    // mock commit
    const commit = ( type, payload ) => {
        const mutation = expectedMutations[ count ]
        expect( mutation.type ).toBe( type )
        if ( payload ) {
            if ( verbose ) {
                console.log( 'mutation', mutation, 'payload', payload );
            }

            if ( typeof mutation.payload == 'object' ) {
                if ( verbose ) {
                    console.log( 'type is object', typeof mutation.payload );
                }

                //check that of same type
                expect( typeof mutation.payload === typeof payload );

                //check that have the same number of properties
                expect( Object.keys( mutation.payload ).length === Object.keys( payload ).length );

                //check have same values for properties
                for (let prop in mutation.payload) {
                    if ( verbose ) {
                        console.log( 'checking prop', prop, 'expected payload', payload, 'expected payload value', payload[ prop ], 'actual payload', mutation.payload[ prop ] );

                    }
                    expect( mutation.payload[ prop ] ).toBe( payload[ prop ] );
                }
            }

            else {
                if ( verbose ) {
                    console.log( 'type not object', typeof mutation.payload );
                }
                expect( mutation.payload ).toBe( payload )
            }

        }
        count++
        if ( count >= expectedMutations.length ) {
            if ( typeof done != 'undefined' ) {
                done();
            }
        }
    }

    // call the action with mocked store and arguments
    action( { commit, state, dispatch, getters }, payload )

    // check if no mutations should have been dispatched
    if ( expectedMutations.length === 0 ) {
        expect( count ).toBe( 0 )
        if ( typeof done != 'undefined' ) {
            done();
        }
    }
}
