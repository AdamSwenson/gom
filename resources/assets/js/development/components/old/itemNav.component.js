/**
 * Created by adam on 2/17/17.
 */
//var $ = require('jquery');
//window.$ = $;

/**
 * This is a button which either advances us to the next item
 * or returns us to the previous item
 *
 * @type {{template: *, props: Array, data: module.exports.data, computed: {}, methods: {}, directives: {}, events: {}, ready: module.exports.ready}}
 */
module.exports = {

    template: require( '../../templates/item-nav.template.html' ),

    props: [
        //'forward', 'back'
        'nav-type'
    ],

    data: function () {
        return {
            icons: {
                leftArrow: 'glyphicon glyphicon-arrow-left',
                rightArrow: 'glyphicon glyphicon-right'

                // leftArrow: 'glyphicon glyphicon-chevron-left',
                // rightArrow: 'glyphicon glyphicon-chevron-right'
            }
        };
    },

    computed: {
        type: function () {
            return this.navType;
        },

        /**
         * Returns the appropriate icon
         */
        arrow: function () {
            switch ( this.type ) {
                case 'forward':
                    return this.icons.rightArrow;
                    break;

                case 'back':
                    return this.icons.leftArrow;
                    break;

                default:
                    return '';
            }

        }
    },


    methods: {
        goTo: function () {
            switch ( this.type ) {
                case 'forward':
                    return this.goToNextItem();
                    break;

                case 'back':
                    return this.goToPreviousItem();
                    break;

                default:
                //todo add error handler

            }
        },

        /**
         * Requests that the next item be displayed
         */
        goToNextItem: function () {
            console.log('CALLED', 'goToNextItem'  );
        },

        /**
         * Requests that the previous item be displayed
         */
        goToPreviousItem: function () {
            console.log('CALLED', 'goToPreviousItem'  );
        },
    },

    directives: {},

    events: {},

    mounted: function () {
        console.log( 'itemNav ready ', this.type );
    },
};