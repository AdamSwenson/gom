<template>
    <!--These are the navigation tabs for the exam cardonly-->
    <nav class="exam-card-navigation-tabs tabs is-centered"
    >
        <ul v-bind:id="id">

            <!--details-->
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


            <!--routeToExamDetails"-->
            <!--&gt;-->
            <!--<a class="exam-details-nav exam-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-pencil" aria-hidden="true"></i>-->
                        <!--</span>-->
                <!--<span>Details</span>-->
            <!--</a>-->
            <!--</router-link>-->


            <!--&lt;!&ndash;students&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToStudents"-->
            <!--&gt;-->
                <!--<a class="exam-nav students-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-group" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Students</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;comments&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToComments"-->
            <!--&gt;-->
                <!--<a class="exam-nav feedback-nav"-->
                   <!--v-on:click="togglePaneVisibility"-->
                <!--&gt;-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-comments-o" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Feedback</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;notes&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToNotes"-->
            <!--&gt;-->
                <!--<a id="notes-nav"-->
                   <!--class="exam-nav notes-nav"-->
                   <!--v-on:click="togglePaneVisibility"-->
                <!--&gt;-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-sticky-note-o" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Notes</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;quality control&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToQuality"-->
            <!--&gt;-->
                <!--<a class="exam-nav quality-nav"-->
                   <!--v-on:click="togglePaneVisibility"-->
                <!--&gt;-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-rocket" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Quality</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;grade distribution&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToGrades"-->
            <!--&gt;-->
                <!--<a class="exam-nav grades-nav"-->
                   <!--v-on:click="togglePaneVisibility"-->
                <!--&gt;-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-graduation-cap" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Grades</span>-->
                <!--</a>-->
            <!--</router-link>-->

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
            '$route': function () {
                //Since we are not using the settings button for the exam
                //we need to make sure that the pane opens when we hit one of
                //the routes on the exam card.
                if ( this.watchedPaths.includes( this.$route.path ) ) {
                    //this first tests whether the pane is visible, if not,
                    //it shows it
                    this.togglePaneVisibility();
                }
            }
        },

        computed: {
            watchedPaths: function () {
                let paths = [];
                _.forEach( this.routes, ( r ) => {
                    paths.push( r.path );
                } );
                return paths;
            },

            routes: function () {
                //nb, these need to be in order of display, l to r
                return [
                    {
                        name: 'details',
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


            // item: function () {
            //     return this.exam; //$store.getters.getItemBySerialNumber( this.serialNumber );
            // },
            //
            // isExam: function () {
            //     return true;
            //     // return this.item ? this.item.isExam() : false;
            // },

            isExamPaneVisible: function () {
                return this.$store.getters[ gTypes.isExamSettingsVisible ];
            },

            //
            // node: function () {
            //     return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            // },
            //
            // depth: function () {
            //     return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            // },
            //
            //
            // height: function () {
            //     return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            // },
            //
            //
            // parentSerialNumber: function () {
            //     return this.node.parent;
            // },


            /**
             * The input's css id
             */
            id: function () {
                return this.identifier;
            },

            serialNumber: function () {
                return this.exam.serialNumber
            },

            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
            }


        },

        methods: {

            togglePaneVisibility: function () {
                window.console.log( 'exam-card-navigation-tabs', 'togglePaneVisibility', 244, this.isExamPaneVisible );
                if ( !this.isExamPaneVisible ) {
                    this.$store.commit( mTypes.toggleExamSettings, Payload.factory( { mutateSilently: true } ) );
                }
            },


            getId: function ( name ) {
                if ( this.isExam ) return 'exam-' + name + '-nav-' + this.serialNumber;
                return 'item-' + name + '-nav-' + this.serialNumber;
            }


        },

    }

</script>
