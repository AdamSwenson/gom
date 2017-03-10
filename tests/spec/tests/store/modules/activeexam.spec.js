//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as activeexam from '../../../../../resources/assets/js/store/modules/activeexam';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Exam from '../../../../../resources/assets/js/models/Exam';
import Payload from '../../../../../resources/assets/js/models/Payload';

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//tested object
let obj = activeexam.default;
//tested methods
let {getters, actions, mutations} = obj;


const makeMutationPayload = function () {
    let q = factories.examFactory();
    let p = Payload.factory( {obj: q, id: q.id, index: q.index} );
    return p;
};

export const makeState = () => {
    let s = makeRootState();
    s.activeExam = factories.examFactory();
    return s;
};

export const makeRootState = () => {
    return {activeExam: null};
};


describe( "store | modules | activeexam | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.mutationPayload = makeMutationPayload();
        this.exam = factories.examFactory();
    } );


    describe( "mutations | ", function () {
        describe( description( mTypes.setActiveExam ), function () {

            it( "happy path ", function () {
                let pl = Payload.factory( {obj: this.exam} );
                mutations[ mTypes.setActiveExam ]( this.state, {}, pl );
                expect( this.state.activeExam ).toBe( this.exam );
            } );
        } );

        describe( description( mTypes.clearActiveExam ), function () {
            it( "happy path  ", function () {
                let state2 = {activeExam: 'taco'};
                let exam2 = factories.examFactory();
                mutations[ mTypes.clearActiveExam ]( state2, {}, exam2 );
                expect( state2.activeExam ).toBeNull();
            } );
        } );
    } );

    describe( "actions | ", function () {

        describe( description( aTypes.setActiveExam ), function () {
            describe( " payload is Exam | ", function () {
                it( "happy path ", function () {
                    let action = actions[ aTypes.setActiveExam ];
                    testAction( action, this.exam, this.state, [
                        {
                            type: mTypes.setActiveExam,
                            payload: Payload.factory( {obj: this.exam} )
                        }
                    ], {verbose: true} )
                } );
            } );

            describe( " unhappy path |  payload Not Exam | ", function () {
                xit( "reports error ", function () {
                //     let action = actions[ aTypes.setActiveExam ];
                //     let pl = makeMutationPayload();
                //     let p = {
                //         examId: pl.id,
                //         examIndex: pl.index,
                //         name: pl.obj.name,
                //         year: pl.obj.year,
                //         term: pl.obj.term
                //     };
                //     console.log( 'pl', pl );
                //     console.log( 'p', p );
                //     testAction( action, p, this.state, [
                //         {
                //             type: mTypes.setActiveExam,
                //             payload: pl
                //         }
                //     ], {verbose: true} );
                } );
            } );

        } );

        describe( description( aTypes.clearActiveExam ), function () {
            it( "happy path | ", function () {
                let action = actions[ aTypes.clearActiveExam ];

                testAction( action, {}, this.state, [
                    {
                        type: mTypes.clearActiveExam
                    }
                ] );
            } );
        } );

    } );

    describe( "getters | ", function () {

        describe( "getActiveExamId | ", function () {
            it( "happy path ", function () {
                expect( getters.getActiveExamId( this.state ) ).toBe( this.state.activeExam.id );
            } );
        } );

        describe( "getActiveExamIndex | ", function () {
            it( "happy path ", function () {
                expect( getters.getActiveExamIndex( this.state ) ).toBe( this.state.activeExam.index );
            } );
        } );

        describe( "getActiveExamObj | ", function () {
            it( "happy path ", function () {
                expect( getters.getActiveExamObj( this.state ) ).toBe( this.state.activeExam );
            } );
        } );
    } );
} );

