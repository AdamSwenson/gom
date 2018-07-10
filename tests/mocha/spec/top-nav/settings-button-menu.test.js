//The name of the tested component
var compName = 'settings-button-menu';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/top-nav/settings-button-menu.vue' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


import { SettingsLinks } from '../../../../resources/assets/js/api/apiSettings';

//tested stuff


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( () => {

        getters = {};

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

    describe( " toggleModal", () => {
        it( ' sets isModalVisible to true when was false', () => {
            wrapper.setData( { isModalVisible: false } );
            expect( wrapper.vm.isModalVisible ).toBe( false );
            wrapper.vm.toggleModal();
            expect( wrapper.vm.isModalVisible ).toBe( true );
        } );
        it( ' sets isModalVisible to false when was true', () => {
            wrapper.setData( { isModalVisible: true } );
            expect( wrapper.vm.isModalVisible ).toBe( true );
            wrapper.vm.toggleModal();
            expect( wrapper.vm.isModalVisible ).toBe( false );
        } );
    } );

    describe( " handleClick ", () => {
        it( ' sets the appropriate type', () => {
            expect( wrapper.vm.type ).toBe( '' );
            _.forEach( SettingsLinks, function ( link ) {
                wrapper.vm.toggleModal( link.type );
            } );
        } );

        it( ' toggles modal visibility', () => {
            wrapper.setData( { isModalVisible: true } );
            expect( wrapper.vm.isModalVisible ).toBe( true );
            wrapper.vm.handleClick( 'student' );
            expect( wrapper.vm.isModalVisible ).toBe( false );
        } );
    } );


} );
