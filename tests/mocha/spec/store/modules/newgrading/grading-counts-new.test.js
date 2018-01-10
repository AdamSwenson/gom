require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as nggTypes from "../../../../../../resources/assets/js/store/modules/newgrading/new-grading-getter-types";
import * as mTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/grading-counts-new';

let obj = Component.default;
//tested methods
let { getters } = obj;


describe( "grading-counts-new  | ", function () {

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
                getters[ gTypes.getStudentCount ] = (function(){ return getterStub() ;})();
            } );

            it( " returns the expected count ", () => {
                let result = getters[ nggTypes.getTotalExams ]({}, getters, {});
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
                getterStub =  sinon.stub();
                getterStub.returns( testScoreList );
                getters[ nggTypes.getAllItemScores ] = (function(){ return getterStub(); })();
            } );

            it( " returns the expected count ", () => {
                let result = getters[ nggTypes.getNumberGraded ]({}, getters, {});
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
                getters[ nggTypes.getNumberGraded ] = (function(){return getterStub();})();

                getterStub2 = sinon.stub();
                getterStub2.returns( expectedTotalExams );
                getters[ nggTypes.getTotalExams ] = (function(){return getterStub2();})();

                //call
                let result = getters[ nggTypes.getNumberExamsRemaining ]({}, getters, {});

                //check
                expect( getterStub.callCount ).toBe( 1 );
                expect( getterStub2.callCount ).toBe( 1 );
                expect( result ).toBe( expectedRemaining );
            } );

        } );

    } );
} );

