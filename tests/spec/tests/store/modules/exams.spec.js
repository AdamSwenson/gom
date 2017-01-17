//test libraries
require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as exams from '../../../../../resources/assets/js/store/modules/exams';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Exam from '../../../../../resources/assets/js/store/models/Exam'

const makeState = ( n = 5 ) => {

    let s = makeRootState();

    for ( let i = 0; i < n; i++ ) {
        let e = factories.examFactory();
        s.exams[ i ] = e;
        s.indexMap[ i ] = i;
    }
    return s;
};

const makeRootState = function () {
    return {
        exams: {},
        indexMap: {}
    };
};

const makeTestPayload = function () {
    let e = factories.examFactory();
    return {
        examIndex: e.examIndex,
        examId: e.examId,
        obj: e
    };
};


//tested object
let obj = exams.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store | modules | ", function () {
    describe( " exams | ", function () {
        beforeEach( function () {
            this.state = makeState();
            this.rootState = makeRootState();
            this.payload = makeTestPayload();
        } );

        describe( "mutations | ", function () {
            describe( description( mTypes.addExam ), function () {
                it( "happy path | ", function () {
                    mutations[ mTypes.addExam ]( this.state, this.rootState, this.payload );
                    expect( this.state.exams[ this.payload.obj.id ] ).toBe( this.payload.obj );
                } );

                xit( "payload.obj not Exam | ", function () {
                    // mutations[ mTypes.addExam ]( this.state, this.rootState, this.payload );
                    // expect( this.state.exams[ this.payload.obj.id ] ).toBe( this.payload.obj );
                } );
            } );

            describe( description( mTypes.addIndexMapping ), function () {
                it( "happy path | ", function () {
                    let v = faker.random.number();

                    mutations[ mTypes.addIndexMapping ]( this.state, this.rootState, {examIndex: v, examId: v} );
                    expect( this.state.indexMap[ v ] ).toBe( v );
                } );

                xit( "payload does not contain index  | ", function () {
                    // mutations[ mTypes.addExam ]( this.state, this.rootState, this.payload );
                    // expect( this.state.exams[ this.payload.obj.id ] ).toBe( this.payload.obj );
                } );

                xit( "payload does not contain id  | ", function () {
                    // mutations[ mTypes.addExam ]( this.state, this.rootState, this.payload );
                    // expect( this.state.exams[ this.payload.obj.id ] ).toBe( this.payload.obj );
                } );
            } );

            describe( description( mTypes.loadExams ), function () {
                xit( "happy path | ", function () {
                    //todo
                } );
            } );
        } );


        describe( "actions | ", function () {

            describe( description( aTypes.addNewExam ), function () {
                xit( "happy path | ", function () {

                    let action = actions[ aTypes.addNewExam ];
                    expect(typeof action).not.toBe('undefined');

                    //Todo make work
                    //let pl = makeTestPayload();
                    let expectedMutations = [
                        {
                            type: mTypes.addExam,
                            payload: this.payload
                        },

                        {
                            type: mTypes.addIndexMapping,
                            payload: this.payload
                        }
                    ];

                    testAction( action, this.payload, this.state, expectedMutations );
                } );
            } );
            //needs non instance of exam case too


            describe( description( aTypes.loadExams ), function () {
                xit( "happy path | ", function () {

                    let action = actions[ aTypes.loadExams ];
//Todo write
//                let pl = makeTestPayload();
                    let expectedMutations = [
                        {
                            type: mTypes.addExam,
                            payload: this.payload
                        },

                        {
                            type: mTypes.addIndexMapping,
                            payload: this.payload
                        }
                    ];

                    testAction( action, this.payload, this.state, expectedMutations );
                } );
            } );
            //needs non instance of exam case too

        } );

        describe( "getters | ", function () {
            describe( "getExam | ", function () {
                it( "happy path | ", function () {
                    //prep
                    this.state.exams[ this.payload.examId ] = this.payload.obj;

                    //call
                    let result = getters.getExam( this.state, {}, this.payload );

                    //check
                    expect( result ).toBe( this.payload.obj );
                } )

            } );


            describe( "getAllExams | ", function () {
                it( "happy path | ", function () {
                    //call
                    let result = getters.getAllExams( this.state, {}, {} );

                    //check
                    for ( let i = 0; i < result.length; i++ ) {
                        expect( typeof result[ i ] ).toBe( 'object' );
                        expect( result[ i ] instanceof Exam ).toBe(true);
                    };
                } );
            } );

        } );
    } );
} )
;
