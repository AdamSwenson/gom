/**
 * This is the settings component which contains
 * the more lengthy item text (like the prompt question)
 * as well as other settings, depending on which role it
 * is playing.
 *
 * todo Add an 'other uses of this quetion' area
 * Created by adam on 2/19/17.
 */

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';

import Payload from '../../models/Payload'


module.exports = {

    template: require( '../templates/item-settings.detail.template.html' ),

    props: [ 'index' ],

    data: function () {
        return {
            placeholders: {
                questionName: "Enter a brief description of the question or task, e.g. &quot;Causes of the Civil War&quot;"
            },
        };
    },

    computed: {

        questionText: {
            get: function () {
                return this.getter('text');

            },

            set: function ( v ) {
                this.setter('text', v);
                // let pl = Payload.factory( {index: this.index, updateProp: 'text', updateVal: v} );
                // this.$store.commit( mTypes.updateItem, pl );
            }
        },

        questionNumber: {
            get: function () {
                return this.getter('number');
                          },

            set: function ( v ) {
                this.setter('number', v);
                // let pl = Payload.factory( {index: this.index, updateProp: 'number', updateVal: v} );
                // this.$store.commit( mTypes.updateItem, pl );
            }

        },
        maxScore: {
            get: function () {
                return this.getter('maxScore');
            },

            set: function ( v ) {
this.setter('maxScore', v)
            }

        },
    },

    methods: {
        getter: function(name){
            let item = this.$store.getters.getItemByIndex( this.index );
            if ( typeof item != 'undefined' ) {
                return item[name]
            }
        },

        setter: function(name, value){
            let pl = Payload.factory( {index: this.index, updateProp: name, updateVal: value} );
            this.$store.commit( mTypes.updateItem, pl );
        }
    },

    directives: {},

    events: {},

    ready: function () {
    },
};