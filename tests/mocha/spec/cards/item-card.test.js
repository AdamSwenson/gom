//The name of the tested component
var compName = 'item-card';
//The path to the tested component

var Component = require( '../../../../resources/assets/js/development/components/cards/item-card.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper, item, nodeHeight;

    beforeEach( () => {
        nodeHeight = 4;
        item = factories.itemFactory();

        getters = {
            getItemNodeFromOrder: () => () => item,
            [gTypes.getHeightOfNode] :() => () => nodeHeight,
            [gTypes.getDepthOfNode]:() => () => nodeHeight,
            [gTypes.isItemSettingsVisible]:() => () => true
        };

        mutations = {};
        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: { item }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " TESTS NEEDED", () => {
        it( 'awaits tests' )
    } );


} );
