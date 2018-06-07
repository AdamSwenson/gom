
//The name of the tested component
var compName = 'question-score';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/inputs/question-score.vue');


require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

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
            [ nggTypes.getActiveExam] : () => examGetterStub
        };

        actions = {
            [ ngaTypes.recordCommentText ]: sinon.spy()
        }
        store = new Vuex.Store( {
            actions,
            getters,
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

        wrapper.setProps({item, student});


    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe(" Popover display -- not currently enabled", () => {
        // it('awaits tests')
    });


});
