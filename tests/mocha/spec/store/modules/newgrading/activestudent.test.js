require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;


//Dependencies
import * as Component from '../../../../../../resources/assets/js/store/modules/newgrading/activestudent-new';


import Payload from '../../../../../../resources/assets/js/models/Payload';

//tested object
let { getters, actions, mutations } = Component.default;


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


describe( " activestudent (new)", function () {
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

    describe( "mutations  ", function () {
        describe( description( ngmTypes.setActiveStudent ), function () {

            it( "happy path ", function () {
                state.activeStudent = student;
                let pl = Payload.factory( { obj: student } );
                mutations[ ngmTypes.setActiveStudent ]( state, {}, pl );
                expect( state.activeStudent ).toBe( student );
            } );
        } );

        describe( description( ngmTypes.setActiveStudentTime ), function () {
            it( "happy path  ", function () {
                state.activeStudent = student;
                let time = faker.random.number();
                let pl = Payload.factory( { num: time } );

                mutations[ ngmTypes.setActiveStudentTime ]( state, {}, pl );
                expect( state.activeStudent.gradingTime ).toBe( time );
            } );
        } );
    } );

    describe( "actions  ", function () {


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
        describe( ngaTypes.resetActiveStudent, function () {

            it( "happy path ", () => {
                let test = factories.studentFactory(); //todo make random
                let state = makeState(); //{Index: null, Id: null, student: null};
                let action = actions[ ngaTypes.resetActiveStudent ];
                let expectedPayload = Payload.factory( { obj: null, num: null } );

                let expectedMutations = [
                    { type: ngmTypes.setActiveStudent, payload: expectedPayload },
                    { type: ngmTypes.setActiveStudentTime, payload: expectedPayload }
                ];

                testAction( action, test.studentIndex, state, expectedMutations, { verbose: true } );

            } );

        } ),

            describe( ngaTypes.setStudentAsActive + " | ", function () {
                describe( "Happy paths  | ", function () {
                    it( "input is Student object ", function () {
                        let test = factories.studentFactory(); //todo make random
                        let state = makeState(); //{Index: null, Id: null, student: null};
                        let action = actions[ ngaTypes.setStudentAsActive ];

                        testAction( action, test.studentIndex, state, [
                                { type: ngmTypes.setActiveStudent, payload: Payload.factory( { obj: test } ) }
                            ],
                            { verbose: true } );
                    } );
                } );
            } );

        // describe( ngaTypes.setTime + " | ", function () {
        //     it( "happy path ", function () {
        //         it( "input is Student object ", function () {
        //             let test = faker.random.number();
        //             let state = makeState(); //{Index: null, Id: null, student: null};
        //             let action = active.default.actions[ ngaTypes.setTime ];
        //
        //             testAction( action, test.studentIndex, state, [
        //                 { type: ngmTypes.setActiveStudentTime, payload: Payload.factory( { num: test } ) }
        //             ] );
        //         } );
        //     } );
        //
        // } );

    } );

    describe( "getters  ", function () {
        beforeEach( function () {
        } );
    } );

} )
;
