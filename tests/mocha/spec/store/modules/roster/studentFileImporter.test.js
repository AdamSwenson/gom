//The name of the tested component
var compName = 'studentFileImporter';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/studentFileImporter.js' );


require( '../../../../injectglobals' );

//tested object


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {

    } );
    describe( 'utilities', () => {

        it.skip( 'browserSupportFileUpload', () => {

        } );

        it.skip( 'firstRowContainsTitles', () => {

        } );


        it.skip( '    guessColumnDataByTitles', () => {

        } );

        it.skip( 'guessColumnDataByContent', () => {

        } );

        it.skip( 'filterHeaderRows', () => {

        } );
    } );

    describe( " actions", () => {
        it.skip( 'importStudentsFromFile', () => {
        } );
    } );

} );
