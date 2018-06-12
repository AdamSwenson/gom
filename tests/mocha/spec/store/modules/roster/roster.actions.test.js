require( '../../../../injectglobals' );

const testAction = helpers.testAction;
const description = helpers.description;

//tested object
import * as Component from '../../../../../../resources/assets/js/store/modules/roster/roster.actions';
import Payload from "../../../../../../resources/assets/js/models/Payload";
import Kumi from "../../../../../../resources/assets/js/models/Kumi";

let actions = Component;


describe( "roster | actions ", function () {

    let getters, gettersStub, students, kumis;
    let numberStudentsAndKumis = 2;
    let expectedMutations;

    beforeEach( function () {

        students = [];
        kumis = [];
        for (let i = 0; i < numberStudentsAndKumis; i++) {
            students.push( factories.studentFactory() );
            kumis.push( Kumi.factory( { name: faker.company.bs() } ) );
        }
        //set up getter
        getters = {};
        gettersStub = sinon.stub();
        gettersStub.returns( kumis[ 0 ] );
        getters.getRootKumi = gettersStub;

        expectedMutations = [];
    } );


    describe( description( "addStudentsToKumis  " ), () => {
        it( " happy path ", () => {

            _.forEach( kumis, function ( kumi ) {
                _.forEach( students, function ( student ) {
                    let pl = {
                        type: 'associateStudentWithKumi',
                        payload: Payload.factory( { student, kumi } )
                    };
                    expectedMutations.push( pl );
                } );
            } );

            let payload = { students: students, kumis: kumis };

            testAction( actions.addStudentsToKumis, payload, {}, expectedMutations, { verbose: false } );
        } );
    } );


    describe( description( " removeStudentsFromKumis " ), () => {
        it( " happy path ", () => {


            _.forEach( kumis, function ( kumi ) {
                _.forEach( students, function ( student ) {
                    let pl = {
                        type: 'disassociateStudentFromKumi',
                        payload: Payload.factory( { student, kumi } )
                    };
                    expectedMutations.push( pl );
                } );
            } );

            let payload = { students: students, kumis: kumis };

            testAction( actions.removeStudentsFromKumis, payload, {}, expectedMutations, { verbose: false } );

        } );
    } );


    describe( description( " removeStudentsFromRoster " ), () => {
        it( " happy path ", () => {


            _.forEach( kumis, function ( kumi ) {
                _.forEach( students, function ( student ) {
                    let pl = {
                        type: mTypes.removeStudentFromRoster,
                        payload: Payload.factory( { student, kumi } )
                    };
                    expectedMutations.push( pl );
                } );
            } );

            let payload = { students: students, kumis: kumis };

            testAction( actions.removeStudentsFromRoster, payload, {}, expectedMutations, { verbose: false } );

        } );
    } )

});

//
// describe( description( " createStudent " ), () => {
//     it( " happy path ", () => {
//
//         let student = newStudentObjectOrPayload instanceof Student ? newStudentObjectOrPayload : Student.factory( newStudentObjectOrPayload );
//
//         //Start by saving the student object to the db
//         let p = createStudentRequest( student );
//         //We will need to wait for this to resolve
//         //because we will need the student's db id for
//         //the next step
//         p.then( function ( data ) {
//             //update the id on our newly created student object
//             student.id = data.id;
//             let pl = Payload.factory( {
//                 obj: student,
//                 mutateSilently: true
//             } );
//
//             //quietly add the student to store
//             commit( mTypes.addStudentToRoster, pl );
//
//
//         } );
//     } );
//
//     describe( description( aTypes.handleNewStudentStorageAndAssociation ), () => {
//         it( " happy path ", () => {
//             //Create a new student
//             //and save them to the db.
//             //We will need to wait for this to resolve
//             //because we will need the student's db id for
//             //the next step
//             let p = dispatch( 'createStudent', newStudentObject );
//
//             //Start by building a list of kumis that the student
//             //will need to be associated with
//             let kumis = [];
//             //all students need to be associated with the kumi
//             //connecting to the exam
//             kumis.push( getters.getRootKumi );
//             //get the kumis that are currently displayed and
//             //selected
//             kumis = kumis.concat( getters.getDisplayedKumis );
//             kumis = kumis.concat( getters.getSelectedKumis );
//
//             //once the promise has resolved, we have the student, with id,
//             //stored in our roster. We can now associate them with the kumis
//             p.then( function ( student ) {
//                 _.forEach( kumis, function ( k ) {
//                     //Create an association between the newly created
//                     //student and the currently selected kumi, both
//                     //locally and on server
//                     let p2 = associateStudentWithKumiRequest( student, k );
//                     p2.then( function () {
//
//                         let pl = Payload.factory( {
//                             student: student,
//                             kumi: k,
//                             mutateSilently: true
//                         } );
//
//                         commit( mTypes.associateStudentWithKumi, pl );
//
//                     } );
//
//                 } );
//
//             } );
//         } );
//
//
//     }
//     ;
