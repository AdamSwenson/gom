
const Vue = require( 'vue' );

/**
 * The older version used an index value to do lots of stuff.
 * Given the prospect of using a websocket connection or connecting
 * to canvas or other 3rd party system, it now makes more sense
 * to use the db's id as the primary locator in the store. Thus
 * state.Items has the Item's database id as key and an Item object
 * as value. That is:
 *      state.Items[Item.id] = Item
 *
 * To maintain compatibility, indexMap holds a mapping from the old
 * ItemIndex to the database id
 */
export default {


    /**
     * This holds the current item objects.
     * Because we now want maximal flexibility in how we store and
     * retrieve item objects, we store them in a simple list.
     * The access to the items in the last is handled by getters
     * which filter the list on whatever internal property of the item
     * a particular use case needs.
     */
    items: [],

    // items: [ Exam.factory({index: 0}), Item.factory({index: 1}) ],
    /**
     * Mapping from older ItemIndex to new Item id value
     */
    // indexMap: new Map(),

    // orderMap: {}
};

// Object indexed by Item id holding Item objects
// On load the root exam object and first item are created but given no
// ids. thus we will eventually need to create an exam object if one isn't set
//
// However don't ask the server to create an id just yet
// lookup the exam object that resides at index 0
// this will have either been newly created on page load
// or it will be an existing exam object loaded from the db
// let exam = this.$store.getters[ gTypes.getActiveExamObj ];
// //Call the set active exam method
// //We do this rather than call the mutation directly
// //because there may need to be various other events and
// //things which need to happen depending on the context.
// //                this.$store.dispatch(aTypes.setActiveExam, Payload.factory({obj: exam}));
// this.$store.getters[ mTypes.setItem ](Payload.factory({index: 0, obj: exam}));
// }