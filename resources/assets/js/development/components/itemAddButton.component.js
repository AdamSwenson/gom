/**
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-add-button.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {},

    methods: {
        /**
         * Called on click.
         * It in turn calls a handler
         */
        addItem:function(){
            console.log( 'CALLED', 'addItem' );
            this.sendRequest();
        },
        sendRequest:function(){
            this.$dispatch('add-item');
        }
    },

    directives: {},

    events: {},

    ready: function () {
    },
};