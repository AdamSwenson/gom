//The name of the tested component
var compName = 'valence-buttons';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/comment/valence-buttons.vue' );

import Comment from '../../../../../resources/assets/js/models/Comment';

require( '../../../injectglobals' );


import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let actions;
    let getters;
    let mutations;
    let store;
    let event;

    let wrapper;

    let item, exam, student, score, scoreObj;

    let examGetterStub;
    let studentGetterStub;
    let scoreGetterStub;

    beforeEach( () => {
        item = factories.itemFactory();

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
            [ nggTypes.getItemScoreObject ]: () => scoreGetterStub,
            [ nggTypes.getActiveExam ]: function () {
                return exam;
            },
            [ nggTypes.getActiveStudent ]: () => studentGetterStub
        };

        mutations = {};

        actions = {
            [ aTypes.handleNewStudentStorageAndAssociation ]: sinon.spy()
        }

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
            attachToDocument: true,
            sync: false
        } );


    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " methods ", () => {
        describe( 'setValence', () => {
            it( "sends the correct payload when called programmatically", () => {
                let i = 0;
                _.forEach( Comment.valences, function ( valence ) {
                    wrapper.vm.setValence( valence );
                    let evt = wrapper.emitted()[ wrapper.vm.events.changeValence ];
                    expect( evt ).toBeTruthy();
                    expect( evt[ i ][0] ).toBe( valence );
                    i++;
                } );
            } );

            it( "emits the correct event  when each of the buttons is clicked", () => {
                _.forEach( Comment.valences, function ( valence ) {
                    let buttonId = '#' + valence + '-button';
                    wrapper.find( buttonId ).trigger( 'click' );
                    let evt = wrapper.emitted()[ wrapper.vm.events.changeValence ];
                    expect( evt ).toBeTruthy();
                    //nb won't have the correct valence since that has to be passed in
                } );
            } );

        } );

    } );

} );
