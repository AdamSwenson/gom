//The name of the tested component
var compName = 'setup-page-preferences';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/preferences/setup/setup-page-preferences.vue' );

require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store, actions;
    let wrapper;

    beforeEach( () => {

        getters = {};
        actions = {
            [ ngaTypes.loadSetupPreferencesFromServer ]: () => () => sinon.spy()
        }
        mutations = {};

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        let $router = {
            push: sinon.stub()
        };

        wrapper = shallow( Component, {
            store, localVue, mocks: {
                $router
            }
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
