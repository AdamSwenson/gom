import { mount, shallow, createLocalVue } from 'vue-test-utils';
require('../../injectglobals');

//helpers
import { assertThatSeeText } from '../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );

import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
// import { makeGradeFrequencyObject } from '../../helpers/factories';

//tested stuff
var Component = require( "../../../../resources/assets/js/development/components/stats/time-stats.vue" );


describe( "time-stats  ", () => {
    let componentDivIdentifier = '.time-stats';
    let getters;
    let mutations;
    let store;
    let item, exam;
    let $route = { params: { serialNumber: null } };
    let wrapper, stub;
    let routeSerialNumber;

    beforeEach( () => {
        exam = factories.examFactory();

        item = exam;
        routeSerialNumber = item.serialNumber;

        stub = sinon.stub();
        // import and pass your custom axios instance to this method
        // moxios.install();

        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            },

            [ gTypes.getItemCount ]: ( v ) => ( v ) => {
            },

            getStudentCount: ( v ) => ( v ) => {
            },

        };

        mutations = {
            [ mTypes.updateItem ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = item.serialNumber;

        wrapper = shallow( Component, {
            store, localVue, propsData : {exam},
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );
        stub.resolves({
            averageSeconds: 33,
            elapsedSeconds: 22
        });
        wrapper.setMethods({getTotalGradingTime: stub});

    } );

    afterEach( function () {
        // import and pass your custom axios instance to this method
        // moxios.uninstall();
    } );

    describe( " loads into expected default state for testing ", () => {

        it( " test store has been set up properly ", () => {
            expect( getters.getItemBySerialNumber() ).toBe( item );
        } );


        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );

    } );


    describe( " loading indicator  ", () => {

        it( " loading indicator displays and time-list is hidden when isTimeLoading is true  ", () => {
            wrapper.vm.isLoading = true;
            wrapper.update();
            expect( wrapper.contains( '.loadArea ' ) ).toBe( true );
            expect( wrapper.contains( '.time-list' ) ).toBe( false );

        } );

        it( " loading indicator is hidden and time-list is visible when isTimeLoading is false  ", () => {
            //not loading; should see list of exams
            wrapper.vm.isLoading = false;
            wrapper.update();
            expect( wrapper.contains( '.loadArea ' ) ).toBe( false );
            expect( wrapper.contains( '.time-list' ) ).toBe( true );
        } );
    } );


    describe( " displays expected data after loading async   ", () => {
        let expected = {};

        it( " happy path ", (done) => {
            expect(stub.callCount>0).toBe(true);
            done();
            // let data = {
            //     elapsedSeconds:
            //         590.86,
            //     averageSeconds: 324.56
            // };
            //
            // item.numberStudents = 34;
            // item.numberGraded =0;
            //
            // moxios.wait( function () {
            //     let request = moxios.requests.mostRecent();
            //     request.respondWith( {
            //         status: 200,
            //         response: [ data ]
            //     } )
            //         .then( function () {
            //         //elapsed time
            //         assertThatSeeText( wrapper, data.elapsedSeconds, componentDivIdentifier );
            //         //average time
            //         assertThatSeeText(wrapper, data.averageSeconds, componentDivIdentifier);
            //         //remaining time
            //         assertThatSeeText(wrapper, item.numberRemaining * data.averageSeconds);
            //     } );
            // } );
        } );
    } );
} );
