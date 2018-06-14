//The name of the tested component
var compName = 'kumi-selector';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/kumi/kumi-selector.vue');

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let kumis;

    let listOfValues, showLetter, grade;
    let payload, test;

    beforeEach( () => {
kumis = factories.makeKumis(4);
        getters = {
            [gTypes.getAllKumis]: (  ) => kumis,
            getSelectedKumis: (  ) => kumis,
            isKumiSelectVisible: (  ) => true
        };

        mutations = {
            selectKumi: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
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

    describe("methods", (  ) => {
        it(" calls for the correct mutation when an option is selected", (  ) => {
            wrapper.findAll('option').at(1).element.selected = true;
            wrapper.find('select').trigger('change');
            //check
            expect(mutations.selectKumi.calledOnce).toBe(true);
        });
    })


});
