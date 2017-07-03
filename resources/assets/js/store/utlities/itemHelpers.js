/**
 * Generic methods for getting and doing stuff with items
 * Created by adam on 7/2/17.
 */

module.exports = {
    getItemFromPayload: ( state, payload ) => {
        return state.items[ payload.index ];
    },
    /**
     * Build an input object out of an input object
     * and return a payload object containing it
     * @param input
     */
    buildPayloadFromInput : ( state, rootState, payload ) => {
        //either a json or an item object have been passed in
        let { ItemId, ItemIndex, obj, ItemObject } = payload;

        obj = typeof ItemObject !== 'undefined' ? ItemObject : obj;

        //check and see if an Item object has already been passed in
        if ( !obj instanceof Item ) {
            //create a new Item
            let { name, id, index } = payload;
            let ItemJson = { name, ItemIndex };
            obj = Item.factory( ItemJson );
        }

        //assemble the expected payload
        // let out = { ItemId: ItemId, ItemIndex: ItemIndex, obj: obj };
        let out = Payload.factory( { id: obj.id, index: obj.index, obj: obj } );
        //Add to the Items store
        return out;
    },

    getItem: ( state, id ) => {
        return (function ( state, id ) {
            var r = state.items.filter( function ( i ) {
                if ( i.id === id ) {
                    return i;
                }
                ;
            } );
            return r[ 0 ];
        })( state, id );
    }

};