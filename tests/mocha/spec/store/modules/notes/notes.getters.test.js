//The name of the tested component
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

var compName = 'notes.getters';
//The path to the tested component
import getters from '../../../../../../resources/assets/js/store/modules/notes/notes.getters.js' ;


require( '../../../../injectglobals' );

import { createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();
localVue.use( Vuex )


describe( compName, () => {
    let state, store, note, item, exam, numNotes, itemNotes, examNotes, results;
    beforeEach( () => {
        numNotes = 10;

        state = {
            notes: [],
            newNoteSerialNumber: -1,
        };
        item = factories.itemFactory();
        exam = factories.examFactory();

        itemNotes = [];
        examNotes = [];
        for (let i = 0; i < numNotes; i++) {
            note = factories.noteFactory();
            note.associatedItemSerialNumber = item.serialNumber;
            itemNotes.push( note );

            note = factories.noteFactory();
            note.associatedItemSerialNumber = exam.serialNumber;
            examNotes.push( note );
        }

        //combine into state
        state.notes += itemNotes;
        state.notes += examNotes;


        store = new Vuex.Store( {
            state, getters
        } );

        // expect( state.notes.length ).toBe( numNotes * 2 );
    } );


    describe( 'getNotesForItem', () => {
        it( "returns notes associated with item", () => {
            results = store.getters.getNotesForItem( item );
            //check
            expect( results.length ).toBe( numNotes );
            _.forEach( results, function ( r ) {
                expect( r.associatedItemSerialNumber ).toBe( item.serialNumber );
            } );
        } );

        it( "returns notes associated with exam", () => {
            results = store.getters.getNotesForItem( exam );
            //check
            expect( results.length ).toBe( numNotes );
            _.forEach( results, function ( r ) {
                expect( r.associatedItemSerialNumber ).toBe( exam.serialNumber );
            } );

        } );
    } );

    describe( gTypes.getNoteBySerialNumber, function () {
        it("returns the correct note", (  ) => {
        let t = itemNotes[ 0 ];
        let result = store.getters[ gTypes.getNoteBySerialNumber ]( t.serialNumber );
        expect( result ).toMatchObject( t );
        });
    } );

    describe( 'getNewNote', function () {
        it("returns the note whose serial number is set in newNoteSerialNumber", (  ) => {
            let t = itemNotes[ 0 ];
            state.newNoteSerialNumber = t.serialNumber;
            let result = store.getters.getNewNote;
            expect( result ).toMatchObject( t );
        });
    } );
} );
