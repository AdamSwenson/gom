//The name of the tested component
var compName = 'grading-nav-tabs';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/grading/nav/grading-nav-tabs.vue' );

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
    let items;
    beforeEach( () => {
        items = factories.makeItems();
        getters = {
            getQuestionLevelItems: () => () => items
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
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " asyncComputed", () => {
        it( 'emits an event with the default question tab', (done) => {
            expect( wrapper.emitted( 'set-default-question-tab-route' ).length ).toBe(1);
            done();

        } );
    } );


} );
