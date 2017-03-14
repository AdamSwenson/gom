/**
 * Created by adam on 2/19/17.
 */

import Comment from '../../models/Comment'
import Payload from '../../models/Payload'
import * as mTypes from '../../store/mutation-types';

import * as aTypes from '../../store/action-types';

module.exports = {

    template: require( '../templates/item-settings.commentSetup.template.html' ),

    props: [ 'index' ],

    data: function () {
        return {

            displayedValence: 'stock',

            defaults: {
                commentText: ''
            },
            placeholders: {
                elementName: "Enter a short reminder for this element, e.g., &quot;Economic causes of World War I&quot; ",
                elementText: "Explain in detail what needed to be done in order to fully complete this task. This will form the basis for the response seen by the student.",
            },
        };
    },

    computed: {

        commentText: {
            get: function () {
                let item = this.$store.getters.getItemByIndex( this.index );

                //make sure there is a comment object waiting for us
                // if not, initialize it
                if ( item.comments.size === 0 ) {
                    item.initializeComments();
                }
                
                let comment = item.getComment( this.displayedValence );
                console.log( 'commenet', comment );
                if(typeof comment != 'undefined'){
                    return comment.text;
                }
            },

            set: function ( v ) {
                let pl = Payload.factory( {
                    index: this.index,
                    updateValence: this.displayedValence,
                    updateVal: v
                } );

                this.$store.commit( mTypes.updateComment, pl );
            }
        },

        valences: function(){
        return Comment.valences;
        }

    },

    methods: {
        getter: function ( name ) {
            let item = this.$store.getters.getItemByIndex( this.index );
            if ( typeof item != 'undefined' ) {
                return item[ name ]
            }
        },

        setter: function ( name, value ) {
            let pl = Payload.factory( {index: this.index, updateProp: name, updateVal: value} );
            this.$store.commit( mTypes.updateItem, pl );
        }
    },


    directives: {},

    events: {
        'please-change-valence' : function(evt) {
            console.log( 'caught please-change-valence', evt );
            this.displayedValence = evt;
        }
    },

    ready: function () {
        //push a comment into the item

    },
};