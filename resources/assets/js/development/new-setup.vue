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
    import * as ngmTypes from '../store/new-grading-mutation-types';
    import * as ngaTypes from '../store/new-grading-action-types';


    import { updateItemsOrder } from '../api/requests'
    import { loadKumiForExam } from '../api/requests/kumiRequests';
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

                defaults: {},
            };
        },

        watch: {},

        asyncComputed: {
            /**
             * The exam object being set up. Loads async upon creation
             */
            exam: function () {
                let me = this;
                let p = this.$store.dispatch( 'loadExamFromServer', this.examId );
                return p.then( function () {
                    return me.$store.getters[ gTypes.getActiveExam ];
                } );
            },


        },

        computed: {

            examSerialNumber: function () {
                return !_.isNull( this.exam ) ? this.exam.serialNumber : null;
                // return this.$store.getters.getExamSerialNumber;
            }
        },

        methods: {},

        directives: {},

        events: {},

        created: function () {
            window.console.log( 'new-setup', 'created', 176, this.examId);
            this.$store.dispatch( 'loadItemsFromServer', this.examId );
        },


    }
</script>
