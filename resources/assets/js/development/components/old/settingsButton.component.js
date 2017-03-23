/**
 * Created by adam on 2/18/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../../templates/settings-button.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {},

    methods: {
        /**
         * Requests that the item properties area
         * be displayed
         */
        openItemSettings: function () {
            console.log( 'CALLED', 'openItemSettings' );
            this.requestSettingsDisplay();
        },

        /**
         * Emits an event caught by the parent.
         * The catching object will handle the opening.
         * Thus there is no need for this button to know
         * who it belongs to
         */
        requestSettingsDisplay: function(){
            this.$store.dispatch('display-settings');
        }
    },

    directives: {},

    events: {},

    mounted: function () {
    },
};