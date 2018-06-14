//The name of the tested component

var compName = 'kumis.actions';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/kumis.actions.js' );

import Payload from "../../../../../../resources/assets/js/models/Payload";
import { Routes } from "../../../../../../resources/assets/js/api/apiSettings";

import axios from 'axios';
window.axios = axios;

require( '../../../../injectglobals' );

//tested object
let actions = Component;

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let action, getters, state, expectedMutations;
    beforeEach( () => {
        moxios.install();

        exam = factories.examFactory();
        kumi = factories.kumiFactory();

        getters = {};
        getters[ gTypes.getActiveExam ] = sinon.stub();
        getters[ gTypes.getActiveExam ].returns( exam );
    } );

    afterEach( () => {
        moxios.uninstall();
    } );

    //todo check payload contents
    describe( 'createKumi', () => {

        //todo not really working, probably because not getting response to request
        it( 'happy path', ( done ) => {
            action = actions.createKumi;
            payload = {};
            state = {};
            expectedMutations = [ { type: mTypes.addKumi , payload: false}, {type: mTypes.associateExamWithKumi , payload: false} ]

            moxios.stubRequest( Routes.createKumi(), {
                status: 200,
                response: { id: 12345 }
            } );

            helpers.testAction( action, payload, state, expectedMutations , {getters: getters, verbose: false});

            // expect(getters[gTypes.getActiveExam].callCount).toBe(1);
            done();

        } );
    } );


    describe( " removeKumi", () => {
        //todo not really working, probably because not getting response to request
        it( 'no students associated with kumi', ( done ) => {
            action = actions.removeKumi;
            payload = {kumi, exam};
            state = {};
            expectedMutations = [ { type: mTypes.disassociateExamFromKumi, payload: Payload.factory({kumi, exam}) } ];

            //no students in kumi
            getters.getStudentsForKumi = sinon.stub();
            getters.getStudentsForKumi.returns( [] );

            moxios.stubRequest( Routes.disassociateKumi(kumi, exam), {
                status: 200
            } );

            helpers.testAction( action, payload, state, expectedMutations, {getters} );
            done();

        } );
    } );

} )
;
