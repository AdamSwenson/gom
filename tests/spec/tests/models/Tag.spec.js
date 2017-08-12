var $ = require('jquery');
window.$ = $;
//test libraries
require('jasmine-jquery');
require('sinon');

const faker = require('faker');

//tested stuff
import Tag from  "../../../../resources/assets/js/models/Tag.js" ;

describe(" models.Tag | ", function () {

    describe('styling  | ', function(){
        //otherwise the starting count of the serial
        //will be non-deterministic, since the first
        //time it is called on this page, it will count 1
        describe('getStyleKey | ', function(){
            it("happy path", function(){
                let numStyles = Object.keys(Tag.styleMap).length;
                for(let i=1; i<numStyles; i++){
                    let st = Tag.styleMap[i];
                    expect(Tag.getStyleKey(st)).toBe(i);
                }
            });
        });

        describe( "styleString | " , function () {
            it("happy path", function(){
                let numStyles = Object.keys(Tag.styleMap).length;
                // window.console.log( 'Tag.spec', 'numStyles', 31, numStyles);
                for(let i=1; i<numStyles; i++){
                    let tag = new Tag();
                    tag.priority = i;

                    // window.console.log( 'Tag.spec', 'i', 34, i , tag);

                    expect(tag.props.priority).toBe(i);
                    let r = tag.styleString();
                    let e = Tag.styleMap[i];
                    // window.console.log( 'Tag.spec', '', 41, r, e, tag );
                    expect(r).toBe(e);
                }
            });
        } );
    });


    describe( "factory | ", function () {
        beforeEach( function () {
this.Tag = new Tag();
        } );

        it( "isObject ", function () {
            expect( typeof this.Tag ).toBe( 'object' );
        } );

        it( "is Tag ", function () {
            expect( this.Tag instanceof Tag ).toBe( true );
        } );

        it( "has id ", function () {
            window.console.log( this.Tag );
            expect( this.Tag.id ).toBe( this.TagId );
        } );

        it( "properties ", function () {
            let me = this;
            $.each( this.dataJson, function ( k, v ) {
                window.console.log(k, v);
                expect( me.Tag[ k ] ).toBe( me.dataJson[ k ] );
            } );
        } );

    } );

    // describe("factory | ", () => {
    //     xit("happy path | ", () => {
    //         //todo
    //     });
    // });

});