
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as gTypes from "../../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";
import * as mTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/timer-new';
let obj = Component.default;
//tested methods
let { getters, actions, mutations, state } = obj;


describe( "timer-new  | ", function () {

    beforeEach( function () {

    } );


    describe( "mutations  ", function () {
        describe( description( mTypes.startExamTimer ), function () {

            it( "happy path ", function () {
                expect( state.timerRunning ).toBe( false );
                mutations[ mTypes.startExamTimer ]( state );
                expect( state.timerRunning ).toBe( true );
            } );
        } );

        describe( description( mTypes.stopExamTimer ), function () {

            it( "happy path ", function () {
                state.timerRunning = true;
                expect( state.timerRunning ).toBe( true );
                mutations[ mTypes.stopExamTimer ]( state );
                expect( state.timerRunning ).toBe( false );
            } );
        } );

    } );

    describe( "actions  ", function () {
        describe( description( aTypes.startExamTimer ), function () {

            it( "happy path ", function () {

                let action = actions[ aTypes.startExamTimer ];
                testAction( action, exam, state, [
                    {
                        type: mTypes.startExamTimer
                    }
                ], { verbose: true } )

            } );
        } );

        describe( description( aTypes.stopExamTimer ), function () {

            it( "happy path ", function () {
                let action = actions[ aTypes.stopExamTimer ];
                testAction( action, exam, state, [
                    {
                        type: mTypes.stopExamTimer
                    }
                ], { verbose: true } )

            } );
        } );


    } );

    describe( "getters  ", function () {
        describe( gTypes.isTimerRunning  , function () {
            it( "happy path when true", function () {
                state.timerRunning = true;
                expect( getters[ gTypes.isTimerRunning ]( state ) ).toBe( true );
            } );
            it( "happy path when false", function () {
                state.timerRunning = false;
                expect( getters[ gTypes.isTimerRunning ]( state ) ).toBe( false );
            } );
        } );
    } );
} );

