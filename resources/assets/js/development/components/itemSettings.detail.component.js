/**
 * This is the settings component which contains
 * the more lengthy item text (like the prompt question)
 * as well as other settings, depending on which role it
 * is playing.
 *
 * todo Add an 'other uses of this quetion' area
 * Created by adam on 2/19/17.
 */
//var $ = require('jquery');
//window.$ = $;

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';

import Payload from '../../models/Payload'


module.exports = {

    template: require( '../templates/item-settings.detail.template.html' ),

    props: ['item-obj', 'item-index' ],

    data: function () {
        return {
            placeholders:{
                questionName: "Enter a brief description of the question or task, e.g. &quot;Causes of the Civil War&quot;"
            },
        };
    },

    computed: {

        item: {
            get: function () {
                // if(typeof this.itemObj != 'undefined'){
                //     return this.itemObj;
                // }
                // if(typeof this.itemIndex != 'undefined'){
                //     return this.$store.getters.getItem(Payload.factory({index: this.itemIndex}));
                // }
                //

            },
            set: function ( v ) {
            }
        },

                index: {
            get: function () {
            //     console.log( 'indx', this.item);
            //     if ( typeof this.item != 'undefined' ) {
            //         return this.itemObj.index;
            //     }
            //     if ( typeof this.item.index == 'undefined' ) {
            //         return this.defaults.index;
            //     }
            //     return this.itemObj.index;
            },

            //todo this is a kludge until get store and item worked in
            set: function ( v ) {
                // if ( typeof this.item == 'undefined' ) {
                //     this.item.index = v;
                // }
                // if ( typeof this.item.index == 'undefined' ) {
                //     this.defaults.index = v;
                // }
                // this.item.index = v;
            }
        },

        questionText: {
            get: function () {
                // return this.itemObj.text;
            },
            set: function (v) {
                // this.itemObj.text = v;
            }
        },
        questionNumber: {
            get: function () {
            },
            set: function () {
            }
        },
        questionName: {
            get: function () {
                // return this.itemObj.name;
            },
            set: function (v) {
                // this.itemObj.name = v;
            }
        },
        maxScore: {
            get: function () {
                // return this.itemObj.maxScore;
            },
            set: function (v) {
                // this.itemObj.maxScore = v;
            }
        },
    },

    methods: {},

    directives: {},

    events: {},

    ready: function () {
    },
};