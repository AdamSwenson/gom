
//The name of the tested component
var compName = 'new-kumi-control';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/kumi/new-kumi-control.vue');

require( '../../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, showLetter, grade;
    let payload, test;

    beforeEach( () => {
        actions = {
            createKumi: sinon.spy()
        }

        getters = {
            isKumiEditModalVisible: (  ) => false
        };

        mutations = {
            toggleEditKumiModal: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        describe('newKumi', (  ) => {

            it( " calls for the correct mutation when new group is clicked", () => {
                wrapper.find( componentDivIdentifier ).trigger( 'click' );
                expect( mutations.toggleEditKumiModal.calledOnce ).toBe( true );
            } );

            it( "it opens the kumi edit window if it was closed", () => {
                wrapper.find( componentDivIdentifier ).trigger( 'click' );
                expect( mutations.toggleEditKumiModal.calledOnce ).toBe( true );
            } );

            it( "does not close the kumi edit window if it was open", () => {
                getters = {
                    isKumiEditModalVisible: (  ) => true
                };
                store = new Vuex.Store( {
                    getters, mutations, actions
                } );
                wrapper = shallow( Component, {
                    store, localVue
                } );
                //call
                wrapper.find( componentDivIdentifier ).trigger( 'click' );
                //check
                expect( mutations.toggleEditKumiModal.notCalled ).toBe( true );
            } );


        });
    } )


} );
