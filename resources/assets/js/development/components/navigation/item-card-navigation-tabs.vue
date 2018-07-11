<template>

    <nav class="item-card-navigation-tabs tabs is-centered is-boxed">
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
    .item-card-navigation-tabs {

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
        props: [ 'item' ],

        data: function () {
            return {
                activeClass: 'is-active',
                identifier: 'item-nav-tabs',

                defaults: {
                    types: [ 'question', 'element' ]
                },
                // currentView: 'item-settings-question',
                tabs: [
                    'details', 'comments', 'stats', 'history', 'notes', 'tags'
                ],

            };
        },


        watch: {
            $route: function () {

                //We need to make sure any other open pane's close when the
                // route changes. This is because all pane's will have their
                // serial number from the current route. Thus they will all
                // show the same item, despite appearing in the item cards of other
                // items. See GOM-326 for info.

                // So, obviously, we need not worry unless our pane is open
                if ( !this.isSettingPaneVisible ) return true;

                // We want to know whether the route that is now open
                // is one of the panels for this item. If it is not, we
                // need to close our area
                if ( !this.watchedPaths.includes( this.$route.path ) ) {
                    let pl = Payload.factory( { serialNumber: this.serialNumber, mutateSilently: true } );
                    this.$store.commit( mTypes.hideItemSettings, pl );
                }
            }
        },


        computed: {
            isSettingPaneVisible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ]( this.serialNumber );
            },

            routes: function () {
                return [
                    {
                        name: 'item-details',
                        path: this.routeToItemDetails,
                        icon: "fa fa-pencil",
                        label: "Details"
                    },
                    {
                        name: 'comments',
                        path: this.routeToComments,
                        icon: "fa fa-comments-o",
                        label: "Feedback"
                    },

                    {
                        name: 'stats',
                        path: this.routeToStats,
                        icon: "fa fa-bar-chart",
                        label: "Stats"
                    },

                    {
                        name: 'history',
                        path: this.routeToHistory,
                        icon: "fa fa-book",
                        label: "History"
                    },

                    {
                        name: 'notes',
                        path: this.routeToNotes,
                        icon: "fa fa-sticky-note-o",
                        label: "Notes"
                    },

                ]
            },

            routeToComments: function () {
                return "/panel-comments/" + this.serialNumber;
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

            //Notes
            routeToNotes: function () {
                return "/panel-item-notes/" + this.serialNumber;
            },

            routeToStats: function () {
                return "/panel-stats/" + this.serialNumber;
            },

            isExam: function () {
                return false;
            },

            serialNumber: function () {
                return this.item.serialNumber;
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
            getId: function ( name ) {
                if ( this.isExam ) return 'exam-' + name + '-nav-' + this.serialNumber;
                return 'item-' + name + '-nav-' + this.serialNumber;
            },


            togglePaneVisibility: function () {
                let pl = Payload.factory( { serialNumber: this.serialNumber, mutateSilently: true } );
                if ( this.isSettingPaneVisible ) {
                    this.$store.commit( mTypes.hideItemSettings, pl );
                } else {
                    this.$store.commit( mTypes.showItemSettings, pl );
                }
            },

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
