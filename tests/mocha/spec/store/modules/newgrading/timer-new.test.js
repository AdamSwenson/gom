require( '../../../../injectglobals' );


const testAction = helpers.testAction;
const description = helpers.description;


//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/timer/timer-new';

let obj = Component.default;
//tested methods
let { getters, actions, mutations, state } = obj;


describe( "timer-new  ", function () {

    beforeEach( function () {

    } );

    describe( "mutations  ", function () {
        it( 'should jip', function () {

            expect( true ).toBe( true );
        } );

        describe( ngmTypes.startExamTimer, function () {

            it( "happy path ", function () {
                let s = ngmTypes.startExamTimer;

                window.console.log( 'timer-new.test', 's', 27, s );

                // expect( state.timerRunning ).toBe( false );
                //         // mutations[ ngmTypes.startExamTimer ]( state );
                //         // expect( state.timerRunning ).toBe( true );
            } );
        } );

        describe( ngmTypes.stopExamTimer, function () {

            it( "happy path ", function () {
                state.timerRunning = true;
                expect( state.timerRunning ).toBe( true );
                mutations[ ngmTypes.stopExamTimer ]( state );
                expect( state.timerRunning ).toBe( false );
            } );
        } );

    } );

    describe( "actions  ", function () {
        describe( ngaTypes.startExamTimer, function () {

            it( "happy path ", function () {

                let action = actions[ ngaTypes.startExamTimer ];
                testAction( action, {}, state, [
                    {
                        type: ngmTypes.startExamTimer
                    }
                ], { verbose: true } )

            } );
        } );

        describe( ngaTypes.stopExamTimer, function () {

            it( "happy path ", function () {
                let action = actions[ ngaTypes.stopExamTimer ];
                testAction( action, {}, state, [
                    {
                        type: ngmTypes.stopExamTimer
                    }
                ], { verbose: true } )

            } );
        } );


    } );

    describe( "getters  ", function () {
        describe( nggTypes.isTimerRunning, function () {
            it( "happy path when true", function () {
                state.timerRunning = true;
                expect( getters[ nggTypes.isTimerRunning ]( state ) ).toBe( true );
            } );

            it( "happy path when false", function () {
                state.timerRunning = false;
                expect( getters[ nggTypes.isTimerRunning ]( state ) ).toBe( false );
            } );
        } );
    } );
} );

