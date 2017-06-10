/**
 * Created by adam on 6/9/17.
 */

export const traverseDF = ( root, callback ) => {
    let stillLooking = true;

    // this is a recurse and immediately-invoking function
    (function recurse( currentNode ) {
        // while(stillLooking) {
        // step 2
        for (var i = 0, length = currentNode.children.length; i < length; i++) {
            if ( callback( currentNode ) ) {
                return currentNode;
            } else {

                // step 3
                recurse( currentNode.children[ i ] );
            }

        }
        // }
        // window.console.log( 'orderings', 'recurse', 47, callback(currentNode));
        // step 4
        if ( callback( currentNode ) ) {
            // window.console.log( 'orderings', 'recurse', 50, 'FOUND IT!', currentNode );
            stillLooking = false;
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
