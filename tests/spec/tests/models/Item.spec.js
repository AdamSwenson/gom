var $ = require('jquery');
window.$ = $;
//test libraries
require('jasmine-jquery');
require('sinon');

const faker = require('faker');

//tested stuff
import Item from  "../../../../resources/assets/js/models/Item.js" ;

describe(" models.Item | ", function () {

    beforeEach(function () {
        this.ItemId = faker.random.number();
        this.ItemIndex = faker.random.number();
        this.name = faker.random.number();

        this.dataJson = {
            ItemId: this.ItemId,
            ItemIndex: this.ItemIndex,
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