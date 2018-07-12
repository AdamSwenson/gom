/**
 * These are assertions and action shortcuts
 * to assist in running mocha tests
 */

let faker = require( 'faker' );


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
    return ` ${text} `;
    // return `${text} | `;
};


export const makeFakeServerResponse = () => {
    return [
        {
            displayValue: 'A+',
            calcValue: 98,
            minScore: 97,
            group: 0,
            ordinal: 0,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'A',
            calcValue: 95,
            minScore: 93,
            group: 0,
            ordinal: 1,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'A-',
            calcValue: 92,
            minScore: 90,
            group: 0,
            ordinal: 2,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B+',
            calcValue: 88,
            minScore: 87,
            group: 0,
            ordinal: 3,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B',
            calcValue: 85,
            minScore: 83,
            group: 0,
            ordinal: 4,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'B-',
            calcValue: 82,
            minScore: 80,
            group: 0,
            ordinal: 5,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C+',
            calcValue: 78,
            minScore: 77,
            group: 0,
            ordinal: 6,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C',
            calcValue: 75,
            minScore: 73,
            group: 0,
            ordinal: 7,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'C-',
            calcValue: 72,
            minScore: 70,
            group: 0,
            ordinal: 8,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D+',
            calcValue: 68,
            minScore: 67,
            group: 0,
            ordinal: 9,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D',
            calcValue: 65,
            minScore: 63,
            group: 0,
            ordinal: 10,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'D-',
            calcValue: 62,
            minScore: 60,
            group: 0,
            ordinal: 11,
            id: faker.random.number(),
            gradeId: faker.random.number()
        },
        {
            displayValue: 'F',
            calcValue: 55,
            minScore: 50,
            group: 0,
            ordinal: 12,
            id: faker.random.number(),
            gradeId: faker.random.number()
        }
    ];
};


/**
 * helper for testing action with expected mutations
 * see https://vuex.vuejs.org/en/testing.html
 *
 * expectedMutations should be a list of objects {type: xxxx, payload: xxxx}
 * @param action
 * @param payload
 * @param state
 * @param expectedMutations
 * @param done Callback
 */
export const testAction = ( action, payload, state, expectedMutations, ...kwargs ) => {
    let count = 0
    let { verbose = false, getters = {}, done = undefined } = kwargs[ 0 ];
    // if ( typeof kwargs[ 0 ] != 'undefined' && typeof kwargs[ 0 ][ 'verbose' ] != 'undefined' ) {
    //     verbose = kwargs[ 0 ].verbose;
    // }

    if ( verbose ) {
        console.log( 'verbose', verbose, kwargs );
    }

    // window.console.log( 'vuex.spec.helpers', 'getters', 115, getters);
    const dispatch = ( type, payload ) => {
    };

    // mock commit
    const commit = ( type, payload ) => {
        const mutation = expectedMutations[ count ];
        //check that the mutation name was correct
        expect( mutation.type ).toBe( type );

        //if the expected payload was set, check it
        if ( _.has( mutation, 'payload' ) ) {
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
                    //we're not going to check that the serial numbers match
                    //because that prevents us from testing actions which create
                    //new objects
                    if ( prop != 'serialNumber' ) {
                        if ( verbose ) {
                            console.log( 'checking prop', prop, 'expected payload', payload, 'expected payload value', payload[ prop ], 'actual payload', mutation.payload[ prop ] );

                        }
                        expect( mutation.payload[ prop ] ).toBe( payload[ prop ] );
                    }
                }
            }

            else { //payload wasn't an object, so we just check for equality
                if ( verbose ) {console.log( 'type not object', typeof mutation.payload );}
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
