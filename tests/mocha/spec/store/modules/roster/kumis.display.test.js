let sinon = require( 'sinon' );
let faker = require( 'faker' );

//Dependencies
import * as nggTypes from "../../../../../../resources/assets/js/store/new-grading-getter-types";
import * as ngmTypes from '../../../../../../resources/assets/js/store/new-grading-mutation-types';
import * as ngaTypes from '../../../../../../resources/assets/js/store/new-grading-action-types';
import * as gTypes from "../../../../../../resources/assets/js/store/getter-types";
import * as mTypes from '../../../../../../resources/assets/js/store/mutation-types';
import * as aTypes from '../../../../../../resources/assets/js/store/action-types';

import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/roster/kumis.display';
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

let { state, getters, mutations } = Component;


describe( "kumi | display   ", function () {

    let payload;
    let gettersStub, students, kumis;
    let numberStudentsAndKumis = 2;
    let expectedMutations;

    beforeEach( function () {
        state.kumisToFilterStudentsBy = [];
        state.selectedKumis = [];
        students = [];
        kumis = [];
        for (let i = 0; i < numberStudentsAndKumis; i++) {
            students.push( factories.studentFactory() );
            kumis.push( Kumi.factory( { name: faker.company.bs() } ) );
        }

        expectedMutations = [];
    } );


    describe( description( " getters " ), () => {

        //
        // describe( description( "isStudentInSelectedKumis" ), () => {
        //     it( "returns true when the student is one of the selected kumis", () => {
        //         let student = faker.random.arrayElement( students );
        //         let d = faker.random.arrayElement( kumis );
        //         //add the kumi to the student's list
        //         student.associatedKumis.push( d );
        //
        //         //set up getters
        //         state.selectedKumis = kumis;
        //
        //         //call
        //         let result = getters.isStudentInFilterByKumis( student );
        //
        //         //check
        //         expect( result ).toBe( true );
        //     } );
        //     it( "returns false when the student is not in any of the selected kumis", () => {
        //
        //     } );
        // } );
    } );

    describe( description( " mutations " ), () => {

        describe( description( "selectKumi" ), () => {

            it( "happy path ", () => {
                payload = Payload.factory( { obj: kumis[ 0 ] } );
                mutations.selectKumi( state, payload );

                expect( state.selectedKumis[ 0 ] ).toBe( payload.obj );
            } );
        } );

        describe( description( " deselectKumi" ), () => {
            it( "happy path ", () => {
                let k = kumis[ 0 ];
                let payload = Payload.factory( { obj: k } );
                state.selectedKumis.push( k );
                //call
                mutations.deselectKumi( state, payload );
                //check
                expect( state.selectedKumis.length ).toBe( 0 );
            } );
        } );


    } );
} );
