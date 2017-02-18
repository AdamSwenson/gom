/**
 * This is the name field for a question or an element
 *
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

import Item from '../models/Item'

module.exports = {

    template: require( '../templates/item-name.template.html' ),

    props: [ 'itemModel' ],

    data: function () {
        return {

            placeHolders: {
                privateName: "Enter a descriptive name for this item (e.g., Cat petting amount )"
            },

            types: [ 'Question', 'Element' ],

            display: {
                type: {
                    question: 'Q',
                    element: 'E'
                }
            },

            defaults: {
                item: new Item(),
                type: '-'
            },
        };
    },

    computed: {

        /**
         * This will return the reference to
         * the item
         * If the model wasn't set in the prop, it makes a new one.
         * This probably won't ever be used. It might be necessary in testing.
         * Nonetheless, there is no reason it should cause a
         * problem if the stored model isn't available. It will
         * return the stored model on subsequent calls if it
         * becomes available
         * @returns{Item}
         */
        item: {
            get(){
                if(typeof this.itemModel == 'undefined' ){
                    return this.defaults.item;
                }
                return this.itemModel;
            }
        },

        /**
         * The id of the item that this is the name of
         * @returns {module.exports.computed.itemId|null|itemId}
         */
        itemId: function () {
            return this.item.id;
//            return (typeof this.id != 'undefined') ? this.id : this.defaults.itemId;
        },

        itemName: {
            get: function () {
                return this.item.name;
            },

            set: function ( v ) {
                this.item.name = v;
            }
        },

        public: function () {
            return this.item.isPublic();
        }

    },

    methods: {
        /**
         * Requests that the item properties area
         * be displayed
         */
        openItemProperties: function () {
            console.log( 'CALLED', 'openItemProperties' );
        },

        isPublic: function () {
            return this.item.isPublic();
        }

    },

    directives: {},

    events: {
        'toggle-public': function () {
            console.log( 'itemName', 'CAUGHT', 'toggle-public' , this.item);
            this.item.togglePublic();
        }
    },

    ready: function () {
    },
};