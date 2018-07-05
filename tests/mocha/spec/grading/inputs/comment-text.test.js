
//The name of the tested component
var compName = 'comment-text';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/inputs/comment-text.vue');

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
        // scoreGetterStub.returns( scoreObj );


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


    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            wrapper = shallow( Component, {
                store, localVue
            } );

            wrapper.setProps({item, student});

            expect(wrapper.vm.isReady()).toBe(true);
            // assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe(" computed", () => {

        describe('commentText -- get ', () => {
            it(" returns an empty string if the item score object is undefined. ", (  ) => {
                wrapper = shallow( Component, {
                    store, localVue
                } );
                wrapper.setProps({item, student});

                expect(wrapper.vm.commentText).toBe('');
            });

            it(" returns the relevant text if the item score object is defined ", () => {
                scoreGetterStub.returns(scoreObj);
                wrapper = shallow( Component, {
                    store, localVue
                } );
                wrapper.setProps({item, student});

                //check
                expect(wrapper.vm.commentText).toBe(scoreObj.text);
            });
        });

        describe('commentText -- set ', (  ) => {
            it(" dispatches the appropriate action ", (  ) => {
                wrapper = shallow( Component, {
                    store, localVue
                } );

                wrapper.setProps({item, student});

                //call
                //nb just using scoreObj as a shortcut to random text
                let input = wrapper.find(componentDivIdentifier);
                    input.element.value = scoreObj.text;
                    input.trigger('input');

                //check
                expect(actions[ngaTypes.recordCommentText].callCount).toBe(1);

            });

        });
    });


});
