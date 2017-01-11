/**
 * Created by adam on 1/10/17.
 */

/**
 *
 * NOT IN USE
 *
 *
 *
 *
 *
 *
 *
 *
 * Global events bus which is a
 * temporary replacement for $broadcast and $dispatch
 * until those can be better integrated with vuex.
 * See https://vuex.vuejs.org/en/state.html
 *
 *  https://vuejs.org/v2/guide/components.html#Non-Parent-Child-Communication
 *

 // in component A's method
 bus.$emit('id-selected', 1)

 // in component B's created hook
 bus.$on('id-selected', function (id) {
  // ...
})
 *
 * */

/**
 * Alternatively, maybe this should just be using the injected store.$emit
//  */
// import Vue from 'vue'
// // import Vuex from 'vuex'
//
// var bus = new Vue({
//     methods: {
//         /**
//          * Replacement for the old broadcast behavior
//          * @param eventName
//          * @param payload
//          */
//         broadcast : function(eventName, payload){
//             this.$emit(eventName, payload)
//         },
//
//         /**
//          * Replacement for the old dispatch behavior
//          * @param eventName
//          * @param payload
//          */
//         dispatch : function(eventName, payload){
//             this.$emit(eventName, payload)
//         },
//
//         /**
//          * Wrapper for listener initialization
//          * @param eventName String name of the event
//          * @param callback The function to run on the payload
//          */
//         listen: function(eventName, callback) {
//             this.$on(eventName, function () {
//                 return callback();
//             });
//         }
//
//     }
// });