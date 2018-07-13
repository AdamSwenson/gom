//The name of the tested component
import { Routes } from "../../../../../../resources/assets/js/api/apiSettings";

var compName = 'items.order.actions';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/items/items.order.actions.js' );

require( '../../../../injectglobals' );
window.axios = require( 'axios' );

//tested object
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import Node from '../../../../../../resources/assets/js/models/Node'

import Requests from '../../../../../../resources/assets/js/api/requests/itemRequests';

import { traverseDF, traverseBF, getSerialNumber } from '../../../../../../resources/assets/js/models/NodeTools'
import { addNodes } from "../../../../helpers/item-test-helpers";
import { factories } from "../../../../../spec/helpers/vuex.spec.helpers";

//tested object
let actions = Component;

const testAction = helpers.testAction;
const description = helpers.description;

// let m = sinon.stub(  Requests, 'updateItemsOrder' );
// m.resolves(true);

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let numItems, filledState, testItemIndex;
    let parent;
    let getterSpy1, getterSpy2, getters;
    let newNode, parentNode, index, commit, prom;


    beforeEach( () => {
        moxios.install();

        //setup test objects
        exam = factories.examFactory();
        item = factories.itemFactory();
        parent = factories.itemFactory();
        newNode = new Node( item.serialNumber, parent.serialNumber );
        parentNode = new Node( parent.serialNumber );
        index = faker.random.number();


        numItems = 5;
        testItemIndex = faker.random.number( { min: 0, max: numItems - 1 } );
        filledState = { itemMap: new Node( 0, 0 ) };
        addNodes( filledState.itemMap, numItems );
        for (let n of filledState.itemMap.children) {
            addNodes( n, numItems );
        }

        //setup getters
        getters = {
            [ gTypes.getItemNodeFromOrder ]: sinon.stub(),
            [ gTypes.getActiveExam ]: sinon.stub(),
            getOrderForSync: sinon.stub(),
        };
        getters[ gTypes.getActiveExam ].returns( exam );


        //create a dummy commit
        commit = sinon.spy();
    } );

    afterEach( () => {
        moxios.uninstall();
    } )

    describe( aTypes.addItemToOrder, function () {

        beforeEach( function () {

            //setup getters
            getters[ gTypes.getItemNodeFromOrder ].returns( parentNode );

            // getters = {
            //     [ gTypes.getItemNodeFromOrder ]: sinon.stub(),
            //     [ gTypes.getActiveExam ]: sinon.stub()
            // };
            // getters[ gTypes.getActiveExam ].returns( exam );

            //This is the payload that the action will receive
            //NB, index will have to be added for tests which want it
            payload = Payload.factory( {
                obj: item,
                parent: parent,
                mutateSilently: true
            } );

            //handle the server request
            let route = Routes.updateItemsOrder( exam );
            moxios.stubRequest( route, { status: 200 } );
        } );

        describe( "when no index provided", function () {
            beforeEach( () => {
                //call the action
                prom = actions[ aTypes.addItemToOrder ]( {
                    state: {},
                    dispatch: {},
                    commit,
                    getters
                }, payload );
            } );

            it( "calls the correct mutation", ( done ) => {
                prom.then( function () {
                    expect( true ).toBeTruthy();
                    expect( commit.callCount ).toBe( 1 );
                    //it was the correct mutation
                    expect( commit.args[ 0 ][ 0 ] ).toBe( mTypes.insertNodeIntoOrder );
                    done();
                } );
            } );

            it( "sends the mutation the correct payload", ( done ) => {
                prom.then( function () {
                    let receivedPayload = commit.args[ 0 ][ 1 ];
                    // expect(receivedPayload.objNode).toMatchObject(newNode);
                    // expect(receivedPayload.objNode.parent).toBe(parent.serialNumber);
                    expect( receivedPayload.objNode.data ).toBe( item.serialNumber );
                    //and has the right parent
                    expect( receivedPayload.parentNode ).toMatchObject( parentNode );
                    done();
                } );
            } );

        } );

        describe( "when an index is provided ", function () {
            beforeEach( () => {
                payload.index = index;

                //call the action
                prom = actions[ aTypes.addItemToOrder ]( {
                    state: {},
                    dispatch: {},
                    commit,
                    getters
                }, payload );
            } );

            it( "calls the correct mutation", ( done ) => {
                prom.then( function () {
                    expect( commit.callCount ).toBe( 1 );
                    //it was the correct mutation
                    expect( commit.args[ 0 ][ 0 ] ).toBe( mTypes.insertNodeIntoOrder );
                    done();
                } );
            } );

            it( "sends the mutation the correct payload e", ( done ) => {
                prom.then( function () {
                    let receivedPayload = commit.args[ 0 ][ 1 ];

                    //it created the correct node
                    // expect(receivedPayload.objNode).toMatchObject(newNode);
                    // expect(receivedPayload.objNode.parent).toBe(parent.serialNumber);
                    expect( receivedPayload.objNode.data ).toBe( item.serialNumber );
                    //and has the right parent
                    expect( receivedPayload.parentNode ).toMatchObject( parentNode );
                    //and had the correct index
                    expect( receivedPayload.index ).toBe( index );
                    done();
                } );
            } );
        } );

    } );

    describe( description( aTypes.removeItemFromOrder ), function () {
        it( "removes the node from the itemMap", function () {
            let toRemove = filledState.itemMap.children[ testItemIndex ];
            let parent = filledState.itemMap;
            let spyGetter = sinon.stub();
            spyGetter.onCall( 0 ).returns( toRemove );
            spyGetter.onCall( 1 ).returns( parent );

            let getters = {
                [ gTypes.getItemNodeFromOrder ]: spyGetter
            };

            //Expected endpoint
            let expectedPayload = Payload.factory( { parent: parent, obj: toRemove } );
            let expectedMutations = [
                { type: mTypes.removeNodeFromOrder, payload: expectedPayload }
            ];

            let payload = Payload.factory( { obj: toRemove } );

            //Checks that the appropriate mutations are called
            testAction( actions[ aTypes.removeItemFromOrder ], payload, filledState, expectedMutations, {
                verbose: false,
                getters: getters
            } );

            //check that the method was called on the spy
            expect( spyGetter.callCount ).toBe( 2 );

        } );
    } );

    describe( description( aTypes.updateItemOrder ), function () {
        beforeEach( () => {
            getters[ gTypes.getItemNodeFromOrder ].returns( parentNode );
            getters.getOrderForSync.returns( { num1nom: 'taco' } );

            payload = Payload.factory( {
                objNode: newNode,
                parentNode: parentNode
            } )
        } );


        it( "`promote` calls correct mutation", function ( done ) {

            payload.type = 'promote';
            prom = actions[ aTypes.updateItemOrder ]( {
                state: {},
                dispatch: {},
                commit,
                getters
            }, payload );

            prom.then( function () {
                //some mutation was called
                expect( commit.callCount ).toBe( 1 );
                //it was the right on3
                expect( commit.args[ 0 ][ 0 ] ).toBe( payload.type );
                //with the right payload
                expect( commit.args[ 0 ][ 1 ] ).toBe( payload );
                done();
            } );


        } );


        it( "`demote` calls correct mutation", function ( done ) {

            payload.type = 'demote';
            prom = actions[ aTypes.updateItemOrder ]( {
                state: {},
                dispatch: {},
                commit,
                getters
            }, payload );

            prom.then( function () {
                //some mutation was called
                expect( commit.callCount ).toBe( 1 );
                //it was the right on3
                expect( commit.args[ 0 ][ 0 ] ).toBe( payload.type );
                //with the right payload
                expect( commit.args[ 0 ][ 1 ] ).toBe( payload );
                done();
            } );

        } );


        it( "`increasePosition` calls correct mutation", function ( done ) {
            payload.type = 'increasePosition';
            prom = actions[ aTypes.updateItemOrder ]( {
                state: {},
                dispatch: {},
                commit,
                getters
            }, payload );

            prom.then( function () {
                //some mutation was called
                expect( commit.callCount ).toBe( 1 );
                //it was the right on3
                expect( commit.args[ 0 ][ 0 ] ).toBe( payload.type );
                //with the right payload
                expect( commit.args[ 0 ][ 1 ] ).toBe( payload );
                done();
            } );

        } );

        it( "`decreasePosition` calls correct mutation", function ( done ) {
            payload.type = 'decreasePosition';
            prom = actions[ aTypes.updateItemOrder ]( {
                state: {},
                dispatch: {},
                commit,
                getters
            }, payload );

            prom.then( function () {
                //some mutation was called
                expect( commit.callCount ).toBe( 1 );
                //it was the right on3
                expect( commit.args[ 0 ][ 0 ] ).toBe( payload.type );
                //with the right payload
                expect( commit.args[ 0 ][ 1 ] ).toBe( payload );
                done();
            } );
        } );

    } );
});
