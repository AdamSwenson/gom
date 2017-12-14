import sinon from 'sinon';

let faker = require( 'faker' );
//
import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';


import moxios from 'moxios';

//Dependencies
//import * as items from '../../../../../resources/assets/js/store/modules/items';

import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../../resources/assets/js/store/action-types'
import * as gTypes from '../../../../../../resources/assets/js/store/getter-types'
import Item from '../../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../../resources/assets/js/models/Payload'
import GradeAssignment from '../../../../../../resources/assets/js/models/GradeAssignment'


var Component = require( '../../../../../../resources/assets/js/store/modules/analytics/gradedCounts' );

let { getters, actions, mutations } = Component.default;


describe( "gradedCounts  ", () => {
    let freq;
    let scores;
    let state;
    let letters;

    beforeEach( () => {
        //we fill the total scores with two scores of
        //each minimum for a grade. thus all grades
        //will have frequency = 2
        freq = 2;
        scores = [];
    } );

    describe( " test environment is set up correctly ", () => {
        it( " correctly imported the test objects ", () => {
            expect( _.isObject( getters ) ).toBe( true );
            expect( _.isObject( actions ) ).toBe( true );
            expect( _.isObject( mutations ) ).toBe( true );
        } );
    } );

    describe( " helpers ", () => {

        describe( " sortTotalScores ", () => {

        } );

        describe( " sortGradeAssignments ", () => {

        } );

        describe( " updateInconsistentList ", () => {

            // beforeEach( () => {
            //     letters = _.keys( state.gradeAssignments );
            // } );

            it( " behaves properly when there are no inconsistencies ", () => {
                Component.updateInconsistentList( state );
                expect( state.inconsistent.length ).toBe( 0 );
            } );

            it( " behaves properly (easy) ", () => {

                let problemKey = faker.random.arrayElement( letters );
                if ( problemKey === 'A+' ) problemKey = 'B-';

                state.gradeAssignments[ problemKey ].minScore = 1000000007;
                Component.updateInconsistentList( state );

                //check
                expect( state.inconsistent.length > 0 ).toBe( true );

            } );


        } );
    } );

    describe( "getters", () => {
        beforeEach( () => {
        } );

        // describe( gTypes.getCutOffsForLetterGrade, () => {
        //
        //     it( "happy path", function () {
        //
        //     } );
        //
        // } );


        describe( gTypes.getTotalNumberOfExamsToGrade, () => {

        } );

        describe( gTypes.getNumberGraded, () => {

        } );

        describe( gTypes.getNumberUngraded, () => {

        } );

    } );//getters


    describe( " actions ", () => {
        beforeEach( () => {
        } );
        describe( aTypes.loadGradeAssignmentsFromServerData, () => {
            it( " correctly parses the data and calls mutations  ", () => {
                //prep
                let payload = makeFakeServerResponse();

                //call
                testAction( actions[ aTypes.loadGradeAssignmentsFromServerData ], payload, {}, [
                    { type: 'replaceGradeAssignments' }
                ], { verbose: true } );

            } );
        } );

    } );

    describe( " mutations ", () => {
        describe( mTypes.updateGradeCutoffs, () => {

            // beforeEach( () => {c} );

            it( " behaves properly when there are no inconsistencies ", () => {
                let alteredKey = faker.random.arrayElement( letters );
                let obj = state.gradeAssignments[ alteredKey ];
                let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: obj.minScore + 1 } )

                //call
                mutations[ mTypes.updateGradeCutoffs ]( state, payload );
                //check
                //the value updated as expected
                expect( obj.minScore ).toBe( payload.updateVal );
                //the inconsistent list was not altered
                expect( state.inconsistent.length ).toBe( 0 );
            } );

            it( " behaves properly when there is one inconsistency ( value is too high for position) ", () => {
                let problemKey = faker.random.arrayElement( letters );
                if ( problemKey === 'A+' ) problemKey = 'B-';
                let obj = state.gradeAssignments[ problemKey ];
                let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 1000000007 } )

                //call
                mutations[ mTypes.updateGradeCutoffs ]( state, payload );

                //check
                //the mutation itself still happened
                expect( obj.minScore ).toBe( payload.updateVal );
                //the grade was recorded as inconsistent
                expect( state.inconsistent.length === 1 ).toBe( true );
                //since the value was too high, the newly inconsistent object
                //should be the changed object's higher neighbor. We can check via the
                //ordinal property
                expect( state.inconsistent[ 0 ].ordinal ).toBe( obj.ordinal - 1 );
            } );

            it( " behaves properly when there is one inconsistency ( value is too low for position) ", () => {
                let problemKey = faker.random.arrayElement( letters );
                if ( problemKey === 'A+' ) problemKey = 'B-';
                let obj = state.gradeAssignments[ problemKey ];
                let payload = Payload.factory( { obj: obj, updateProp: 'minScore', updateVal: 0 } )

                //call
                mutations[ mTypes.updateGradeCutoffs ]( state, payload );

                //check
                //the mutation itself still happened
                expect( obj.minScore ).toBe( payload.updateVal );
                //the grade was recorded as inconsistent
                expect( state.inconsistent.length === 1 ).toBe( true );
                //since the value was too low, the newly inconsistent object
                //should be the changed object itself.
                expect( state.inconsistent[ 0 ] ).toBe( obj );

            } );

        } );

    } );
} );
