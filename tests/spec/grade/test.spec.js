/**
 * Created by adam on 7/12/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

require( 'bootstrap' );
var Vue = require( 'vue' );
//dev
Vue.config.debug = true;

var testedComponent = require( "../../../resources/assets/js/grade/components/elementInput.js" );

require( '../../../resources/assets/js/grade/components/Data.js' );

// var kvc = require('karma-vue-component');
require( 'jasmine-jquery' );

jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';

describe( "Slider and comment integration", function () {
    var fixture;
    var $fixture;

    beforeEach( function () {
        //  loadFixtures('elementInput.fixture.html');
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
        //'<input type="text" id="test2" v-model="test-val"/>' +


        $fixture = setFixtures( fixture );
        // $( fixture ).appendTo(document.body);
        //

    } );

    afterEach( function () {
//delete vm;
    } );

    it( 'tries to test something trivially', function () {
        expect( true ).toBe( true );
    } );

    it( "checks that fixture has loaded", function () {
        var newVal = 24;
        var $obj = $( '#test' );
        expect( $obj ).not.toBeUndefined();
        expect( $obj ).not.toBeNull();

        $obj.val( newVal );
        expect( Number( $obj.val() ) ).toBe( Number( newVal ) );
    } );

    // it( "checks that vue has loaded", function () {
    //     var vm = new Vue(
    //         {
    //             el: 'gradeExamPage',
    //             // data: { 'testVal': 5 }
    //         } ).$appendTo(document.body);
    //
    //     var newVal = 26;
    //     var $obj = $( '#test2' );
    //     expect( $obj ).not.toBeUndefined();
    //     expect( $obj ).not.toBeNull();
    //
    //     expect( Number( $obj.val() ) ).toBe( Number( 5 ) );
    //     window.console.log( 'test2', $obj );
    //     $obj.val( newVal );
    //     expect( Number( $obj.val() ) ).toBe( Number( newVal ) );
    // } );

    it( "puts the lotion in the basket", function () {
        var MyComponent = Vue.extend( {
            template: '<div id="test3"><input type="text" id="dtest" v-model="ddd"/></div>',
            data: function () {
                return { ddd: 5 }
            }
        } )

        new MyComponent().$mount().$appendTo( '#app' )

        expect( $( '#test3' ) ).not.toBeNull();
        expect( $( '#test3' ) ).not.toBeUndefined();

        var $obj = $( '#dtest' );
        expect( $obj ).not.toBeNull();
        expect( $obj ).not.toBeUndefined();
        expect($obj).toExist();

        expect( Number( $obj.val() ) ).toBe( 5 );
    } );

    it( 'gets the hose again ', function () {
        expect(true).toBe(true);
//         require( '../../../resources/assets/js/grade/components/Data.js' );
//         var activeStudent = 0;
//         var elementIndex = 1;
//
//         var store = new Data();
//         store.activeStudent = 0;
//         store.loadStockComments( {
//             0: {
//                 0: 'e0 missing',
//                 1: 'e0 poor',
//                 2: 'e0 fair',
//                 3: 'e0 excellent'
//             },
//             1: {
//
//                 0: 'e1 missing',
//                 1: 'e1 poor',
//                 2: 'e1 fair',
//                 3: 'e1 excellent'
//             }
//         } );
//         store.loadElementComments( {
//             0: {
//                 0: '',
//                 1: '',
//                 2: ''
//             },
//             1: {
//                 0: '',
//                 1: '',
//                 2: ''
//             }
//         } );
//         store.loadElementScores( {
//             0: {
//
//                 0: null,
//                 1: null
//             },
//
//             1: {
//                 0: null,
//                 1: null,
//                 2: null,
//             }
//         } );
//         store.loadQuestionScores( {} );
//         store.loadGradingTimes( {} );
//         store.loadExamGrades( {} );
//         store.loadNumberQuestions( 2 );
// window.store = store;
//         var MyComponent = Vue.extend( testedComponent );
// // register
//         Vue.component('element-input', MyComponent)
//
// // create a root instance
//         new Vue({
//             el: '#app'
//         }).$mount();//.$appendTo( '#app' );
//         // compile off-document and append afterwards:
//         // new MyComponent().$mount().$appendTo( '#app' )
//
//         expect( true ).toBe( true );
//
//         var $slider = $( '#element1' );
//         expect( $slider ).not.toBeNull();
//         expect( $slider ).not.toBeUndefined();
//
//         var $comment = $( '#commentQ1E1' );
//         expect( $comment ).not.toBeNull();
//         expect( $comment ).not.toBeUndefined();
//
//         expect( $comment.val() ).toBe( 'e1 missing' );
//
//         var testC = 'taco';
//         $comment.val( testC );
//
//         expect( $comment.val() ).toBe( testC );
//         window.console.log(store);
//         expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( testC );
//
//
//         function moveSlider( newVal ) {
//             var event = jQuery.Event( "slideStop" );
//             event.value = newVal;
//             event.type = "slideStop";
//             $slider.trigger( event );
//         }
//
//
//         var newVal = 10;
//         moveSlider( newVal );
//         expect( store.elementScores[ activeStudent ][ elementIndex ] ).toBe( newVal );
//         expect( store.elementComments[ activeStudent ][ elementIndex ] ).toBe( 'e1 excellent' );
    } );
} );
