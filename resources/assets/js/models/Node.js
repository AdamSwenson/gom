/**
 * Created by adam on 5/31/17.
 */

export default class Node {
    constructor( data, parent = null, children = [] ) {
        /** The parent node */
        this.parent = parent;

        /**
         * The database identifier of the item.
         * Not super sure on whether to use it
         */
        this.id;

        /**
         * The data stored in the node,
         * Can be any of:
         *      serial number of item
         *      id of item
         *      an item object
         */
        this.data = data;

        /**
         * The type of data stored in the node.
         * This is not guaranteed to be set or to
         * be accurate if the node has been altered.
         * @type {null}
         */
        this.dataType = null;

        /**
         * Holds the child nodes of this node
         * @type {Array}
         */
        this.children = children;
    }

    isRoot(){
        //if set as own parent, it  is the tree's root
        if(this.parent === this.data){
            return true;
        }

        //do we want this too?
        //if a node accidentally doesn't
        //get its parent set, it becomes the root...
        if(this.parent === null){
            return true;
        }
        return false;
    }


    addChild(node, loc=null){
        //set self as child's parent
        node.parent = this.data;
        //if loc is set, we are to splice it in
        //at a particular location.
        if(loc){

        }else{
            //just push child into children array at end
            this.children.push(node);
        }
    }


}



