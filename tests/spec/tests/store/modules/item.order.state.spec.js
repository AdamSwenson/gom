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

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../resources/assets/js/models/NodeTools'

//tested object
let obj = orderings.default;
//tested methods
let { getters, actions, mutations, state } = obj;

const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    addNodes( state.itemMap, numItems );
    for (let n of state.itemMap.children) {
        addNodes( n, numItems );
    }
};

fdescribe( "store.modules.item.order state ", function () {

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

});