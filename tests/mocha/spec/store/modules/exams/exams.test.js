
//The name of the tested component
var compName = 'exams';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/exams/exams.js' );


require( '../../../../injectglobals' );

//tested object
let obj = Component.default;

describe( compName, () => {

    describe( " has expected methods ", () => {
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
