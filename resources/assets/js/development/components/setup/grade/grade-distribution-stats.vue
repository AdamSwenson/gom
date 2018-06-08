<template>

    <div class="grade-distribution-stats">

        <div class="box">
            <div class="columns">
                <div class="column">
                    <dist-area :list-of-values="grades">
                        <span slot="heading">Grades</span>
                    </dist-area>
                </div>
                <div class="column">
                    <dist-area :list-of-values="scores">
                        <div slot="heading">Total scores</div>
                    </dist-area>
                </div>
            </div>
        </div>
    </div>

    <!--<p> {{ examMaxScore }}</p>-->
    <!--<p>Total graded exams: {{ totalGraded }}</p>-->

</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';
    import Payload from '../../../../models/Payload';

    import statDisplay from '../stats/stat-display-columns';
    import distArea from './dist-area';

    export default {

        props: [ 'exam' ],

        components: {
            'dist-area': distArea,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {

            scores: function () {
                return this.$store.getters[ gTypes.getTotalScores ];
            },

            grades: function () {
                return this.$store.getters.getListOfGradeValues;
            },


        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>