/**
 * Created by adam on 2/19/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-settings.commentSetup.template.html' ),

    props: ['item'],

    data: function () {
        return {

            defaults: {
                name: '',
                text: '',
                commentText: ''
            },
            placeholders: {
                elementName: "Enter a short reminder for this element, e.g., &quot;Economic causes of World War I&quot; ",
                elementText: "Explain in detail what needed to be done in order to fully answer this element. This will form the basis for the response seen by the student.",
            },

            tabs:[
                'details', 'stats', 'history', 'notes'
            ]
        };
    },

    computed: {
        index: {
            get: function () {
                if ( typeof this.item == 'undefined' ) {
                    return this.item.index;
                }
                if ( typeof this.itemIndex == 'undefined' ) {
                    return this.defaults.index;
                }
                return this.itemIndex;
            },

            //todo this is a kludge until get store and item worked in
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

        name: {
            get:function(){},
            set:function(v){}
        },
        text: {
            get:function(){},
            set:function(v){}
        },
        commentText:  {
            get:function(){},
            set:function(v){}
        },
    },

    methods: {},

    directives: {},

    events: {},

    ready: function () {
    },
};