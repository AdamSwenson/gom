
//The name of the tested component
var compName = 'students-panel';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/setup/students-panel.vue');


require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        actions = {
            loadKumisForExamFromServer: sinon.spy(),
            loadStudentsFromServer: sinon.spy()
        }

        getters = {};

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = mount( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {

        describe("handleImportComplete", (  ) => {
            it(" hides the file button by setting fileButtonVisible to false ", (  ) => {
                wrapper.setData({fileButtonVisible: true});
                //check setup
                expect(wrapper.vm.fileButtonVisible).toBe(true);
                //call
                wrapper.vm.handleImportComplete();
                //check
                expect(wrapper.vm.fileButtonVisible).toBe(false);
            });
        });

        it( " calls for the correct mutation when ....", () => {
        } );
    } )


} );
