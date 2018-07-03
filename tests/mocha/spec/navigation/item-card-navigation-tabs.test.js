
//The name of the tested component
var compName = 'item-card-navigation-tabs';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/navigation/item-card-navigation-tabs.vue');

require('../../injectglobals');

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';


const localVue = createLocalVue();

localVue.use( Vuex );

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( (  ) => {

        getters = {
            [gTypes.getHeightOfNode] : (  ) => () => 3,
            getDepthOfNode: (  ) => (  ) => 4,
            getItemBySerialNumber : (  ) =>(  ) => factories.itemFactory()
        };


        mutations = {};

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
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe.skip(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
