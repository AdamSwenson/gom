//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as active from '../../../../../resources/assets/js/store/modules/activestudent';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/store/models/Payload'


import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//tested object
let obj = active.default;
//tested methods
let {getters, actions, mutations} = obj;


const makeState = function () {
    let s = makeRootState();
    return s;
};

const makeRootState = function () {
    return {
        activeStudent: null
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
    for ( let i = 0; i < n; i++ ) {
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

        let {studentIndex, studentId, studentObject} = payload;
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


describe( "store | modules | activestudent | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
        this.student = factories.studentFactory();
    } );

    describe( "mutations | ", function () {
        describe( description( mTypes.setActiveStudent ), function () {

            it( "happy path ", function () {
                // let stu = factories.studentFactory();
                let pl = Payload.factory( {obj: this.student} );
                mutations[ mTypes.setActiveStudent ]( this.state, {}, pl );
                expect( this.state.activeStudent ).toBe( this.student );
            } );
        } );

        describe( description( mTypes.clearActiveExam ), function () {
            it( "happy path  ", function () {
                let stu2 = factories.studentFactory();
                mutations[ mTypes.clearActiveStudent ]( this.state, {}, stu2 );
                expect( this.state.activeStudent ).toBeNull();
            } );
        } );
    } );

    describe( "actions | ", function () {
        xdescribe( aTypes.setIndex, function () {
            describe( "happy paths | ", function () {
                //happy path cases:
                //Number
                it( "is number | ", function () {
                } );

            } );

            describe( "sad paths | ", function () {
                //object, even with expected key
                it( "is object | ", function () {
                } );
                //numeric string
                it( "is numeric string | ", function () {
                } );
            } )
        } );

        xdescribe( aTypes.setId, function () {
            describe( "happy paths | ", function () {
                //happy path cases:
                //Number
                it( "is number | ", function () {
                } );

            } );

            describe( "sad paths | ", function () {
                //object, even with expected key
                it( "is object | ", function () {
                } );
                //numeric string
                it( "is numeric string | ", function () {
                } );
            } )
//cases: integer, object.studentId, objectStudentindex
        } );

        xdescribe( aTypes.setStudentObject, function () {
            describe( "happy paths", function () {
                //happy path cases:
                //Number
                it( "is number | ", function () {
                } );

            } );
            describe( "sad paths | ", function () {
                //object, even with expected key
                it( "is object | ", function () {
                } );
                //numeric string
                it( "is numeric string | ", function () {
                } );
            } )
        } );

        xdescribe( aTypes.setTime, function () {
            describe( "happy paths ", function () {
                //happy path cases:
                //Number
                it( "is number | ", function () {
                } );

            } );
            describe( "sad paths | ", function () {
                //object, even with expected key
                it( "is object | ", function () {
                } );
                //numeric string
                it( "is numeric string | ", function () {
                } );
            } )
        } );

        describe( aTypes.setActiveStudent + " | ", function () {
            describe( "input is is number | ", function () {
                xit( "happy path ", function () {
                    let test = 6; //todo make random
                    let state = makeState(); //{Index: null, Id: null, student: null};
                    let action = active.default.actions[ aTypes.setActiveStudentId ];

                    testAction( action, test, state, [
                        {type: mTypes.setId, payload: test}
                    ] );

                    expect( state.Index ).toBeNull();
                    // expect(state.Id).toBe(test);
                    expect( state.student ).toBeNull();
                } );


            } );

            xdescribe( aTypes.setActiveStudentId + " | ", function () {
                describe( "is number | ", function () {
                    it( "happy path ", function () {
                        let test = 6; //todo make random
                        let state = makeState(); //{Index: null, Id: null, student: null};
                        let action = active.default.actions[ aTypes.setActiveStudentId ];

                        testAction( action, test, state, [
                            {type: mTypes.setId, payload: test}
                        ] );

                        expect( state.Index ).toBeNull();
                        // expect(state.Id).toBe(test);
                        expect( state.student ).toBeNull();
                    } );

                } );

                xdescribe( "is object w expected key | ", function () {
                    it( "happy path | ", function () {
                        //todo
                    } );
                } );

                xdescribe( "is numeric string | ", function () {
                    it( "happy path | ", function () {
                        //todo
                    } );
                } );
            } );


            xdescribe( aTypes.setActiveStudentIndex + " | ", function () {
                describe( "is number | ", function () {
                    it( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is object with expected key | ", function () {
                    it( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is numeric string | ", function () {
                    it( "happy path | ", function () {
                        //todo
                    } );
                } );

            } );

            xdescribe( aTypes.setActiveStudentObject + " | ", function () {
                describe( "is number | ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is object w expected key | ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is numeric string | ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

            } );

            describe( aTypes.setActiveStudentTime + " | ", function () {
                describe( "is number | ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is object w expected key| ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

                describe( "is numeric string | ", function () {
                    xit( "happy path | ", function () {
                        //todo
                    } );
                } );

            } );

        } );
    } );

    describe( "getters | ", function () {
        beforeEach( function () {
            this.state.activeStudent = this.student;
            console.log( 'getters', this.student );
        } );

        describe( "getActiveStudentId | ", function () {
            it( "happy path ", function () {
                console.log( 'fasi', this.student );

                expect( getters.getActiveStudentId( this.state, {}, {} ) ).toBe( this.student.id );
            } );
        } );

        describe( "getActiveStudentIndex", function () {
            it( "happy path ", function () {
                expect( getters.getActiveStudentIndex( this.state, {}, {} ) )
                    .toBe( this.student.index );
            } );
        } );

        describe( "getActiveStudent", function () {
            it( "happy path ", function () {
                expect( getters.getActiveStudent( this.state, {}, {} ) )
                    .toBe( this.student );
            } );
        } );
    } );

} );