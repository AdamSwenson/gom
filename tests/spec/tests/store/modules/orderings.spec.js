//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from '../../../helpers/items.tests.helpers'


//Dependencies
import * as orderings from '../../../../../resources/assets/js/store/modules/items.order';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../resources/assets/js/store/getter-types'

import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../resources/assets/js/models/Node'

//tested object
let obj = orderings.default;
//tested methods
let { getters, actions, mutations, state, traverseBF, traverseDF } = obj;

const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    addNodes( state.itemMap, numItems );
    for (let n of state.itemMap.children) {
        addNodes( n, numItems );
    }
};

fdescribe( "store.modules.item.order  ", function () {

    beforeEach( function () {
        this.numItems = 5;
        this.testItemIndex = faker.random.number( { min: 0, max: this.numItems - 1 } );
        this.filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( this.filledState.itemMap, this.numItems );
        for (let n of this.filledState.itemMap.children) {
            addNodes( n, this.numItems );
        }
        window.console.log( 'orderings.spec', 'filledState', 34, this.filledState );

    } );

    describe( description( 'itemMap properties' ), function () {
        it( "itemMap is expected Node object ", function () {
            window.console.log( 'orderings.spec', 'state', 41, state );
            expect( state.itemMap.data ).toBe( 0 );
            expect( state.itemMap.parent ).toBe( 0 );
            expect( state.itemMap.children.length ).toBe( 0 )
            // expect(state.itemMap instanceof Node).toBe(true);
        } );
    } );

    describe( description( 'helpers ' ), function () {
        describe( description( 'traverseDF' ), function () {

            it( "happy path", function () {
                let targetNode = this.filledState.itemMap.children[ this.testItemIndex ];
                window.console.log( 'orderings.spec', 'testItemIndex', 73, this.testItemIndex );
                var callback = function ( node ) {
                    if ( !callback.found ) callback.found = [];

                    if ( node.data === targetNode.data ) {
                        callback.found.push( node );
                        return true;
                    }
                    return false;
                };

                let j = traverseDF( this.filledState.itemMap, callback );
                let result = callback.found[ 0 ];
                expect( result ).toBe( targetNode );
            } );
        } );

        describe( description( 'traverseBF' ), function () {

            it( "happy path", function () {
                let targetNode = this.filledState.itemMap.children[ this.testItemIndex ];

                var callback = function ( node ) {
                    if ( !callback.found ) callback.found = [];
                    // window.console.log( 'orderings.spec', 'callback', 74, node.data, targetNode.data);

                    if ( node.data === targetNode.data ) {
                        callback.found.push( node );
                        // window.console.log( 'orderings.spec', 'callback.found', 78, node, callback.found );
                        return true;
                    }
                    return false;
                };
                traverseBF( this.filledState.itemMap, callback );
                let result = callback.found[ 0 ];

                // window.console.log( 'orderings.spec', 'found', 83, callback.found);
                expect( result ).toBe( targetNode );

            } );
        } );
    } );

    describe( description( "getters" ), function () {
        describe( description( gTypes.getItemNodeFromOrder ), function () {
            it( "happy path ", function () {
                //prep
                let targetNode = this.filledState.itemMap.children[ this.testItemIndex ];
                // window.console.log( 'orderings.spec', 'target', 133,targetNode );
                //call
                let result = getters.getItemNodeFromOrder( this.filledState, getters, targetNode.data );

                // window.console.log( 'orderings.spec', 'result', 136, result);
                //check
                expect( result ).toBe( targetNode );
            } )

        } );

        describe( description( gTypes.getItemMapCopy ), function () {
            it( "happy path ", function () {
                let test = this.filledState.itemMap;
                let result = getters[ gTypes.getItemMapCopy ]( this.filledState, {} );
                window.console.log( 'orderings.spec', 'result', 139, this.filledState, result, test );

                //todo rewrite recursively to check  all children
                for (let i = 0; i < test.children.length; i++) {
                    let r = result.children[ i ];
                    let t = test.children[ i ];
                    expect( t.data ).toBe( r.data );
                    expect( r.children.length ).toBe( t.children.length );
                    if ( t.children.length > 0 ) {
                        for (let j = 0; j < t.children.length; j++) {
                            let jr = result.children[ j ];
                            let jt = test.children[ j ];
                            expect( jt.data ).toBe( jr.data );
                            expect( jr.children.length ).toBe( jt.children.length );
                        }
                    }

                }

            } );

        } );

        describe( description( gTypes.getDepthOfNode ), function () {
            describe( description( "Happy paths" ), function () {
                it( "exam", function () {
                    //prep
                    let targetSerialNumber = this.filledState.itemMap.data;
                    //call
                    let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    //At the exam level, so the result should be 0
                    expect( result ).toBe( 0 );
                } );

                it( "question", function () {
                    //this is the question number
                    //prep
                    let targetSerialNumber = this.filledState.itemMap.children[ this.testItemIndex ].data;
                    //call
                    let result = getters[ gTypes.getDepthOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    //At the question level,
                    expect( result ).toBe( this.testItemIndex );

                } );

                it( "element", function () {
                    //prep
                    let targetSerialNumber = this.filledState
                        .itemMap
                        .children[ this.testItemIndex ]
                        .children[ this.testItemIndex ]
                        .data;
                    //call
                    let result = getters[ gTypes.getDepthOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    expect( result ).toBe( this.testItemIndex );
                } );

            } );
        });

        describe( description( gTypes.getHeightOfNode ), function () {
            describe( description( "Happy paths" ), function () {

                it( "exam", function () {
                    //prep
                    let targetSerialNumber = this.filledState.itemMap.data;
                    //call
                    let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    //At the exam level, so the result should be 0
                    expect( result ).toBe( 0 );
                } );

                it( "question", function () {
                    //prep
                    let targetSerialNumber = this.filledState.itemMap.children[ this.testItemIndex ].data;
                    //call
                    let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    //At the exam level, so the result should be 0
                    expect( result ).toBe( 1 );

                } );

                it( "element", function () {
                    //prep
                    let targetSerialNumber = this.filledState
                        .itemMap
                        .children[ this.testItemIndex ]
                        .children[ this.testItemIndex ]
                        .data;
                    //call
                    let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters, targetSerialNumber );
                    //check
                    //At the element level, so the result should be 0
                    expect( result ).toBe( 2 );

                } );

            } );
        } );
    } );


    describe( description( 'mutations' ), function () {
        xdescribe( description( 'add' ), function () {

            it( "happy path", function () {
                let parent = { serialNumber: 0 };
                let toAdd = new Item();
                let payload = { obj: toAdd, parent: parent };
                //call
                mutations.add( state, payload );
                // window.console.log( 'orderings.spec', 'add', 76, state );
                //check
                //parent is unchanged other than children
                expect( state.itemMap.data ).toBe( 0 );
                expect( state.itemMap.parent ).toBe( 0 );
                expect( state.itemMap.children.length ).toBe( 1 );
                //the added node has the parent's id set properly
                expect( state.itemMap.children[ 0 ].parent ).toBe( state.itemMap.data );

            } );
        } );

        describe( description( 'remove' ), function () {

            it( "happy path", function () {

                let parent = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
                let numChildren = parent.children.length;
                let toRemove = parent.children[ faker.random.number( { min: 0, max: parent.children.length - 1 } ) ];
                let toRemoveSerial = toRemove.data;
                let payload = { obj: toRemove, parent: parent };

                //call
                mutations.remove( this.filledState, payload );
                // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

                //check
                let result = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
                ;
                //parent is unchanged other than children
                expect( parent.data ).toBe( result.data );
                expect( parent.parent ).toBe( result.parent );
                expect( parent.children.length ).toBe( numChildren - 1 );
                //make sure not in array
                for (let i = 0; i < parent.children; i++) {
                    expect( parent.children[ i ].data ).not.toBe( toRemoveSerial );

                }
            } );
        } );

        describe( description( 'insert' ), function () {

            describe( description( 'happy paths' ), function () {

                it( "no index set", function () {
                    //Should just push onto the end of the parent's children
                    //array

                    let parent = this.filledState.itemMap.children[ this.testItemIndex ].children[ this.testItemIndex ];
                    let numChildren = parent.children.length;
                    let toAddSerial = faker.random.number();

                    let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code
                    let payload = { obj: toAdd, parent: parent };

                    //call
                    mutations.insert( this.filledState, payload );
                    // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

                    //check
                    let result = this.filledState.itemMap.children[ this.testItemIndex ].children[ this.testItemIndex ];
                    //parent properties are unchanged (other than children)
                    expect( result.data ).toBe( parent.data );
                    expect( result.parent ).toBe( parent.parent );
                    expect( result.children.length ).toBe( numChildren + 1 );
                    //check the node we added
                    let added = result.children[ result.children.length - 1 ];
                    expect( added ).toBe( toAdd );
                    // explicitly check that it has the parent's isn set properly
                    expect( added.parent ).toBe( parent.data );

                } );

                it( "index set", function () {
                    //Should splice into particular location of
                    // the parent's children array
                    let parent = this.filledState.itemMap.children[ this.testItemIndex ];//.children[ this.testItemIndex ];
                    let numChildren = parent.children.length;
                    let toAddSerial = faker.random.number();
                    let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code
                    let index = faker.random.number( { min: 0, max: parent.children.length - 1 } )

                    //call
                    let payload = { index: index, obj: toAdd, parent: parent };
                    mutations.insert( this.filledState, payload );
                    // window.console.log( 'orderings.spec', 'add', 76, this.filledState );

                    //check
                    let result = this.filledState.itemMap.children[ this.testItemIndex ];//children[ this.testItemIndex ];
                    //parent properties are unchanged (other than children)
                    expect( result.data ).toBe( parent.data );
                    expect( result.parent ).toBe( parent.parent );
                    expect( result.children.length ).toBe( numChildren + 1 );

                    //check the node we added
                    let added = result.children[ index ];
                    expect( added.data ).toBe( toAddSerial );
                    expect( added.children.length ).toBe( toAdd.children.length );
                    // explicitly check that it has the parent's isn set properly
                    expect( added.parent ).toBe( parent.data );
                } );

            } );

        } );

    } );

    describe( description( "actions" ), function () {
        describe( description( aTypes.addItemToOrder ), function () {
            describe( description( "happy paths" ), function () {
                it( "no index", function () {
                    let parent = this.filledState.itemMap.children[ this.testItemIndex ];
                    let getters = {
                        [gTypes.getItemNodeFromOrder]: () => {
                        }
                    };
                    let toAdd = new Item();

                    //Expected endpoint
                    let expectedPayload = Payload.factory( { parent: parent, obj: toAdd } );

                    let expectedMutations = [
                        { type: 'insert', payload: expectedPayload }
                    ];
                    // let payload = toRemove.serialNumber;
                    let payload = Payload.factory( { obj: toAdd, parent: parent } );

                    //Checks that the appropriate mutations are called
                    testAction( actions[ aTypes.addItemToOrder ], payload, this.filledState, expectedMutations, {
                        verbose: true,
                        getters: getters
                    } );
                } );

                it( "with index", function () {
                    let parent = this.filledState.itemMap.children[ this.testItemIndex ];
                    let getters = {
                        [gTypes.getItemNodeFromOrder]: () => {
                        }
                    };
                    let toAdd = new Item();
                    let index = faker.random.number();

                    //Expected endpoint
                    let expectedPayload = Payload.factory( { parent: parent, obj: toAdd, index: index } );

                    let expectedMutations = [
                        { type: 'insert', payload: expectedPayload }
                    ];

                    // let payload = toRemove.serialNumber;
                    let payload = Payload.factory( {
                        index: index,
                        obj: toAdd,
                        parent: parent
                    } );

                    //Checks that the appropriate mutations are called
                    testAction( actions[ aTypes.addItemToOrder ], payload, this.filledState, expectedMutations, {
                        verbose: true,
                        getters: getters
                    } );
                } );
            } );
        } );

        describe( description( aTypes.removeItemFromOrder ), function () {
            describe( description( "happy paths" ), function () {
                it( "by serial number", function () {
                    let toRemove = this.filledState.itemMap.children[ this.testItemIndex ];
                    let parent = this.filledState.itemMap;
                    let getters = {
                        [gTypes.getItemNodeFromOrder]: () => {
                        }
                    };

                    // //now create a spy for the getters object it expects
                    let spyGetter = sinon.mock( getters, gTypes.getItemNodeFromOrder );
                    spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.data ).returns( toRemove );
                    spyGetter.expects( gTypes.getItemNodeFromOrder ).withArgs( toRemove.parent ).returns( parent );

                    //Expected endpoint
                    let expectedPayload = Payload.factory( { parent: parent, obj: toRemove } );

                    let expectedMutations = [
                        { type: 'remove', payload: expectedPayload }
                    ];
                    // let payload = toRemove.serialNumber;
                    let payload = Payload.factory( { serialNumber: toRemove.data } );

                    //Checks that the appropriate mutations are called
                    testAction( actions[ aTypes.removeItemFromOrder ], payload, this.filledState, expectedMutations, {
                        verbose: true,
                        getters: getters
                    } );

                    //check that the method was called on the spy
                    expect( spyGetter.verify() ).toBe( true );
                } );
            } );
        } );
    } );
});