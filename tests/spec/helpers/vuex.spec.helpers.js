/**
 * Created by adam on 1/11/17.
 */
//
// export const PATH_TO_STORE_FROM_TEST_MODULES = '../../../../../resources/assets/js/store/';

import Exam from '../../../resources/assets/js/store/models/Exam';
import Student from '../../../resources/assets/js/store/models/Student';
import Question from '../../../resources/assets/js/store/models/Question';


let faker = require( 'faker' );

/**
 * Generators of fake model objects
 * @type {{examFactory: (())}}
 */
export const factories = {
    /**
     * Returns an Exam instance with random id and index
     * @returns {Exam}
     */
    examFactory: ( index ) => {
        let idx = typeof index != 'undefined' ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );

        let e = new Exam();
        e.id = faker.random.number();
        e.index = idx;
        e.name = faker.company.bsNoun();
        e.year = 2013;
        e.term = faker.company.bs();
        return e;
    },

    studentFactory: ( index ) => {
        let s = new Student( faker.random.number() );
        s.email = faker.internet.email();
        s.studentIndex = index ? index : faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
        s.studentIdentifier = faker.random.uuid();
        s.lastName = faker.name.lastName();
        s.firstName = faker.name.firstName();
        return s;
    },

    questionFactory: ( index ) => {
        let question = new Question( index );
        question.questionName = faker.hacker.phrase();
        question.questionNumber = faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
        question.questionAssignmentId = faker.random.number();
        question.maxScore = faker.random.number();
        question.content = faker.hacker.phrase();
        return question;
    }
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
    let verbose = false;

    if ( typeof kwargs[ 0 ] != 'undefined' && typeof kwargs[ 0 ][ 'verbose' ] != 'undefined' ) {
        verbose = kwargs[ 0 ].verbose;
    }
    ;

    if ( verbose ) {
        console.log( 'verbose', verbose, kwargs );
    }

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
                for ( let prop in mutation.payload ) {
                    if ( verbose ) {
                        console.log( 'checking prop', prop, 'payload', payload, 'payload value', payload[ prop ] );
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
    action( {commit, state}, payload )

    // check if no mutations should have been dispatched
    if ( expectedMutations.length === 0 ) {
        expect( count ).toBe( 0 )
        if ( typeof done != 'undefined' ) {
            done();
        }
    }
}
