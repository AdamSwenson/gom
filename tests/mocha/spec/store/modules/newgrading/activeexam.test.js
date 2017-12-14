require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as activeexam from '../../../../../../resources/assets/js/store/modules/newgrading/activeexam-new';

import * as mTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';

import Exam from '../../../../../../resources/assets/js/models/Exam';
import Payload from '../../../../../../resources/assets/js/models/Payload';

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
let obj = activeexam.default;
//tested methods
let { getters, actions, mutations } = obj;


const makeMutationPayload = function () {
    let q = factories.examFactory();
    let p = Payload.factory( { obj: q, id: q.id, index: q.index } );
    return p;
};

export const makeState = () => {
    let s = makeRootState();
    s.activeExam = factories.examFactory();
    return s;
};

export const makeRootState = () => {
    return { activeExam: null };
};


describe( "store | modules | newgrading |  activeexam | ", function () {
    let state;
    let rootState;
    let payload;
    let mutationPayload;
    let exam;

    beforeEach( function () {
        state = makeState();
        rootState = makeRootState();
        mutationPayload = makeMutationPayload();
        exam = factories.examFactory();
    } );


    describe( "mutations  ", function () {
        describe( description( mTypes.setActiveExam ), function () {

            it( "happy path ", function () {
                let pl = Payload.factory( { obj: exam } );
                mutations[ mTypes.setActiveExam ]( state, pl );
                expect( state.activeExam ).toBe( exam );
            } );
        } );

        describe( description( mTypes.updateActiveExamProp ), function () {
            it( "happy path  ", () => {
                let test = 'taco';
                let pl = Payload.factory( { updateProp: 'name', updateVal: test } );
                mutations[ mTypes.updateActiveExamProp ]( state, pl );
                expect( state.activeExam.name ).toBe( test );
            } );
        } );
    });

    describe( "actions  ", function () {

        describe( description( aTypes.setExamAsActive ), function () {
            it( "happy path ", function () {
                let action = actions[ aTypes.setExamAsActive ];
                testAction( action, exam, state, [
                    {
                        type: mTypes.setActiveExam,
                        payload: Payload.factory( { obj: exam } )
                    }
                ], { verbose: true } )
            } );


        } );

        describe( description( aTypes.resetActiveExam ), function () {
            it( "happy path | ", function () {
                let action = actions[ aTypes.resetActiveExam ];

                testAction( action, {}, state, [
                    {
                        type: mTypes.setActiveExam,
                        payload: Payload.factory( { obj: null } )
                    }
                ], { verbose: true } );
            } );
        } );

    } );

    describe( "getters  ", function () {
        describe( "getActiveExam | ", function () {
            it( "happy path ", function () {
                state.activeExam = exam;
                expect( getters.getActiveExam( state ) ).toBe( exam );
            } );
        } );
    } );
} );

