
//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );

//Dependencies
import * as activeexam from '../../../../../resources/assets/js/store/modules/activeexam';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import {makeState, makeRootState, testAction, description} from './helpers';


describe( "store | modules | ", () => {
    describe( " activeexam | ", () => {

        describe( "mutations | ", () => {
            describe( description( mTypes.setActiveExam), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( description(mTypes.clearActiveExam), () => {
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

            describe( description(aTypes.clearActiveExam), () => {
                it( "happy path | ", () => {
                    //todo
                } );
            } );

        } );

        describe( "getters | ", () => {
            describe( "getActiveExamId | ", () => {

            } );

            describe( "getActiveExamIndex | ", () => {

            } );
            describe( "getActiveExamObj | ", () => {

            } );


        } );
    } );
} );
