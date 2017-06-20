/**
 * Created by adam on 6/9/17.
 */

// import IModel from './IModel';
import Item from './Item';
import Node from './Node';
import Payload from './Payload';

export const traverseDF = ( root, callback ) => {
    // this is a recursive and immediately-invoking function
    (function recurse( currentNode ) {
        // step 2
        for (var i = 0, length = currentNode.children.length; i < length; i++) {
            //if we are at the exam or at the last child, call
            //the callback and return the node
            //todo Not sure why this is here....
            // if ( callback( currentNode ) ) {
            //     return currentNode;
            // }
            // else {
                // step 3
                // iterate through the node's children
                // calling the recursive function on each
                recurse( currentNode.children[ i ] );
            // }

        }
        // step 4
        //We are out of children to cycle through. We can call the callback
        //node. If the callback returns true, we return the node
        if ( callback( currentNode ) ) {
            window.console.log( 'orderings', 'recurse', 50, 'FOUND IT!', currentNode );
            return currentNode;
        }

        // step 1
    })( root );

};

export const traverseBF = ( root, callback ) => {
    var queue = [];
    queue.push( root );
    let currentTree = queue.pop();

    while (currentTree) {
        for (var i = 0, length = currentTree.children.length; i < length; i++) {
            queue.push( currentTree.children[ i ] );
        }

        callback( currentTree );
        currentTree = queue.pop();
    }
};

/**
 * Returns the serial number stored in a Node, Item, Payload,
 * or just straight number
 * @param serialNumberStoringThing
 * @returns {*}
 */
export const getSerialNumber = ( serialNumberStoringThing ) => {
    switch ( serialNumberStoringThing ) {
        case  serialNumberStoringThing instanceof Node:
            return serialNumberStoringThing.data;
            break;
        case serialNumberStoringThing instanceof Item:
            return serialNumberStoringThing.serialNumber;
            break;
        case serialNumberStoringThing instanceof Payload:
            return serialNumberStoringThing.serialNumber;
            break
        case serialNumberStoringThing instanceof Number:
            return serialNumberStoringThing;
        default:
            return serialNumberStoringThing;
    }
};

