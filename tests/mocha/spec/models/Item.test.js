require( '../../injectglobals' );

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from '../../helpers/item-test-helpers'

//tested stuff
import Item from "../../../../resources/assets/js/models/Item.js" ;
import Comment from "../../../../resources/assets/js/models/Comment.js" ;

describe( " Item ", function () {

    let itemId, itemIndex, name, dataJson, item, object;

    describe( 'Serial numbering', function () {

        it( "Items have increasing serial numbers", function () {
            //Note that we're not assuming that they are consecutive
            //since the tests run async. That's fine because nothing depends
            //on the order of serial numbers.
            let results = [];
            let number = 10;
            for (var i = 0; i < number; i++) {
                results.push( new Item() );
            }

            //check
            expect( results.length ).toBe( number );
            let prevSN = 0;

            for (let i = 0; i < results.length; i++) {
                let item = results[ i ];
                window.console.log( 'Item.test', 'pr', 32, prevSN, item.serialNumber);

                if (i > 0){
                    expect( item instanceof Item ).toBe( true );
                    expect( item.serialNumber > prevSN ).toBe( true );
                }
                prevSN = item.serialNumber;
            }
        } );


    } );

    describe( description( "canSync" ), function () {
        it( "Returns false when id is -1", function () {
            let item = Item.factory();
            expect( item.id ).toBe( -1 );
            expect( item.canSync() ).toBe( false );
        } );

        it( "Returns true when id is 0", function () {
            let item = Item.factory( { id: 0 } );
            expect( item.id ).toBe( 0 );
            expect( item.canSync() ).toBe( true );
        } );

        it( "Returns true when id is > 0", function () {
            let id = faker.random.number();
            let item = Item.factory( { id: id } );
            expect( item.id ).toBe( id );
            expect( item.canSync() ).toBe( true );
        } );

    } );


    describe( "comment stuff ", function () {
        let comment;
        beforeEach( () => {
            item = new Item();
            comment = factories.commentFactory();
        } );

        it( "addComment adds comment at correct valence", function () {
            //call
            item.addComment( comment.valence, comment );

            //check
            expect( item.comments.get( comment.valence ) ).toMatchObject( comment );
        } );

        it( "getStockComment returns the stock comment ", function () {
            //call
            let result = item.getStockComment();

            //check
            expect( result.isStock() ).toBe( true );
            expect( result.valence ).toBe( 'stock' );
        } );


    } );

    describe( "factory  ", function () {

        beforeEach( function () {
            itemId = faker.random.number();
            itemIndex = faker.random.number();
            name = faker.random.number();

            dataJson = {
                id: itemId,
                index: itemIndex,
                name: name,

            }
            item = Item.factory( dataJson );
            object = item;
        } );

        it( "isObject ", function () {
            expect( typeof item ).toBe( 'object' );
        } );

        it( "is Item ", function () {
            expect( item instanceof Item ).toBe( true );
        } );

        it( "has id ", function () {
            // window.console.log( Item );
            expect( item.id ).toBe( itemId );
        } );

        it( "properties ", function () {
            _.forEach( dataJson, function ( k, v ) {
                expect( item[ k ] ).toBe( dataJson[ k ] );
            } );
        } );

    } );

} );
