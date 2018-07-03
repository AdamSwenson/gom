import Payload from "../../../../../../resources/assets/js/models/Payload";

var compName = 'items.order.mutations';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.mutations.js' );

require( '../../../../injectglobals' );

//tested object
import Node from '../../../../../../resources/assets/js/models/Node'


import {
    addNodes,
    makeState,
    makeRootState,
    makeTestPayload,
    makeMutationPayload
} from "../../../../helpers/item-test-helpers";

//tested object
let mutations = Component;


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let state, rootState, mutationPayload, numItems, filledState, testItemIndex;
    let rootId, parentId, root, parent;

    beforeEach( function () {
        numItems = 5;
        testItemIndex = faker.random.number( { min: 0, max: numItems - 1 } );
        filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( filledState.itemMap, numItems );
        for (let n of filledState.itemMap.children) {
            addNodes( n, numItems );
        }
        // window.console.log( 'orderings.spec', 'filledState', 34, filledState );

        rootId = 1;
        parentId = 2;
        root = new Node( rootId, rootId );
        state = { itemMap: root };
        parent = new Node( parentId, rootId );
        root.children.push( parent );

    } );

    describe( description( "decreasePosition" ), function () {
        it( "happy path", function () {
            //prep
            let c1 = new Node( 4, parentId );
            let c2 = new Node( 5, parentId );
            parent.children.push( c1 );
            parent.children.push( c2 );

            //check prep
            expect( parent.children[ 0 ] ).toBe( c1 );
            expect( parent.children[ 1 ] ).toBe( c2 );

            mutations.decreasePosition( state, Payload.factory( {
                objNode: c1, parentNode: parent
            } ) );

            // window.console.log( 'item.order.mutations.spec', 'increasePosition', 71, parent );
            expect( parent.children.length ).toBe( 2 );
            expect( parent.children[ 0 ] ).toBe( c2 );
            expect( parent.children[ 1 ] ).toBe( c1 );
        } );
    } );

    describe( description( "increasePosition" ), function () {
        it( "happy path", function () {
            //prep
            let c1 = new Node( 4, parentId );
            let c2 = new Node( 5, parentId );
            parent.children.push( c1 );
            parent.children.push( c2 );

            //check prep
            expect( parent.children[ 0 ] ).toBe( c1 );
            expect( parent.children[ 1 ] ).toBe( c2 );

            mutations.increasePosition( state, Payload.factory(
                {
                    objNode: c2, parentNode: parent
                } ) );

            // window.console.log( 'item.order.mutations.spec', 'increasePosition', 71, parent );
            expect( state.itemMap.children[ 0 ].children.length ).toBe( 2 );
            expect( state.itemMap.children[ 0 ].children[ 0 ] ).toBe( c2 );
            expect( state.itemMap.children[ 0 ].children[ 1 ] ).toBe( c1 );
        } );
        //problem cases: where would move beyond ends of array
    } );


    describe( description( "promote" ), function () {
        it( "happy path", function () {
            //prep
            let c1 = new Node( 4, parentId );
            let c2 = new Node( 5, parentId );
            parent.children.push( c1 );
            parent.children.push( c2 );

            //check prep
            expect( parent.children[ 0 ] ).toBe( c1 );
            expect( parent.children[ 1 ] ).toBe( c2 );

            mutations.promote( state, Payload.factory(
                {
                    objNode: c1, parentNode: parent
                } ) );

            //check that the original parent's children are correct
            expect( parent.children.length ).toBe( 1 );
            expect( parent.children[ 0 ] ).toBe( c2 );

            //check that now sibling of parent
            expect( state.itemMap.children.length ).toBe( 2 );
            expect( state.itemMap.children[ 0 ] ).toBe( parent );
            expect( state.itemMap.children[ 1 ] ).toBe( c1 );
        } );
        //problem cases: where would move beyond ends of array
    } );

    describe( description( "demote" ), function () {
        it( "happy path", function () {
            //prep
            let c1 = new Node( 4, parentId );
            let c2 = new Node( 5, parentId );
            parent.children.push( c1 );
            parent.children.push( c2 );

            //check prep
            expect( parent.children[ 0 ] ).toBe( c1 );
            expect( parent.children[ 1 ] ).toBe( c2 );

            mutations.demote( state, Payload.factory(
                {
                    objNode: c2, parentNode: parent
                } ) );

            expect( parent.children.length ).toBe( 1 );
            expect( parent.children[ 0 ].children.length ).toBe( 1 );
            expect( parent.children[ 0 ].children[ 0 ] ).toBe( c2 );
            expect( c1.children[ 0 ] ).toBe( c2 );

        } );
        //problem cases: where would move beyond ends of array
    } );


    describe( description( mTypes.removeNodeFromOrder ), function () {

        it( "happy path", function () {

            let parent = filledState.itemMap.children[ testItemIndex ];//.children[ testItemIndex ];
            let numChildren = parent.children.length;
            let toRemove = parent.children[ faker.random.number( { min: 0, max: parent.children.length - 1 } ) ];
            let toRemoveSerial = toRemove.data;
            let payload = { obj: toRemove, parent: parent };

            //call
            mutations[ mTypes.removeNodeFromOrder ]( filledState, payload );
            // window.console.log( 'orderings.spec', 'add', 76, filledState );

            //check
            let result = filledState.itemMap.children[ testItemIndex ];//.children[ testItemIndex ];
            ;
            //parent is unchanged other than children
            expect( parent.data ).toBe( result.data );
            expect( parent.parent ).toBe( result.parent );
            expect( parent.children.length ).toBe( numChildren - 1 );
            //make sure not in array
            for (let i = 0; i < parent.children; i++) {
                expect( parent.children[ i ].data ).not.toBe( toRemoveSerial );

            }
        } );
    } );

    describe( description( mTypes.insertNodeIntoOrder ), function () {

            it( "it pushes the node onto the end of the parent's children list when no index is provided", function (  ) {

                let parent = filledState.itemMap.children[ testItemIndex ].children[ testItemIndex ];
                let numChildren = parent.children.length;
                let toAddSerial = faker.random.number();

                let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code

                let payload = Payload.factory( {
                    objNode: toAdd,
                    parentNode: parent,
                    mutateSilently: true
                } );

                //call
                mutations[ mTypes.insertNodeIntoOrder ]( filledState, payload );

                //check
                let result = filledState.itemMap.children[ testItemIndex ].children[ testItemIndex ];
                //parent properties are unchanged (other than children)
                expect( result.data ).toBe( parent.data );
                expect( result.parent ).toBe( parent.parent );
                expect( result.children.length ).toBe( numChildren + 1 );
                //check the node we added
                let added = result.children[ result.children.length - 1 ];
                expect( added ).toBe( toAdd );
                // explicitly check that it has the parent's isn set properly
                expect( added.parent ).toBe( parent.data );
            } );

            it( "pushes the node into correct location when an index is provided", function (  ) {
                //Should splice into particular location of
                // the parent's children array
                let parent = filledState.itemMap.children[ testItemIndex ];//.children[ testItemIndex ];
                let numChildren = parent.children.length;
                let toAddSerial = faker.random.number();
                let toAdd = new Node( toAddSerial, parent.data ); //this step is handled by the action in the real code
                let index = faker.random.number( { min: 0, max: parent.children.length - 1 } )

                let payload = Payload.factory( {
                    objNode: toAdd,
                    parentNode: parent,
                    index: index,
                    mutateSilently: true
                } );

                //call
                mutations[ mTypes.insertNodeIntoOrder ]( filledState, payload );

                // window.console.log( 'orderings.spec', 'add', 76, filledState );

                //check
                let result = filledState.itemMap.children[ testItemIndex ][index];//children[ testItemIndex ];
                //parent properties are unchanged (other than children)
                expect( result.data ).toBe( parent.data );
                expect( result.parent ).toBe( parent.parent );
                expect( result.children.length ).toBe( numChildren + 1 );

                //check the node we added
                let added = result.children[ index ];
                expect( added.data ).toBe( toAddSerial );
                expect( added.children.length ).toBe( toAdd.children.length );
                // explicitly check that it has the parent's isn set properly
                expect( added.parent ).toBe( parent.data );


        } );

    } );

} );