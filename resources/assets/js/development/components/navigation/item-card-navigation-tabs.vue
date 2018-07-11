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

    <!--<ul v-bind:id="id">-->

            <!--&lt;!&ndash;details&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToItemDetails">-->
                <!--<a class="item-details-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-pencil" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Details</span>-->
                <!--</a>-->
            <!--</router-link>-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToComments"-->
                    <!--v-bind:id="getId('feedback')"-->
            <!--&gt;-->
                <!--<a class="feedback-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-comments-o" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Feedback</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;stats&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToStats">-->
                <!--<a class="stats-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-bar-chart" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Stats</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;history&ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToHistory">-->
                <!--<a class="history-nav">-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-book" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>History</span>-->
                <!--</a>-->
            <!--</router-link>-->

            <!--&lt;!&ndash;notes    &ndash;&gt;-->
            <!--<router-link-->
                    <!--tag="li"-->
                    <!--v-bind:active-class="activeClass"-->
                    <!--v-bind:to="routeToNotes"-->
            <!--&gt;-->
                <!--<a id="notes-nav"-->
                   <!--class="notes-nav"-->
                <!--&gt;-->
                    <!--<span class="icon is-small">-->
                            <!--<i class="fa fa-sticky-note-o" aria-hidden="true"></i>-->
                        <!--</span>-->
                    <!--<span>Notes</span>-->
                <!--</a>-->
            <!--</router-link>-->
        <!--</ul>-->
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
        props: [ 'serialNumber' ],

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

        computed: {
            routes: function(){
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

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return false;
                // return this.item ? this.item.isExam() : false;
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
            // parentSerialNumber: function () {
            //     return this.node.parent;
            // },
            //
            //
            // /**
            //  * The input's css id
            //  */
            // id: function () {
            //     if ( this.isExam ) return this.identifier;
            //     return this.identifier + "-" + this.height + '-' + this.depth;
            // },
            //
            //
            // /**
            //  * Injected into the classes of the input
            //  * */
            // styling: function () {
            //     return this.identifier; // + '-' + this.serialNumber;
            // }


        },

        methods: {
            getId: function ( name ) {
                if ( this.isExam ) return 'exam-' + name + '-nav-' + this.serialNumber;
                return 'item-' + name + '-nav-' + this.serialNumber;
            }


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
