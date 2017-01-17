//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );


const makeState = ( n = 5 ) => {
    let s = {
        elementComments: {},
        stockComments: {}
    };

    for ( let i = 0; i < n; i++ ) {
        s.elementComments[ i ] = {}
        for ( let k = 0; k < n; k++ ) {
            s.elementComments[ i ][ k ] = faker.hacker.phrase();
        }
    }
    return s;
};

const makeRootState = () => {
    return {
        elementComments: {},
        stockComments: {}
    };

};

const makeTextPayload = () => {
    return {
        elementIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        commentText: faker.hacker.phrase()
    };
};

console.log( makeState() );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';
//Dependencies
import * as comments from '../../../../../resources/assets/js/store/modules/comments';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

//tested object
let obj = comments.default;
//tested methods
let {getters, actions, mutations} = obj;

//test data
let exam = factories.examFactory();
let index = exam.examIndex;
let examId = exam.examId;

let studentIndex = faker.random.number();
let elementIndex = faker.random.number();
let commentText = faker.hacker.phrase();


describe( "store | modules | ", () => {
    describe( "grade.comments | ", () => {

        describe( "mutations | ", () => {
            describe( description( mTypes.loadElementComments ), () => {
                it( "happy path | ", () => {
                    //mock store
                    let state = makeState();
                    let rootState = makeRootState();
                    let pl = makeTextPayload();
                    mutations[ mTypes.loadElementComments ]( state, rootState, pl );
                    expect( state.elementComments ).toBe( pl );
                } );
            } );

            describe( description( mTypes.loadStockComments ), () => {
                it( "happy path | ", () => {
                    //mock store
                    let state = makeState();
                    let rootState = makeRootState();
                    let pl = makeTextPayload();

                    mutations[ mTypes.loadStockComments ]( state, rootState, pl );
                    expect( state.stockComments ).toBe( pl );
                } );
            } );

            describe( description( mTypes.setElementComment ), () => {
                describe( "pre-existing comment text | ", () => {
                    it( "happy path | ", () => {
                        let state = makeState();
                        let rootState = makeRootState();
                        let pl = makeTextPayload();

                        mutations[ mTypes.setElementComment ]( state, rootState, pl );
                        expect( state.elementComments[ pl.studentIndex ][ pl.elementIndex ] ).toBe( pl.commentText );
                    } );
                } );

                describe( "no pre-existing comment text | ", () => {
                    it( "happy path | ", () => {
                        let state = makeState();
                        let rootState = makeRootState();
                        let pl = makeTextPayload();
                        state.elementComments[ pl.studentIndex ][ pl.elementIndex ] = '';

                        mutations[ mTypes.setElementComment ]( state, rootState, pl );
                        expect( state.elementComments[ pl.studentIndex ][ pl.elementIndex ] ).toBe( pl.commentText );
                    } );
                } );

            } );


        } );

        describe( "actions | ", () => {
            describe( description( aTypes.storeCommentText ), () => {
                it( "happy path | ", () => {
                    let action = actions[ aTypes.storeCommentText ];
                    let pl = makeTextPayload();

                    let state = makeRootState();
                    testAction( action, pl, state, [ {
                        type: mTypes.setElementComment,
                        payload: pl
                    } ] );

                } )
            } );
            describe( description( aTypes.storeCommentTextForActiveStudent ), () => {
                xit( "happy path | ", () => {
                    //todo
                } )
            } );
        } );

        describe( "getters | ", () => {
            describe( "getElementComment | ", () => {
                it( "happy path | ", () => {
                    //prep
                    let pl = makeTextPayload();
                    let rootState = makeRootState();
                    let state = makeState();

                    //call
                    let result = getters.getElementComment( state, {}, rootState, pl.studentIndex, pl.elementIndex );

                    //check
                    expect( result ).toBe( state.elementComments[ pl.studentIndex ][ pl.elementIndex ] );
                } )
            } );

            //THIS IS THE MOST IMPORTANT ONE!!!!!!!
            describe( "getCommentText | ", () => {
                xit( "happy path | ", () => {
                    //prep
                    let pl = makeTextPayload();
                    let rootState = makeRootState();
                    let state = makeState();

                    //call
                    let result = getters.getCommentText( state, {}, rootState, pl.studentIndex, pl.elementIndex );

                    //check
                    expect( result ).toBe( state.elementComments[ pl.studentIndex ][ pl.elementIndex ] );
                    //todo
                } );

                //todo lots of cases
            } );

            describe( "getStoredCommentText | ", () => {
                it( "happy path | ", () => {
                    //prep
                    let pl = makeTextPayload();//used for random vlue
                    let rootState = makeRootState();
                    let state = makeState();

                    //call
                    let result = getters.getStoredCommentText( state, {}, rootState, pl.studentIndex, pl.elementIndex );

                    //check
                    expect( result ).toBe( state.elementComments[ pl.studentIndex ][ pl.elementIndex ] );
                } )
            } );

            describe( "getCommentTextForActiveStudent | ", () => {
                //todo Requires adding in valence
                xit( "happy path | ", () => {
                    //prep
                    let pl = makeTextPayload(); //makes nice fake data
                    let rootState = makeRootState();
                    let state = makeState();
                    let txt = state[pl.studentIndex][pl.elementIndex];

                    state.activeStudentIndex = pl.studentIndex;
                    pl.studentIndex = null;

                    //call
                    let result = getters.getCommentTextForActiveStudent( state, {
                        getCommentText: ( ...kwargs ) => {
                            return txt;
                        }
                    }, rootState, pl.studentIndex, pl.elementIndex );

                    //check
                    expect( result ).toBe( txt );

                } );

                it( "null case | ", () => {
                    //prep
                    let pl = makeTextPayload();
                    let rootState = makeRootState();
                    let state = makeState();

                    state.activeStudentIndex = null;
                    pl.studentIndex = null;

                    //call
                    let result = getters.getCommentTextForActiveStudent( state, {
                        getCommentText: ( ...kwargs ) => {
                            return pl.commentText;
                        }
                    }, rootState, pl.studentIndex, pl.elementIndex );

                    //check
                    expect( result ).toBe( '' );

                } )
            } );
        } );
    } );
} );
