//The name of the tested component
var compName = 'item-input';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/grading/inputs/item-input.vue' );

require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let item, student;

    beforeEach( () => {
        student = factories.studentFactory();
        item = factories.itemFactory();
        getters = {
            [ nggTypes.getActiveStudent ]: () => () => student
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
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );

        it(" displays the item' name", (  ) => {
            assertions.assertThatSeeText(wrapper, item.name)
        })
    } );


} );
