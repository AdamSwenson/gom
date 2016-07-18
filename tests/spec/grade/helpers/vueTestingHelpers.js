/**
 * Created by adam on 7/18/16.
 */
//cf https://github.com/jasmine/jasmine-npm/issues/25
var Vue = require( 'vue' );
Vue.config.debug = true;

// file name must contain the word helper
module.exports = {
    foo: function () {
        return 'test';
    },

    loadVueComponent: function ( testedComponent, componentName ) {
        //declare
        var vm;
        var MyComponent = Vue.extend( testedComponent );
        // register
        Vue.component( componentName, MyComponent )

        // create a root instance
        vm = new Vue( {
            el: '#app'
        } );
        return vm.$mount()

        // return vm;
        // compile off-document and append afterwards:
        // new MyComponent().$mount().$appendTo( '#app' )
    }

}
