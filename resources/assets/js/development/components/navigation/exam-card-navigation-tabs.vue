<template>
    <!--These are the navigation tabs for the exam cardonly-->
    <nav class="exam-card-navigation-tabs tabs is-centered"
    >
        <ul v-bind:id="identifier">

            <router-link
                    v-for="r in routes"
                    v-bind:key="r.name"
                    tag="li"
                    v-bind:active-class="activeClass"
                    v-bind:to="r.path"
            >
                <a class="exam-nav">
                    <span class="icon is-small">
                            <i v-bind:class="r.icon" aria-hidden="true"></i>
                        </span>
                    <span>{{r.label}}</span>
                </a>
            </router-link>

        </ul>
    </nav>


</template>
<style lang="scss">
    .exam-card-navigation-tabs {
        .exam-nav {
            color: #DDDDDD;
        }

    }


</style>
<script>

    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'
    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'


    /**
     * This holds all the tools for editing an item. It drops down
     * when called and has lots of tabs etc
     *
     * Created by adam on 2/18/17.
     */
    export default {
        props: [ 'exam' ],

        data: function () {
            return {
                activeClass: 'is-active',

                identifier: 'exam-nav-tabs',

                defaults: {
                    // types: [ 'question', 'element' ]
                },
                // currentView: 'item-settings-question',
                tabs: [
                    'details', 'feedback', 'grades', 'students', 'notes', 'quality'
                ],
            };
        },

        watch: {
            $route : function () {
                //Since we are not using the settings button for the exam
                //we need to make sure that the pane opens when we hit one of
                //the routes on the exam card.
                if ( this.watchedPaths.includes( this.$route.path ) ) {
                    //this first tests whether the pane is visible, if not,
                    //it shows it
                    if ( !this.isExamPaneVisible ) {

                        this.togglePaneVisibility();
                    }
                } else {
                    //if an item settings pane is opened
                    // while the exam pane is open, the url will change so that
                    // the content no longer displays. Thus we need to make sure
                    // we close the whole pane so we don't just have the close button
                    // hanging out all alone
                    if ( this.isExamPaneVisible ) {
                        this.togglePaneVisibility();
                    }
                }
            }
        },

        computed: {

            /**
             * Whether the pane is open
             */
            isExamPaneVisible: function () {
                return this.$store.getters[ gTypes.isExamSettingsVisible ];
            },


            /**
             * These are the routes for the exam settings pane
             */
            routes: function () {
                //nb, these need to be in order of display, l to r
                return [
                    {
                        name: 'exam-details',
                        path: this.routeToExamDetails,
                        icon: "fa fa-pencil",
                        label: "Details"
                    },
                    {
                        name: 'students',
                        path: this.routeToStudents,
                        icon: "fa fa-group",
                        label: "Students"
                    },
                    {
                        name: 'comments',
                        path: this.routeToComments,
                        icon: "fa fa-comments-o",
                        label: "Feedback"
                    },

                    {
                        name: 'quality',
                        path: this.routeToQuality,
                        icon: "fa fa-rocket",
                        label: 'Quality',
                    },
                    {
                        name: 'grades',
                        path: this.routeToGrades,
                        icon: "fa fa-graduation-cap",
                        label: 'Grades'
                    },

                    {
                        name: 'notes',
                        path: this.routeToNotes,
                        icon: "fa fa-sticky-note-o",
                        label: "Notes"
                    },

                ];
            },

            //feedback
            routeToComments: function () {
                return "/exam-panel-comments/" + this.serialNumber;
                // return "/panel-comments/" + this.serialNumber;
            },

            //details
            routeToExamDetails: function () {
                return "/panel-exam-detail/" + this.serialNumber;
            },

            //grade distributions
            routeToGrades: function () {
                return "/panel-grades/" + this.serialNumber;
            },

            //Notes
            routeToNotes: function () {
                return "/panel-exam-notes/" + this.serialNumber;
                // return "/panel-item-notes/" + this.serialNumber;
            },


            //quality control
            routeToQuality: function () {
                return '/panel-quality/' + this.serialNumber;
            },

            //roster management
            routeToStudents: function () {
                return "/panel-students/" + this.serialNumber;
            },


            serialNumber: function () {
                return this.exam.serialNumber
            },

            watchedPaths: function () {
                let paths = [];
                _.forEach( this.routes, ( r ) => {
                    paths.push( r.path );
                } );
                return paths;
            },


        },

        methods: {

            togglePaneVisibility: function () {
                    this.$store.commit( mTypes.toggleExamSettings, Payload.factory( { mutateSilently: true } ) );
                },


            // getId: function ( name ) {
            //     if ( this.isExam ) return 'exam-' + name + '-nav-' + this.serialNumber;
            //     return 'item-' + name + '-nav-' + this.serialNumber;
            // }


        },

    }

</script>
