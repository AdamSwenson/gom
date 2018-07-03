
//The name of the tested component
var compName = 'preferences-base';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/preferences/preferences-base.vue');


require('../../injectglobals');

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';


const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( (  ) => {

        getters = {   };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        let $router = {push: sinon.spy()};

        wrapper = shallow( Component, {
            store, localVue, mocks: { $router }
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
