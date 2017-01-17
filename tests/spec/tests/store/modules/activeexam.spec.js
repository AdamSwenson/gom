//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as activeexam from '../../../../../resources/assets/js/store/modules/activeexam';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import {makeState, makeRootState, testAction, description} from '../../../helpers/vuex.spec.helpers';

let {getters} = activeexam.default;

let index = faker.random.number();
let examId = faker.random.number();

//mock of the store
let state = {
    activeExam: {
        id: examId,
        index: index
    }
};

fdescribe( "store | modules | ", () => {
    describe( " activeexam | ", () => {

        describe( "mutations | ", () => {
            describe( description( mTypes.setActiveExam ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( description( mTypes.clearActiveExam ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );

        describe( "actions | ", () => {

            describe( description( aTypes.setActiveExam ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( description( aTypes.clearActiveExam ), () => {
                it( "happy path | ", () => {
                    //todo
                } );
            } );

        } );

        describe( "getters | ", () => {

            describe( "getActiveExamId | ", () => {
                it( "happy path | ", () => {
                    expect( getters.getActiveExamId( state ) ).toBe( examId );
                } );
            } );

            describe( "getActiveExamIndex | ", () => {
                it( "happy path | ", () => {
                    expect( getters.getActiveExamIndex( state ) ).toBe( index );
                } );
            } );

            describe( "getActiveExamObj | ", () => {
                it( "happy path | ", () => {

                    expect( getters.getActiveExamObj( state ) ).toBe( state.activeExam );
                } );
            });
        } );
    } );
} );
