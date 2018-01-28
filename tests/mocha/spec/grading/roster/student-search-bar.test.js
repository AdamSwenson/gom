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

import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/grading/roster/student-search-bar.vue" );


describe.only( " student-search-bar ", () => {
    let componentDivIdentifier = '';

    let getters;
    let mutations;
    let store;
    let exam;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let students;
    let numStudents;

    beforeEach( () => {
        students = [];
        numStudents = 10;
        for (let i = 0; i < numStudents; i++) {
            students.push( factories.studentFactory( i ) );
        }

        getters = {
            'getSortedStudents' : ( v ) => {
                return students;
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

    //
    // describe( " loads into expected default state for testing ", () => {
    //     it( 'displays the expected component div on first load', () => {
    //         assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
    //     } );
    // } );

    describe(" computed properties ", (  ) => {

        describe(" students ", (  ) => {
           it(" happy path ", (  ) => {
              let r = wrapper.vm.students;
               expect( r.length ).toBe(numStudents);
           });
        });

        describe(" studentNames", (  ) => {
            it(" happy path ", (  ) => {
                let r = wrapper.vm.studentNames;
                expect(r.length ).toBe(numStudents );
            });
        })

        describe(" studentIdents", (  ) => {
            it(" happy path ", (  ) => {
                let r = wrapper.vm.studentIdents;
                window.console.log( 'student-search-bar.test', 'r', 98, r);
                expect(r.length ).toBe(numStudents);
            });
        });
    });


    describe( " methods    ", () => {

        describe( " handleSearchResult ", () => {
            it( " student name query ", () => {

                    let s = faker.random.arrayElement(students);
                    let name = s.nameFirstLast;
                    wrapper.vm.handleStudentSelection = sinon.stub();

                    //call
                    wrapper.vm.handleSearchResult(name);
                    //check
                    expect(wrapper.vm.handleStudentSelection.callCount).toBe(1);
                    expect(wrapper.vm.handleStudentSelection.args[0][0]).toBe(s);

            } );

            it( " student identifier query ", () => {
                let s = faker.random.arrayElement(students);
                let id =  s.studentIdentifier  ;
                window.console.log( 'student-search-bar.test', '', 126,id );
                wrapper.vm.handleStudentSelection = sinon.stub();

                //call
                wrapper.vm.handleSearchResult(id);
                //check
                expect(wrapper.vm.handleStudentSelection.callCount).toBe(1);
                expect(wrapper.vm.handleStudentSelection.args[0][0]).toBe(s);

            } );
        } );


    describe(" handleStudentIdentifierSearchResult ", (  ) => {
        it("happy path ", (  ) => {
            let s = faker.random.arrayElement(students);
            let id = s.studentIdentifier;
            wrapper.vm.handleStudentSelection = sinon.stub();

            //call
            wrapper.vm.handleStudentIdentifierSearchResult(id);
            //check
            expect(wrapper.vm.handleStudentSelection.callCount).toBe(1);
            expect(wrapper.vm.handleStudentSelection.args[0][0]).toBe(s);
        });
    });

    describe(" handleStudentNameSearchResult ", (  ) => {
        it("happy path ", (  ) => {
            let s = faker.random.arrayElement(students);
            let name = s.nameFirstLast;
            wrapper.vm.handleStudentSelection = sinon.stub();

            //call
            wrapper.vm.handleStudentNameSearchResult(name);
            //check
            expect(wrapper.vm.handleStudentSelection.callCount).toBe(1);
            expect(wrapper.vm.handleStudentSelection.args[0][0]).toBe(s);
        });

    });

    });
} );
