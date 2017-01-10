/**
 * Created by adam on 7/18/16.
 */
//cf https://github.com/jasmine/jasmine-npm/issues/25
var Vue = require( 'vue' );
Vue.config.debug = true;

require('sinon');

// file name must contain the word helper
/**
 * Helpful site: http://www.slideshare.net/coulix/vuejs-testing
 **/
module.exports = {
    foo: function () {
        return 'test';
    },

    markLog: function () {
        window.console.log( "~~~~~~~~~~~~~~~%%%%%%%%%%%%%%%%%%%%%%%%%%%%~~~~~~~~~~~~~~~" );
    },


    /**
     * Checks whether a vue component's property has the specified value.
     * @param dthis The 'this' context from the calling test
     * @param propertyName String name of the property to check
     * @param expectedValue
     */
    assertValueIs: function ( dthis, propertyName, expectedValue ) {
        let component = dthis.vm.$refs.testObject;
        return expect( component[ propertyName ] ).toBe( expectedValue );
    },
    /**
     * Checks whether a vue component's property has the specified value.
     * Waits for the next tick so that avoids problem of asynchronous changes.
     * @param dthis The 'this' context from the calling test
     * @param propertyName String name of the property to check
     * @param expectedValue
     */
    asyncAssertValueIs: function ( dthis, propertyName, expectedValue ) {
        let component = dthis.vm.$refs.testObject;
        return component.$nextTick( function () {
            return expect( component[ propertyName ] ).toBe( expectedValue );
        } );
    },

    /**
     * Runs a callback with an assertion asynchronously
     * @param dthis
     * @param assertion
     */
    asyncAssert: function ( dthis, callbackContainingAssertion ) {
        return dthis.vm.$refs.testObject.$nextTick( function () {
            return callbackContainingAssertion();
        } );
    },

    /**
     * Creates and mounts a vue components. Returns the instance.
     *
     * When instantiating the components in a fixture, make sure to include
     * v-ref:test-object
     * so that can access the components through the vm with vm.$refs.testObject
     *
     * @param testedComponent
     * @param componentName
     * @param elementId
     * @returns {Vue}
     */
    loadVueComponent: function ( testedComponent, componentName, elementId = false ) {

        //Default element to bind the vue instance to is app
        //but can set by passing in something else as elementId;
        var bindTo = (elementId ? elementId : '#app');

        //just in case I forgot to pass in the pound as the first character
        if ( bindTo[ 0 ] != '#' ) {
            bindTo = '#' + bindTo;
        }

        //declare
        let MyComponent = Vue.extend( testedComponent );

        // register
        Vue.component( componentName, MyComponent )

        // create a root instance
        let vm = new Vue( {
            el: '#app'
        } );

        //mount it to the document
        vm.$mount();

        //in other cases could've done by compiling off-document and append afterwards:
        //new MyComponent().$mount().$appendTo( '#app' )
        //that doesn't work here (don't know why).

        //pass the instantiated and bound vue instance back to the user
        return vm;

    },

    getComponent: function(dthis){
        return dthis.vm.$refs.testObject;
    },

    createEventSpy: function(dthis, eventName){
        //prep
        let spy = sinon.spy();
        dthis.vm.$on( eventName, spy );
        return spy;
    }

}
