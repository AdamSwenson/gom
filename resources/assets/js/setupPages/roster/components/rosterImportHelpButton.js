/**
 * Created by adam on 3/25/16.
 */
//var $ = require('jquery');
//window.$ = $;

var bootbox = require( 'bootbox' );

module.exports = {

    template: require( '../templates/roster-import-help-button.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {
        rosterHelpUrl: function () {
            return baseUrl + '/help#rosterSetup';
        }

    },

    methods: {
        showHelpModal: function () {
            bootbox.dialog( {
                message: "<p>Student roster files should be formatted as a .CSV file type.</p>" +
                "<p>Each row holds one student's data, with the following information:</p>" +
                "<ul><li>Last name</li> <li>first name</li> <li>ID (optional)</li> <li>email (optional)</li></ul>" +
                "<p>Using these 4 fields as the first row of the file, though not required, " +
                "will make it more likely that the data can be imported correctly.</p>" +
                "For more detailed instructions, please see <a href='" + this.rosterHelpUrl + "'>" + this.rosterHelpUrl + "</a>",
                title: "Import Help",
                buttons: {
                    success: {
                        label: "Ok",
                        className: "btn-primary",
                        callback: function () {
                        }
                    }
                }
            } );
        }
    },

    directives: {}
};