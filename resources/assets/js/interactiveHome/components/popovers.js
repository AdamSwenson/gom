/**
 * Created by adam on 2/3/16.
 *
 * Want the popovers/tooltips to display when initially arrive, then
 * hide themselves as appropriate.
 *
 * Perhaps also set a cookie
 */
var $ = require('jquery');
window.$ = $;

require('bootstrap');

module.exports = {

    template: require('../templates/popovers.template.html'),

    props: ['content'],

    data: function () {
        return {

        };
    },

    computed: {},

    methods: {
        open: function(){},

        close: function(){}
    },

    directives:{
        popover: function(){
            $('.popover').popover(options)
        },
    },

    ready: function(){
        jQuery(function () {
            jQuery('.instructionTooltip').tooltip('show');
            //$('[data-toggle="tooltip"]').tooltip()
        });

        //$(function () {
        //    $('[data-toggle="tooltip"]').tooltip()
        //})
    }
};