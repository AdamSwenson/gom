//The name of the tested component
var compName = 'column-header-field';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/student/column-header-field.vue' );


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

    let column, sortedBy;

    beforeEach( () => {

        store = new Vuex.Store( {
            //    getters,
        } );

        column = {
            shortText: 'dog',
            longText: 'dog food',
            studentProperty: 'name',
        };
        sortedBy = 'name';

        wrapper = shallow( Component, {
            store, localVue, propsData : { column, sortedBy }
        } );

        // wrapper.setProps( { column, sortedBy } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( " methods ", () => {
        it( 'sortRosterBy emits expected event', () => {
            wrapper.trigger( 'click' );
            expect( wrapper.emitted()[wrapper.vm.events.sortEvent][0][0] ).toBe(column.shortText);
        } );

        it( 'toggleSortAscending emits expected event when column.studentProp = sortedBy', () => {
            wrapper.vm.toggleSortAscending( );
            expect( wrapper.emitted()[wrapper.vm.events.toggleEvent][0][0] ).toBe(column.shortText);
        } );

        it( 'toggleSortAscending does not emit an event when column.studentProp != sortedBy', () => {
            sortedBy = 'tacos';
            wrapper = shallow( Component, {
                store, localVue, propsData : { column, sortedBy }
            } );
            wrapper.vm.toggleSortAscending(  );
            expect( wrapper.emitted()[wrapper.vm.events.toggleEvent] ).toBeFalsy();
        } );
    } );


} );
