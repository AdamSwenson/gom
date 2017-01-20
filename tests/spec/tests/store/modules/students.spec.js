//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );

let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as students from '../../../../../resources/assets/js/store/modules/students';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Student from '../../../../../resources/assets/js/store/models/Student'
import Payload from '../../../../../resources/assets/js/store/models/Payload'

const makeState = ( n = 5 ) => {
    let s = makeRootState();
    //
    for ( let i = 0; i < n; i++ ) {
        s.students[ i ] = factories.studentFactory( i );
    }
    return s;
};

const makeRootState = function () {
    return {
        students: {},
    };
};

const makeTestPayload = function ( n = 1 ) {
    let make = () => {
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


//tested object
let obj = students.default;
//tested methods
let {getters, actions, mutations} = obj;


fdescribe( "store | modules | ", function () {
    describe( "students | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
            this.mutationPayload = makeMutationPayload();
            this.student = factories.studentFactory();
        } );

        describe( "mutations | ", function () {

            describe( description( mTypes.setStudent ), function () {
                it( "happy path | ", function () {
                    // console.log( 'mp', this.mutationPayload );
                    //call
                    mutations[ mTypes.setStudent ]( this.state, this.rootState, this.mutationPayload );
                    //check
                    // console.log( 'st', this.state.students );
                    expect( this.state.students[ this.mutationPayload.index ] ).toBe( this.mutationPayload.obj );
                } );
            } );
        } );

        describe( "actions | ", function () {
            describe( description( aTypes.loadStudents ), function () {
                describe( "happy path | ", function () {

                    it( "1 student ", function () {
                        let action = actions[ aTypes.loadStudents ];
                        let expected = Payload.factory( {
                            id: this.payload.studentId,
                            index: this.payload.studentIndex,
                            obj: this.payload.studentObject
                        } );

                        console.log( 'expect', expected );

                        let expectMutations = [ {
                            type: mTypes.setStudent,
                            payload: expected
                        } ];

                        console.log( 'expectM', expectMutations );
                        testAction( action, this.payload, this.state, expectMutations );

                    } );

                    it( "multiple students ", function () {
                        let numStudents = 2;
                        let action = actions[ aTypes.loadStudents ];

                        let pl = makeTestPayload( numStudents );

                        let expectedMutations = makeExpMut( mTypes.setStudent, pl );

                        testAction( action, pl, this.state, expectedMutations );

                        // let pl = [ {
                        //     studentIndex: this.payload.studentIndex,
                        //     studentObject: this.student
                        // }, {
                        //     studentIndex: this.payload.studentIndex + 1,
                        //     studentObject: factories.studentFactory()
                        // } ];

                        // let expected = Payload.factory( {
                        //     index: this.payload.studentIndex,
                        //
                        // } );


                    } );
                } );
            } );

            describe( description( aTypes.addStudent ), function () {
                it( "happy path ", function () {
                    //prep
                    let action = actions[ aTypes.addStudent ];
                    //check
                    testAction( action, this.payload, this.state, [ {
                        type: mTypes.setStudent,
                        payload: Payload.factory( {index: this.payload.index, obj: this.payload.obj} )
                    } ] );
                } );
            } );

        } );

        describe( "getters | ", function () {
            describe( "getStudent | ", function () {
                it( "happy path | ", function () {
                    //call
                    let result = getters.getStudent( this.state, {}, this.rootState, this.payload.studentIndex );
                    //check
                    let expected = this.state.students[ this.payload.studentIndex ];
                    expect( result ).toBe( expected );
                } );
            } );

            describe( "getStudents | ", function () {
                it( "happy path | ", function () {
                    //call
                    let result = getters.getStudents( this.state, {}, this.rootState );
                    //check
                    let expected = this.state.students;
                    expect( result ).toBe( expected );
                } );
            } );
        } );
    } );
} )
;
