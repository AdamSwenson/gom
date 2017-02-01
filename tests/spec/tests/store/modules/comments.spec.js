//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );
import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';
//Dependencies
import * as comments from '../../../../../resources/assets/js/store/modules/comments';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/store/models/Payload'

//tested object
let obj = comments.default;
//tested methods
let {getters, actions, mutations} = obj;


//valid values for indees
let studentIndexValues = [ 0, 1, 2, 3, 4 ];
let elementIndexValues = [ 0, 1, 2, 3, 4 ];

const makeState = ( n = 5 ) => {
    let s = makeRootState();

    for ( let i = 0; i < n; i++ ) {
        s.elementComments[ i ] = {}
        s.stockComments[ i ] = {}
        for ( let k = 0; k < n; k++ ) {
            s.elementComments[ i ][ k ] = faker.hacker.phrase();
            s.stockComments[ i ][ k ] = faker.hacker.phrase();
        }
    }
    return s;
};

const makeRootState = function () {
    return obj.state;
    // return {
    //     elementComments: {},
    //     stockComments: {}
    // };

};

const makeMutationPayload = function () {
    return Payload.factory( {
        index: faker.random.arrayElement( studentIndexValues ),
        index2: faker.random.arrayElement( elementIndexValues ),
        str: faker.hacker.phrase(),
        obj: {taco: 'nom'},
    } );
};

const makeTextPayload = function () {
    return {
        elementIndex: faker.random.arrayElement( elementIndexValues ),
        studentIndex: faker.random.arrayElement( studentIndexValues ),
        commentText: faker.hacker.phrase()
    };
};



describe( "store | modules | comments | ", function () {
    beforeEach( function () {
        //test data
        this.exam = factories.examFactory();
        this.index = this.exam.examIndex;
        this.examId = this.exam.examId;

        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTextPayload();
        this.mutationPayload = makeMutationPayload();
        this.studentIndex = this.payload.studentIndex;
        this.elementIndex = this.payload.elementIndex;
        this.commentText = this.payload.commentText;

    } );

    describe( "mutations | ", function () {
        describe( description( mTypes.loadElementComments ), function () {
            it( "happy path  ", function () {
                //call
                mutations[ mTypes.loadElementComments ]( this.state, this.rootState, this.mutationPayload );
                //check
                expect( this.state.elementComments ).toBe( this.mutationPayload.obj );
            } );
        } );

        describe( description( mTypes.loadStockComments ), function () {
            it( "happy path this.", function () {
                //call
                mutations[ mTypes.loadStockComments ]( this.state, this.rootState, this.mutationPayload );
                //check
                expect( this.state.stockComments ).toBe( this.mutationPayload.obj );
            } );
        } );

        describe( description( mTypes.setElementComment ), function () {
            describe( "pre-existing comment text | ", function () {
                it( "happy path ", function () {

                    //call
                    mutations[ mTypes.setElementComment ]( this.state, this.rootState, this.mutationPayload );
                    //check

                    let target = this.state.elementComments[ this.mutationPayload.index ][ this.mutationPayload.index2 ];

                    expect( target ).toBe( this.mutationPayload.str );
                } );
            } );

            describe( "no pre-existing comment text | ", function () {
                it( "happy path ", function () {
                    this.state.elementComments[ this.mutationPayload.index ][ this.mutationPayload.index2 ] = '';
                    //call
                    mutations[ mTypes.setElementComment ]( this.state, this.rootState, this.mutationPayload );
                    //check
                    let target = this.state.elementComments[ this.mutationPayload.index ][ this.mutationPayload.index2 ];
                    expect( target ).toBe( this.mutationPayload.str );
                } );
            } );

        } );


    } );

    describe( "actions | ", function () {
        describe( description( aTypes.storeCommentText ), function () {
            it( "happy path ", function () {
                let action = actions[ aTypes.storeCommentText ];

                let pl = Payload.factory( {
                    index: this.payload.studentIndex,
                    index2: this.payload.elementIndex,
                    str: this.payload.commentText
                } );
                testAction( action, this.payload, this.state, [ {
                    type: mTypes.setElementComment,
                    payload: pl
                } ] );

            } )
        } );
        describe( description( aTypes.storeCommentTextForActiveStudent ), function () {
            xit( "happy path | ", function () {
                //todo
            } )
        } );
    } );

    describe( "getters | ", function () {
        describe( "getElementComment | ", function () {
            it( "happy path ", function () {
                //prep

                //call
                let result = getters.getElementComment( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                //check
                expect( result ).toBe( this.state.elementComments[ this.payload.studentIndex ][ this.payload.elementIndex ] );
            } )
        } );

        //THIS IS THE MOST IMPORTANT ONE!!!!!!!
        describe( "getCommentText | ", function () {
            it( "happy path  ", function () {
                // //prep
                let valence = this.payload.studentIndex;
                //call
                let result = getters.getCommentText( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex, valence );

                //check
                expect( result ).toBe( this.state.elementComments[ this.payload.studentIndex ][ this.payload.elementIndex ] );

            } );

            //todo lots of cases
        } );

        describe( "getStoredCommentText | ", function () {
            it( "happy path ", function () {
                //prep

                //call
                let result = getters.getStoredCommentText( this.state, {}, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                //check
                expect( result ).toBe( this.state.elementComments[ this.payload.studentIndex ][ this.payload.elementIndex ] );
            } )
        } );

        describe( "getCommentTextForActiveStudent | ", function () {
            //todo Requires adding in valence
            xit( "happy path | ", function () {
                //prep
                let pl = makeTextPayload(); //makes nice fake data
                let rootState = makeRootState();
                let state = makeState();
                let txt = state[ pl.studentIndex ][ pl.elementIndex ];

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

            it( "null case | ", function () {
                //prep

                this.state.activeStudentIndex = null;
                this.payload.studentIndex = null;

                //call
                let result = getters.getCommentTextForActiveStudent( this.state, {
                    getCommentText: ( ...kwargs ) => {
                        return this.payload.commentText;
                    }
                }, this.rootState, this.payload.studentIndex, this.payload.elementIndex );

                //check
                expect( result ).toBe( '' );

            } )
        } );
    } );
} );
