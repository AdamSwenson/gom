//The name of the tested component
import { assertThatSeeText } from "../../helpers/assertions";

var compName = 'number-graded';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/stats/number-graded.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

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

    let responseData;

    beforeEach( function () {

        exam = factories.examFactory();

        actions = {
            [ ngaTypes.loadGradingProgress ]: sinon.spy()
        }
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

        wrapper = mount( Component, {
            store, localVue,
            // When sync is false, the Vue component is rendered asynchronously.
            sync: false,
            propsData: { exam }
        } );


    } );

    afterEach( function () {
        moxios.uninstall()
    } )


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'async computed', function () {

        describe( 'examCountsAjax', function () {
            it( 'loads and sets isLoading to false', function ( done ) {

                moxios.wait( function () {
                    expect( wrapper.vm.isLoading ).toBe( false );
                    //could add checks for subordinate html items, if we wanted....
                    expect( wrapper.html() ).toContain( 'stat-display-table-row' );
                    done();
                } );
            } );

            it( 'does not drive adam nuts', function (  ) {
                // let j = wrapper.vm.examCountsAjax;
                // j.then(function(){
                expect( actions[ ngaTypes.loadGradingProgress ].callCount ).toBe( 1 );
                // done();

                // });
                //
                // let pl;
                // moxios.wait( function () {
                //     pl = Payload.factory( {
                //         mutateSilently: true,
                //         obj: exam,
                //         updateProp: 'numberStudents',
                //         updateVal: _.toInteger( responseData.numStudents )
                //     } );
                // //
                // // } )
                // //     .then( function () {
                //         //check
                //         expect( actions[ ngaTypes.loadGradingProgress ].callCount ).toBe( 1 );
                //
                //         // assertions.assertPayloadWasCorrect( mutations[ mTypes.updateItem ], pl );
                //         done();
                //     } )
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

} )
;
