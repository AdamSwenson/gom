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
var testedComponent = require( "../../../resources/assets/js/grade/components/dashboard.counts.component.js" );
var fixture = 'dashboard.counts.fixture.html';


//Dependencies
require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "dashboard-counts tests | ", function () {
    var $fixture;
    var vm;

    var $button, $label, $icon;

    beforeEach( function () {
        this.expectedTotal = 5;
        this.expectedGraded = 4;
        this.expectedRemaining = 1;
        var me = this;

        //mock the Data object
        var store = {};
        store.activeStudent = 0;
        store.getNumberGraded = function () {
            return me.expectedGraded;
        };
        store.getTotalExams = function () {
            return me.expectedTotal;
        };
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'dashboard-counts' );
    } );

    describe( "Intact | ", function () {
        it( "page elements present", function () {
            expect( $( "#dashboardCounts" ) ).toExist();
        } );

    } );

    describe( "Count values | ", function () {
        beforeEach( function () {
        } );

        it( "total exams ", function () {
            let component = Helper.getComponent( this );
            expect( component.totalExams ).toBe( this.expectedTotal );
        } );

        it( "graded exams ", function () {
            let component = Helper.getComponent( this );
            expect( component.totalExams ).toBe( this.expectedTotal );
        } );

        it( "remaining exams ", function () {
            let component = Helper.getComponent( this );
            expect( component.totalExams ).toBe( this.expectedTotal );
        } );
    } );


    describe( "showFinishButton | ", function () {

        it( "programmatically called ", function () {
            //prep
            let component = Helper.getComponent( this );
            expect( component.finishButtonHidden ).toBe( true );

            //call
            component.showFinishButton();

            //check
            expect( component.finishButtonHidden ).toBe( false );
        } );

        it( "shows when 0 remain ", function () {
            //prep
            let component = Helper.getComponent( this );
            expect( component.finishButtonHidden ).toBe( true );
            this.expectedGraded = this.expectedTotal;

            //call
            component.showFinishButton();

            //check
            expect( component.finishButtonHidden ).toBe( false );
        } );
    } );


} );