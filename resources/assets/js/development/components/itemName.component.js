/**
 * This is the name field for a question or an element
 *
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

import Item from '../../models/Item'
import Payload from '../../models/Payload'

import * as mTypes from '../../store/mutation-types'

module.exports = {

    template: require( '../templates/item-name.template.html' ),

    props: [ 'index' ],

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
         * For questions, this will be the question number
         * For elements it will be the subtask number.
         * todo This should be displayed on the left of the area and update as the item is moved.
         * todo It could also be hidable....
         */
        displayOrder: {
            get: function () {
                //if question, return q number

                //if element, return order

            },
            set: function ( v ) {

            }
        },

        /**
         * The id of the item that this is the name of
         * @returns {module.exports.computed.itemId|null|itemId}
         */
        itemId: function () {
            // return this.itemObj.id;

        },

        name: {
            get: function () {

                // return this.$store.getters.getItemNameByIndex( this.itemIndex );
                let item = this.$store.getters.getItemByIndex(this.index);
                console.log( "item", item );
                if(typeof item.name != 'undefined'){
                    return item.name;

                }

            },

            set: function ( v ) {
                let pl = Payload.factory( {index: this.index, str: v} );
                this.$store.commit( mTypes.updateItemName, pl );

                // this.$store.commit( mTypes.updateItemNameByIndex, pl );
                // let item = this.$store.getters.getItemByIndex(this.index)
                // this.itemObj.name = v;

            }
        },

        public: function () {
            // return this.itemObj.isPublic();
        }

    },

    methods: {
        /**
         * Requests that the item properties area
         * be displayed
         */
        openItemSettings: function () {
            console.log( 'itemName', 'CALLED', 'openItemSettings' );
            this.$dipatch( 'display-settings' );
        },

        isPublic: function () {
            // return this.item.Obj.isPublic();
        }

    },

    directives: {},

    events: {


        'toggle-public': function () {
            // console.log( 'itemName', 'CAUGHT', 'toggle-public' , this.itemObj);
            // this.itemObj.togglePublic();
        }
    },

    ready: function () {
    },
};