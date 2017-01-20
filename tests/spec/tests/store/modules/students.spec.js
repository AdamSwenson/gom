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

const makeTestPayload = function () {
    return {
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        studentId: faker.random.number(),
        firstName: faker.name.firstName(),
        lastName: faker.name.lastName(),
        studentIdentifier: faker.random.uuid(),
    };
};


const makeMutationPayload = function () {
    let p = new Payload();
    let s = factories.studentFactory();
    p.index = s.studentIndex; //faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] );
    p.id = s.studentId; //faker.random.number();
    p.obj = s;
    return p;
};

//tested object
let obj = students.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | ", function () {
    describe( "students | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
            this.mutationPayload = makeMutationPayload();
        } );

        describe( "mutations | ", function () {

            describe( description( mTypes.setStudent ), function () {
                it( "happy path | ", function () {
                    console.log( 'mp', this.mutationPayload );
                    //call
                    mutations[ mTypes.setStudent ]( this.state, this.rootState, this.mutationPayload );
                    //check
                    console.log( 'st', this.state.students );
                    expect( this.state.students[ this.mutationPayload.index ] ).toBe( this.mutationPayload.obj );
                } );
            } );
        } );

        describe( "actions | ", function () {
            describe( description( aTypes.loadStudents ), function () {
                describe( "happy path | ", function () {

                    it( "1 student | ", function () {
                        // let pl = [ {
                        //     studentIndex: this.payload.studentIndex,
                        //     studentObject: this.payload.studentObject
                        // } ];

                        let action = actions[ aTypes.loadStudents ];

                        testAction( action, this.payload, this.state, [ {
                            type: mTypes.setStudent,
                            payload: this.mutationPayload
                        } ] );

                    } );

                    it( "multiple students | ", function () {
                        let pl = [ {
                            studentIndex: this.payload.studentIndex,
                            studentObject: {taco: 2}
                        }, {
                            studentIndex: this.payload.studentIndex + 1,
                            studentObject: {taco: 3}
                        } ];

                        let action = actions[ aTypes.loadStudents ];

                        testAction( action, pl, this.state, [ {
                            type: mTypes.setStudent,
                            payload: pl
                        } ] );

                    } );
                } );


                describe( description( aTypes.addStudent ), function () {
                    it( "happy path | ", function () {

                        let action = actions[ aTypes.addStudent ];

                        testAction( action, this.payload, this.state, [ {
                            type: mTypes.setStudent,
                            payload: this.mutationPayload
                        } ] );

                        //todo
                    } );
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
