//The name of the tested component
import * as mTypes from "../../../../../../resources/assets/js/store/mutation-types";

var compName = 'tags.mutations';
//The path to the tested component
import mutations from '../../../../../../resources/assets/js/store/modules/tags/tags.mutations.js' ;
import Payload from "../../../../../../resources/assets/js/models/Payload";


require( '../../../../injectglobals' );

//tested object


describe( compName, () => {
    let listOfValues, test;
    let state, tag, tags, payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        state = {
            tags: []
        }
        tag = factories.tagFactory();
        item = factories.itemFactory();
        exam = factories.examFactory();
    } );


    describe( mTypes.addTag, () => {
        it( 'adds the new tag to store', () => {
            mutations[ mTypes.addTag ]( state, Payload.factory( { obj: tag } ) );
            expect( state.tags.length ).toBe( 1 );
            expect( state.tags[ 0 ] ).toMatchObject( tag );
        } );
    } );


    describe( mTypes.updateTag, () => {
        it( 'updates properties of the tag', () => {
            let test = 'taco'
            mutations[ mTypes.updateTag ]( state, Payload.factory( {
                obj: tag,
                updateProp: 'name',
                updateVal: test
            } ) );
            expect( tag.name ).toBe( test );

        } );
    } );


    describe( mTypes.destroyTag, () => {
        it( 'removes the tag from storage', () => {
            let num = 4;
            state.tags = factories.makeTags( num );
            expect(state.tags.length).toBe(num);
            let t = state.tags[ num - 1 ];
            //call
            mutations[ mTypes.destroyTag ]( state, t );
            //check
            expect( state.tags.length ).toBe( num - 1 );
            // expect( _.findIndex( state.tags, t ) ).toBe( -1 );
        } );
    } );

    describe( mTypes.associateTag, () => {
        it( 'updates the tag list on an item to include the tag', () => {
            payload = Payload.factory( { tag: tag, obj: item } );
            expect( item.tags.length ).toBe( 0 );
            //call
            mutations[ mTypes.associateTag ]( state, payload );
            //check
            expect( item.tags.length ).toBe( 1 );
            expect( _.findIndex( item.tags, tag ) ).not.toBe( -1 );
        } );
    } );

    describe( mTypes.disassociateTag, function () {
        it( 'removes the tag from the list on an item', () => {
            item.tags.push( tag );
            expect( item.tags.length ).toBe( 1 );
            payload = Payload.factory( { tag: tag, obj: item } );
            //call
            mutations[ mTypes.disassociateTag ]( state, payload );
            //check
            expect( item.tags.length ).toBe( 0 );
            expect( _.findIndex( item.tags, tag ) ).toBe( -1 );

        } );
    } );

} )
;
