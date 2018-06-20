//The name of the tested component
import * as mTypes from "../../../../../../resources/assets/js/store/mutation-types";

var compName = 'tags.loaders';
//The path to the tested component
import { actions, mutations } from '../../../../../../resources/assets/js/store/modules/tags/tags.loaders.js' ;

require( '../../../../injectglobals' );

import requests, { loadTagsForItemRequest } from '../../../../../../resources/assets/js/api/requests/tagRequests';
//tested object


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let expectedMutations, action, store, state;
    let tag, obj, tags, numTags, commit, dispatch, getters, requestStub, requestStub2;

    // requestStub = sinon.stub( requests, 'loadAllUserTagsRequest' );
    // requestStub.resolves( tags );
    //
    // requestStub2 = sinon.stub( requests, 'loadTagsForItemRequest' );
    // requestStub2.resolves( tags );


    beforeEach( () => {
        numTags = 5;
        item = factories.itemFactory();
        tags = factories.makeTags( numTags );

        state = { tags: [] };

    } );

    describe.skip( 'loadAllUserTagsFromServer', () => {
        beforeEach( () => {

        } );
        afterEach( () => {
            // requestStub.reset();
            // requestStub2.reset();
        } );

        it( 'creates tag objects when getter returns no preexisting objects', function ( done ) {
            // let j2 = sinon.stub(getters, 'getTagById' ).get( (  ) => {
            //     return tags[1];
            // });
            //  = sinon.stub();
            // getters['getTagById'].returns(tags[1]);
            commit = sinon.stub();
            dispatch = sinon.spy();
            getters = {
                getTagById: sinon.stub()
            }
            //call
            let p = actions.loadAllUserTagsFromServer( { state, dispatch, commit, getters } );
            // Promise.resolve(p);
            return p.then( function ( done ) {
                window.console.log( 'tags.loaders.test', 'rr', 59, );
                //check
                //request was called
                expect( requestStub.callCount ).toBe( 1 );
                //existing tag getter called expected times
                // expect(getters.getTagById.callCount).toBe(numTags);
                //commit was called for each tag
                expect( commit.callCount ).toBe( numTags )
                // mTypes.addTag
                done()

            } );
        } );

        it.skip( 'does not create a new tag object when getter returns existing tag object', ( done ) => {
            commit = sinon.stub();
            dispatch = sinon.spy();
            getters = {
                getTagById: sinon.stub()
            }
            //call
            let r = actions.loadAllUserTagsFromServer( { state, dispatch, commit, getters } );
            r.then( function () {

                //check
                //request was called
                expect( requestStub.callCount ).toBe( 1 );
                //existing tag getter called expected times
                // expect(getters.getTagById.callCount).toBe(numTags);
                //commit was not called (since we already have a tag
                expect( commit.callCount ).toBe( 0 );
                //
                done()

            } );
        } );
    } );

    describe.skip( 'loadTagsForItem', function () {

        it( 'creates tag objects when getter returns no preexisting objects', ( done ) => {
            // let j2 = sinon.stub(getters, 'getTagById' ).get( (  ) => {
            //     return tags[1];
            // });
            //  = sinon.stub();
            // getters['getTagById'].returns(tags[1]);
            commit = sinon.stub();
            dispatch = sinon.spy();
            getters = {
                getTagById: sinon.spy()
            }
            //call
            let p = actions.loadAllUserTagsFromServer( { state, dispatch, commit, getters } );
            p.then( function () {

                //check
                //request was called
                expect( requestStub.callCount ).toBe( 1 );
                //existing tag getter called expected times
                // expect(getters.getTagById.callCount).toBe(numTags);
                //commit was called for each tag
                expect( commit.callCount ).resolves.toBe( numTags )
                // mTypes.addTag
                done();
            } );
        } );
        it( 'does not create a new tag object when getter returns existing tag object', ( done ) => {
            let action = actions.loadTagsForItem;
            commit = sinon.stub();
            dispatch = sinon.spy();
            getters = {
                getTagById: sinon.spy()
            }
            //call
            let p = action( { state, dispatch, commit, getters }, item );
            p.then( function () {


                //check
                //request was called
                expect( requestStub2.callCount ).toBe( 1 );
                //existing tag getter called expected times
                expect( getters.getTagById.callCount ).resolves.toBe( numTags );
                //commit was not called (since we already have a tag
                expect( commit.callCount ).resolves.toBe( 0 );
                //
                done();
            } );


        } );
    } );

    describe.skip( " processItemTags", () => {
        it( 'calls correct mutations', ( done ) => {
            let getters = {};

            getters.getTagById = () => {
            };
            let action = actions.processItemTags;

            let commit = sinon.spy();
            let data = []
            _.forEach( tags, ( t ) => {
                data.push( {
                    id: t.id,
                    name: t.name,
                    props: t.props
                } )
            } )

            item.tags = data;
            state.items = [ item ];
            getters[ gTypes.getAllItems ] = state.items;

            actions.processItemTags( { state, dispatch: {}, commit, getters } );
            expect( commit.callCount ).toBe( numTags * 2 );
            expect( commit.args[ 0 ][ 0 ] ).toBe( mTypes.addTag );
            expect( commit.args[ 1 ][ 0 ] ).toBe( 'replaceBareObjectWithTag' );
            done();
        } );
    } );

} );
