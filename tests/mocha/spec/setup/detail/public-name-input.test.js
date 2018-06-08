
//The name of the tested component
var compName = 'public-name-input';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/detail/public-name-input.vue');

require( '../../../injectglobals' );


import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let actions;
    let getters;
    let mutations;
    let store;
    let event;

    let wrapper;

    let item, exam, student, score, scoreObj;

    let examGetterStub;
    let studentGetterStub;
    let scoreGetterStub;

    beforeEach( () => {
        item = factories.itemFactory();

        exam = factories.examFactory();

        getters = {
        };

        mutations = {};

        actions = {
        }

        store = new Vuex.Store( {
            actions,
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
    } );
    


});
