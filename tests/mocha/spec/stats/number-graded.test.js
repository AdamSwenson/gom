//The name of the tested component
import { assertThatSeeText } from "../../helpers/assertions";

var compName = 'number-graded';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/stats/number-graded.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';
import Payload from "../../../../resources/assets/js/models/Payload";
import sinon from "sinon";

const localVue = createLocalVue();

localVue.use( Vuex )

function moxiosTester( data, test ) {
    moxios.wait( function () {
        let request = moxios.requests.mostRecent();
        request.respondWith( {
            status: 200,
            response: [ data ]
        } ).then( function () {
            return test();
        } );
    } )
};


describe( compName, function () {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let $route = { params: { serialNumber: null } };

    let responseData;
    let updateStub = sinon.stub();

    beforeEach( function () {

        exam = factories.examFactory();

        actions = {
            [ ngaTypes.loadGradingProgress ]: sinon.stub()
        }
        actions[ ngaTypes.loadGradingProgress ].resolves( true );

        getters = {};
        mutations = {
            [ mTypes.updateItem ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        //
        // let route = 'dev/numgraded/exam/' + exam.id;
        //
        // moxios.stubRequest( route, {
        //     status: 200,
        //     response: [ responseData ]
        // } );
        //

        $route.params.serialNumber = exam.serialNumber;

        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            },
            // When sync is false, the Vue component is rendered asynchronously.
            sync: false,
            propsData: { exam }
        } );


    } );

    afterEach( function () {
        // moxios.uninstall()
    } )


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'async computed', function () {

        describe( 'examCountsAjax', function () {

            it( 'does not drive adam nuts', function ( done ) {
                let r = wrapper.vm.examCountsAjax;
                expect( actions[ ngaTypes.loadGradingProgress ].callCount ).toBe( 1 );
                done();
            } );


            it.skip( 'sets isLoading (which the indicator uses) to false when done', function () {

            } );

            it.skip( 'returns false when the exam is undefined or newly created (id = -1)', function () {
                exam.id = -1
                wrapper.setProps( { exam } );
                expect( wrapper.vm.examCountsAjax ).toBe( false );

                exam.id = undefined;
                wrapper.setProps( { exam } );
                expect( wrapper.vm.examCountsAjax ).toBe( false );
            } );
        } );
    } );


    describe( " loading indicator  ", () => {

        it( " loading indicator displays and data is hidden when isLoading is true  ", ( done ) => {
            wrapper.vm.isLoading = true;
            wrapper.update();
            expect( wrapper.contains( '.loadingArea ' ) ).toBe( true );
            expect( wrapper.contains( '.number-graded-list' ) ).toBe( false );
            done();
        } );

        it( " loading indicator is hidden and data is visible when isLoading is false  ", ( done ) => {
            //not loading; should see list of exams
            wrapper.vm.isLoading = false;
            wrapper.update();
            expect( wrapper.contains( '.loadingArea ' ) ).toBe( false );
            expect( wrapper.contains( '.number-graded-list' ) ).toBe( true );
            done();
        } );
    } );


} );

// describe( " displays expected data after loading async   ", () => {
//     let expected = {};
//
//     it( " happy path ", ( done ) => {
//         let data = {
//             numStudents: 590,
//             numGraded: 400
//         };
//
//         updateStub.withArgs( Payload.factory( {
//             mutateSilently: true,
//             obj: exam,
//             updateProp: 'numberStudents',
//             updateVal: data.numStudents
//         } ) ).returns( data.numStudents );
//
//
//         updateStub.withArgs( Payload.factory( {
//             mutateSilently: true,
//             obj: exam,
//             updateProp: 'numberGraded',
//             updateVal: data.numGraded
//         } ) ).returns( data.numGraded );
//
//         // updateStub.onCall( 1 ).returns( data.numGraded );
//
//         moxios.wait( function () {
//             let request = moxios.requests.mostRecent()
//             request.respondWith( {
//                 status: 200,
//                 response: [ data ]
//             } ).then( function () {
//                 //check that mutation was called as expected
//                 expect( updateStub.callCount ).toBe( 2 );
//
//                 //should see values on page
//                 assertThatSeeText( wrapper, data.numStudents, '.number-graded' );
//                 assertThatSeeText( wrapper, data.numGraded, '.number-graded' );
//                 assertThatSeeText( wrapper, data.numStudents - data.numGraded, '.number-graded' );
//                 done();
//
//             } );
//         } )
//     } )
// } );
