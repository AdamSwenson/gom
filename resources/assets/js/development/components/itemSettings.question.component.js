/**
 * This is the settings component which is
 * specific to items playing the question role.
 *
 * todo Add an 'other uses of this quetion' area
 * Created by adam on 2/19/17.
 */
//var $ = require('jquery');
//window.$ = $;

module.exports = {

    template: require( '../templates/item-settings.question.template.html' ),

    props: ['item'],

    data: function () {
        return {
            placeholders:{
                questionName: "Enter a brief description of the question, i.e. &quot;Causes of the Civil War&quot;"
            },

            tabs:[
                'details', 'stats', 'history', 'notes'
            ]
        };
    },

    computed: {
        index: {
            get: function () {
                console.log( 'indx', this.item);
                if ( typeof this.item != 'undefined' ) {
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

        questionText: {
            get: function () {
            },
            set: function () {
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
            },
            set: function () {
            }
        },
        maxScore: {
            get: function () {
            },
            set: function () {
            }
        },
    },

    methods: {},

    directives: {},

    events: {},

    ready: function () {
    },
};