//The name of the tested component
var compName = 'active-student-area';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/grading/roster/active-student-area.vue' );

require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let student;
    let studentGetterStub;

    beforeEach( () => {
        student = factories.studentFactory();
        studentGetterStub = sinon.stub();
        studentGetterStub.returns( student );

        getters = {
            [ nggTypes.getActiveStudent ]: () => (  ) => student,
            [ nggTypes.areStudentNamesVisible ]: () => () => true
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = mount( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
            assertions.assertElementExists(wrapper, '.active-student-name');
            assertions.assertElementExists(wrapper, '.active-student-id');
        } );

        it("has the correct computed properties", (  ) => {
            expect(wrapper.vm.isStudentNameVisible).toEqual(true);
           expect(wrapper.vm.activeStudent).toMatchObject(student);
        });
    } );

    describe( " Displays student info ", () => {
        it( ' shows name when name visibility is on ', (  ) => {
            assertions.assertThatSeeText(wrapper, student.nameFirstLast, '.active-student-name');
        } );

        it(" shows only the id when blind grading is on ", (  ) => {
            getters[gTypes.areStudentNamesVisible] = (  ) => (  ) => false;
            store = new Vuex.Store( {
                getters,
                mutations
            } );

            wrapper = shallow( Component, {
                store, localVue, mocks: { $parent: sinon.stub() }
            } );


            expect( wrapper.find('.active-student-id').text() ).toContain( student.studentIdentifier );
            expect( wrapper.find('.active-student-name').text() ).not.toContain( student.nameFirstLast );
        });
    } );


} );
