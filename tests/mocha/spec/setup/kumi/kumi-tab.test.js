
var compName = 'kumi-tab';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/kumi/kumi-tab.vue');


require( '../../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {
    kumi = factories.kumiFactory();
    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, student, grade;

    beforeEach( () => {
        kumi = factories.kumiFactory();
        actions = {}

        getters = {
            getKumisToFilterStudentsBy: (  ) => (  ) => [kumi]
        };

        mutations = {
            toggleKumi: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: { kumi }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        it( " calls for the correct mutation when clicked", () => {
            wrapper.find('a').trigger('click');
            expect(mutations.toggleKumi.calledOnce).toBe(true);
        } );
    } )


} );
