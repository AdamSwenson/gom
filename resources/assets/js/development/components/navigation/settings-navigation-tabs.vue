<template>

    <nav class="nav-edit-tabs-component tabs is-centered">
        <ul>
            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToExamDetails">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <span>Details</span>
                    </a>
                </router-link>
            </li>

            <li v-else role="presentation">
                <router-link v-bind:to="routeToItemDetails">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <span>Details</span>
                    </a>
                </router-link>
            </li>

            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToStudents">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-group" aria-hidden="true"></i>
                        </span>
                        <span>Students</span>
                    </a>
                </router-link>
            </li>

            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToGrades">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        </span>
                        <span>Grades</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToComments">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                        </span>
                        <span>Feedback</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToStats">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </span>
                        <span>Stats</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToHistory">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-book" aria-hidden="true"></i>
                        </span>
                        <span>History</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToNotes">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                        </span>
                        <span>Notes</span>
                    </a>
                </router-link>
            </li>


            <li role="presentation">
                <router-link v-bind:to="routeToTags">
                    <a>
                        <span class="icon is-small">
                            <i class="fa fa-tags" aria-hidden="true"></i>
                        </span>
                        <span>Tags</span>
                    </a>
                </router-link>
            </li>
        </ul>
    </nav>


</template>
<style>

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
        props: [ 'index', 'is-exam', 'serialNumber' ],

        data: function () {
            return {
                defaults: {
                    types: [ 'question', 'element' ]
                },
                // currentView: 'item-settings-question',
                tabs: [
                    'details', 'comments', 'stats', 'history', 'notes', 'tags'
                ],
                hiding: true,

            };
        },

        computed: {
            routeToComments: function () {
                return "/panel-comments/" + this.serialNumber;
            },

            routeToExamDetails: function () {
                return "/panel-exam-detail/" + this.serialNumber;
            },

            routeToItemDetails: function () {
                return "/panel-item-detail/" + this.serialNumber;
            },

            routeToGrades: function () {
                return "/panel-grades/" + this.serialNumber;
            },

            routeToHistory: function () {
                return "/panel-history/" + this.serialNumber;
            },

            routeToNotes: function () {
                return "/panel-notes/" + this.serialNumber;
            },

            routeToStats: function () {
                return "/panel-stats/" + this.serialNumber;
            },

            routeToStudents: function () {
                return "/panel-students/" + this.serialNumber;
            },

            routeToTags: function () {
                return "/panel-tags/" + this.serialNumber;
            },


        },

        methods: {
//            show: function () {
//                console.log('itemSetting', 'CALLED', 'show');
//                this.$store.commit( mTypes.showItemSettings( Payload.factory( { index: this.index } ) ) );
//            },
//            hide: function () {
//                console.log('itemSetting', 'CALLED', 'hide');
//                this.$store.commit( mTypes.hideItemSettings( Payload.factory( { index: this.index } ) ) );
//            },

        },

        directives: {},

        events: {
            'display-settings': function () {
//                console.log('itemSettings', 'CAUGHT', 'display-settings', this.hiding);
                //this.toggle();
            }
        },

        mounted: function () {
//            window.console.log('nav.edit-tabs.component', 'mounted', 136, this.index);
        },

    }

</script>
