/**
 * Created by adam on 8/17/16.
 */
//var $ = require('jquery');
//window.$ = $;

/**
 * This is a mixin which handles interaction with the data store
 *
 * @type {{data: module.exports.data, computed: {}, methods: {}, directives: {}, events: {}, ready: module.exports.ready}}
 */
module.exports = {

    data: function () {
        return {
            /**
             * The data repository store shared by everyone
             */
            store: store,
        };
    },

    computed: {},

    methods: {},

    directives: {},

    events: {},

    ready: function () {
    },
};