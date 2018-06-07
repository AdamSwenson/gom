require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

import Exam from "../../../../../resources/assets/js/models/Exam";
import GradeAssignment from "../../../../../resources/assets/js/models/GradeAssignment";
import PayloadScore from "../../../../../resources/assets/js/models/PayloadScore";

import {
    calculateGradeAssignmentFromItemScore,
    calculateItemScoreFromLetterGrade
} from "../../../../../resources/assets/js/store/modules/scores/itemLetterGradeHelpers";


const localVue = createLocalVue();

localVue.use( Vuex )

//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/grading/inputs/letter-grade-button.vue" );


describe( " letter-grade-button ", () => {
    let componentDivIdentifier = '#letterGradeArea';
    let componentIdentifier = '.letterGradeList';

    let getters;
    let mutations;
    let actions;
    let store;
    let exam;
    let student;
    let score;
    let scoreObj;
    let item;
    let wrapper;

    let examGetterStub;
    let studentGetterStub;
    let scoreGetterStub;

    beforeEach( () => {
        score = 95;

        item = factories.itemFactory();
        item.maxScore = 100;

        exam = factories.examFactory();
        examGetterStub = sinon.stub();
        examGetterStub.returns( exam );

        student = factories.studentFactory();
        studentGetterStub = sinon.stub();
        studentGetterStub.returns( student );

        scoreObj = factories.itemScoreFactory( exam, item, student, score )
        scoreGetterStub = sinon.stub();
        scoreGetterStub.returns( scoreObj );


        getters = {
            [ nggTypes.getItemScoreObject ] : () => scoreGetterStub,
            [ nggTypes.getActiveExam ]: function(){ return exam;} //examGetterStub,
            };

        mutations = {};

        actions = {
            [ ngaTypes.recordItemScore ]: sinon.spy()
        }

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

        wrapper.setProps({item, student});

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );


    describe( ' computed ', () => {

        // it( " displays the expected default (empty string) when the score is null ", () => {
        //     getters.getItemScoreObject = ()=> (  ) => {
        //         return null;
        //     },
        //         // wrapper.vm.selectedGradeAssignment = null;
        //     // let input = wrapper.find( componentIdentifier );
        //     // input.trigger( 'change' );
        //
        //     expect( wrapper.vm.displayedGradeAssignment ).toBe( '' );
        // } )
    } );

    describe( " when a new value is selected via the select  ", () => {
        it( " changes the displayed grade and score ", () => {

            let pl = {
                exam: exam,
                item: item,
                student: student,
                score: score
            };

            //call
            wrapper.vm.selectedGradeAssignment = score;
            let input = wrapper.find( componentIdentifier );

            input.trigger( 'change' );

            expect( actions[ ngaTypes.recordItemScore ].callCount ).toBe( 1 );
            // expect( actions[ ngaTypes.recordItemScore ].args[ 0 ][ 1 ] ).toMatchObject( pl );
        } );

        it("same test, but via selecting the options", () => {

            // _.forEach(GradeAssignment.defaults, function(ga){
            //
            //     wrapper = shallow( Component, {
            //         store, localVue
            //     } );
            //
            //     wrapper.setProps({item, student});
            //
            //     let pl = {
            //         exam: exam,
            //         item: item,
            //         student: student,
            //         score: ga.calcValue
            //     };
            //
            //     wrapper.find('option[data="' + ga.calcValue + '"]' ).element.selected = true;
            //     wrapper.find( 'select' ).trigger( 'change' );
            //
            //     let act = actions[ ngaTypes.recordItemScore ]
            //     expect( act.callCount ).toBe( 1 );
            //     expect(act.args[ 0 ][ 1 ].score).toBe(ga.calcValue);

            // });

        })

    } );

    describe( " when the score is changed by a process other than this button  ", () => {
        it( " the displayed grade changes but the score is not replaced  (as though the button had been pressed", (  ) => {
            //
            // wrapper.vm.score = 88;
            // wrapper.update
            // expect(wrapper.vm.displayedGradeValue).toBe(88);
        } );


    } );


    it( " displays the expected values when the score is non-null  ", () => {
        _.forEach( GradeAssignment.defaults, function ( ga ) {
            let maxScore = item.maxScore;
            let score = item.maxScore * (ga.minScore / item.maxScore);
            let result = calculateGradeAssignmentFromItemScore( score, maxScore );
            expect( result.displayValue ).toBe( ga.displayValue );
        } );
    } );


} );
