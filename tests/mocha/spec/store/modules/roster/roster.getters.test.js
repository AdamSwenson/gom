//The name of the tested component

var compName = 'roster.getters';
//The path to the tested component
import getters from  '../../../../../../resources/assets/js/store/modules/roster/roster.getters.js';


require( '../../../../injectglobals' );


import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let state, numStudents, testObj, store;

    beforeEach( function () {
        numStudents = faker.random.number( { min: 1, max: 50 } );
        state = { roster: factories.makeStudents(numStudents) };

        testObj = faker.random.arrayElement( state.roster );

        store = new Vuex.Store({
            state, getters
        });

    } );


    describe( description( 'getStudentFromRosterBySerialNumber' ), function () {
        it( "happy path", function () {
            //call
            let result = store.getters.getStudentFromRosterBySerialNumber( testObj.serialNumber );
            //check
            expect( result ).toBe( testObj );
            expect( result.serialNumber ).toBe( testObj.serialNumber );
        } );
    } );


    describe( description( 'getStudentFromRosterById' ), function () {
        it( "happy path", function () {
            //call and check
            _.forEach(state.roster, function(student){
                let result = store.getters.getStudentFromRosterById( student.id );
                //check
                expect( result ).toMatchObject( student );
                expect( result.id ).toBe( student.id );

            });

        } );
    } );

    describe( description( 'getStudentCount' ), function () {
        it( "happy path ", function () {
            //call
            let result = store.getters.getStudentCount;
            //check
            expect( result ).toBe( numStudents );
        } );
    } );

} );
