
//test libraries
require('jasmine-jquery');
require('sinon');

import * as exams from '../../../../../resources/assets/js/store/modules/exams';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import {makeState} from './helpers';
import {makeRootState} from './helpers';
import {testAction} from './helpers';
import {description} from './helpers';


describe( "store | modules | ", () => {
    describe( " exams | ", () => {
        describe( "mutations | ", () => {
            describe( description( mTypes.addExam ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( description( mTypes.addIndexMapping ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );

            describe( description( mTypes.populateExams ), () => {
                xit( "happy path | ", () => {
                    //todo
                } );
            } );
        } );



        describe( "actions | ", () => {

            describe( description(aTypes.addNewExam), () => {
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
