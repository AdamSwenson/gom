/**
 * Created by adam on 3/10/17.
 */
import * as aTypes from '../../store/action-types';


module.exports = {

    template: require( '../templates/delete-item-button.template.html' ),

    props: [],

    computed: {
        visible: function(){
            return this.$store.getters.isDeleteVisible;
        }
    },

    methods: {
        isVisible: function () {
            return this.$store.getters.isDeleteVisible;
        },

        /**
         * Called when the button is clicked. Handles
         * the request for deletion.
         */
        remove: function () {
            console.log( 'deleteItem pressed' );
            this.sendRequest();
        },

        /**
         * This sends the actual request(s)
         */
        sendRequest: function () {
            this.$store.dispatch( aTypes.deleteItem );
        }
    },

    ready: function () {
    },
};