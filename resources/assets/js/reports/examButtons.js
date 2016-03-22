/**
 * Created by  adam on 3/3/16.
 */

var $ = require( 'jquery' );
var jQuery = $;
window.$ = $;
window.jQuery = $;
require( 'bootstrap' );

var Vue = require( 'vue' );

//dev
Vue.config.debug = true;

//TODO Once this is ready, change the release request methods to POST

new Vue( {
    el: '#app',

    components: {
        'exam-release-toggle': require( './components/examReleaseToggle.js' ),
        'exam-buttons': require( './components/reportExamButtons.js' ),
        'exam-buttons-dropdown': require( './components/examButtonsDropdown.js' )
    },

    data: {},

    computed: {
        baseUrl: function () {
            return baseUrl;
        },

    },

    methods: {
        releaseRoute: function ( examId ) {
            return "/report/" + examId + "/release";
        },

        hideRoute: function ( examId ) {
            return "/report/" + examId + "/unrelease";
        },
        /**
         * Make the request to server to release the exam.
         *
         * This will compile student scores and stats, then sends notification emails to all
         * graded students who have not yet received an email. Normally, this will be most (if not all)
         * of the class.
         *
         * Any late graded exams can be processed by releasing again or individually via
         * the student controls page
         *
         * @param examId
         */
        releaseExam: function ( examId ) {
            var me = this;
            var path = this.releaseRoute( examId );
            $.ajax( {
                url: path,
                type: 'GET',
                success: function () {
                    me.notifyReleaseSuccess( examId );
                },
                error: function () {
                    me.notifyReleaseError( examId );
                },
                complete: function () {
                }
            } );
        },

        /**
         * Makes the request to the server to hide the exam.
         * This removes student access to the exam, deleting any response keys that have been generated.
         * @param examId
         */
        hideExam: function ( examId ) {
            var me = this;
            var path = this.hideRoute( examId );
            $.ajax( {
                url: path,
                type: 'GET',
                success: function () {
                    me.notifyHideSuccess( examId );
                },
                error: function () {
                    me.notifyHideError( examId );
                },
                complete: function () {
                }
            } );
        },

        notifyReleaseSuccess: function ( examId ) {
            this.$broadcast( 'exam-release-success', examId );
        },

        notifyReleaseError: function ( examId ) {
            this.$broadcast( 'exam-release-error', examId );
        },

        notifyHideSuccess: function ( examId ) {
            this.$broadcast( 'exam-hide-success', examId );
        },

        notifyHideError: function ( examId ) {
            this.$broadcast( 'exam-hide-error', examId );
        }
    },

    events: {
        'exam-release-event': function ( examId ) {
            window.console.log( 'examButtons', 'caught exam-release-event', examId);
            this.releaseExam( examId );
        },

        'exam-hide-event': function ( examId ) {
            window.console.log( 'examButtons', 'caught exam-hide-event', examId );
            this.hideExam( examId );
        },
    },

    directives: {},

    ready: function () {
    }
} );

