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
require( 'sinon' );

//helpers
var Helper = require( '../helpers/vueTesting.helper.js' );
var DataHelper = require( '../helpers/dataObject.helper' );


//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/elementInput.component.js" );

import Data from '../../../resources/assets/js/data/Data.js';

//require( '../../../resources/assets/js/grade/components/Data.js' );
var fixture = 'elementInput.fixture.html';

describe( "elementInput.js | ", function () {
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


    beforeEach( function () {
        var store = new Data();
        this.activeStudentIndex = 0;
        store.students[ this.activeStudentIndex ] = DataHelper.makeStudent();

        store.setActiveStudent( this.activeStudentIndex );
        store.loadStockComments( DataHelper.defaultStockComments() );
        //{
        //     0: {
        //         0: 'e0 missing',
        //         1: 'e0 poor',
        //         2: 'e0 fair',
        //         3: 'e0 excellent'
        //     },
        //     1: {
        //
        //         0: 'e1 missing',
        //         1: 'e1 poor',
        //         2: 'e1 fair',
        //         3: 'e1 excellent'
        //     }
        // } );
        store.loadElementComments( DataHelper.defaultElementComments() );
        //{
        //     0: {
        //         0: '',
        //         1: '',
        //         2: ''
        //     },
        //     1: {
        //         0: '',
        //         1: '',
        //         2: ''
        //     }
        // } );
        store.loadElementScores( DataHelper.defaultElementScores() );
        // {
        //     0: {
        //         0: null,
        //         1: null
        //     },
        //
        //     1: {
        //         0: null,
        //         1: null,
        //         2: null,
        //     }
        // } );

        store.loadNumberQuestions( 2 );
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'element-input' );

        this.$slider = $( "#sliderQ1E1" );
        this.$comment = $( "#commentQ1E1" );

    } );

    afterEach( function () {
    } );

    /* -------------------------- make sure intact ----------- */
    describe( "Intact | ", function () {

        it( "store valid and accessible", function () {
            expect( store ).not.toBeUndefined();
            expect( typeof store ).toBe( 'object' );
        } );


        it( "fixture loaded", function () {
            var $el = $( '#gradeExamPage' );
            expect( $el ).toExist();
            expect( $el ).not.toBeUndefined();
            expect( $el ).not.toBeNull();
        } );


        it( "slider and comment areas are present", function () {
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


    describe( "getValence | ", function () {
        beforeEach( function () {
            this.component = Helper.getComponent( this );
        } );

        describe( "Happy paths | ", function () {
            describe( "Missing | ", function () {
                it( "0 ", function () {
                    expect( this.component.getValence( 0 ) ).toBe( 0 );
                } );
            } );

            describe( "Poor | ", function () {
                it( "0.1", function () {
                    expect( this.component.getValence( 0.1 ) ).toBe( 1 );
                } );
                it( "1", function () {
                    expect( this.component.getValence( 1 ) ).toBe( 1 );
                } );
                it( "3", function () {
                    expect( this.component.getValence( 3 ) ).toBe( 1 );
                } );
                it( "3.25", function () {
                    expect( this.component.getValence( 3.25 ) ).toBe( 1 );
                } );
            } );

            describe( "Fair | ", function () {
                it( "3.26", function () {
                    expect( this.component.getValence( 3.26 ) ).toBe( 2 );
                } );
                it( "4", function () {
                    expect( this.component.getValence( 4 ) ).toBe( 2 );
                } );
                it( "5.5", function () {
                    expect( this.component.getValence( 5.5 ) ).toBe( 2 );
                } );
                it( "6.75", function () {
                    expect( this.component.getValence( 6.75 ) ).toBe( 2 );
                } );
            } );

            describe( "Excellent | ", function () {
                it( "6.76 ", function () {
                    expect( this.component.getValence( 6.76 ) ).toBe( 3 );
                } );
                it( "7 ", function () {
                    expect( this.component.getValence( 7 ) ).toBe( 3 );
                } );
                it( "8.34 ", function () {
                    expect( this.component.getValence( 8.34 ) ).toBe( 3 );
                } );
                it( "9 ", function () {
                    expect( this.component.getValence( 9 ) ).toBe( 3 );
                } );
                it( "10 ", function () {
                    expect( this.component.getValence( 10 ) ).toBe( 3 );
                } );
            } );
        } );

        xdescribe( "Problem cases | ", function () {

            it( "null ", function () {
                expect( this.component.getValence( null ) ).toThrow();
            } );

            it( "out of range max ", function () {
                expect(this.component.getValence(11)).toThrow("cannot get valence. value out of range");
            } );
            it( "out of range min ", function () {
                expect(this.component.getValence(-1)).toThrow("cannot get valence. value out of range");
            } );
        } );

    } );


    /* ------------------------------- Slider movement -------------------- */
    describe( "slider movements |", function () {


        it( "case: excellent ", function () {
            //prep
            var newVal = 10;
            //call
            moveSlider( this.$slider, newVal );
            //check
            expect( store.getElementScore( activeStudent, elementIndex ) ).toBe( newVal );
            expect( store._getStoredCommentText( activeStudent, elementIndex ) ).toBe( 'e1 excellent' );
        } );


        it( "case: fair ", function () {
            var newVal = 6.3;

            //call
            moveSlider( this.$slider, newVal );

            //check
            expect( store.getElementScore( activeStudent, elementIndex ) ).toBe( newVal );
            expect( store._getStoredCommentText( activeStudent, elementIndex ) ).toBe( 'e1 fair' );
        } );

        it( "case: poor", function () {
            var newVal = 1.75;

            //call
            moveSlider( this.$slider, newVal );

            //check
            expect( store.getElementScore( activeStudent, elementIndex ) ).toBe( newVal );
            expect( store._getStoredCommentText( activeStudent, elementIndex ) ).toBe( 'e1 poor' );
        } );


        it( "case: missing ", function () {
            var newVal = 0;
            moveSlider( this.$slider, newVal );

            //check
            expect( store.getElementScore( activeStudent, elementIndex ) ).toBe( newVal );
            expect( store._getStoredCommentText( activeStudent, elementIndex ) ).toBe( 'e1 missing' );
        } );
    } );

    describe( "customized text functions ", function () {


        it( "custom text | manual change to text box recorded in store", function () {
            var newText = "custom text";
            //call
            editComment( this.$comment, newText );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );
        } );


        it( "custom text | moving the slider does not change the customized comment text", function () {
            //prep
            var newText = "custom text";
            editComment( this.$comment, newText );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );

            //call
            moveSlider( this.$slider, 10 );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );
            //Make sure does not interfere with slider value
            expect( store.getElementScore( activeStudent, elementIndex ) ).toBe( 10 );

        } );

        it( "custom text | custom text can still be manually updated", function () {
            //prep
            var newText = "custom text";
            var newText2 = "custom text 2";

            //call ---enter initial comment
            editComment( this.$comment, newText );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText );
            expect( this.$comment.val() ).toBe( newText );

            //call ---alter with new comment
            editComment( this.$comment, newText2 );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText2 );
            expect( this.$comment.val() ).toBe( newText2 );

            //call ---make sure still persists after slider movement
            moveSlider( this.$slider, 10 );

            //check
            expect( store.getCommentText( activeStudent, elementIndex ) ).toBe( newText2 );
            expect( this.$comment.val() ).toBe( newText2 );
        } );

    } );
} )
;
