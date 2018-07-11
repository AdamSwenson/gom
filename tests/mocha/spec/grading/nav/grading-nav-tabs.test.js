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
    let items, spy;
    beforeEach( () => {
        spy = sinon.stub();
        items = factories.makeItems();
        spy.returns(items);
        getters = {
            getQuestionLevelItems: () => (  ) => items
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = mount( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " asyncComputed", () => {
        it('returns questions from store', ( done ) => {
            let j = wrapper.vm.questions;
            window.console.log( 'grading-nav-tabs.test', 'j', 55, j);
            // expect(spy.callCount).toBe(1);
expect(j.length).toBe(items.length);
            // expect( wrapper.emitted( 'set-default-question-tab-route' ).length ).toBe(1);
            done();


        })

        it( 'emits an event with the default question tab', (done) => {
            let j = wrapper.vm.questionRoutes;
            window.console.log( 'grading-nav-tabs.test', 'j', 55, j);
            // expect(spy.callCount).toBe(1);

            expect( wrapper.emitted( 'set-default-question-tab-route' ).length ).toBe(1);
            done();

        } );
    } );


} );
