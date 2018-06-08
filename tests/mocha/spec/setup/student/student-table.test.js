//The name of the tested component
var compName = 'student-table';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/student/student-table.vue' );

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

    let item, exam, student, students;
    let sorter;

    let examGetterStub;
    let studentGetterStub;
    let scoreGetterStub;

    beforeEach( () => {
        item = factories.itemFactory();

        exam = factories.examFactory();
        examGetterStub = sinon.stub();
        examGetterStub.returns( exam );

        let numberStudents = 4;
        students = [];
        for (let i = 0; i < numberStudents; i++) {
            students.push( factories.studentFactory() );
        }
        // studentGetterStub = sinon.stub();
        // studentGetterStub.returns( students );


        sorter = ( students, field ) => {
            return _.sortBy( students, [ ( o ) => o[ field ] ] );
        };


        getters = {
            'getSelectedStudents': () => students
        };

        store = new Vuex.Store( {
            getters,
        } );

        wrapper = shallow( Component, {
            store, localVue,
        } );

        wrapper.setProps( { students } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " computed properties ", () => {
        describe( 'isOpsButtonAreaVisible', () => {
            it( 'shows the move and delete buttons when there are selected students', () => {
                //the getter stub will return students
                expect( wrapper.vm.isOpsButtonsAreaVisible ).toBe( true );
            } );
            it( "does not show the move and delete buttons when no students are selected", () => {
                getters = {
                    'getSelectedStudents': () => []
                };

                store = new Vuex.Store( {
                    getters,
                } );

                wrapper = shallow( Component, {
                    store, localVue,
                } );

                wrapper.setProps( { students } );

                //check
                expect( wrapper.vm.isOpsButtonsAreaVisible ).toBe( false );
            } );
        } );

        describe( 'sortedStudents', () => {
            it( 'reverses the order of the students when sortAsc is changed', () => {
                let first = _.first(wrapper.vm.sortedStudents);
                let last = _.last(wrapper.vm.sortedStudents);
                //call
                wrapper.vm.sortAsc = !wrapper.vm.sortAsc;
                //check
                expect( _.first(wrapper.vm.sortedStudents).serialNumber ).toBe( last.serialNumber );
                expect( _.last(wrapper.vm.sortedStudents).serialNumber ).toBe( first.serialNumber );
            } );

            it( 'changes the order of the students when sortedBy is changed', () => {
                _.forEach( wrapper.vm.columns, ( c ) => {
                    wrapper.vm.sortedBy =  c.studentProperty;
                    //check
                    let exp = sorter(students, c.studentProperty);
                    expect( wrapper.vm.sortedStudents ).toMatchObject( exp );
                } );

            } );
        } )

    } );

    describe( 'methods', () => {
        describe( 'sortRosterBy', () => {
            it( "changes the sortedBy field based on a shortText value of a column", () => {
                _.forEach( wrapper.vm.columns, ( c ) => {
                    wrapper.vm.sortRosterBy( c.shortText );
                    //check
                    expect( wrapper.vm.sortedBy ).toBe( c.studentProperty );
                } );
            } );
        } );
    } );


} );
