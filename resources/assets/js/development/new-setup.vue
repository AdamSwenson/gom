<template>
    <div id="setup-main-page"
         class=" mainBodyLocator"
    >
        <div class="container">
            <top-navbar
                    page-type="setup"
                    :exam="exam"
            ></top-navbar>

            <div id="setup-main-body"
                 class="columns is-centered"
            >

                <div class="column is-three-fourths ">
                    <!--<div class="column is-four-fifths ">-->

                    <div id="examCardArea">

                        <exam-card
                                v-if="exam"
                                :exam="exam"
                        ></exam-card>

                    </div>

                </div>

            </div>

            <div class="columns">
                <div class="column">
                    <progress-dashboard></progress-dashboard>
                </div>
                <div class="column is-1">
                    <sync-indicator></sync-indicator>
                </div>
            </div>


            <input type="hidden" id="examId" v-model="examId"/>
        </div>

        <bottom-navbar></bottom-navbar>

    </div>
</template>

<style lang="scss">
    @import '../../sass/development/newSetup';

    #setup-main-page {
        background-color: $main-background-color-gradient-limit;

        #setup-main-body {

            /*<!-- background-image:linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);-->*/

            #examCardArea {
                /*<!--background-color: $color-primary-2;-->*/
                padding-left: 2px;
                padding-right: 2px;
                background-color: $main-background-color-gradient-limit;
                box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
            }

            #itemCardArea {
                box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
            }

            .itemCol {
                border-left-color: $border-outline-color;
                border-left-width: thin;
                border-left-style: solid;
                border-right-color: $border-outline-color;
                border-right-width: thin;
                border-right-style: solid;
                /*-moz-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
                /*-webkit-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
                /*border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
                /*border-width: 10px;*/
                /*border-image : url('http://localhost:8000/images/styling/border.png') 10 repeat;*/

            }

            .infoCol {
                margin-top: 2em;
                /*background-color: #00496C;*/
            }
        }
    }
