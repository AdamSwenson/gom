require( '../../../../injectglobals' );

// import Payload from "../../../../../../../resources/assets/js/models/Payload";
//
//
// //Dependencies
// import * as nggTypes from "../../../../../../../resources/assets/js/store/new-grading-getter-types";
// import * as mTypes from '../../../../../../../resources/assets/js/store/new-grading-mutation-types';
// import * as aTypes from '../../../../../../../resources/assets/js/store/new-grading-action-types';
// import * as gTypes from "../../../../../../../resources/assets/js/store/getter-types";

// import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/grading-progress';

let obj = Component.default;
//tested methods
let { actions, getters } = obj;


describe( "grading-progress ", function () {

    let getterStub;
    let getterStub2;
    let testTotalExams;
    let testScoreList = [];

    beforeEach( function () {
        testTotalExams = faker.random.number();
    } );


    describe( "getters  ", function () {

        describe( nggTypes.getTotalExams, () => {
            beforeEach( function () {
                getterStub = sinon.stub();
                getterStub.returns( testTotalExams );
                getters[ gTypes.getStudentCount ] = (function () {
                    return getterStub();
                })();
            } );

            it( " returns the expected count ", () => {
                let result = getters[ nggTypes.getTotalExams ]( {}, getters, {} );
                expect( result ).toBe( testTotalExams );
                expect( getterStub.callCount ).toBe( 1 );
            } )

        } );

        describe( nggTypes.getNumberGraded, () => {
            let expectedNumber = 5;
            beforeEach( function () {
                for (let i = 0; i < expectedNumber; i++) {
                    let s = factories.itemScoreFactory();
                    s.studentId = i;
                    testScoreList.push( s );
                }
                getterStub = sinon.stub();
                getterStub.returns( testScoreList );
                getters[ nggTypes.getAllItemScores ] = (function () {
                    return getterStub();
                })();
            } );

            it( " returns the expected count ", () => {
                let result = getters[ nggTypes.getNumberGraded ]( {}, getters, {} );
                expect( result ).toBe( expectedNumber );
                expect( getterStub.callCount ).toBe( 1 );
            } )

        } );

        describe( nggTypes.getNumberExamsRemaining, () => {
            it( " returns the expected count when total is greater than number graded  ", () => {
                //prep
                let expectedNumberGraded = faker.random.number();
                //ensure that total is bigger than number graded
                let expectedTotalExams = testTotalExams * expectedNumberGraded;
                let expectedRemaining = expectedTotalExams - expectedNumberGraded;

                getterStub = sinon.stub();
                getterStub.returns( expectedNumberGraded );
                getters[ nggTypes.getNumberGraded ] = (function () {
                    return getterStub();
                })();

                getterStub2 = sinon.stub();
                getterStub2.returns( expectedTotalExams );
                getters[ nggTypes.getTotalExams ] = (function () {
                    return getterStub2();
                })();

                //call
                let result = getters[ nggTypes.getNumberExamsRemaining ]( {}, getters, {} );

                //check
                expect( getterStub.callCount ).toBe( 1 );
                expect( getterStub2.callCount ).toBe( 1 );
                expect( result ).toBe( expectedRemaining );
            } );

        } );

    } );

    describe( "actions", function () {
        let responseData, test, state;
        let exam;

        describe( ngaTypes.loadGradingProgress, function () {
            beforeEach( function () {
                // import and pass your custom axios instance to this method
                moxios.install()

                responseData = {
                    numStudents: helpers.randomInteger(),
                    numGraded: helpers.randomInteger()
                };

                test = factories.examFactory(); //todo make random
                state = {};
            } );
            afterEach( function () {
                moxios.uninstall();
            } );

            it( 'loads progress values from exam and updates them on exam object', function ( done ) {

                let route = 'dev/numgraded/exam/' + test.id;

                moxios.stubRequest( route, {
                    status: 200,
                    response: [ responseData ]
                } );

                let action = actions[ ngaTypes.loadGradingProgress ];
                let expectedPayload = Payload.factory( {
                    mutateSilently: true,
                    obj: test,
                    updateProp: 'numberStudents',
                    updateVal: _.toInteger( responseData.numStudents )
                } );
                let expectedPayload2 = Payload.factory( {
                    mutateSilently: true,
                    obj: test,
                    updateProp: 'numberGraded',
                    updateVal: _.toInteger( responseData.numGraded )
                } );
                let expectedMutations = [
                    { type: mTypes.updateItem, payload: expectedPayload },
                    { type: mTypes.updateItem, payload: expectedPayload2 }
                ];

                helpers.testAction( action, test, {}, expectedMutations, { verbose: true } );
                done();


            } );
        } );
    } );
});

