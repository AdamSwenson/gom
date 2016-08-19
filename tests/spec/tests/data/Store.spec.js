var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';
require( 'sinon' );

//helpers

import Store from  "../../../../resources/assets/js/data/Store.js";


describe( "Store tests | ", function () {

    beforeEach( function () {
this.store = new Store();
    } );

    afterEach( function () {
//runs after each test
    } );

    it( "intact ", function () {
expect(true).toBe(true);
        //    expect(typeof this.store).toBe('store');
    } );

} );