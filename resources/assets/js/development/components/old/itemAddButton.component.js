/**
 * Created by adam on 2/17/17.
 */

import * as aTypes from '../../../store/action-types';
import * as mTypes from '../../../store/mutation-types';


module.exports = {

    template: require( '../../templates/item-add-button.template.html' ),

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

        /**
         * This sends the actual request(s)
         */
        sendRequest:function(){
            this.$store.dispatch(aTypes.createItem);
        }
    },

    directives: {},

    events: {},

    mounted: function () {
        console.log( 'itemAddButton', 'ready', this.$store );
    },
};