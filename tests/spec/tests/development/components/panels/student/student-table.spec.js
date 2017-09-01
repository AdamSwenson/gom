var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

//helpers
var Helper = require( '../../../../../helpers/vueTesting.helper.js' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../../../../../resources/assets/js/development/components/panels/student/student-table.vue" );
var fixture = 'generic.fixture.html';


describe( " tests | ", function () {
    beforeAll( function () {
//runs once before all tests
    } );

    beforeEach( function () {
//runs before each test
    } );

    afterEach( function () {
//runs after each test
    } );

    it( " ", function () {
    } );

} );