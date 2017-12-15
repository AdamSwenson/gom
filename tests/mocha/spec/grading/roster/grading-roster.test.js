import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
import { factories } from '../../../../spec/helpers/vuex.spec.helpers';


import Exam from "../../../../../resources/assets/js/models/Exam";
import Comment from "../../../../../resources/assets/js/models/Comment";
import Payload from "../../../../../resources/assets/js/models/Payload";
import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "../../../../../resources/assets/js/store/getter-types";

import * as nggTypes from "../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/grading/roster/grading-roster.vue" );


describe( " grading-roster ", () => {
    let componentDivIdentifier = '#grading-roster';

    let getters;
    let mutations;
    let store;
    let exam;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let students = [];
    let numStudents;
    let visibility = true;

    beforeEach( () => {
        numStudents = 10;
        for (let i = 0; i < numStudents; i++) {
            students.push( factories.studentFactory( i ) );
        }

        getters = {
            [ gTypes.getStudentsFromRoster ]: ( v ) => ( v ) => {
                return students;
            },
            [ nggTypes.areStudentNamesVisible ]: ( v ) => ( v ) => {
                return visibility;
            },
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
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );


    describe( " students display as expected    ", () => {
        let expected = {};

        it( " happy path ", () => {
            _.forEach( students, function ( s ) {
                see( wrapper, s.nameLastFirst, '.student-name' );
            } );
        } );
    } );

    describe( " actions on row click  ", () => {
        it( "when a row is clicked, it notifies the central store" );
    } );

    describe( " Toggling student name visibility works as expected ", () => {
        it( " shows student names when visibility is on " );
        it( " does not show student names when visibility is off" );
    } );

    describe( " Graded and ungraded students have appropriate row styling", () => {
        it( "properly displays the expected styling" );
        it( "updates the style when a student becomes graded " );
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
