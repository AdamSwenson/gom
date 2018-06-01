
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
import * as Component from '../../../../../../resources/assets/js/store/modules/roster/roster.mutations';
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

let  mutations = Component;


describe( "roster | mutations ", function () {
let state, student;
    let payload;
    let gettersStub, students, kumis;
    let numberStudentsAndKumis = 2;
    let expectedMutations;

    beforeEach( function () {
    state= {
        roster : []
    };
    student = factories.studentFactory();
    } );

    describe( description( mTypes.addStudentToRoster ), () => {
        it( "Adds student to roster when student doesn't already exist in roster" , (  ) => {
            payload = Payload.factory({obj: student});
            //call
            mutations[mTypes.addStudentToRoster](state, payload );
            //check
            expect(state.roster.length).toBe(1);
            expect(state.roster[0]).toBe(student);
        });

        it( "Does not add student to roster when student is already in roster", (  ) => {
            payload = Payload.factory({obj: student});
            state.roster.push(student);
            //call
            mutations[mTypes.addStudentToRoster](state, payload );
            //check
            expect(state.roster.length).toBe(1);
            expect(state.roster[0]).toBe(student);
        } );
    } );
});
    //
    // /**
    //  * This updates the properties of a currently existing
    //  * student object
    //  * It is named this to avoid confusion with updateStudent which
    //  * the old version uses
    //  * @param state
    //  * @param payload
    //  */
    // [mTypes.updateStudentInRoster] : ( state, payload ) => {
    //     // window.console.log( 'roster', 'updateStudentInRoster', 60, payload);
    //     Payload.checkIfPayload( payload );
    //     let student = payload.obj;
    //     let idx = state.roster.indexOf( student );
    //
    //     Vue.set( state.roster[ idx ], payload.updateProp, payload.updateVal );
    // },
