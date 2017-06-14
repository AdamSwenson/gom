require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import { testAction, description, factories } from '../../helpers/vuex.spec.helpers';

import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from '../../helpers/items.tests.helpers'


//Dependencies
// import * as orderings from '../../../../resources/assets/js/store/modules/items.order';

// import * as mTypes from '../../../../resources/assets/js/store/mutation-types'
// import * as aTypes from '../../../../resources/assets/js/store/action-types'
// import * as gTypes from '../../../../resources/assets/js/store/getter-types'

// import Item from '../../../../../resources/assets/js/models/Item'
// import Payload from '../../../../resources/assets/js/models/Payload'
import Node from '../../../../resources/assets/js/models/Node'

import { traverseDF, traverseBF, getSerialNumber } from '../../../../resources/assets/js/models/NodeTools'

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

fdescribe( description( "NodeTools" ), function () {

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

