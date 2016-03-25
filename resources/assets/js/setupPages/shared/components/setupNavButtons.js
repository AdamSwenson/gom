/**
 * Created by adam on 3/25/16.
 */

/**
 * Top nav buttons for set up pages.
 * When either button is clicked, it dispatches an 'please-validate-and-submit' event
 * along with the string target expected by the server. Something else will need to
 * catch that event, perform the page specific validation, and make the submit request
 * (including the target) as expected.
 *
 * @type {{template: *, props: string[], data: module.exports.data, computed: {isDisk: module.exports.computed.isDisk, isLeft: module.exports.computed.isLeft, isRight: module.exports.computed.isRight}, methods: {validateAndSubmit: module.exports.methods.validateAndSubmit, navigateForward: module.exports.methods.navigateForward, navigateBack: module.exports.methods.navigateBack}, directives: {}}}
 */
module.exports = {

    template: require( '../templates/setup-nav-buttons.template.html' ),

    props: [
        'forward-nav-icon', //string: either 'disk', 'right'
        'forward-nav-label', //Text to display in the nav
        'forward-nav-target', //should not include the routeRoute/baseUrl

        'back-nav-icon', //string: 'left'
        'back-nav-label', //text to display in the nav
        'back-nav-target' //should not include the routeRoute/baseUrl
    ],

    data: function () {
        return {};
    },

    computed: {
        isDisk: function(){
            if(this.forwardNavIcon == 'disk'){
                return true;
            }
            return false;
        },
        isLeft: function(){
            if(this.backNavIcon == 'left'){
                return true;
            }
            return false;
        },
        isRight: function(){
            if(this.forwardNavIcon == 'right'){
                return true;
            }
            return false;
        },
    },

    methods: {
        validateAndSubmit: function(target){
            this.$dispatch('please-validate-and-submit', target);
        },

        navigateForward: function () {
            return this.validateAndSubmit(this.forwardNavTarget);
        },

        navigateBack: function () {
            return this.validateAndSubmit(this.backNavTarget);
        },

    },

    directives: {}
};