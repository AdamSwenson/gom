//The name of the tested component
var compName = 'kumi-name-field';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/kumi/kumi-name-field.vue');

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let payload, exam, item, kumi, student, grade;

    beforeEach( () => {
        exam = factories.examFactory();
        kumi = factories.kumiFactory();

        actions = {}

        getters = {
            areKumiAndExamAssociated: (  ) => (  ) => true,
        [gTypes.getActiveExam] :(  ) =>  (  ) => exam


    };

        mutations = {
            updateKumi: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue,
            propsData: {kumi}
        } );


    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            expect(wrapper.find(componentDivIdentifier).exists()).toBe(true);
            // assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        it( " name calls for the correct mutation when edited", () => {
            let t = 'tacos';
            helpers.type(wrapper, componentDivIdentifier, t);
            expect( mutations.updateKumi.calledOnce ).toBe( true );
        } );
    } )


} );
