
require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;

import { makeKumis } from '../../../../helpers/factories';

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/roster/kumis.mutations';
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

let mutations = Component;


describe( "kumi.mutations ", function () {
    let state, student;
    let payload;
    let gettersStub,exam, students, kumis, kumi;

    beforeEach( function () {
        state = {
            kumis: [],
            studentKumiAssociations: [],
            examKumiAssociations: []
        };

        kumis = makeKumis( 3 );
        kumi = faker.random.arrayElement( kumis );
        exam = factories.examFactory();
        student = factories.studentFactory();
    } );

    // ------------ kumi props
    describe( description( mTypes.addKumi ), () => {
        it( "Adds kumi to store when kumi doesn't already exist in store", () => {
            payload = Payload.factory( { obj: kumi } );
            //call
            mutations[ mTypes.addKumi ]( state, payload );
            //check
            expect( state.kumis.length ).toBe( 1 );
            expect( state.kumis[ 0 ] ).toBe( kumi );
        } );

        it( "Does not add kumi to store when kumi is already in store", () => {
            payload = Payload.factory( { obj: kumi } );
            state.kumis.push( kumi );
            //call
            mutations[ mTypes.addKumi ]( state, payload );
            //check
            expect( state.kumis.length ).toBe( 1 );
            expect( state.kumis[ 0 ] ).toBe( kumi );
        } );
    } );

    describe( mTypes.updateKumi, function () {
        it( 'updates values on kumi', () => {
            state.kumis.push( kumi );
            let test = 'taco';
            payload = Payload.factory( { obj: kumi, updateProp: 'name', updateVal: test } );
            //call
            mutations[ mTypes.updateKumi ]( state, payload );
            //check
            expect( kumi.name ).toBe( test );

        } );

    } );

    // -------------- kumi - student
    describe( description( mTypes.associateStudentWithKumi ), () => {
        it( "Creates the student-kumi association when none existed", () => {
            payload = Payload.factory( { student: student, kumi: kumi } );
            //call
            mutations[ mTypes.associateStudentWithKumi ]( state, payload );
            //check
            expect( student.associatedKumis.length ).toBe( 1 );
            expect( student.associatedKumis[ 0 ] ).toBe( kumi );
        } );

        it( "Silently does not create a new association when one already exists", () => {
            student.associatedKumis.push( kumi );
            payload = Payload.factory( { student: student, kumi: kumi } );
            //call
            mutations[ mTypes.associateStudentWithKumi ]( state, payload );
            //check
            expect( student.associatedKumis.length ).toBe( 1 );
            expect( student.associatedKumis[ 0 ] ).toBe( kumi );
        } );
    } );

    describe( description( mTypes.disassociateStudentFromKumi ), () => {
        it( "Removes the student-kumi association when one exists", () => {
            student.associatedKumis.push( kumi );
            payload = Payload.factory( { student: student, kumi: kumi } );
            //call
            mutations[ mTypes.disassociateStudentFromKumi ]( state, payload );
            //check
            expect( student.associatedKumis.length ).toBe( 0 );
        } );

        it( "Silently fails to remove a non-existent association", () => {
            payload = Payload.factory( { student: student, kumi: kumi } );
            //call
            mutations[ mTypes.disassociateStudentFromKumi ]( state, payload );
            //check
            expect( student.associatedKumis.length ).toBe( 0 );

        } );

    } );


    // --------------- kumi - exam
    describe( mTypes.associateExamWithKumi, function () {
        it( 'adds kumi and exam ids to the associated list when not already present', () => {
            let examId = exam.id;
            let kumiId = kumi.id;
            expect(state.examKumiAssociations.length).toBe(0);
            //call
            mutations[mTypes.associateExamWithKumi](state, {exam, kumi});
            //check
            expect(state.examKumiAssociations.length).toBe(1);
            expect(state.examKumiAssociations[0].examId).toBe(examId);
            expect(state.examKumiAssociations[0].kumiId).toBe(kumiId);
        } );

        it( 'does not add kumi and exam ids to the associated list when already present', () => {
            let o = {examId: exam.id, kumiId: kumi.id};
            state.examKumiAssociations.push(o);
            expect(state.examKumiAssociations.length).toBe(1);
            //call
            mutations[mTypes.associateExamWithKumi](state, {exam, kumi});
            //check
            expect(state.examKumiAssociations.length).toBe(1);
            expect(state.examKumiAssociations[0].examId).toBe(o.examId);
            expect(state.examKumiAssociations[0].kumiId).toBe(o.kumiId);
        } );
    } );

    describe( mTypes.disassociateExamFromKumi, function () {
        it( 'removes kumi and exam association ', () => {
            //prep
            let numKumis = 3;
            let kumis = factories.makeKumis(numKumis);
            _.forEach(kumis, function(k){
                let ex = factories.examFactory();
                let o = {examId: ex.id, kumiId: k.id};
                state.examKumiAssociations.push(o);
            });
            //make sure test state is correct
            expect(state.examKumiAssociations.length).toBe(numKumis);
            let test = state.examKumiAssociations[numKumis - 1];
            expect(_.findIndex(state.examKumiAssociations, test)).not.toBe(-1);
            //call
            payload = { exam : { id : test.examId}, kumi  :{ id: test.kumiId}};
            mutations[mTypes.disassociateExamFromKumi](state, payload)
            //check
            expect(_.findIndex(state.examKumiAssociations, test)).toBe(-1);
            expect(state.examKumiAssociations.length).toBe(numKumis - 1);
        } );

    } );
} );
