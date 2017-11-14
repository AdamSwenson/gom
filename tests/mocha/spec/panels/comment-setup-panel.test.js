import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import expect from 'expect';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import Item from "./../../../../resources/assets/js/models/Item";

const localVue = createLocalVue();

localVue.use(Vuex)
// localVue.use(VueRouter);


//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/panels/comment-setup-panel.vue" );



describe( "comment-setup-panel  ",  () => {

    let getters;
    let store;


    beforeEach(() => {
        let item  = new Item();

            getters = {
                getItemBySerialNumber: ()=> 4, //sinon.stub().returns(item),

                inputValue: () => 'input'
        }

        store = new Vuex.Store({
            getters,
            mutations: {}
        });

    });

    it( 'has the serial number passed in as a prop ', ()=>{

        let wrapper = shallow(Component, {
            store, localVue
        });

        wrapper.setProps({ dataSerialNumber : 47});
        expect( wrapper.vm.serialNumber ).toBe( 47 );
    });
    //
    // it( 'displays the expected default on first load',  ()=> {
    //
    //     let wrapper = shallow(Component, {
    //         store, localVue
    //     });
    //
    //     wrapper.setProps({ dataSerialNumber : 47});
    //     expect( wrapper.vm.serialNumber ).toBe( 47 );
    //
    //
    //     expect( wrapper.vm.displayed ).toBe( 'stock' )
    //
    //     expect( true ).toBe( true );
    // } );
} );


//
//     beforeEach(  ()=> {
// //runs before each test
// //         let component = mount( commentPanel );
//
//     })

        // wrapper.vm // the mounted Vue instance


    //
    // describe( "computed properties ", () => {
    //
    //     it( 'displays the expected default on first load',  ()=> {
    //        // let component = mount( commentPanel );
    //
    //         expect( wrapper.vm.displayed ).toBe( 'stock' )
    //
    //         expect( true ).toBe( true );
    //     } );
    //
    // } );
    //
    // describe(  "methods" , function () {
    //     beforeEach( function () {
    //         let component = mount( commentPanel );
    //
    //     } );
    //
    //     it( 'prePopulateComments | ', function () {
    //         expect( true ).toBe( true );
    //     } );
    // } );
// } );
