<template>
    <div class="feedback-panel">
        <p class="title has-text-centered">{{ examName }}</p>
        <p class="subtitle">{{ studentName }}</p>

        <div class="columns">
            <div class="column">
                <grade-table :exam="exam" :student="student"></grade-table>
            </div>

            <div class="column">
                <overall-chart :exam="exam" :student="student"></overall-chart>
            </div>

        </div>

        <div v-for="i in topLevelItems">
            <item-area
                    :exam="exam"
                    :item="i"
                    :student="student"
            ></item-area>
        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>
    import ItemComment from "./item-comment";
    import ItemArea from "./item-area";

    import * as nggTypes from '../../../store/new-grading-getter-types';
    import ItemChart from "./item-chart";
    import GradeTable from "./grade-table";
    import OverallChart from "./overall-chart";

    export default {

        props: [ 'exam', 'student' ],

        components: {
            OverallChart,
            GradeTable,
            ItemChart,
            ItemArea,
            ItemComment
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {

            examName: function () {
                return this.exam ? this.exam.name : '';
            },

            studentName: function () {
                return (!_.isUndefined( this.student ) && !_.isNull( this.student )) ? this.student.nameFirstLast : '';
            },

            topLevelItems: function () {
                if ( _.isUndefined( this.exam ) || _.isNull( this.exam ) ) return [];

                return this.$store.getters.getItemChildren( this.exam );
            },

        },

    }
</script>