//The name of the tested component
import Note from "../../../../../../resources/assets/js/models/Note";

var compName = 'notes.actions';
//The path to the tested component
import actions from '../../../../../../resources/assets/js/store/modules/notes/notes.actions' ;
import Payload from "../../../../../../resources/assets/js/models/Payload";


require( '../../../../injectglobals' );

describe( compName, () => {
    let state, note, payload, expectedMutations, item;
    beforeEach( () => {

        state = {
            notes: [],
            newNoteSerialNumber: -1,
        };
        note = factories.noteFactory();
    } );

    describe( 'createNewNote (payload contents not checked)', () => {
        beforeEach( (  ) => {

            expectedMutations = [
                {type: 'createNote'}, // payload: exp },
                {type: 'setNewNote'} //, payload: exp}
            ];
        });

        it( 'dispatches expected mutations when called for an item ', () => {
            // item = factories.itemFactory();
            // let n = Note.factory({associatedItemSerialNumber: item.serialNumber});
            // n.id = -1;
            // let exp = Payload.factory( { obj: n} )


            payload = global.Payload.factory( { obj: item} )
            helpers.testAction(actions.createNewNote, payload, state, expectedMutations , {verbose:true});
        } )

        it( 'dispatches expected mutations when called for an exam', () => {
            // item = factories.examFactory();
            // let exp = Note.factory({associatedItemSerialNumber: item.serialNumber});
            // expectedMutations = [
            //     {type: 'createNote',  payload: exp },
            //     {type: 'setNewNote' , payload: exp}
            // ];
            payload = global.Payload.factory( { obj: item } )
            helpers.testAction(actions.createNewNote, payload, state, expectedMutations , {verbose:false});
        } )
    } );
} );
