import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';
let faker= require('faker');
//helpers
import { see, type } from '../../../helpers/test-helpers';

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
var Component = require( "../../../../../resources/assets/js/development/components/panels/grade/assignment-table-row.vue" );


describe( "assignment-table-row  ", function () {

    let getters;
    let mutations;
    let store;
    let grade;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let updateStub = sinon.stub();
    let getterStub = sinon.stub();
    let getterStub2 = sinon.stub();
    let minScore = 3;

    beforeEach( function () {

        grade = faker.random.arrayElement(GradeAssignment.defaults);
        
        getterStub.returns(grade);

        let totalScores = [ 2, 2, 5, 6, 7, 9];
        getterStub2.returns(totalScores);

        getters = {
            [gTypes.getGradeFrequencies]: sinon.stub(),
            [gTypes.getCutOffsForLetterGrade]: getterStub,
            [gTypes.getTotalScores]: getterStub2
        };

        mutations = {
            [mTypes.updateGradeCutoffs]: updateStub
        };

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
            expect( wrapper.find( '.grade-assignment-fields' ).isEmpty() ).toBe( false );
        } );

    } );


    describe( " marks the row as inconsistent by adding style and other indicators ", () => {

        it( " adds the indicators when the row's grade is in the inconsistent list ", () => {
            let testVal = 45;
            type( wrapper, '.minScore', testVal );

            expect( updateStub.callCount ).toBe( 1 );
        } );

        it( " removes the indicators when the row's grade is no longer on the inconsistent list ", () => {

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