</style>
<script>

    import Exam from '../models/Exam'
    import Item from '../models/Item'
    import Payload from '../models/Payload'

    import * as aTypes from '../store/action-types';
    import * as mTypes from '../store/mutation-types';
    import * as gTypes from '../store/getter-types';
    import * as ngmTypes from '../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../store/modules/newgrading/new-grading-action-types';


    import { updateItemsOrder } from '../api/requests'
    import { loadExamKumi } from '../api/requests/kumiRequests';
    import { loadAllStudents } from '../api/requests/studentRequests';
    import { loadExam } from '../api/requests/examRequests';
    // import { getItemsForExam, getItemOrderForExam } from '../api/requests/itemRequests';

    import ProgressDashboard from './components/dashboard.progress.component.vue'

    import ExamCard from './components/cards/exam-card.vue'


    //navigation bars
    import BottomNavbar from '../development/components/bottom-nav/bottom-navbar.vue';
    import TopNavbar from '../development/components/top-nav/top-navbar.vue';

    import SyncIndicator from './components/helpers/server-sync-indicator.vue';


    // var Sortable = require( 'sortablejs' );

    export default {

        components: {
            BottomNavbar,
            ExamCard,
            ProgressDashboard,
            SyncIndicator,
            TopNavbar
        },
        data: function () {
            return {
                examId: window.examId,
//                isSyncable: this.$store.getters.canSync,
                defaults: {},

                // options: {
                //     group: 'items', //name must be common to drag between menus
                //     filter: '.js-remove', // Selectors that do not lead to dragging (String or Function)
                //     animation: 150,
                //     handle: '.handle',  // Drag handle selector within list items
                //     ghostClass: "sortable-ghost", // Class name for the drop placeholder
                //     dataIdAttr: 'data-id',
                //     onUpdate: function ( event ) {
                //         this.$store.dispatch( 'onUpdate', event );
                //     },
                // }
            };
        },

        watch: {
            // canSync: function ( newVal, oldVal ) {
            //     window.console.log( 'new-setup', 'canSync', 118, newVal, oldVal );
            //     //if the can Sync is newly true, call update
            //     if ( newVal ) updateItemsOrder( this.$store );
            // }
        },

        asyncComputed: {
            /**
             * The exam object being set up
             */
            exam: function () {
                // let me = this;
                // let p = this.$store.dispatch( 'loadExamFromServer', this.examId );
                // return p.then( function () {
                    return this.$store.getters[ gTypes.getActiveExam ];
                // } );
            },

            items: function () {

                if ( !_.isUndefined( this.exam ) ) {
                    // let p = this.$store.dispatch( 'loadItemsFromServer', this.exam );
                }
            }


        },

        computed: {
            // canSync: function () {
            //     return this.$store.getters.canSync;
            // },

            //
            // examId: function () {
            //     return _.isNull( this.exam ) ?: this.exam.id;
            // },

            examSerialNumber: function () {
                return !_.isNull( this.exam ) ? this.exam.serialNumber : null;
                // return this.$store.getters.getExamSerialNumber;
            }
        },

        methods: {},

        directives: {},

        events: {},

        created: function () {
            let me = this;
            let p = this.$store.dispatch( 'loadExamFromServer', this.examId );
            p.then( function () {
                let p = me.$store.dispatch( 'loadItemsFromServer', me.exam );
            } );



            //
            // // return new Promise( function ( resolve, reject ) {
            // //load the exam object and store it
            // loadExam( me.examId )
            //     .then( function ( data ) {
            //         let exam = Exam.factory( data );
            //         let pl = Payload.factory( {
            //             obj: exam,
            //             mutateSilently: true
            //         } );
            //         //and save it in the exams list
            //         me.$store.commit( mTypes.addExam, pl );
            //         window.console.log( 'new-setup', 'addExam', 204, );
            //         //Now that we have the exam loaded,
            //         //we need to do some stuff with it.
            //         //NB, since these call mutations, they happen
            //         //synchronously, thus no need to wrap in promises
            //         //First, we initialize the item store (which holds the
            //         //order of the items) with the exam
            //         me.$store.commit( mTypes.initializeItemStorage, pl );
            //         window.console.log( 'new-setup', 'initialized', 211, );
            //         //Then we et the exam as the current exam
            //         me.$store.commit( mTypes.setActiveExam, pl );
            //         me.$store.commit( ngmTypes.setActiveExam, pl );
            //         window.console.log( 'new-setup', 'setActive', 216, );
            //         //Now we can get the item objects
            //         let p = me.$store.dispatch( 'loadItemsFromServer', exam );
            //         p.then( function () {
            //             window.console.log( 'new-setup', 'loadItems', 220, );
            //             //get any groups associated with the exam
            //             //this will include the central group which
            //             //constitutes the roster
            //             let p1 = me.$store.dispatch( 'loadKumisForExamFromServer', exam );
            //             p1.then( function () {
            //                 //and then get the students to go in those
            //                 //groups
            //                 loadAllStudents( me.$store, exam )
            //                     .then( function () {
            //                         //and any existing scores
            //                         //as well as comments
            //                         let p2 = me.$store.dispatch( 'loadScoresFromServer', exam );
            //                         p2.then( function () {
            //                             //finally we get grading times
            //                             let p3 = me.$store.dispatch( ngaTypes.loadTimesFromServer, exam );
            //                             p3.then( function () {
            //
            //                                 //Tags for the items loaded
            //                                 //Does not load tags that aren't yet used on the
            //                                 //exam. That is done on the tags-panel creation
            //
            //                                 me.$store.dispatch( 'processTagsOutOfLoadedItems' );
            //                                 //and are done.
            //                             } );
            //
            //                         } );
            //                     } );
            //             } );
            //         } );
            //     } );

            // } );
//
//             let p1 = new Promise( function ( resolve, reject ) {
//                 window.console.log( 'new-setup', 'start loading', 192, );
//                 me.$store.commit( mTypes.loadExamAndItemsFromPageData );
//                 window.console.log( 'new-setup', 'done loading', 193, );
//                 resolve();
//             } )
//             p1.then( function () {
//                 window.console.log( 'new-setup', 'exam', 196, me.exam);
//                 let p2 = loadExamKumi( me.$store, me.exam );
//                 p2.then( function () {
//                     //set the first kumi as the one to display
//                     //this needs to happen before associate exam is called
// //                me.$store.commit( 'updateSelectedKumi' );
//                     loadAllStudents( me.$store, me.exam );
//                 } );
//
//             } );
        },


    }
</script>
