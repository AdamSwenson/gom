//The name of the tested component
var compName = 'items.obj.state';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.obj.state.js' );

require( '../../../../injectglobals' );

//tested object
let state = Component;

describe( compName, () => {

    describe( " has expected properties ", () => {
        it( 'has property items', () => {
            expect( _.has( state, 'items' ) ).toBe( true );
        } );

        it( 'items is a list', () => {
            expect( _.isArray(state.items) ).toBe( true );
        } );
    } );

} );
