// import { description } from "../../../helpers/vuex.spec.helpers";
//
// var $ = require( 'jquery' );
// window.$ = $;
// var jQuery = $;
// window.jQuery = jQuery;
//
// //test libraries
// require( 'jasmine-jquery' );
// jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
// require( 'sinon' );
//
// //helpers
// var Helper = require( '../../../helpers/vueTesting.helper.js' );
//
// //for fixture
// var Vue = require( 'vue' );
// Vue.config.debug = true;
//
// //tested stuff
// var testedComponent = require( "../resources/assets/js/development/components/helpers/server-sync-indicator.vue" );
//
//
// describe( "server-sync-indicator tests | ", function () {
//     beforeAll( function () {
// //runs once before all tests
//         //prep the page
//         this.$fixture = loadFixtures( fixture );
//         this.vm = Helper.loadVueComponent( testedComponent, 'server-sync-indicator' );
//     } );
//
//     beforeEach( function () {
// //runs before each test
//     } );
//
//     describe( description( "computed properties" ), function () {
//
//         describe( description( "isSyncing" ), function () {
//
//             it("is syncing", function(){
//                 return this.$store.getters.isRequestInProgress;
//
//                 expect(this.vm.$refs.testObject.isSyncing).toBe(false);
//
//             });
//
//             it("not syncing", function(){
//
//             });
//
//
//         } );
//
//
//         describe( description( "isError" ), function () {
//
//         } );
//
//     } );
//
//
//
// } );