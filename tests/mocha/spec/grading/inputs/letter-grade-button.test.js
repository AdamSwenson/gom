import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';

let faker = require( 'faker' );
import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
import { factories } from '../../../../spec/helpers/vuex.spec.helpers';


import Exam from "../../../../../resources/assets/js/models/Exam";
import GradeAssignment from "../../../../../resources/assets/js/models/GradeAssignment";
import PayloadScore from "../../../../../resources/assets/js/models/PayloadScore";
import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
import * as gTypes from "../../../../../resources/assets/js/store/getter-types";

import * as nggTypes from "../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";
import { calculateGradeAssignmentFromItemScore } from "../../../../../resources/assets/js/store/modules/scores/itemLetterGradeHelpers";


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/grading/inputs/letter-grade-button.vue" );


describe( " letter-grade-button ", () => {
    let componentDivIdentifier = '#letterGradeArea';

    let getters;
    let mutations;
    let store;
    let exam;
    let student;
    let item;
    let wrapper;

    let examGetterStub;
    let studentGetterStub;

    beforeEach( () => {
        exam = factories.examFactory();
        examGetterStub = sinon.stub();
        examGetterStub.returns( exam );

        student = factories.studentFactory();
        studentGetterStub = sinon.stub();
        studentGetterStub.returns( student );

        item = factories.itemFactory();

        getters = {
            [ nggTypes.getActiveStudent ]: studentGetterStub,
            [ nggTypes.getActiveExamNew ]: examGetterStub,
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


    describe( " when loading ", () => {
        let expected = {};

        it( " displays the expected values when the score is non-null  ", () => {
            _.forEach( GradeAssignment.defaults, function ( ga ) {
                let maxScore = item.maxScore;
                let score = item.maxScore * (ga.minScore / item.maxScore);
                let result = calculateGradeAssignmentFromItemScore( score, maxScore );
                expect( result.displayValue ).toBe( ga.displayValue );
            } );
        } );

        it( " displays the expected defaults when the score is null ", () => {

        } );

    } );

    describe( " when a a new value is selected  ", () => {
        it( " changes the displayed grade and score " );
        it( " calls the expected mutation " );
    } );

    describe( " when the score is changed by some other process ", () => {
        it( " changes the displayed grade but does not replace the score (as though the button had been pressed" );


    } );

} );
