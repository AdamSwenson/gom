/**
 * Created by adam on 1/12/17.
 */

//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );

//Dependencies
//import * as questions from '../../../../../resources/assets/js/store/modules/grade.questions';

import * as mTypes from '../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../resources/assets/js/store/action-types'

// import {makeState} from './helpers';
// import {makeRootState} from './helpers';
// import {testAction} from './helpers';
// import {description} from './helpers';
import {makeState, makeRootState, testAction, description} from './vuex.spec.helpers';


describe( "store | modules | ", () => {
    describe( " MODULENAME | ", () => {
        describe( "mutations | ", () => {
            describe( description( 'REPLACE' ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );

        describe( "actions | ", () => {

            describe( description( 'REPLACE | ' ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );

        describe( "getters | ", () => {

            describe( "REPLACE | ", () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

        } );
    } );
} );
