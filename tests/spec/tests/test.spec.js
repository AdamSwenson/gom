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

var testedComponent = require( "../../../resources/assets/js/grade/components/elementInput.component.js" );

require( '../../../resources/assets/js/data/Data.js' );

//helpers
var Helper = require('../helpers/vueTesting.helper.js');

// var kvc = require('karma-vue-component');
require( 'jasmine-jquery' );
require('sinon')
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';


describe("Checks that jasmine is available and can be used", function(){
    it( 'tries to test something trivially', function () {
        expect( true ).toBe( true );
    } );
});

describe('Tests for including and using helpers', function () {
    it('should have foo defined', function () {
        expect(typeof Helper.foo).toBe('function')
    })
})

describe( "tests for using fixtures ", function () {
    //This will break if anything gets changed with directory structures
    //or other stuff which tests using fixtures assume.

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
    } );


    it( "checks that fixture has loaded", function () {
        var newVal = 24;
        var $obj = $( '#test' );
        expect( $obj ).not.toBeUndefined();
        expect( $obj ).not.toBeNull();

        $obj.val( newVal );
        expect( Number( $obj.val() ) ).toBe( Number( newVal ) );
    } );
});

describe("shell tests for experimentation", function(){

    it( "puts the lotion in the basket", function () {
        expect(true).toBe(true);
    } );

    it( 'gets the hose again ', function () {
        expect(true).toBe(true);

    } );
} );
