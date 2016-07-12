/**
 * Created by adam on 7/11/16.
 */
var rosterComponent = require('../../resources/assets/js/grade/components/RosterComponent.js');
var assert = require('assert');

//load the component with a vue instance
vm = new Vue({
    template: '<div><test v-ref:test-component></test></div>',
    components: {
        'test': rosterComponent
    }
}).$mount();

var roster = vm.$refs.testComponent;

describe('close()', function () {
    // beforeEach(function () {
    //     modal.active = true;
    // });
    //
    // it('should set modal to inactive', function () {
    //     console.log(modal.active); // -> true
    //     modal.close();
    //     console.log(modal.active); // -> false
    //     assert.equal(modal.active, false);
    // });
});