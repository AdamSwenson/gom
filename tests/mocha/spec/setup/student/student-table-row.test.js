
//The name of the tested component
var compName = 'student-table-row';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/student/student-table-row.vue');

import Payload from '../../../../../resources/assets/js/models/Payload';

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

    let item, exam, student, students, kumis;
    let sorter;

    let column, sortedBy;

    beforeEach( () => {
        kumis = factories.makeKumis(2);
        student = factories.studentFactory();

        getters = {
            getKumisToFilterStudentsBy: (  ) => [] //kumis
        };
        mutations = {
            toggleStudent: sinon.spy(),
            updateStudentInRoster: sinon.spy()
        }

        store = new Vuex.Store( {
                getters, mutations
        } );

        wrapper = shallow( Component, {
            store, localVue, propsData: { student }
        } );

        // wrapper.setProps( { column, sortedBy } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'computed properties', function () {
        // expect(mutations.updateStudentInRoster.calledOnce).toBe(true);

    } );
    
    describe( " methods ", () => {

        describe( "handleRowSelection", () => {

            it( "calls the mutation to toggle selected state", () => {

                wrapper.vm.handleRowSelection();
                let pl = Payload.factory({
                    obj: student,
                    mutateSilently: true
                });

                //check
                expect(mutations.toggleStudent.calledOnce).toBe(true);
                expect(mutations.toggleStudent.args[0][1]).toMatchObject(pl);

            } );

            it( "emits an event to notify any listening parent", () => {
                wrapper.vm.handleRowSelection();
                expect( wrapper.emitted()[ wrapper.vm.events.rowToggle ] ).toBeTruthy();
            } );

            it("fires when the appropriate cell is clicked", (  ) => {
               wrapper.find('td.' + wrapper.vm.classes.rowSelectionCell).trigger('click');
                expect(mutations.toggleStudent.calledOnce).toBe(true);
                // expect(mutations.toggleStudent.args[0][1]).toMatchObject(pl);

            });
        } );

    });
});