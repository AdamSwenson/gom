//The name of the tested component
var compName = 'show-all-kumi-control';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/kumi/show-all-kumi-control.vue' );


require( '../../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, student, grade;

    beforeEach( () => {
        actions = {}

        getters = {};

        mutations = {
            clearKumisToFilterStudentsBy: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: { isVisible: true }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            expect( wrapper.find( componentDivIdentifier ).exists() ).toBe( true );
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        it( " calls for the correct mutation when clicked", () => {
            wrapper.find( componentDivIdentifier ).trigger( 'click' );
            expect( mutations.clearKumisToFilterStudentsBy.calledOnce ).toBe( true );
        } );
    } )


} );
