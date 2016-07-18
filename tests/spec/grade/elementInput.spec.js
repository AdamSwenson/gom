/**
 * Created by adam on 7/11/16.
 */

/*
 These aren't necessary while using browser based tes
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';


//helpers
//var Helper = require('helpers/vueTestingHelpers.js');

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/elementInput.js" );
require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "Slider and comment integration", function () {
    var fixture;
    var $fixture;
    var vm;
    // var store;
    var activeStudent = 0;
    var elementIndex = 1;
    var questionNumber = 1;
    var $slider; //= $( "#sliderQ1E1" );
    var $comment; //= $( "#commentQ1E1" );

    function moveSlider( slider, newVal ) {
        var event = jQuery.Event( "slideStop" );
        event.value = newVal;
        event.type = "slideStop";
        slider.trigger( event );
    }

    function editComment( $comment, newText ) {
        $comment.val( newText ).trigger( 'change' ).trigger( 'blur' );
    }

    function loadComponent() {
        //declare
        var MyComponent = Vue.extend( testedComponent );
        // register
        Vue.component( 'element-input', MyComponent )

        // create a root instance
        var vm = new Vue( {
            el: '#app'
        } ).$mount();

        return vm;
        // compile off-document and append afterwards:
        // new MyComponent().$mount().$appendTo( '#app' )
    }

    beforeEach( function () {
        this.$fixture = loadFixtures( 'elementInput.fixture.html' );
        // fixture = '<div class="fixture container-fluid">' +
        //     '<div id="gradeExamPage">' +
        //     '<element-input :element-number="1"' +
        //     ':element-index="1"' +
        //     'element-id="1"' +
        //     'element-name="testname"' +
        //     ':question-number="1"></element-input>' +
        //     '</div></div>';

        fixture = '<div class="fixture container-fluid">' +
            '<div id="gradeExamPage">' +
            '<input type="text" id="test"/>' +
            '<div id="app">' + +
                '<div id="gradeExamPage">' +
            '<element-input :element-number="1"' +
            ':element-index="1"' +
            'element-id="1"' +
            'element-name="testname"' +
            ':question-number="1"></element-input>' +
            '</div></div></div></div>';
        // this.$fixture = setFixtures(fixture);

        var store = new Data();
        store.activeStudent = 0;
        store.loadStockComments( {
            0: {
                0: 'e0 missing',
                1: 'e0 poor',
                2: 'e0 fair',
                3: 'e0 excellent'
            },
            1: {

                0: 'e1 missing',
                1: 'e1 poor',
                2: 'e1 fair',
                3: 'e1 excellent'
            }
        } );
        store.loadElementComments( {
            0: {
                0: '',
                1: '',
                2: ''
            },
            1: {
                0: '',
                1: '',
                2: ''
            }
        } );
        store.loadElementScores( {
            0: {

                0: null,
                1: null
            },

            1: {
                0: null,
                1: null,
                2: null,
            }
        } );

        // store.loadQuestionScores( {
        //     0: {
        //         0: null,
        //         1: null,
        //         2: null
        //     },
        //     1: {
        //         0: null,
        //         1: null,
        //         2: null,
        //     }
        // } );
        //
        // store.loadGradingTimes( {} );
        // store.loadExamGrades( {
        //     0: 'Letter grade',
        //     1: 'Letter grade',
        //     2: 'Letter grade'
        // } );
        store.loadNumberQuestions( 2 );
        window.store = store;

        loadComponent();

        this.$slider = $( "#sliderQ1E1" );
        this.$comment = $( "#commentQ1E1" );

    } )
    ;

    afterEach( function () {
    } );

    /* -------------------------- make sure intact ----------- */
    describe( "prepared and intact", function () {

        it( "checks that the data store is valid and accessible", function () {
            expect( store ).not.toBeUndefined();
            expect( store.stockComments[ 0 ][ 0 ] ).toBe( 'e0 missing' );
        } );


        it( "checks that fixture has loaded", function () {
            var $el = $( '#gradeExamPage' );
            expect( $el ).toExist();
            expect( $el ).not.toBeUndefined();
            expect( $el ).not.toBeNull();
        } );


        it( "checks that the slider and comment areas are present", function () {
            expect( this.$slider ).toExist();
            expect( this.$slider ).not.toBeUndefined()
            expect( this.$slider ).not.toBeNull()

            expect( this.$comment ).toExist();
            expect( this.$comment ).not.toBeUndefined()
            expect( this.$comment ).not.toBeNull()
        } );


        it( "checks to make sure events get fired", function () {
            //prep
            var spyEvent = spyOnEvent( '#sliderQ1E1', 'slideStop' )
            var event = jQuery.Event( "slideStop" );
            event.value = 5;
            event.type = "slideStop";

            //call
            this.$slider.trigger( event );

            //check
            expect( 'slideStop' ).toHaveBeenTriggeredOn( '#sliderQ1E1' )
            expect( spyEvent ).toHaveBeenTriggered()
        } );
    } );


    /* ------------------------------- Slider movement -------------------- */
    describe( "slider movements", function () {


        it( "case: excellent | moves the slider and checks the comment text", function () {
            //prep
            var newVal = 10;
            //call
            moveSlider( this.$slider, newVal );
            //check
            expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( newVal );
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( 'e1 excellent' );
        } );


        it( "case: fair | moves the slider and checks the comment text", function () {
            var newVal = 6.3;

            //call
            moveSlider( this.$slider, newVal );

            //check
            expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( newVal );
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( 'e1 fair' );
        } );

        it( "case: poor | moves the slider and checks the comment text", function () {
            var newVal = 1.75;

            //call
            moveSlider( this.$slider, newVal );

            //check
            expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( newVal );
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( 'e1 poor' );
        } );


        it( "case: missing | moves the slider and checks the comment text", function () {
            var newVal = 0;
            moveSlider( this.$slider, newVal );

            //check
            expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( newVal );
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( 'e1 missing' );
        } );
    } );

    describe( "customized text functions ", function () {


        it( "custom text | manual change to text box recorded in store", function () {
            var newText = "custom text";
            //call
            editComment( this.$comment, newText );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );
        } );


        it( "custom text | moving the slider does not change the customized comment text", function () {
            //prep
            var newText = "custom text";
            editComment( this.$comment, newText );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );

            //call
            moveSlider( this.$slider, 10 );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );
            //Make sure does not interfere with slider value
            expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( 10 );

        } );

        it( "custom text | custom text can still be manually updated", function () {
            //prep
            var newText = "custom text";
            var newText2 = "custom text 2";

            //call ---enter initial comment
            editComment( this.$comment, newText );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );

            //call ---alter with new comment
            editComment( this.$comment, newText2 );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText2 );
            expect( this.$comment.val() ).toBe( newText2 );

            //call ---make sure still persists after slider movement
            moveSlider( this.$slider, 10 );

            //check
            expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( newText2 );
            expect( this.$comment.val() ).toBe( newText2 );
        } );

    } );
} )
;
