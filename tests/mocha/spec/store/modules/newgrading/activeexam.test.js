require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;

//Dependencies
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/activeexam-new';

import Payload from '../../../../../../resources/assets/js/models/Payload';


//tested object
//tested methods
let { getters, actions, mutations} = Component.default;


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


describe( "activeexam (new)", function () {
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

        describe( description( ngaTypes.setExamAsActive ), function () {
            it( "happy path ", function () {
                // let action = actions[ aTypes.setExamAsActive ];

                testAction( actions[ ngaTypes.setExamAsActive ], exam, state, [
                    {
                        type: ngmTypes.setActiveExam,
                        payload: Payload.factory( { obj: exam } )
                    }
                ], { verbose: true } )
            } );


        } );

        describe( description( ngaTypes.resetActiveExam ), function () {
            it( "happy path | ", function () {
                let action = actions[ ngaTypes.resetActiveExam ];

                testAction( action, {}, state, [
                    {
                        type: ngmTypes.setActiveExam,
                        payload: Payload.factory( { obj: null } )
                    }
                ], { verbose: true } );
            } );
        } );

    } );

    describe( "getters  ", function () {
        describe( nggTypes.getActiveExam, function () {
            it( "happy path ", function () {
                state.activeExam = exam;
                expect( getters[nggTypes.getActiveExam]( state ) ).toBe( exam );
            } );
        } );
    } );
} );

