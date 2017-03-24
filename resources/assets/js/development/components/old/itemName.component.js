/**
 * This is the name field for a question or an element
 *
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

import Item from '../../../models/Item'
import Payload from '../../../models/Payload'

import * as mTypes from '../../../store/mutation-types'

module.exports = {

    template: require( '../../templates/item-name.template.html' ),

    props: [ 'index', 'id' ],

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


        name: {
            get: function () {
                let item = this.$store.getters.getItemById( this.id );
                // let item = this.$store.getters.getItemByIndex( this.index );
                if ( typeof item != 'undefined' ) {
                    return item.name;
                }
            },

            set: function ( v ) {
                    let pl = Payload.factory( {id: this.id, index: this.index, updateProp: 'name', updateVal: v} );
                this.$store.commit( mTypes.updateItem, pl );
            }
        },

        public: function () {
            let item = this.$store.getters.getItemById( this.id );
            // let item = this.$store.getters.getItemByIndex( this.index );
            if ( typeof item != 'undefined' ) {
                return item.isPublic();
            }
        },
    },

    methods: {
        /**
         * Requests that the item properties area
         * be displayed
         */
        openItemSettings: function () {
            console.log( 'itemMain', 'CALLED', 'openItemSettings' );
            this.$dipatch( 'display-settings' );
        },

        isPublic: function () {
            return this.public;
        }
    },

    directives: {},

    events: {
        'toggle-public': function () {
            let item = this.$store.getters.getItemById( this.id );
            // let item = this.$store.getters.getItemByIndex( this.index );
            if ( typeof item!= 'undefined' ) {
                return item.togglePublic();
            }
        }
    },

    mounted: function () {
    },
};