//The name of the tested component
import Payload from "../../../../../../resources/assets/js/models/Payload";

var compName = 'tags.actions';
//The path to the tested component
import actions from '../../../../../../resources/assets/js/store/modules/tags/tags.actions.js' ;


require( '../../../../injectglobals' );

//tested object


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let expectedMutations, action, store, state;
    let tag, obj, tags, numTags;

    beforeEach( () => {
        // moxios.install();
        numTags = 5;
        item = factories.itemFactory();
        tags = factories.makeTags( numTags );
let st = sinon.stub();
st.resolves(56);
        state = { tags: [] };
        window['axios'] = {
            post : st
        }
    } );

    afterEach( (  ) => {
        // moxios.uninstall();
    })

    describe( "associateTag", () => {
        it( 'creates a relationship with the object ', ( done ) => {
            let action = actions.associateTag;
            let pl = Payload.factory({tag: tag, obj: factories.itemFactory()});

            expectedMutations = [
                {
                    type: mTypes.associateTag,
                    // payload: Payload.factory( { obj: obj, tag: tag } )
                }
            ];
            helpers.testAction( action, pl, {}, expectedMutations, { verbose: false } );
            done()
        } );
    } );

    describe( "createTag", () => {
        it( 'creates a tag', ( done ) => {
            let action = actions.createTag;

            expectedMutations = [
                {
                    type: mTypes.addTag,
                    // payload: Payload.factory( { obj: tag } )
                },
                {
                    type: mTypes.associateTag,
                    // payload: Payload.factory( { obj: obj, tag: tag } )
                }
            ];
            helpers.testAction( action, item, {}, expectedMutations, { verbose: false } );
            done();
        } );
    } );


    describe( "createAndAssociateTag", (  ) => {
        it( 'creates tag and creates association with object', (done) => {
            let action = actions.createAndAssociateTag;

            let dispatch = sinon.stub();
            dispatch.resolves(45);
            // returns((function(){return new Promise(function(resolve, reject){ resolve(); }))();
            let pl = Payload.factory({tag: tag, obj: factories.itemFactory()});
            action({state, dispatch, commit: {}, getters: {}}, pl);
            window.console.log( 'tags.actions.test', 'd', 77, dispatch.args);

            expect(dispatch.callCount).toBe(2);
            done();
            //
            // expectedMutations = [
            //     {
            //         type: mTypes.addTag,
            //         // payload: Payload.factory( { obj: tag } )
            //     },
            //     {
            //         type: mTypes.associateTag,
            //         // payload: Payload.factory( { obj: obj, tag: tag } )
            //     }
            // ];
            // helpers.testAction( action, item, {}, expectedMutations, { verbose: false } );

        } );
    } );


} );
