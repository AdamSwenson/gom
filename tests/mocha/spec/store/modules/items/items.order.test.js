
//The name of the tested component
var compName = 'items.order';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.js' );

require( '../../../../injectglobals' );

//tested object
let obj = Component.default


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    

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

} );
