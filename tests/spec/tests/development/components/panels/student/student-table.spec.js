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
import { testAction, description, factories } from '../../../../../helpers/vuex.spec.helpers';

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../../../../../resources/assets/js/development/components/setup/student/student-table.vue" );
var fixture = 'generic.fixture.html';


describe( " student-table | ", function () {


    beforeEach( function () {
//runs before each test
    } );

    describe( description( "sort " ), function () {
        describe( description( "default state" ), function () {
            
        } );
        
        describe( description( "column selected" ), function () {
           it("correct sort icon displays", function(){
               
           });

            describe( description("sort icon area is active"), function(){
                it("clicking toggles sort order", function(){
                    //verify rows are in correct order
                });

                it("icon changes with sort order", function(){

                });

            });

        } );
        
        describe( description( "column not selected" ), function () {
            it("icon area does not toggle sort", function(){

            });      
            
            it("no icon is displayed", function(){

            });
        } );
        
      
    } );

} );