<template>

    <nav class="nav-edit-tabs-component tabs is-centered"
    >
        <ul v-bind:id="id">
            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToExamDetails">
                    <a class="exam-details-nav"
                       v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <span>Details</span>
                    </a>
                </router-link>
            </li>

            <li v-else role="presentation">
                <router-link v-bind:to="routeToItemDetails">
                    <a class="item-details-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </span>
                        <span>Details</span>
                    </a>
                </router-link>
            </li>

            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToStudents">
                    <a class="students-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-group" aria-hidden="true"></i>
                        </span>
                        <span>Students</span>
                    </a>
                </router-link>
            </li>

            <li v-if="isExam" role="presentation">
                <router-link v-bind:to="routeToGrades">
                    <a class="grades-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                        </span>
                        <span>Grades</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToComments"
                             v-bind:id="getId('feedback')"
                >
                    <a class="feedback-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-comments-o" aria-hidden="true"></i>
                        </span>
                        <span>Feedback</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToStats">
                    <a class="stats-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-bar-chart" aria-hidden="true"></i>
                        </span>
                        <span>Stats</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToHistory">
                    <a class="history-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-book" aria-hidden="true"></i>
                        </span>
                        <span>History</span>
                    </a>
                </router-link>
            </li>

            <li role="presentation">
                <router-link v-bind:to="routeToNotes">
                    <a class="notes-nav" v-bind:class="{ 'exam-nav' : isExam  }">
                        <span class="icon is-small">
                            <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                        </span>
                        <span>Notes</span>
                    </a>
                </router-link>
            </li>


            <li role="presentation">
                <router-link v-bind:to="routeToTags">
                    <a class="tags-nav" v-bind:class="{ 'exam-nav' : isExam  }">
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
<style lang="scss">
    .nav-edit-tabs-component {
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
        props: [ 'serialNumber' ],

        data: function () {
            return {
                identifiers: {
                    exam: 'exam-nav-tabs',
                    item: 'item-nav-tabs'
                },
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
                if ( this.isExam ) return "/exam-panel-comments/" + this.serialNumber;
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

            //Notes
            routeToNotes: function () {

                if(this.isExam) return "/panel-exam-notes/" + this.serialNumber;

                return "/panel-item-notes/" + this.serialNumber;
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

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            node: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            },

            depth: function () {
                return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            },


            height: function () {
                return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            },


            parentSerialNumber: function () {
                return this.node.parent;
            },

            /**
             * Gets the appropriate base string for the input
             * depending on whether it is attached to an exam or
             * regular item
             */
            identifier: function () {
                return this.isExam ? this.identifiers.exam : this.identifiers.item;
            },

            /**
             * The input's css id
             */
            id: function () {
                if ( this.isExam ) return this.identifier;
                return this.identifier + "-" + this.height + '-' + this.depth;
            },


            /**
             * Injected into the classes of the input
             * */
            styling: function () {
                return this.identifier; // + '-' + this.serialNumber;
            }


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
