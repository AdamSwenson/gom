//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import { addNodes, makeState, makeRootState, makeTestPayload, makeMutationPayload } from '../../../helpers/items.tests.helpers'


//Dependencies
import * as orderings from '../../../../../resources/assets/js/store/modules/orderings';

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



fdescribe( "store.modules.orderings  ", function () {

    beforeAll( function () {
//runs once before all tests
        this.numItems = 5;
        this.testItemIndex = faker.random.number( { min: 0, max: this.numItems - 1 } );
        this.filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( this.filledState.itemMap, this.numItems );
        for (let n of this.filledState.itemMap.children) {
            addNodes( n, this.numItems );
        }
        window.console.log( 'orderings.spec', 'filledState', 34, this.filledState );

    } );

    beforeEach( function () {
//runs before each test
    } );

    afterEach( function () {
//runs after each test
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
                window.console.log( 'orderings.spec', 'result', 86, result );

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
        describe( description( "getItemNodeFromOrder" ), function () {
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
                    if(t.children.length > 0){
                        for(let j=0;j<t.children.length;j++){
                            let jr = result.children[ j ];
                            let jt = test.children[ j ];
                            expect( jt.data ).toBe( jr.data );
                            expect( jr.children.length ).toBe( jt.children.length );
                        }
                    }

                }

            } );

        } );
    } );
    describe( description( 'mutations' ), function () {
        describe( description( 'add' ), function () {

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
    } );


} );