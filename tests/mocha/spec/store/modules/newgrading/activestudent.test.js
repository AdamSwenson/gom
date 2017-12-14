//test libraries

require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/activestudent-new';


import * as mTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-mutation-types';

import * as aTypes from '../../../../../../resources/assets/js/store/modules/newgrading/new-grading-action-types';

import Payload from '../../../../../../resources/assets/js/models/Payload';

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
let obj = Component.default;
//tested methods
let { getters, actions, mutations } = obj;


const makeState = function () {
    let s = makeRootState();
    return s;
};

const makeRootState = function () {
    return {
        activeStudent: null,
        timerRunning: false,
    };
};

const makeTestPayload = function ( n = 1 ) {
    let make = function () {
        return {
            studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
            studentId: faker.random.number(),
            firstName: faker.name.firstName(),
            lastName: faker.name.lastName(),
            studentIdentifier: faker.random.uuid(),
        };
    }

    let out = [];
    for (let i = 0; i < n; i++) {
        out.push( make() );
    }
    return out;
};


const makeMutationPayload = function () {
    let p = new Payload();
    let s = factories.studentFactory();
    p.index = s.studentIndex; //faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    p.id = s.studentId; //faker.random.number();
    p.obj = s;
    return p;
};

const makeExpMut = ( type, payloads ) => {
    let out = [];

    payloads.forEach( function ( payload ) {

        let { studentIndex, studentId, studentObject } = payload;
        let expected = Payload.factory( {
            index: studentIndex,
            id: studentId,
            obj: studentObject
        } );

        out.push( {
            type: type,
            payload: expected
        } );

    } );
    return out;
};


describe( "store | modules | newgrading | activestudent | ", function () {
    let state;
    let rootState;
    let payload;
    let mutationPayload;
    let student;

    beforeEach( function () {
        state = makeState();
        rootState = makeRootState();
        //this.payload = makeTestPayload();
        //this.mutationPayload = makeMutationPayload();
        student = factories.studentFactory();
    } );

    describe( "mutations | ", function () {
        describe( description( mTypes.setActiveStudent ), function () {

            it( "happy path ", function () {
                state.activeStudent = student;
                let pl = Payload.factory( { obj: student } );
                mutations[ mTypes.setActiveStudent ]( state, {}, pl );
                expect( state.activeStudent ).toBe( student );
            } );
        } );

        describe( description( mTypes.setActiveStudentTime ), function () {
            it( "happy path  ", function () {
                state.activeStudent = student;
                let time = faker.random.number();
                let pl = Payload.factory( { num: time } );

                mutations[ mTypes.setActiveStudentTime ]( state, {}, pl );
                expect( state.activeStudent.gradingTime ).toBe( time );
            } );
        } );
    } );

    describe( "actions | ", function () {


        /**
         * This is the omnibus handler for resetting
         * the active student state
         *
         * Resets active exam to null and
         * resets the current grading time to null
         *
         * @param state
         * @param rootState
         * @param payload
         */
        describe( aTypes.resetActiveStudent, function () {

            it( "happy path ", () => {
                let test = factories.studentFactory(); //todo make random
                let state = makeState(); //{Index: null, Id: null, student: null};
                let action = active.default.actions[ aTypes.resetActiveStudent ];
                let expectedPayload = Payload.factory( { obj: null, num: null } );

                let expectedMutations = [
                    { type: mTypes.setActiveStudent, payload: expectedPayload },
                    { type: mTypes.setActiveStudentTime, payload: expectedPayload }
                ];

                testAction( action, test.studentIndex, state, expectedMutations, { verbose: true } );

            } );

        } ),

            describe( aTypes.setStudentAsActive + " | ", function () {
                describe( "Happy paths  | ", function () {
                    it( "input is Student object ", function () {
                        let test = factories.studentFactory(); //todo make random
                        let state = makeState(); //{Index: null, Id: null, student: null};
                        let action = active.default.actions[ aTypes.setStudentAsActive ];

                        testAction( action, test.studentIndex, state, [
                                { type: mTypes.setActiveStudent, payload: Payload.factory( { obj: test } ) }
                            ],
                            { verbose: true } );
                    } );
                } );
            } );

        describe( aTypes.setTime + " | ", function () {
            it( "happy path ", function () {
                it( "input is Student object ", function () {
                    let test = faker.random.number();
                    let state = makeState(); //{Index: null, Id: null, student: null};
                    let action = active.default.actions[ aTypes.setTime ];

                    testAction( action, test.studentIndex, state, [
                        { type: mTypes.setActiveStudentTime, payload: Payload.factory( { num: test } ) }
                    ] );
                } );
            } );

        } );

    } );

    describe( "getters | ", function () {
        beforeEach( function () {
        } );
    } );

} )
;
