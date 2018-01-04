<template>
    <div class="stats-panel">

        <h3 class="title is-3">{{ title }}</h3>

        <div class="box">

            <div class="tile is-ancestor">

                <div class="tile is-4 is-vertical is-parent">

                    <div class="tile is-child box">

                        <score-list
                                scope="exam"
                                :item="item"
                        ></score-list>

                    </div>
                </div>

                <div class="tile is-parent is-vertical">

                    <div class="tile is-child box ">

                        <stats-summary
                                scope="exam"
                                :item="item"
                                :exam="exam"
                        ></stats-summary>

                    </div>

                    <div class="tile is-child box ">

                        <stats-summary
                                scope="all"
                                :item="item"
                        ></stats-summary>

                    </div>

                    <div class="tile is-child box">

                        <stats-summary
                                scope="kumi"
                                :item="item"
                        ></stats-summary>

                    </div>

                </div>
            </div>
        </div>
    </div>

</template>
<style>

</style>
<script>

    import loadingIndicator from '../helpers/loading-indicator.vue';
    import statsSummary from './stats/item-summary-stats.vue';
    import statsScores from './stats/score-list.vue';

    export default {
        components: {
            'loading-indicator': loadingIndicator,
            'stats-summary': statsSummary,
            'score-list': statsScores
        },


        data: function () {
            return {

                /**
                 * Whether there are any stats for this
                 * item. Used to control what message displays
                 */
                isEmpty: true,

                emptyMessage: "No scores have been recorded for this item on this exam.",
                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                title: "Item score stats",

                active: this.serialNumber,

                placeholders: {},
            };
        },

        asyncComputed: {


        },

        watch: {


        },

        computed: {
            exam: function () {
                return this.item.isExam() ? this.item : this.$store.getters.currentExam;
            },

            id: function () {
                return this.item.id;
            },

            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            }

        },

        methods: {}
    }
</script>
