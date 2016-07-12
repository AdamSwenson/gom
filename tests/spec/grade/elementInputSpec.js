/**
 * Created by adam on 7/11/16.
 */


var Vue = require('vue');
var Jasmine = require('jasmine');
var jasmine = new Jasmine();
//Load configuration from a file or from an object.
// jasmine.loadConfigFile('../spec/support/jasmine.json');
// jasmine.loadConfigFile('./Users/adam/Dropbox/gom3/spec/support/jasmine.json');

jasmine.loadConfig({
    spec_dir: 'tests/spec',
    spec_files: [
        '/**/*[sS]pec.js',
    ],
    helpers: [
        'helpers/**/*.js'
    ]
});

var Store = require('../../../resources/assets/js/grade/components/Data.js');
var testedComponent = require('../../../resources/assets/js/grade/components/elementInput.js');
var assert = require('assert');



//load the component with a vue instance
vm = new Vue({
    template: '<div><element-input v-ref:tested-component></element-input></div>',
    components: {
        'element-input': testedComponent
    }
}).$mount();

var object = vm.$refs.testedComponent;


describe("When no student is currently selected and one is selected", function() {
    var a;

    it("the slider position updates to the stored score", function() {
        a = true;

        expect(a).toBe(true);
    });

    it("the comment text is updated to the stored value", function() {
        a = true;

        expect(a).toBe(true);
    });
});


describe("Element selects correct valence for score", function() {
    var a;

    it("no element score set", function() {
        a = true;

        expect(a).toBe(true);
    });

    it("should have the valence: missing", function() {
        a = true;

        expect(a).toBe(true);
    });

    it("should have the valence: poor", function() {
        a = true;

        expect(a).toBe(true);
    });

    it("should have the valence: good", function() {
        a = true;

        expect(a).toBe(true);
    });

    it("should have the valence: excellent", function() {
        a = true;

        expect(a).toBe(true);
    });
});
