
//The name of the tested component
var compName = 'clear-score-button';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/inputs/clear-score-button.vue');


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
            [ nggTypes.getActiveExam ]: function(){ return exam;} //examGetterStub,
        };

        mutations = {};

        actions = {
            'resetItemScore': sinon.spy(),
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
    
    describe(" methods ", () => {
        it('handleClick dispatches correct action when element clicked', (  ) => {
            wrapper.find(componentDivIdentifier).trigger('click');

            expect(actions.resetItemScore.callCount).toBe(1);
            expect(actions.resetItemScore.args[0][1]).toMatchObject({
                exam,
                item,
                student
            } );
        })
    });


});
