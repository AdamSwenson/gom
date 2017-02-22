/**
 * This handles injecting the correct settings component in
 *
 * Created by adam on 2/18/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-settings.template.html' ),

    props: ["item"],

    data: function () {
        return {
            currentView: 'item-settings-question',

            hiding: true,

            tabs: ['tab1', 'tab2']
        };
    },

    computed: {
        index: {
            get: function () {
                if ( typeof this.item != 'undefined' ) {
                    return this.item.index;
                }
                if ( typeof this.itemIndex == 'undefined' ) {
                    return this.defaults.index;
                }
                return this.itemIndex;
            },

            set: function ( v ) {
                if ( typeof this.item == 'undefined' ) {
                    this.item.index = v;
                }
                if ( typeof this.itemIndex == 'undefined' ) {
                    this.defaults.index = v;
                }
                this.itemIndex = v;
            }
        },
        hidden : function(){
            console.log( this.hiding );
            return this.hiding;
        }
    },

    methods: {
        show: function(){
            console.log( 'itemSetting', 'CALLED', 'show' );
            this.hiding = false;
        },
        hide:function(){
            console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );
            this.hiding = true;
            console.log( this.hiding );
        },
        toggle:function(){
            console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );

            this.hiding = ! this.hiding;

            console.log( this.hiding );
        }
    },

    directives: {},

    events: {
        'display-settings': function(){
            console.log( 'itemSettings', 'CAUGHT', 'display-settings', this.hiding );
            this.toggle();
        }
    },

    ready: function () {
    },
};