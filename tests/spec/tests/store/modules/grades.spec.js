require( 'jasmine-jquery' );
require( 'sinon' );
let faker = require( 'faker' );

import {testAction, description, factories} from '../../../helpers/vuex.spec.helpers';

//Dependencies
import * as grades from '../../../../../resources/assets/js/store/modules/grades';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Payload from '../../../../../resources/assets/js/store/models/Payload'


const makeState = ( n = 5 ) => {

    let s = makeRootState();

    for ( let i = 0; i < n; i++ ) {
        s.examGrades[ i ] = faker.random.number();
        // s.standardGrades[ i ] = i;
    }
    return s;
};

const makeRootState = function () {
    return {
        examGrades: {},
        standardGrades: {}
    };
};

const makeTestPayload = function () {
    return {
        studentIndex: faker.random.arrayElement( [ 0, 1, 2, 3, 4 ] ),
        score: faker.random.number()
    };
};

const makeMutationPayload = function () {
    let e = makeTestPayload();
    return Payload.factory( {
        index: e.studentIndex,
        num: e.score,
        obj: {taco: 'yes please'}
    } );
};

//tested object
let obj = grades.default;
//tested methods
let {getters, actions, mutations} = obj;


describe( "store.modules | grades | ", function () {
    beforeEach( function () {
        this.state = makeState();
        this.rootState = makeRootState();
        this.payload = makeTestPayload();
        this.mutationPayload = makeMutationPayload();
    } );

    describe( "mutations | ", function () {
        describe( description( mTypes.loadExamGrades ), function () {
            it( "happy path ", function () {
                mutations[ mTypes.loadExamGrades ]( this.state, this.rootState, this.mutationPayload );
                expect( this.state.examGrades ).toBe( this.mutationPayload.obj );
            } );
        } );

        describe( description( mTypes.loadStandardGrades ), function () {
            it( "happy path  ", function () {
                mutations[ mTypes.loadStandardGrades ]( this.state, this.rootState, this.mutationPayload );
                expect( this.state.standardGrades ).toBe( this.mutationPayload.obj );
            } );
        } );

        describe( description( mTypes.setGrade ), function () {
            it( "happy path ", function () {
                mutations[ mTypes.setGrade ]( this.state, this.rootState, this.mutationPayload );
                expect( this.state.examGrades[ this.mutationPayload.index ] ).toBe( this.mutationPayload.num );
            } );
        } );

    } );

    describe( "actions | ", function () {

        describe( description( aTypes.loadExamGrades ), function () {
            it( "happy path | ", function () {
                let action = actions[ aTypes.loadExamGrades ];
                testAction( action, this.mutationPayload.obj, this.state, [ {
                    type: mTypes.loadExamGrades,
                    payload: Payload.factory( {obj: this.mutationPayload.obj} )
                } ] );
            } );
        } );


        describe( description( aTypes.loadStandardGrades ), function () {
            it( "happy path | ", function () {
                let action = actions[ aTypes.loadStandardGrades ];

                testAction( action, this.mutationPayload.obj, this.state, [ {
                    type: mTypes.loadStandardGrades,
                    payload: Payload.factory( {obj: this.mutationPayload.obj} )
                } ] );
            } );
        } );


        //THIS IS THE MOST IMPORTANT METHOD
        describe( description( aTypes.updateExamGrade ), function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );

    } );


    describe( "getters | ", function () {
        describe( "getExamGrade | ", function () {
            it( "happy path | ", function () {
                let result = getters.getExamGrade( this.state, {}, this.rootState, this.payload.studentIndex )
                expect( result ).toBe( this.state.examGrades[ this.payload.studentIndex ] )
            } );
        } );

        describe( "getStandardGrades | ", function () {
            it( "happy path | ", function () {
                let result = getters.getStandardGrades( this.state, {}, this.rootState )
                expect( result ).toBe( this.state.standardGrades );
            } );
        } );

        describe( "getGrade | ", function () {
            it( "happy path | ", function () {
                let result = getters.getStandardGrades( this.state, {}, this.rootState )
                expect( result ).toBe( this.state.standardGrades );
            } );
        } );
        describe( "getExamGradeForActiveStudent | ", function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );
    } );
} );
