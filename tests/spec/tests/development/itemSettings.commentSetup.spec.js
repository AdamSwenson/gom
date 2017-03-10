var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

//helpers
var Helper = require( '../../helpers/vueTesting.helper.js' );

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../../resources/assets/js/development/components/itemSettings.commentSetup.component" );
var fixture = 'itemSettings.fixture.html';


describe( "item-settings-comment-setup tests | ", function () {
    var $fixture;
    var vm;

    beforeAll( function () {
//runs once before all tests
    } );

    beforeEach( function () {
//runs before each test
        //prep the page
        this.$fixture = loadFixtures( fixture );
        this.vm = Helper.loadVueComponent( testedComponent, 'item-settings' );

    } );

    afterEach( function () {
    //runs after each test
    } );

    describe( "computed properties | ", function () {
        beforeEach(function(){

            let component = Helper.getComponent( this );
        });

        it( 'index | ', function () {
            expect( true ).toBe( true );
        } );

    } );

} );