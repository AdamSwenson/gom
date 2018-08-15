<template>
    <div id="setup-main-page"
         class="mainBodyLocator"
    >

        <top-navbar
                page-type="setup"
                :exam="exam"
        ></top-navbar>

        <div class="container">

            <div id="setup-main-body"
                 class="columns is-centered"
            >
                <div class="central-column column is-three-fourths">

                        <exam-card
                                v-if="exam"
                                :exam="exam"
                        ></exam-card>

                        <div class="item-card-holder box graph-paper-background-big">

                            <div v-for="item in items">
                                <!--Now we make cards recursively-->
                                <item-card :item="item"
                                           :key="item.serialNumber"
                                ></item-card>
                            </div>
                        </div>

                </div>

            </div>

        </div>
        <!--<bottom-navbar></bottom-navbar>-->

    </div>
</template>

<style lang="scss">
    @import '../../sass/development/newSetup';

    #setup-main-page {

        min-height: 1000px;
        /*height: 100%;*/
        /*height: -moz-available;*/
        /*height: -webkit-fill-available;*/
        /*height: fill-available;*/
        /*height:auto !important;*/

        background-color: $main-background-color-gradient-limit;
        .container {

        }

        #setup-main-body {
            /*height: 100vh;*/
            background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);

            .central-column {

                /* Setting these causes the parent background not to fill in */
                /*height: 100%;*/
                /*height: -moz-available;*/
                /*height: -webkit-fill-available;*/
                /*height: fill-available;*/
                /*height:auto !important;*/
                /*min-height: 300px;*/

                background-color: $color-primary-2;
                /*@media screen and (min-width: 767px) {*/
                padding-left: 2px;
                padding-right: 2px;
                /*}*/
                background-color: $main-background-color-gradient-limit;
                box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
            }

            /*#itemCardArea {*/
                /*box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);*/
            /*}*/

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

    import * as gTypes from '../store/getter-types';
    // import ProgressDashboard from './components/dashboard.progress.component.vue'

    import ExamCard from './components/cards/exam-card.vue'
    import ItemCard from './components/cards/item-card';


    //navigation bars
    import BottomNavbar from '../development/components/bottom-nav/bottom-navbar.vue';
    import TopNavbar from '../development/components/top-nav/top-navbar.vue';

    // import SyncIndicator from './components/helpers/server-sync-indicator.vue';


    export default {

        components: {
            BottomNavbar,
            ExamCard,
            ItemCard,
            // ProgressDashboard,
            // SyncIndicator,
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

            /**
             * The children of the item
             */
            items: {
                get() {
                    let me = this;
                    if ( _.isUndefined(me.exam) || _.isNull(me.exam) || _.isUndefined( me.exam.serialNumber ) ) return [];

                    let p = this.$store.dispatch( 'loadItemsFromServer', this.examId );
                    return p.then( function () {
                            // let p = this.$store.dispatch( 'loadItemsFromServer', this.exam.id );
                            // return p.then( function () {
                            let c = me.$store.getters.getItemChildren( me.exam );
                            return !_.isUndefined( c ) ? c : [];

                    } );
                },
                // default() {
                //     return [];
                // }
            },
        },


        computed: {

            examSerialNumber: function () {
                return !_.isNull( this.exam ) ? this.exam.serialNumber : null;
                // return this.$store.getters.getExamSerialNumber;
            }
        }
        ,

        methods: {}
        ,

        directives: {}
        ,

        events: {}
        ,

        created: function () {
        }
        ,


    }
</script>
