//The name of the tested component
var compName = 'items.order.state';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.state.js' );

require( '../../../../injectglobals' );
import Node from "../../../../../../resources/assets/js/models/Node";

let state = Component;

describe( compName, () => {

    beforeEach( function () {

    } );

    describe( description( 'itemMap properties' ), function () {
        it( "itemMap is expected Node object ", function () {
            // window.console.log( 'orderings.spec', 'state', 41, state );
            expect( state.itemMap.data ).toBe( 1 );
            expect( state.itemMap.parent ).toBe( 1 );
            expect( state.itemMap.children.length ).toBe( 0 )
            expect(state.itemMap instanceof Node).toBe(true);
        } );
    } );

} );
