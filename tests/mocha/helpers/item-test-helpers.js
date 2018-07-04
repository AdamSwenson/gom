/**
 * Created by adam on 5/28/17.
 */


require( '../injectglobals' );
const testAction = helpers.testAction;
const description = helpers.description;

import Payload from '../../../resources/assets/js/models/Payload';

import Item from '../../../resources/assets/js/models/Item';

import Node from '../../../resources/assets/js/models/Node';

/**
 * This creates items and pushes their serial numbers into
 * child nodes of the parent.
 * It returns the new item objects so that we
 * can manually add them to the state's item list, if
 * needed.
 * @param parentNode
 * @param number
 * @returns {Array}
 */
export const addNodes = ( parentNode, number ) => {
    if ( ! addNodes.isns) addNodes.isns = [];
    let id = parentNode.data;
    let createdItems = []
    for (let i = 0; i < number; i++) {
        let it = factories.itemFactory();
        createdItems.push(it);
        let o = new Node( it.serialNumber, id );
        addNodes.isns.push(it.serialNumber);
        parentNode.children.push( o )
    }
    return createdItems;
};

export const makeState = ( n = 5 ) => {

    let s = makeRootState();

    for (let i = 0; i < n; i++) {
        let e = factories.itemFactory( i );
        s.items[ i ] = e;
        s.indexMap.set( e.id, i );
    }
    return s;
};

export const makeFilledState = ( state, numItems = 5, testIndex = null ) => {
    let newItems = addNodes( state.itemMap, numItems );
    //this created items and pushed their serial numbers into
    //the itemMap. It returns the item objects so that
    // we can add them to the state's item list
    state.items += newItems;
    for (let n of state.itemMap.children) {
        let moreNewItems = addNodes( n, numItems );

        state.items += moreNewItems;
    }

};

export const makeRootState = function () {
    return {
        /**
         * Object indexed by Item id holding Item objects
         On load the root exam1 object and first item are created but given no
         ids. thus we will eventually need to create an exam1 object if one isn't set

         However don't ask the server to create an id just yet
         lookup the exam1 object that resides at index 0
         this will have either been newly created on page load
         or it will be an existing exam1 object loaded from the db
         let exam1 = this.$store.getters[ gTypes.getActiveExamObj ];
         //Call the set active exam1 method
         //We do this rather than call the mutation directly
         //because there may need to be various other events and
         //things which need to happen depending on the context.
         //                this.$store.dispatch(aTypes.setActiveExam, Payload.factory({obj: exam1}));
         this.$store.getters[ mTypes.setItem ](Payload.factory({index: 0, obj: exam1}));
         }
         */
        items: [],

        // items: [ Exam.factory({index: 0}), Item.factory({index: 1}) ],
        /**
         * Mapping from older ItemIndex to new Item id value
         */
        indexMap: new Map(),

        orderMap: {}
        // items: new Map(),
        // indexMap: new Map(),
    };
};

export const makeTestPayload = function () {
    let e = factories.itemFactory();
    return {
        ItemIndex: e.index,
        ItemId: e.id,
        obj: e
    };
};
export const makeMutationPayload = function ( index ) {
    let e = factories.itemFactory( index );
    return Payload.factory( {
        obj: e
    } );
};
