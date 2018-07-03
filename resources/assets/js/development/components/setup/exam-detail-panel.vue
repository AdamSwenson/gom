<template>

    <div class="exam-detail-panel  ">
        <div class="tile is-ancestor box">

            <div class="tile is-vertical">
                <div class="tile is-parent">

                    <div class="tile is-parent">

                        <div class="tile is-child">

                            <year-input :exam="exam"></year-input>

                            <term-input :exam="exam"></term-input>

                            <family-input :exam="exam"></family-input>

                        </div>

                        <div class="tile is-child">

                            <public-name-input :exam="exam"></public-name-input>

                            <description-input :exam="exam"></description-input>

                        </div>
                    </div>
                </div>

                    <div id="exam-stats"
                         class="tile is-parent"
                    >

                        <div class="tile is-child ">
                            <exam-properties :exam="exam"></exam-properties>
                        </div>

                        <div class="countBox tile is-child ">
                            <exam-counts :exam="exam"></exam-counts>
                        </div>

                        <div class="timeBox tile is-child ">
                            <time-stats :exam="item"></time-stats>
                        </div>


                </div>
            </div>
        </div>
    </div>

</template>

<style type="scss">
    .exam-detail-panel {
        .public-name-input {
            label {
                text-align: left;
            }
        }
    }

</style>

<script>

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload'

    import timeRequests from '../../../api/requests/timeRequests';
    import loadingIndicator from '../helpers/loading-indicator.vue';
    import timeStats from '../stats/time-stats.vue'
    import statsSummary from '../stats/summary-stats-display.vue'
    import examCounts from '../stats/number-graded.vue'
    import examProperties from '../stats/exam-properties.vue'

    import termInput from './detail/term-input.vue';
    import yearInput from './detail/year-input.vue';
    import InputAndSelector from "./detail/input-and-selector.vue";
    import FamilyInput from "./detail/family-input.vue";
    import DescriptionInput from "./detail/description-input.vue";
    import PublicNameInput from "./detail/public-name-input.vue";

    export default {
        components: {
            PublicNameInput,
            DescriptionInput,
            FamilyInput,
            InputAndSelector,
            'exam-counts': examCounts,
            'exam-properties': examProperties,
            'loading-indicator': loadingIndicator,
            'stats-summary': statsSummary,
            'time-stats': timeStats,
            'term-input': termInput,
            'year-input': yearInput
        },

        props: [ 'exam-id' ],

        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                active: this.serialNumber,

                defaults: {
                    term: 'Term',
                },
                placeholders: {},

                //0 index always has an exam
                index: 0,
            };
        },

        computed: {


            id: function () {
                return this.item.id;
            },

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            exam: function () {
                return this.item;
            },

            isExam: function () {
                return true;
            },

        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {},
    };
</script>
