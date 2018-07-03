//The name of the tested component
var compName = 'add-student-button';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/development/components/setup/student/action-buttons/add-student-button.vue' );


require( '../../../../injectglobals' );


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

        wrapper.setProps( { item } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " methods | addStudent", () => {
        let act;
        beforeEach( () => {
            wrapper.find( componentDivIdentifier ).trigger( 'click' );
            act = actions[ aTypes.handleNewStudentStorageAndAssociation ];
        } );

        it( 'dispatches correct action', ( done ) => {
            expect( act.callCount ).toBe( 1 );
            done();
        } );
        it( 'contains expected payload', ( done ) => {
            let resultPl = act.args[ 0 ][ 1 ];
            expect( resultPl ).toBeInstanceOf( Payload );
            expect( resultPl.obj ).toBeInstanceOf( Student.constructor );
            expect( resultPl.student ).toBeInstanceOf( Student.constructor );
            done();
        } );
        it( 'emits expected events', (done) => {
            expect( wrapper.emitted().addStudentCalled ).toBeTruthy();
            //todo are notifications used? if so, test async so can catch this
            // expect( wrapper.emitted().addStudentComplete ).toBeTruthy();
            done();
        } );
    } );


} );
