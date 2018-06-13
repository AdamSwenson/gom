//The name of the tested component
var compName = 'items.obj';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.obj.js' );

require( '../../../../injectglobals' );

//tested object
let obj = Component.default;

describe( compName, () => {

    describe( " object imported actions, mutations, etc", () => {

        it( 'has actions', () => {
            expect( _.has( obj, 'actions' ) ).toBe( true );
        } );
        it( 'has getters', () => {
            expect( _.has( obj, 'getters' ) ).toBe( true );
        } );
        it( 'has mutations', () => {
            expect( _.has( obj, 'mutations' ) ).toBe( true );
        } );
        it( 'has state', () => {
            expect( _.has( obj, 'state' ) ).toBe( true );
        } );
    } );

    describe(  'getItemFromPayload', (  ) => {
        //todo write (unsure whether actually used)
    });
    // ( state, payload ){
    //     return state.items[ payload.index ];
    //     // if (typeof payload.id !== 'undefined') {
        //     //get the item
        //     var item = state.items.filter(function (i) {
        //         if (typeof i.id != 'undefined' && i.id === id) {
        //             return i;
        //         }
        //     });
        //     return item;
        // } else {
        //     //get the item
        //     return state.items[payload.index];
        // }
    // }
// };


    describe(  'buildPayloadFromInput', (  ) => {
        //todo write (unsure whether actually used)
    });


} );
