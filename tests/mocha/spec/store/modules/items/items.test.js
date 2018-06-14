import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

var compName = 'items';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.js' );

require( '../../../../injectglobals' );

//The name of the tested component
import { addNodes, makeFilledState } from "../../../../helpers/item-test-helpers";
import Node from "../../../../../../resources/assets/js/models/Node";
import Item from "../../../../../../resources/assets/js/models/Item";

//tested object

import { createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();
localVue.use( Vuex )

let { actions, getters, mutations, state } = Component.default;

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let filledState, numItems, expectedIds;
    let parent;
    beforeEach( () => {

    } );


    describe( description( "actions (defined in items.js, not imported" ), function () {
        describe( description( aTypes.createItem ), function () {
            beforeEach( function () {
                let s = { itemMap: new Node( 0, 0 ) };
                filledState = makeFilledState( s, numItems );
            } );

            describe( description( "Happy path" ), function () {
                it( "parent defined", function ( done ) {

                    let state = { itemMap: new Node( 0, 0 ) };
                    makeFilledState( state, 5 );
                    window.console.log( 'items.spec', 'ff', 56, state );
                    //prep
                    let parent = state.itemMap.children[ 1 ]; //has to be a parent
                    let payload = parent.data; //has to be a parent
                    let expectedItem = Item.factory( { parent: parent.data } );

                    let expectedMutations = [
                        {
                            type: mTypes.addNewItem,
                            payload: {
                                parent: parent.data,
                                // obj: expectedItem //this won't work because of serial numbers
                            }
                        },
                        {
                            type: mTypes.insertNodeIntoOrder
                        }
                    ];

                    testAction( actions[ aTypes.createItem ], payload, state, expectedMutations, { getters: getters } );
                    done();
                } );

                // xit( "parent not defined", function () {
                //
                // } );
            } );

        } );
    } );


    describe( 'getters (defined in items, not imported)', () => {
        let rootId, root, parentId, store;

        beforeEach( function () {
            parent = new Item();
            filledState = {
                items: [ parent ],
                itemMap: new Node( parent.serialNumber, parent.serialNumber )
            };
            makeFilledState( filledState, 5 );
            rootId = 1;
            parentId = 2;
            root = new Node( rootId, rootId );
            state = { itemMap: root };
            parent = new Node( parentId, rootId );
            root.children.push( parent );

            getters[ gTypes.getItemBySerialNumber ] = ( state, getters ) => {
                return factories.itemFactory();
            };

            store = new Vuex.Store( {
                state, getters
            } );
        } );


        describe( 'getOrderForSync ', function () {

            it( "happy path", function () {
                //prep
                // window.console.log( 'items.spec', 'fs', 98, filledState );
                //call
                let result = getters.getOrderForSync( filledState, getters, {} );
                expect( result ).toBeTruthy();
            } );
        } );


        describe( gTypes.getSortedIds, function () {
            beforeEach( function () {
                numItems = 5;
                expectedIds = [];
                state.itemMap = new Node( 0, 0 );
                addNodes( state.itemMap, numItems );
                for (let n of state.itemMap.children) {
                    addNodes( n, numItems );
                }

                let serialNumbers = addNodes.isns;

                // window.console.log( 'items.spec', 'serialNumbers', 259, serialNumbers );
                //Now make corresponding items for the items array
                for (let i = 0; i < serialNumbers.length; i++) {
                    let a = new Item();
                    a.serialNumber = serialNumbers[ i ];
                    a.id = 2 * a.serialNumber;
                    expectedIds.push( a.id );
                    state.items.push( a );
                }

                store = new Vuex.Store( {
                    state, getters
                } );
            } );

            it( "happy path ", function () {
                // window.console.log( 'items.spec', 'state', 275, state );
                let result = store.getters[ gTypes.getSortedIds ];
                var expectedIds = expectedIds;
                let tester = function ( currentNode ) {
                    // window.console.log( 'items.spec', 'tester', 182, currentNode);
                    //ignore the exam1
                    if ( currentNode.data === 0 ) return true;

                    //Check the type and that the id is one of the expected
                    expect( currentNode.dataType ).toBe( 'id' );
                    expect( expectedIds.includes( currentNode.data ) ).toBe( true );
                    // window.console.log( 'items.spec', 'tester', 188, 'tested', currentNode);
                    //Check that the order is as expected
                    let nodeId = currentNode.data;
                    return true;
                };

                //Check that received the exam1
                expect( result instanceof Node ).toBe( true );
                expect( result.data ).toBe( 0 );
                expect( result.children.length ).toBe( numItems );
                // window.console.log( 'items.spec', 'result ----', 197, result );
                //check the children
                (function recurse( currentNode ) {
                    for (var i = 0, length = currentNode.children.length; i < length; i++) {
                        recurse( currentNode.children[ i ] );
                    }
                    tester( currentNode );
                })( result );
            } );
        } );

        describe( description( "canSync" ), function () {
            it( "all items have ids", function () {
                //prep
                state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    state.items[ i ] = factories.itemFactory( 1, i );
                }

                store = new Vuex.Store( {
                    state, getters
                } );
                //call and check
                expect( store.getters.canSync ).toBe( true );
            } );

            it( "one item lacks id", function () {
                //prep
                state.items = [];
                let numItems = 3;
                for (let i = 0; i < numItems; i++) {
                    state.items[ i ] = factories.itemFactory( 1, i );
                    ;
                }
                state.items.push( new Item() );

                store = new Vuex.Store( {
                    state, getters
                } );
                //call and check
                expect( store.getters.canSync ).toBe( false );
            } );
            it( "empty items list", function () {
                //prep
                state.items = [];

                store = new Vuex.Store( {
                    state, getters
                } );
                //call and check
                expect( store.getters.canSync ).toBe( false );
            } );
        } );

    } );


} );
