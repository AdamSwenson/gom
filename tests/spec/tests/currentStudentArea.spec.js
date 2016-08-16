/**
 * Created by adam on 7/16/16.
 */

var $ = require( 'jquery' );
window.$ = $;
var jQuery = $;
window.jQuery = jQuery;

//test libraries
require( 'jasmine-jquery' );
jasmine.getFixtures().fixturesPath = 'base/tests/spec/fixtures';

//helpers
var Helper = require('../helpers/vueTesting.helper.js');

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/currentStudentArea.component.js" );

require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "CurrentStudentArea tests | ", function () {
    var fixture;
    var $fixture;
    var vm;

    var studentNameIdString;
    var $studentName;
    var studentIdentifierIdString;
    var $studentIdentifier;
    var visibilityControlIdString
    var $visibilityControl;


    beforeEach( function () {
        var store = new Data();
        store.activeStudent = 0;
        store.isBlind = false;
        window.store = store;

        //prep the page
        this.$fixture = loadFixtures( 'currentStudentArea.fixture.html' );
        this.vm = Helper.loadVueComponent( testedComponent, 'current-student-area' );

        this.studentNameIdString = "#activeStudentName";
        this.$studentName = $( this.studentNameIdString );
        this.studentIdentifierIdString = "#activeStudentIdentifier";
        this.$studentIdentifier = $( this.studentIdentifierIdString );
        this.visibilityControlIdString = "#nameVisibilityControl";
        this.$visibilityControl = $( this.visibilityControlIdString );
    } );

    describe( "Confirm intact | ", function () {
        it("fixture's main div is present", function() {
            expect($('#app')).toExist();
            expect( "#activeStudentNameArea" ).toExist();
        });
        it("has the expected student name field", function() {
            expect( this.$studentName ).toExist();
        });
        it("has the expected student identifier field", function() {
            expect( this.$studentIdentifier ).toExist();
        });

        it("has the expected visibility control", function() {
            expect( this.$visibilityControl ).toExist();
        });
    } );


    describe( "Name and id display | ", function () {

        it("upon receiving a notice that the active student has changed, updates the displayed name and id", function (  ) {
            //prep
            var obj = {};
            obj.studentName = "JR JEPSON";
            obj.studentIdentifier = "12345";

            //call
            this.vm.$broadcast('student-select-event', obj);

            //check --value set on component object
            expect(this.vm.$refs.testObject.studentName).toBe(obj.studentName);
            expect(this.vm.$refs.testObject.studentIdentifier).toBe(obj.studentIdentifier);


            //check --value displayed on page
//            expect($( this.studentNameIdString ).val()).toBe(obj.studentName);
//            expect($( this.studentIdentifierIdString ).val()).toBe(obj.studentIdentifier);
            /*
            TODO figure out why vue doesn't update the displayed value in tests. Might be because not waiting long enough? See this http://stackoverflow.com/questions/36951514/how-to-catch-broadcast-in-spyon for other people having the same problem.
             */
        });
    } );

    describe( "Toggle visibility | ", function () {

        it("toggles visibility from visible to blind", function(){
           //prep
            store.isBlind = false;

            //call
            this.$visibilityControl.trigger('click');

            //check
            expect(store.isBlind).toBe(true);
            //a way to check that an event is emitted would be nice....
        });


        it("toggles visibility from blind to visible", function(){
            //prep
            store.isBlind = true;

            //call
            this.$visibilityControl.trigger('click');

            //check
            expect(store.isBlind).toBe(false);
            //a way to check that an event is emitted would be nice....
        });
    } );


    describe( "Typeahead | ", function () {

    } );


} );