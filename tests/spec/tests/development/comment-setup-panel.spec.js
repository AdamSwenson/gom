var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
// jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

//helpers
//var Helper = require( '../../helpers/vueTesting.helper.js' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );


import {mount} from 'vue-test-utils';
//tested stuff
var commentPanel = require( "../../../../resources/assets/js/development/components/panels/comment-setup-panel.vue" );



//
// // var fixture = 'development/generic.fixture.html';
// var fixture = `<div id="app">
//     <component v-ref:test-object></component>
// </div>`;
//


fdescribe( "comment-setup-panel | ", function () {
    var $fixture;
    var vm;

    beforeAll( function () {
//runs once before all tests
    } );

    beforeEach( function () {
//runs before each test
let wrapper = mount(commentPanel);
      //  this.$fixture = setFixtures( fixture );
        //prep the page
        // this.$fixture = loadFixtures( fixture );
      //  this.vm = Helper.loadVueComponent( testedComponent, 'component' );
    } );

    afterEach( function () {
//runs after each test
    } );

    describe( "computed properties | ", function () {
        beforeEach( function () {
            let component = Helper.getComponent( this );
        } );

        it( 'commentText | ', function () {
            expect(component.displayed).toBe('stock')

            expect( true ).toBe( true );
        } );

    } );

    describe( description( "methods" ), function () {
        beforeEach( function () {
            let component = Helper.getComponent( this );
        } );

        it( 'prePopulateComments | ', function () {
            expect( true ).toBe( true );
        } );
    } );
} );
