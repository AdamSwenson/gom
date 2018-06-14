
//The name of the tested component
var compName = 'roster';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/roster.js' );


require( '../../../../injectglobals' );

//tested object


//tested object
let obj = Component.default;

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    describe( " has expected properties ", () => {
        it( 'actions', () => {
            expect(_.has(obj, 'actions')).toBe(true);
        } );
        it( 'getters', () => {
            expect(_.has(obj, 'getters')).toBe(true);
        } );
        it( 'mutations', () => {
            expect(_.has(obj, 'mutations')).toBe(true);
        } );
        it( 'state', () => {
            expect(_.has(obj, 'state')).toBe(true);
        } );
    } );

} );
