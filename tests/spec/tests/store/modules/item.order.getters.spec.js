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
const getters = require('../../../../../resources/assets/js/store/modules/items.order.getters');
//import * as orderings from '../../../../../resources/assets/js/store/modules/items.order';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../resources/assets/js/store/getter-types'

import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../resources/assets/js/models/Node'

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../resources/assets/js/models/NodeTools'
//tested object
// let obj = orderings.default;
//tested methods
// let { getters, actions, mutations, state } = obj;

const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    addNodes( state.itemMap, numItems );
    for (let n of state.itemMap.children) {
        addNodes( n, numItems );
    }
};

describe( "store.modules.item.order getters  ", function () {

    beforeEach( function () {
        this.numItems = 5;
        this.testItemIndex = faker.random.number( { min: 0, max: this.numItems - 1 } );
        this.filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( this.filledState.itemMap, this.numItems );
        for (let n of this.filledState.itemMap.children) {
            addNodes( n, this.numItems );
        }
        // window.console.log( 'orderings.spec', 'filledState', 34, this.filledState );

    } );
    describe( description( gTypes.getItemNodeFromOrder ), function () {
        it( "happy path ", function () {
            //prep
            let targetNode = this.filledState.itemMap.children[ this.testItemIndex ];
            // window.console.log( 'orderings.spec', 'target', 133,targetNode );
            //call
            let result = getters[gTypes.getItemNodeFromOrder]( this.filledState, getters, {}, targetNode.data );

            // window.console.log( 'orderings.spec', 'result', 136, result);
            //check
            expect( result ).toBe( targetNode );
        } )

    } );

    describe( description( gTypes.getItemMapCopy ), function () {
        it( "happy path ", function () {
            let test = this.filledState.itemMap;
            let result = getters[ gTypes.getItemMapCopy ]( this.filledState, {} );
            // window.console.log( 'orderings.spec', 'result', 139, this.filledState, result, test );

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
                let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
                expect( result ).toBe( 0 );
            } );

            it( "question", function () {
                //this is the question number
                //prep
                let targetSerialNumber = this.filledState.itemMap.children[ this.testItemIndex ].data;
                //call
                let result = getters[ gTypes.getDepthOfNode ]( this.filledState, getters,  {}, targetSerialNumber );
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
                let result = getters[ gTypes.getDepthOfNode ]( this.filledState, getters, {},  targetSerialNumber );
                //check
                expect( result ).toBe( this.testItemIndex );
            } );

        } );
    } );

    describe( description( gTypes.getHeightOfNode ), function () {
        describe( description( "Happy paths" ), function () {

            it( "exam", function () {
                //prep
                let targetSerialNumber = this.filledState.itemMap.data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
                expect( result ).toBe( 0 );
            } );

            it( "question", function () {
                //prep
                let targetSerialNumber = this.filledState.itemMap.children[ this.testItemIndex ].data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
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
                let result = getters[ gTypes.getHeightOfNode ]( this.filledState, getters, {},  targetSerialNumber );
                //check
                //At the element level, so the result should be 0
                expect( result ).toBe( 2 );

            } );

        } );
    } );
} );
