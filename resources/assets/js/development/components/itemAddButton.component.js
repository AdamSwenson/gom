/**
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;


import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';


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
            // this.$store.dispatch(addNewItem');
            // this.store[aTypes.addNewItem]();
            this.$dispatch('add-new-item');
        }
    },

    directives: {},

    events: {},

    ready: function () {
        console.log( 'itemAddButton', 'ready', this.$store );
    },
};