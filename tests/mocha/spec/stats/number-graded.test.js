//The name of the tested component
import { see } from "../../helpers/test-helpers";

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


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    let responseData;

    beforeEach( () => {
        // import and pass your custom axios instance to this method
        moxios.install()

        responseData = {
            numStudents: helpers.randomInteger(),
            numGraded: helpers.randomInteger()
        };

        exam = factories.examFactory();

        actions = {}
        getters = {};
        mutations = {
            [ mTypes.updateItem ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue,
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

    describe( 'async computed', () => {

        describe( 'examCountsAjax', () => {
            it( 'loads correctly', () => {
                expect('cat').toBe(39);

                moxios.wait( function () {
                    let request = moxios.requests.mostRecent();
                    request.respondWith( {
                        status: 200,
                        response: [ data ]
                    } ).then( function () {
                        expect('cat').toBe(39);
                        expect(true).toBe(false);
                    } );
                } )

            } );
            it( 'updates the total number of students', () => {

                moxios.wait( function () {
                    let request = moxios.requests.mostRecent();
                    request.respondWith( {
                        status: 200,
                        response: [ responseData ]
                    } ).then( function () {
                        //the test

                        let pl = Payload.factory( {
                            mutateSilently: true,
                            obj: me.exam,
                            updateProp: 'numberStudents',
                            updateVal: _.toInteger( responseData.numStudents )
                        } );

                        expect(mutations[mTypes.updateItem].callCount).toBe(2);
// expect(mutations[mTypes.updateItem].args[0][1])
assertions.assertPayloadWasCorrect(mutations[mTypes.updateItem], pl)

                    } );
                } )
            } );
            it( 'stores the number of graded exams', function () {

            } );

            it( 'sets isLoading (which the indicator uses) to false when done', function () {

            } );

            it( 'returns false when the exam is undefined or newly created (id = -1)', function () {
                exam.id = -1
                wrapper.setProps( { exam } );
                expect( wrapper.vm.examCountsAjax ).toBe( false );

                exam.id = undefined;
                wrapper.setProps( { exam } );
                expect( wrapper.vm.examCountsAjax ).toBe( false );
            } );
        } );
    } );

} );
