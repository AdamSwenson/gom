import { mount, shallow, createLocalVue } from 'vue-test-utils';
import expect from 'expect';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

const localVue = createLocalVue();

localVue.use( Vuex )
localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/helpers/info-button.vue" );

// var Item = require( "./../../../../resources/assets/js/models/Item" );


describe( "info-button  ", () => {

    it( 'help pop up is hidden on load  ', () => {
        let wrapper = mount( Component);
        expect( wrapper.vm.showHelp ).toBe( false );
    } );

    it( 'icon is visible ', () => {
        let wrapper = mount( Component);

        expect( wrapper.contains('.fa-question-circle-o')).toBe(true);

    } );

    it(' toggles visibility of the help text when clicked ', ()=>{
        let wrapper = mount( Component);
        wrapper.find('.icon').trigger('click');
        expect(wrapper.vm.showHelp).toBe(true);
    });

} );


