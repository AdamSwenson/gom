
var compName = 'items.order.getters';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.getters.js' );

require( '../../../../injectglobals' );


import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../../resources/assets/js/models/Node'

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../../resources/assets/js/models/NodeTools'
import { addNodes } from "../../../../helpers/item-test-helpers";

//tested object
let getters = Component;

const testAction = helpers.testAction;
const description = helpers.description;


const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    addNodes( state.itemMap, numItems );
    for (let n of state.itemMap.children) {
        addNodes( n, numItems );
    }
};

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let numItems, filledState, testItemIndex;

    beforeEach( () => {
        numItems = 5;
        testItemIndex = faker.random.number( { min: 0, max: numItems - 1 } );
        filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( filledState.itemMap, numItems );
        for (let n of filledState.itemMap.children) {
            addNodes( n, numItems );
        }

    } );

    describe( description( gTypes.getItemNodeFromOrder ), function () {
        it( "happy path ", function () {
            //prep
            let targetNode = filledState.itemMap.children[ testItemIndex ];
            // window.console.log( 'orderings.spec', 'target', 133,targetNode );
            //call
            let result = getters[gTypes.getItemNodeFromOrder]( filledState, getters, {}, targetNode.data );

            // window.console.log( 'orderings.spec', 'result', 136, result);
            //check
            expect( result ).toBe( targetNode );
        } )

    } );

    describe( description( gTypes.getItemMapCopy ), function () {
        it( "happy path ", function () {
            let test = filledState.itemMap;
            let result = getters[ gTypes.getItemMapCopy ]( filledState, {} );
            // window.console.log( 'orderings.spec', 'result', 139, filledState, result, test );

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
                let targetSerialNumber = filledState.itemMap.data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
                expect( result ).toBe( 0 );
            } );

            it( "question", function () {
                //this is the question number
                //prep
                let targetSerialNumber = filledState.itemMap.children[ testItemIndex ].data;
                //call
                let result = getters[ gTypes.getDepthOfNode ]( filledState, getters,  {}, targetSerialNumber );
                //check
                //At the question level,
                expect( result ).toBe( testItemIndex );

            } );

            it( "element", function () {
                //prep
                let targetSerialNumber = filledState
                    .itemMap
                    .children[ testItemIndex ]
                    .children[ testItemIndex ]
                    .data;
                //call
                let result = getters[ gTypes.getDepthOfNode ]( filledState, getters, {},  targetSerialNumber );
                //check
                expect( result ).toBe( testItemIndex );
            } );

        } );
    } );

    describe( description( gTypes.getHeightOfNode ), function () {
        describe( description( "Happy paths" ), function () {

            it( "exam", function () {
                //prep
                let targetSerialNumber = filledState.itemMap.data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
                expect( result ).toBe( 0 );
            } );

            it( "question", function () {
                //prep
                let targetSerialNumber = filledState.itemMap.children[ testItemIndex ].data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( filledState, getters,  {}, targetSerialNumber );
                //check
                //At the exam1 level, so the result should be 0
                expect( result ).toBe( 1 );

            } );

            it( "element", function () {
                //prep
                let targetSerialNumber = filledState
                    .itemMap
                    .children[ testItemIndex ]
                    .children[ testItemIndex ]
                    .data;
                //call
                let result = getters[ gTypes.getHeightOfNode ]( filledState, getters, {},  targetSerialNumber );
                //check
                //At the element level, so the result should be 0
                expect( result ).toBe( 2 );

            } );

        } );
    } );
} );
