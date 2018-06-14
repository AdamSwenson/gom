var $ = require( 'jquery' );
window.$ = $;
//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );

const faker = require( 'faker' );

//tested stuff
import Item from "../../../../resources/assets/js/models/Item.js" ;
import Comment from "../../../../resources/assets/js/models/Comment.js" ;

describe( " Item ", function () {

    let itemId, itemIndex, name, dataJson, item, object;

    describe( 'tests of serial counter', function () {
        //otherwise the starting count of the serial
        //will be non-deterministic, since the first
        //time it is called on this page, it will count 1
        describe( 'Serial numbering', function () {
            it( "Items have consecutive serial numbers, starting at 1", function () {
                let results = [];
                let number = 10;
                for (var i = 0; i < number; i++) {
                    results.push( new Item() );
                }

                expect( results.length ).toBe( number );
                window.console.log( 'Item.spec', 'results', 39, results );
                let c = 1;
                for (let i = 0; i < results.length; i++) {
                    let item = results[ i ];

                    expect( item instanceof Item ).toBe( true );
                    expect( item.serialNumber ).toBe( c );
                    c += 1;
                }
            } );
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
            let id = faker.random.number;
            let item = Item.factory( { id: id } );
            expect( item.id ).toBe( id );
            expect( item.canSync() ).toBe( true );
        } );

    } );

    describe( 'all other tests', function () {

        beforeEach( function () {
            ItemId = faker.random.number();
            ItemIndex = faker.random.number();
            name = faker.random.number();

            dataJson = {
                id: ItemId,
                index: ItemIndex,
                name: name,

            }
            item = Item.factory( dataJson );
            object = item;
        } );


        describe( "getters and setters | ", () => {
            xit( "happy path | ", () => {
                //todo
            } );
        } );

        describe( "comment stuff ", function () {
            it( "initializeComment  ", function () {
                let itm = new Item();
                expect( itm.comments.size ).toBe( 0 );
                //call
                itm.initializeComments();
                //check
                expect( itm.comments.size ).toBe( Comment.valences.length );
                //iterate to make sure one of each
            } );

            it( "addComment ", function () {
                let itm = new Item();
                let comment = new Comment();
                expect( itm.comments.size ).toBe( 0 );

                //call
                itm.addComment( comment );

                //check
                expect( itm.comments.size ).toBe( 1 );
            } );

            it( "getStockComment ", function () {
                let itm = new Item();
                itm.initializeComments();

                expect( itm.comments.size ).toBe( 5 );

                //call
                let result = itm.getStockComment();

                //check
                expect( result.isStock() ).toBe( true );
                expect( result.valence ).toBe( 'stock' );

            } );

            it( "no stock set | ", function () {
                //todo
            } );

            it( "multiple stocks set | ", function () {
                //todo
            } );
        } );

        it( "getValencedComment ", function () {
            // getValencedComment( valence ) {
            //
            // }                 //todo
        } );

    } );


    describe( "factory | ", function () {
        beforeEach( function () {

        } );

        it( "isObject ", function () {
            expect( typeof Item ).toBe( 'object' );
        } );

        it( "is Item ", function () {
            expect( Item instanceof Item ).toBe( true );
        } );

        it( "has id ", function () {
            window.console.log( Item );
            expect( Item.id ).toBe( ItemId );
        } );

        it( "properties ", function () {
            let me = this;
            $.each( dataJson, function ( k, v ) {
                window.console.log( k, v );
                expect( me.Item[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );

    // describe("factory | ", () => {
    //     xit("happy path | ", () => {
    //         //todo
    //     });
    // });
} );
