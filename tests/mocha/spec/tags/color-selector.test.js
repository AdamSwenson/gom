
//The name of the tested component
var compName = 'color-selector';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/tags/color-selector.vue');


require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        actions = {}

        getters = {};

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
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

    describe( "methods", () => {
        it( " emits the expected event upon selection", () => {
        wrapper.findAll('span').at(1).trigger('click');
        expect(wrapper.emitted()).toBeTruthy();
        expect(wrapper.emitted()[wrapper.vm.events.selectionEvent]).toBeTruthy();
        } );
    } )


} );
