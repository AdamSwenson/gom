var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

//helpers
var Helper = require( '../helpers/vueTesting.helper.js' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/dashboard.timer.component.js" );
var fixture = 'dashboard.timer.fixture.html';


//Dependencies
require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "dashboard-timer tests | ", function () {
    var $fixture;
    var vm;

    var $button, $label, $icon;

    beforeEach( function () {
        var store = new Data();
        store.activeStudent = 0;
        store.examGradingTimes = {
            0: 0,
            1: 0,
        };
        store.questionScores = {
            0: { 0: 34, 1: 45 },
            1: { 0: null, 1: null }
        };
        store.examGrades = { 0: 44, 1: 'Letter grade' };
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-timer' );

        this.$button = $( "#btnTimer" );
        this.$label = $( "#btnTimerLabel" );
        this.$icon = $( "#btnTimerIcon" );

    } );

    describe( "Intact | ", function () {
        it( "page elements present", function () {
            expect( this.$button ).toExist();
            expect( this.$label ).toExist();
            expect( this.$icon ).toExist();
            expect( $( "#gradingStatsPanel" ) ).toExist();
        } );

    } );

    describe( "unit | ", function () {
        describe("convertSecondsToHHMMSS | ", function(){
            it( "< 60 seconds ", function () {
                let component = Helper.getComponent( this );
                expect(component.convertSecondsToHHMMSS(55)).toBe("00:55");
            } );

            it( "> 60 seconds & < 60 min ", function () {
                let component = Helper.getComponent( this );
                expect(component.convertSecondsToHHMMSS(100)).toBe("01:40");
            } );

            it( "> 60 min ", function () {
                let component = Helper.getComponent( this );
                expect(component.convertSecondsToHHMMSS(3700)).toBe("01:01:40");
            } );

            it( "empty", function () {
                let component = Helper.getComponent( this );
                expect(component.convertSecondsToHHMMSS(NaN)).toBe("00:00:00");
                //not exactly sure why does this. but it is expected behavior
                expect(component.convertSecondsToHHMMSS(null)).toBe("00:00");
            } );
        });

        describe( "toggleTimer | ", function () {
            it( "paused to running ", function () {
                let component = Helper.getComponent( this );
                component.paused = true;

                //call
                component.toggleTimer();

                //check
                component.paused = false;
            } );

            it( "running to paused ", function () {
                let component = Helper.getComponent( this );
                component.paused = false;

                //call
                component.toggleTimer();

                //check
                component.paused = true;
            } );
        } );
    } );


    describe( "Timer button properties | ", function () {
        it( "Label updates | paused to running ", function () {
            let component = Helper.getComponent( this );
            component.paused = true;

            //call
            component.paused = false;
            // this.$button.trigger('click');

            //check
            expect( component.buttonLabel ).toBe( component.defaults.button.label.running );
        } );

        it( "Label updates | running to paused ", function () {
            let component = Helper.getComponent( this );
            component.paused = false;

            //call
            component.paused = true;
            // this.$button.trigger('click');

            //check
            expect( component.buttonLabel ).toBe( component.defaults.button.label.paused );
        } );

        it( "Icon updates | paused to running", function () {
            let component = Helper.getComponent( this );
            component.paused = true;

            //call
            component.paused = false;
            // this.$button.trigger('click');

            //check
            expect( component.buttonIcon ).toBe( component.defaults.button.icon.running );
        } );

        it( "Icon updates | running to paused", function () {
            let component = Helper.getComponent( this );
            component.paused = false;

            //call
            component.paused = true;
            // this.$button.trigger('click');

            //check
            expect( component.buttonIcon ).toBe( component.defaults.button.icon.paused );
        } );

        it( "Styling updates | paused to running", function () {
            let component = Helper.getComponent( this );
            component.paused = true;

            //call
            component.paused = false;
            // this.$button.trigger('click');

            //check
            expect( component.buttonStyling ).toBe( component.defaults.button.styling.running );
        } );

        it( "Styling updates | running to paused", function () {
            let component = Helper.getComponent( this );
            component.paused = false;

            //call
            component.paused = true;
            // this.$button.trigger('click');

            //check
            expect( component.buttonStyling ).toBe( component.defaults.button.styling.paused );
        } );

    } );


    describe( "Time values | ", function () {

        describe( "Remaining time", function () {
            beforeEach( function () {
                //prep
                store.examGradingTimes = {
                    0: 65,
                    1: 0,
                };
            } );

            it( "currentExamTime ", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.currentExamTime ).toBe( 65 );
            } );

            it( "currentExamTimeDisplay", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.currentExamTimeDisplay ).toBe( "01:05" );
            } );
        } );

        describe( "Average exam time | ", function () {
            beforeEach( function () {
                //prep
                store.examGradingTimes = {
                    0: 125,
                    1: 75,
                    2: 125,
                    3: 75,
                    4: 0
                }; //total 400
                //it updates the examGrades from questionScores. If this isn't present, it freaks out
                store.questionScores = { 0: { 0: 44 }, 1: { 0: 55 }, 2: { 0: 66 }, 3: { 0: 22 }, 4: { 0: null } };
                store.examGrades = { 0: 44, 1: 55, 2: 66, 3: 22, 4: 'Letter grade' }; //4 graded; 1 ungraded
            } );
            it( "averageTime", function () {
                //TODO check corner case where no exams graded
                let component = Helper.getComponent( this );
                //check
                expect( component.averageTime ).toBe( 100 ); //should be 100 seconds
            } );

            it( "averageTimeDisplay", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.averageTimeDisplay ).toBe( "01:40" ); //should be 100 seconds
            } );
        } );

        describe( "Total time | ", function () {
            beforeEach( function () {
                //prep
                store.examGradingTimes = {
                    0: 100,
                    1: 50,
                };
            } );
            it( "totalTime ", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.totalTime ).toBe( 150 ); //should be 150 seconds
            } );

            it( "totalTimeDisplay", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.totalTimeDisplay ).toBe( "02:30" ); //should be 150 seconds
            } );
        } );

        describe( "Remaining time", function () {
            beforeEach( function () {
                //prep
                store.examGradingTimes = {
                    0: 125,
                    1: 75,
                    2: 125,
                    3: 75,
                    4: 0
                }; //total 400
                //it updates the examGrades from questionScores. If this isn't present, it freaks out
                store.questionScores = { 0: { 0: 44 }, 1: { 0: 55 }, 2: { 0: 66 }, 3: { 0: 22 }, 4: { 0: null } };
                store.examGrades = { 0: 44, 1: 55, 2: 66, 3: 22, 4: 'Letter grade' }; //4 graded; 1 ungraded
            } );

            it( "Remaining time ", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.remainingTime ).toBe( 100 ); //should be 100 seconds
            } );


            it( "Remaining time | Display value", function () {
                let component = Helper.getComponent( this );
                //check
                expect( component.remainingTimeDisplay ).toBe( "01:40" ); //should be 100 seconds
            } );
        } );
    } );


    describe( "Events | Outbound |  ", function () {
        it( "Emits stopping notification ", function () {
            //prep
            let component = Helper.getComponent( this );
            let spy = Helper.createEventSpy( this, 'timer-stop-event' );

            //call
            component.stopTimer();

            //check
            expect( spy.calledOnce ).toBe( true );
        } );

        it( "Emits starting notification ", function () {
            //prep
            let component = this.vm.$refs.testObject;
            // let component = Helper.getComponent(this);
            let spy = Helper.createEventSpy( this, 'timer-start-event' );

            //call
            component.startTimer();

            //check
            expect( spy.calledOnce ).toBe( true );
        } );

    } );


    describe( "Events | Inbound | ", function () {
        it( "Starts on request ", function () {
            //prep
            let component = Helper.getComponent( this );
            expect( component.paused ).toBe( true );

            //call
            this.vm.$broadcast( 'start-timer-request' );

            //check
            window.console.log( component );
            expect( component.paused ).toBe( false );
        } );

        it( "Stops on request ", function () {
            //prep
            let component = Helper.getComponent( this );
            component.paused = false;
            expect( component.paused ).toBe( false );

            //call
            this.vm.$broadcast( 'stop-timer-request' );

            //check
            expect( component.paused ).toBe( true );
        } );

    } );


} );