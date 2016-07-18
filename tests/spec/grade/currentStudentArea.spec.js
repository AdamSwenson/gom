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
var Helper = require('./helpers/vueTestingHelpers.js');

//for fixture
require( 'bootstrap' );
var Vue = require( 'vue' );
Vue.config.debug = true;

//tested stuff
var testedComponent = require( "../../../resources/assets/js/grade/components/currentStudentArea.js" );

require( '../../../resources/assets/js/grade/components/Data.js' );


describe( "CurrentStudentArea tests | ", function () {
    var fixture;
    var $fixture;
    var vm;

    var  $studentName;
    var $studentIdentifier;
    var $visibilityControl;

    function loadComponent( testedComponent, componentName ) {
        //declare
        var MyComponent = Vue.extend( testedComponent );
        // register
        Vue.component( componentName, MyComponent )

        // create a root instance
        this.vm = new Vue( {
            el: '#app'
        } );
        this.vm.$mount()

        // return vm;
        // compile off-document and append afterwards:
        // new MyComponent().$mount().$appendTo( '#app' )
    }


    beforeEach( function () {
        var store = new Data();
        store.activeStudent = 0;
        store.isBlind = false;
        window.store = store;

        this.$fixture = loadFixtures( 'currentStudentArea.fixture.html' );
        Helper.loadVueComponent( testedComponent, 'current-student-area' );
        // loadComponent( testedComponent, 'current-student-area' );

        this.$studentName = $( "#activeStudentName" );
        this.$studentIdentifier = $( "#activeStudentIdentifier" );
        this.$visibilityControl = $( "#nameVisibilityControl" );
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
            var obj = {};
            obj.name = "JR JEPSON";
            obj.identifier = "12345";

            //call
            var event = jQuery.Event( 'student-select-event' );
            event.value = obj;
            event.type = 'student-select-event';
            $(document).trigger(event);

this.vm.$broadcast('student-select-event', obj);
            //check
            expect(this.$studentName.val()).toBe(obj.name);
            expect(this.$studentIdentifier.val()).toBe(obj.identifier);
        });


    } );

    describe( "Toggle visibility | ", function () {

    } );


    describe( "Typeahead | ", function () {

    } );


} );