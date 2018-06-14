//The name of the tested component
import * as mTypes from "../../../../../../resources/assets/js/store/mutation-types";

var compName = 'notes.mutations';
//The path to the tested component
import mutations from '../../../../../../resources/assets/js/store/modules/notes/notes.mutations.js' ;


require( '../../../../injectglobals' );

//tested objectp

describe( compName, () => {
    let state, note, payload;
    beforeEach( () => {

        state = {
            notes: [],
            newNoteSerialNumber: -1,
        };
        note = factories.noteFactory();
    } )

    describe( mTypes.createNote, () => {
        it( "adds the note to the store", () => {
            payload = global.Payload.factory( { obj: note } );
            //call
            mutations[ mTypes.createNote ]( state, payload );
            expect( state.notes.length ).toBe( 1 );
            expect( state.notes[ 0 ] ).toMatchObject( note );
        } )
    } );

    describe( mTypes.updateNote, () => {
        it( "updates the note in the store", () => {
            state.notes.push( note );
            payload = global.Payload.factory( { obj: note, updateProp: 'name', updateVal: 'taco' } );
            //call
            mutations[ mTypes.updateNote ]( state, payload );
            expect( state.notes.length ).toBe( 1 );
            expect( state.notes[ 0 ][ payload.updateProp ] ).toBe( payload.updateVal );
        } )
    } );

    describe( mTypes.destroyNote, () => {
        it( "removes the indicated note from store", () => {
            state.notes.push( note );
            expect( state.notes.length ).toBe( 1 );
            payload = global.Payload.factory( { obj: note } );
            //call
            mutations[ mTypes.destroyNote ]( state, payload );
            expect( state.notes.length ).toBe( 0 );

        } );
    } );

    describe( 'setNewNote', () => {
        it( 'sets the note serial number on the store', () => {
            payload = global.Payload.factory( { obj: note } );
            //call
            mutations.setNewNote( state, payload );
            expect( state.newNoteSerialNumber ).toBe( note.serialNumber );
        } );
    } );
} );
