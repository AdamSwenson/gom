
//The name of the tested component
var compName = 'exam-card-navigation-tabs';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/navigation/exam-card-navigation-tabs.vue');

require ('../../injectglobals');
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let exam;

    beforeEach( (  ) => {


    getters = {
        [gTypes.isExamSettingsVisible] : (  ) => (  ) => false,
        //
        // [gTypes.getHeightOfNode] : (  ) => () => 3,
        // getItemBySerialNumber : (  ) =>(  ) => factories.itemFactory(),
        // getDepthOfNode: (  ) => (  ) => 3

    };
exam = factories.examFactory();
        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: {exam}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );

        it(' see expected labels', () => {
            _.forEach( wrapper.vm.tabs, function ( label ){
                expect(assertions.assertThatSeeText(wrapper, _.capitalize(label)));
            } );
        })
    });


});
