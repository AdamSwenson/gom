import { testActionAsync } from "../../../../helpers/test-helpers";

var compName = 'items';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.js' );

require( '../../../../injectglobals' );

//The name of the tested component
import { addNodes, makeFilledState } from "../../../../helpers/item-test-helpers";
import Node from "../../../../../../resources/assets/js/models/Node";
import Item from "../../../../../../resources/assets/js/models/Item";

import { Routes } from "../../../../../../resources/assets/js/api/apiSettings";

import { createLocalVue } from 'vue-test-utils';

window.axios = require( 'axios' );

const localVue = createLocalVue();
localVue.use( Vuex )

let { actions, getters, mutations, state } = Component.default;

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let filledState, numItems, expectedIds, expectedId;
    let parent;


    describe( description( "actions (defined in items.js, not imported" ), function () {
        let dispatch, commit, expectedItem, expectedPayload;
        describe( description( aTypes.createItem ), function () {
            beforeEach( function () {
                moxios.install();
                let s = { itemMap: new Node( 0, 0 ) };
                filledState = makeFilledState( s, numItems );

                expectedId = helpers.randomInteger();
                let state = { itemMap: new Node( 0, 0 ) };
                makeFilledState( state, 5 );
                //prep
                parent = state.itemMap.children[ 1 ]; //has to be a parent
                payload = parent.data; //has to be a parent
                expectedItem = Item.factory( { parent: parent.data, id: expectedId } );

                moxios.stubRequest( Routes.createItem(), {
                    status: 200,
                    response: { id: expectedId }
                } );

                //since it will need to dispatch the add item to order action
                dispatch = sinon.stub();
                dispatch.resolves( true );

                expectedPayload = Payload.factory( {
                    obj: expectedItem,
                    parent: parent.data,
                    mutateSilently: true
                } );

                commit = sinon.spy();


                // let p = actions[ aTypes.createItem ]( { state, commit, dispatch, getters }, )


                // helpers.testActionAsync( actions[ aTypes.createItem ], payload, state, expectedMutations, done, { getters: getters, dispatch  } );
                //
            } );
            afterEach( () => {
                moxios.uninstall();
            } );

            it( " calls addNewItem mutation after getting new id from the server", ( done ) => {
                let p = actions[ aTypes.createItem ]( { state, commit, dispatch, getters }, payload );
                p.then( function () {
                    //a mutation was called
                    expect( commit.callCount ).toBe( 1 );
                    //it was the correct one
                    expect( commit.args[ 0 ][ 0 ] ).toBe( mTypes.addNewItem );
                    //it had the correct payload
                    // we have to do this piecemeal rather than
                    // just comparing the payloads because a new item
                    // thus it will have different properties than the factory created item
                    let receivedPayload = commit.args[ 0 ][ 1 ];
                    //the thing we care most about is that the id from the server was added
                    expect( receivedPayload.obj.id ).toBe( expectedPayload.obj.id );
                    expect( receivedPayload.mutateSilently ).toBe( expectedPayload.mutateSilently );
                    expect( receivedPayload.parent ).toBe( expectedPayload.parent );
                    done();
                } );

            } );

            it( " dispatches the addItemToOrder action", ( done ) => {
                let p = actions[ aTypes.createItem ]( { state, commit, dispatch, getters }, payload );
                p.then( function () {
                    expect( dispatch.callCount ).toBe( 1 );
                    //it was the correct action
                    expect( dispatch.args[ 0 ][ 0 ] ).toBe( aTypes.addItemToOrder );
                    //it had the correct payload
                    //Again we have to do this piecemeal rather than
                    // just comparing the payloads because a new item
                    // thus it will have different properties than the factory created item
                    let receivedPayload = dispatch.args[ 0 ][ 1 ];
                    expect( receivedPayload.obj.id ).toBe( expectedPayload.obj.id );
                    expect( receivedPayload.mutateSilently ).toBe( expectedPayload.mutateSilently );
                    expect( receivedPayload.parent ).toBe( expectedPayload.parent );
                    done();
                } );

            } );
        } );
    } );

    describe( 'getters (defined in items.js, not imported)', () => {
        let rootId, root, parentId, store;

        beforeEach( function () {
            item = factories.itemFactory();
            parent = factories.examFactory();

            // parent = itemFactory();
            filledState = {
                items: [ parent ],
                itemMap: new Node( parent.serialNumber, parent.serialNumber )
            };
            makeFilledState( filledState, 5 );

            // rootId = 1;
            // parentId = 2;
            // root = new Node( rootId, rootId );
            // state = { itemMap: root };
            // parent = new Node( parentId, rootId );
            // root.children.push( parent );

            getters[ gTypes.getActiveExam ] = () => () => exam;
            // getters[gTypes.getItemBySerialNumber] = (  ) => (  ) => item;

            store = new Vuex.Store( {
                state: filledState, getters
            } );
        } );


        describe( 'getOrderForSync ', function () {

            it( "happy path", function () {
                //call
                let result = store.getters.getOrderForSync;

                expect( result ).toBeTruthy();
            } );
        } );


        describe( gTypes.getSortedIds, function () {
            // beforeEach( function () {
            //     numItems = 5;
            //     expectedIds = [];
            //     state.itemMap = new Node( 0, 0 );
            //     let newItems = addNodes( state.itemMap, numItems );
            //     state.items += newItems;
            //     for (let n of state.itemMap.children) {
            //         let moreNewItems = addNodes( n, numItems );
            //         //this created items and pushed their serial numbers into
            //         //the itemMap. We thus need to add the id to the state
            //         state.items += moreNewItems;
            //     }
            //
            //     // let serialNumbers = addNodes.isns;
            //     //
            //     // // window.console.log( 'items.spec', 'serialNumbers', 259, serialNumbers );
            //     // //Now make corresponding items for the items array
            //     // for (let i = 0; i < serialNumbers.length; i++) {
            //     //     let a = new Item();
            //     //     a.serialNumber = serialNumbers[ i ];
            //     //     a.id = 2 * a.serialNumber;
            //     //     expectedIds.push( a.id );
            //     //     state.items.push( a );
            //     // }
            //
            //     getters[gTypes.getItemMapCopy] = (  ) => () => state.itemMap;
            //
            //     store = new Vuex.Store( {
            //         state, getters
            //     } );
            // } );

            it( "returns a list of ids in sorted order ", function () {
                // window.console.log( 'items.spec', 'state', 275, state );
                let result = store.getters[ gTypes.getSortedIds ];
                var expectedIds = [];
                _.forEach( filledState.items, function ( item ) {
                    expectedIds.push( item );
                } )

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
