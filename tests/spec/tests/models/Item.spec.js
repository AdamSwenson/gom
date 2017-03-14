var $ = require('jquery');
window.$ = $;
//test libraries
require('jasmine-jquery');
require('sinon');

const faker = require('faker');

//tested stuff
import Item from  "../../../../resources/assets/js/models/Item.js" ;
import Comment from  "../../../../resources/assets/js/models/Comment.js" ;

fdescribe(" models.Item | ", function () {

    beforeEach(function () {
        this.ItemId = faker.random.number();
        this.ItemIndex = faker.random.number();
        this.name = faker.random.number();

        this.dataJson = {
            id: this.ItemId,
            index: this.ItemIndex,
            name: this.name,

        }
        this.Item = Item.factory( this.dataJson );
        this.object = this.Item;
    });


    describe("getters and setters | ", () => {
        xit("happy path | ", () => {
            //todo
        });
    });

    describe("comment stuff | ", function(){
        describe('initializeComment | ', function(){
            it( "happy path | ", function () {
                let itm = new Item();
                expect(itm.comments.size).toBe(0);
                //call
                itm.initializeComments();
                //check
                expect(itm.comments.size).toBe(Comment.valences.length);
                //iterate to make sure one of each
            } );
        });

        describe('addComment', function(){
            it( "happy path | ", function () {
                let itm = new Item();
                let comment = new Comment();
                expect(itm.comments.size).toBe(0);

                //call
                itm.addComment(comment);

                //check
                expect(itm.comments.size).toBe(1);
            } );
        });

        describe( "getStockComment | ", function () {
            it( "happy path | ", function () {
                let itm = new Item();
                itm.initializeComments();

                expect(itm.comments.size).toBe(5);

                //call
                let result = itm.getStockComment();

                //check
                expect(result.isStock()).toBe(true);
                expect(result.valence).toBe('stock');

            } );

            it( "no stock set | ", function () {
                //todo
            } );

            it( "multiple stocks set | ", function () {
                //todo
            } );
        } );

        describe( "getValencedComment | ", function () {

            it( "happy path | ", function () {
                // getValencedComment( valence ) {
                //
                // }                 //todo
            } );
        } );

    });


    describe( "factory | ", function () {
        beforeEach( function () {

        } );

        it( "isObject ", function () {
            expect( typeof this.Item ).toBe( 'object' );
        } );

        it( "is Item ", function () {
            expect( this.Item instanceof Item ).toBe( true );
        } );

        it( "has id ", function () {
            window.console.log( this.Item );
            expect( this.Item.id ).toBe( this.ItemId );
        } );

        it( "properties ", function () {
            let me = this;
            $.each( this.dataJson, function ( k, v ) {
                window.console.log(k, v);
                expect( me.Item[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );

    // describe("factory | ", () => {
    //     xit("happy path | ", () => {
    //         //todo
    //     });
    // });

});