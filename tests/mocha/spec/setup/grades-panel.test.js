
//The name of the tested component
var compName = 'grades-panel';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/setup/grades-panel.vue');


require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;
    let $route = { params: {}};

    let getters;
    let mutations;
    let store;
    let wrapper;

    let item, itemProp;
    let payload, test;

    beforeEach( (  ) => {
        item = factories.itemFactory();
        itemProp = 'name';
        test = 392;
        payload = Payload.factory({
            obj: item,
            updateProp: itemProp,
            updateValue: test})

        getters = {   };

        mutations = { [mTypes.updateItem] : sinon.spy()};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
            propsData: {item, itemProp}, mocks:{$route}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

});
