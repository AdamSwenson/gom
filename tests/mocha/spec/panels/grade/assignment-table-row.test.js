import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

//test libraries
import moxios from 'moxios';

let faker = require( 'faker' );

//helpers
import { type } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed, assertThatSeeText } from '../../../helpers/assertions';
import {makeGradeFrequencyObject } from '../../../helpers/factories';

import Exam from "./../../../../../resources/assets/js/models/Exam";
import Comment from "./../../../../../resources/assets/js/models/Comment";
import Payload from "./../../../../../resources/assets/js/models/Payload";
import * as mTypes from "./../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "./../../../../../resources/assets/js/store/getter-types";
import GradeAssignment from "../../../../../resources/assets/js/models/GradeAssignment";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/setup/grade/assignment-table-row.vue" );


describe( "assignment-table-row  ", function () {
    let componentDivId = '.assignment-table-row ';
    let getters;
    let mutations;
    let store;
    let grade;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let getterStub = sinon.stub();
    let getterStub2 = sinon.stub();
    let testFreqs = {};
    let inconsistent = [];
    let minScore = 3;

    beforeEach( function () {

        grade = faker.random.arrayElement( GradeAssignment.defaults );

        testFreqs = makeGradeFrequencyObject();

        getterStub.returns( testFreqs );

        //the inconsistent list is set to be returned
        inconsistent.push( grade );
        getterStub2.returns( inconsistent );


        getters = {
            [ gTypes.getGradeFrequencies ]: getterStub,
            [ gTypes.getInconsistentCutOffs ]: getterStub2,
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
        } );

        wrapper.setProps( { grade: grade } );

    } );


    describe( " loads into expected default state for testing ", () => {

        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivId );
        } );

    } );


    describe( " marks the row as inconsistent by adding style and other indicators ", () => {

        it( " adds the indicators when the row's grade is in the inconsistent list ", () => {
            expect(wrapper.vm.styling).toBe('is-selected');
            assertThatSeeText( wrapper, 'is-selected', componentDivId );
        } );


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
