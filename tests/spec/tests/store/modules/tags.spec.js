//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';


//Dependencies
import * as tags from '../../../../../resources/assets/js/store/modules/tags';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../resources/assets/js/store/getter-types'

import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'
import Tag from '../../../../../resources/assets/js/models/Tag'

//tested object
let obj = tags.default;
//tested methods
let { getters, actions, mutations, state } = obj;


describe( "store.modules.tags | ", function () {
    beforeEach( function () {
        state.tags = [];
        state.associations = [];
    } );

    describe( description( 'helpers' ), function () {
        describe( description( 'getTagSerialNumbersFromObjectSerialNumber' ), function () {

        } );

    } );

    describe( description( "mutations" ), function () {
        describe( description( mTypes.createTag ), function () {
            it( 'happy path', function () {
                let pl = Payload.factory( { obj: Tag.factory() } );
                //call
                mutations[ mTypes.createTag ]( state, pl );
                //check
                expect( state.tags[ 0 ] ).toBe( pl.obj );
            } );
        } );

        describe( description( mTypes.updateTag ), function () {
            it( "happy path", function () {
                let t = Tag.factory( { name: 'taco' } );
                state.tags.push( t );
                let pl = Payload.factory( { obj: t, updateProp: 'name', updateVal: 'fish' } );

                //call
                mutations[ mTypes.updateTag ]( state, pl );

                //check
                window.console.log( 'tags.spec', 'state.tags', 58, state.tags );
                expect( state.tags[ 0 ][ 'name' ] ).toBe( 'fish' );
            } );
        } );

        describe( description( mTypes.destroyTag ), function () {
            //todo
        } );

        describe( description( mTypes.associateTag ), function () {
            beforeEach( function () {
                this.object = new Item();
                this.tag = new Tag();
            } );
            it( "happy path", function () {
                let pl = Payload.factory( { obj: this.object, tag: this.tag } );
                //call
                mutations[ mTypes.associateTag ]( state, pl );

                //check
                expect( state.associations[ this.object.serialNumber ][ 0 ] ).toBe( this.tag.serialNumber );
            } );

            it( "tag already present (no duplicates allowed)", function () {
                state.associations[ this.object.serialNumber ] = [];
                state.associations[ this.object.serialNumber ].push( this.tag.serialNumber );
                let pl = Payload.factory( { obj: this.object, tag: this.tag } );
                //call
                mutations[ mTypes.associateTag ]( state, pl );

                //check
                window.console.log( 'tags.spec', '', 93, state.associations );
                expect( state.associations[ this.object.serialNumber ].length ).toBe( 1 );
                expect( state.associations[ this.object.serialNumber ][ 0 ] ).toBe( this.tag.serialNumber );
            } );

        } );

        describe( description( mTypes.disassociateTag ), function () {
            xit( "happy path ", function () {
                //todo
            } );
        } );

    } );

    describe( description( "actions" ), function () {
        describe( description( 'processItemTags' ), function () {
            beforeEach( function () {

            } );

            describe( description( "Happy path" ), function () {
                it( "process normally", function () {
// let json = '{&quot;0&quot;:{&quot;id&quot;:1034,&quot;name&quot;:null,&quot;text&quot;:&quot;&quot;,&quot;displayText&quot;:null,&quot;comment_text&quot;:null,&quot;max_score&quot;:null,&quot;settings&quot;:null,&quot;exam_id&quot;:null,&quot;user_id&quot;:1,&quot;created_at&quot;:&quot;2017-08-07 16:56:25&quot;,&quot;updated_at&quot;:&quot;2017-08-07 16:56:25&quot;,&quot;deleted_at&quot;:null,&quot;comments&quot;:{},&quot;tags&quot;:{&quot;0&quot;:{&quot;id&quot;:1907,&quot;name&quot;:&quot;sssss&quot;,&quot;text&quot;:&quot;&quot;,&quot;props&quot;:{&quot;priority&quot;:&quot;1&quot;},&quot;user_id&quot;:1,&quot;created_at&quot;:&quot;2017-08-07 16:57:13&quot;,&quot;updated_at&quot;:&quot;2017-08-07 16:57:13&quot;,&quot;pivot&quot;:{&quot;item_id&quot;:1034,&quot;tag_id&quot;:1907,&quot;created_at&quot;:&quot;2017-08-07 16:57:18&quot;,&quot;updated_at&quot;:&quot;2017-08-07 16:57:18&quot;}}}}}';

                    let tag, itemObject;
                    let expectedMutations = [
                        {
                            type: mTypes.createTag,
                            payload: {
                                obj: tag,
                                mutateSilently: true
                            }
                        },
                        {
                            type: mTypes.associateTag,
                            payload: {
                                obj: itemObject,
                                tag: tag,
                                mutateSilently: true
                            }
                        }
                    ];
                    let payload = {}

                    testAction( actions.processItemTags, payload, state, expectedMutations, { getters: getters } );
                } );

            } );

        } );
    } );

    describe( "getters | ", function () {
        describe( gTypes.getTagBySerialNumber + ' | ', function () {
            beforeEach( function () {
                this.tag = new Tag();
            } );

            it( "happy path", function () {
                let state = {};
                state.tags = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    state.tags.push( new Tag() );
                }
                window.console.log( 'tags.spec', 'state.tags', 155, state.tags );
                //pick a random object to use for the text
                let testObj = faker.random.arrayElement( state.tags );
                window.console.log( 'tags.spec', 'testObj', 159, testObj );
                //call
                window.console.log( 'tags.spec', 'getters', 161, getters );
                let result = getters[ gTypes.getTagBySerialNumber ]( state, {}, {}, testObj.serialNumber );
                window.console.log( 'tags.spec', '', 162, result );
                //check
                expect( result ).toBe( testObj );
                expect( result.serialNumber ).toBe( testObj.serialNumber );
                //
                // // //prep
                // state.tags.push( this.tag );
                // let tsn = this.tag.serialNumber;
                // // window.console.log( 'items.spec', 'fs', 98, this.filledState );
                // //call
                // window.console.log( 'tags.spec', '', 153, state.tags, tsn);
                // // let result = getters.getTagBySerialNumber( tsn );
                // let result = getters[gTypes.getTagBySerialNumber]( state, getters, {}, tsn );
                // expect( result ).not.toBeEmpty();
                // expect( result ).toBe( this.tag );
            } );
        } );

        describe( 'getTagById' + ' | ', function () {
            it( "happy path | ", function () {
                let state = {};
                state.tags = [];
                let tag = Tag.factory({id: 4});
                state.tags.push(tag);

                //call
                let result = getters.getTagById(state, {}, {}, tag.id);

                //check
                expect(result).toBe(tag);
            } );
        } );

        describe( gTypes.getAllTags + ' | ', function () {
            beforeEach( function () {
            } );

            it( "happy path ", function () {
                window.console.log( 'tags.spec', 'state', state );
                let numTags = 4;
                for (let i = 0; i < numTags; i++) {
                    state.tags.push( new Tag() );
                }

                //call
                let result = getters.getAllTags( state, {}, {} );
                window.console.log( 'tags.spec', '', 202, result );
                //check
                expect( result.length ).toBe( numTags );
                _.forEach( result, function ( tag ) {
                    expect( tag instanceof Tag ).toBe( true );
                } );

            } );
        } );


        describe( gTypes.getTagsForObject + ' | ', function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );

        describe( description( 'isObjectTagged' ), function () {
            xit( "happy path | ", function () {
                //todo
            } );

        } );

    } );//getters


} );


