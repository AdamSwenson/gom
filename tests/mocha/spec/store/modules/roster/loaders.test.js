//The name of the tested component
var compName = 'loaders';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/loaders.js' );

require( '../../../../injectglobals' );

//tested object
let actions = Component.actions;

describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {

    } );


    describe( " actions", () => {
        it.skip( 'loadStudentsFromServer', () => {
        } );

        it.skip( 'loadStudentsFromPageJson', () => {
        } );

        it.skip( 'processAndStoreLoadedStudents', () => {
        } );

        it.skip( 'loadKumisForExamFromServer', () => {

        } );
    } );

} );
