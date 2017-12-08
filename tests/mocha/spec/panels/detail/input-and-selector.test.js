import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

//test libraries
import moxios from 'moxios';

let faker = require( 'faker' );

//helpers
import { see, type } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types';

import Exam from "./../../../../../resources/assets/js/models/Exam";
import Payload from "../../../../../resources/assets/js/models/Payload";

const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/panels/detail/input-and-selector.vue" );


describe.only( " input-and-selector  ", function () {
    let componentDivId = '.input-and-selector';
    let getters;
    let mutations;
    let store;
    let grade;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let options;
    let inputValue;
    let testOption;
    let testIndex;
    let mutationStub;
    let getterStub;
    let item;
    let itemProp;
    beforeEach( function () {
        inputValue = "2018";
        itemProp = 'year';

        item = new Exam();
        item[itemProp] = inputValue;

        getterStub = sinon.stub();
getterStub.returns(item);
        getters = {getItemBySerialNumber : getterStub};
        mutationStub = sinon.spy();
        mutations = { [ mTypes.updateItem ]: mutationStub };
        store = new Vuex.Store( {
            getters,
            mutations
        } );


        options = [ '23', '45', '67', '88' ];
        testOption = faker.random.arrayElement( options )

        testIndex = options.indexOf( testOption );
        wrapper = shallow( Component, {
            store, localVue,
        } );
        wrapper.setProps( { options, item, itemProp } );
    } );


    describe( " loads into expected default state for testing ", () => {

        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivId );
        } );

        // 244276932
        //
        // 800 711 4555
        // 800 527 0531 fax






    } );

    describe( " displays the values given in props correctly  ", () => {

        it( " displays the expected list of options in the selector  ", () => {
            _.forEach( options, function ( option ) {
                see( wrapper, option, componentDivId );
            } )
        } );

        it( " displays the expected input value  ", () => {
            wrapper.update();
            let e = wrapper.find( 'input[name="ias-input"]' );
            expect( e.element.value ).toBe( inputValue );
        } );
    } );


    describe( " behaves correctly when the input value is updated", () => {
        let testInput;
        beforeEach( () => {
            testInput = faker.random.word();
            type( wrapper, '.ias-input', testInput );
        } );


        it( " dispatches the expected mutation ", () => {
            expect( mutationStub.callCount ).toBe( 1 );
            expect( mutationStub.args[ 0 ][ 1 ].obj ).toBe( item );
            expect( mutationStub.args[ 0 ][ 1 ].updateProp ).toBe( itemProp );
            expect( mutationStub.args[ 0 ][ 1 ].updateVal ).toBe( testInput );
        } );


        it( "emits the expected event", () => {
            expect( wrapper.emitted().update ).toBeTruthy();
        } );

    } );

    describe( " behaves correctly when select occurs ", () => {

        beforeEach( () => {
            expect( wrapper.find( 'option' ).isEmpty() ).toBe( false );

             //trigger the selection
            let option = wrapper.findAll( 'option' ).at( testIndex );
            // window.console.log( 'input-and-selector.test', '', 103, option );

            option.trigger( 'input' );

            // wrapper.findAll( 'option' ).at( testIndex ).trigger( 'change' );

        } );


        it( " dispatches the expected mutation ", () => {
            expect( mutationStub.callCount ).toBe( 1 );
            expect( mutationStub.args[ 0 ][ 1 ].obj ).toBe( item );
            expect( mutationStub.args[ 0 ][ 1 ].updateProp ).toBe( itemProp );
            expect( mutationStub.args[ 0 ][ 1 ].updateVal ).toBe( testOption );
        } );



        // it( "updates the property on the instance", () => {
        //     expect( wrapper.vm[ itemProp ] ).toBe( testOption );
        // } );

        it( "emits the expected event", () => {
            // assert that event of the correct type has been emitted
            expect( wrapper.emitted().update ).toBeTruthy();

            // assert event count
            // expect( wrapper.emitted().update.length ).toBe( 1 )
            // assert event payload
            expect( wrapper.emitted().update[ 0 ][ 1 ] ).toEqual( [ testOption ] )

        } );

        it( "updates the text field", () => {
            let e = wrapper.find( 'input.ias-input' );
            expect( e.element.value ).toBe( testOption );

            // expect( wrapper.find( '.ias-input' ).hasAttribute( 'value', testOption ) ).toBe( true );

        } )

    } );


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
