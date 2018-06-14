//The name of the tested component

var compName = 'roster.display';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/roster.display.js' );


require( '../../../../injectglobals' );

//tested object
let { state, mutations } = Component;

describe( compName, () => {
    let numStudents, listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        numStudents = 5;
        for (let i = 0; i < numStudents; i++) {
            state.selectedStudents.push( factories.studentFactory() );
        }
    } );


    describe( " mutations ", () => {
        it( 'clearSelectedStudents', () => {
            expect( state.selectedStudents.length > 0 ).toBe( true );
            //call
            mutations.clearSelectedStudents( state, {} );
            //check
            expect( state.selectedStudents.length ).toBe( 0 );
        } );

        it( 'deselectStudent', () => {
            let s = state.selectedStudents[ 1 ];
            //call
            mutations.deselectStudent( state, Payload.factory( { obj: s } ) );
            //check
            expect( state.selectedStudents.indexOf( s ) ).toBe( -1 );
        } );

        it( 'setSortedBy', () => {
            test = 'taco';
            mutations.setSortedBy( state, Payload.factory( { updateVal: test } ) );
            //check
            expect( state.sortedBy ).toBe( test );
        } );

        it( 'selectStudent', () => {
            let s = factories.studentFactory();
            //call
            mutations.selectStudent( state, Payload.factory( { obj: s } ) );
            //check
            expect( state.selectedStudents.indexOf( s ) ).not.toBe( -1 );
        } );

        it( 'toggleStudent -- student selected', () => {
            let s = state.selectedStudents[ 1 ];
            //call
            mutations.toggleStudent( state, Payload.factory( { obj: s } ) );
            //check
            expect( state.selectedStudents.indexOf( s ) ).toBe( -1 );
        } );


        it( 'toggleStudent -- student not selected', () => {
            let s = factories.studentFactory();
            //call
            mutations.toggleStudent( state, Payload.factory( { obj: s } ) );
            //check
            expect( state.selectedStudents.indexOf( s ) ).not.toBe( -1 );
        } );

        it( 'toggleSortAscending', () => {
            //call
            mutations.toggleSortAscending( state );
            //check
            expect( state.sortAsc ).toBe( false );
            //call
            mutations.toggleSortAscending( state );
            //check
            expect( state.sortAsc ).toBe( true );
        } );

    } );

} );
