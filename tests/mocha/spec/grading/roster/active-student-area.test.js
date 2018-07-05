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

    beforeEach( () => {
        student = factories.studentFactory();

        getters = {
            [ gTypes.getActiveStudent ]: () => () => student,
            [ gTypes.areStudentNamesVisible ]: () => () => true
        };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue, mocks: { $parent: sinon.stub() }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " Displays student info ", () => {
        it( ' shows name when name visibility is on ', (  ) => {
            assertions.assertThatSeeText(wrapper, student.nameFirstLast);
        } );

        it(" doesn't show name when blind grading is on ", (  ) => {
            getters[gTypes.areStudentNamesVisible] = (  ) => (  ) => false;
            store = new Vuex.Store( {
                getters,
                mutations
            } );

            wrapper = shallow( Component, {
                store, localVue, mocks: { $parent: sinon.stub() }
            } );

            expect( wrapper.html() ).not.toContain( student.nameFirstLast );
        });
    } );


} );
