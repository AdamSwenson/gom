/**
 * This handles the settings associated with the item
 *
 * Created by adam on 2/18/17.
 */

module.exports = {

    template: require( '../templates/item-settings.template.html' ),

    props: [ "item" ],

    data: function () {
        return {
            defaults: {
                types: [ 'question', 'element' ]
            },
            // currentView: 'item-settings-question',
            tabs: [
                'details', 'comments', 'stats', 'history', 'notes'
            ],
            hiding: true,

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

        text: {
            get: function () {
                if ( typeof this.item != 'undefined' ) {
                    return this.item.text;
                }
                return this.defaults.text;

            },

            set: function ( v ) {
                if ( typeof this.item == 'undefined' ) {
                    this.item.text = v;
                }
                else {
                    this.defaults.text = v;
                }

            }
        },


        hidden: {
            get: function () {
                console.log( this.hiding );
                return this.hiding;
            },
            /**
             * Maybe this should be disabled?
             * @param v
             */
            set: function(v){
                this.hiding = v;
            }
        }
    },

    methods: {
        show: function () {
            console.log( 'itemSetting', 'CALLED', 'show' );
            this.hiding = false;
        },
        hide: function () {
            console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );
            this.hiding = true;
            console.log( this.hiding );
        },
        toggle: function () {
            console.log( 'itemSetting', 'CALLED', 'hide', this.hiding );

            this.hiding = !this.hiding;

            console.log( this.hiding );
        }
    },

    directives: {},

    events: {
        'display-settings': function () {
            console.log( 'itemSettings', 'CAUGHT', 'display-settings', this.hiding );
            this.toggle();
        }
    },

    ready: function () {
    },
};