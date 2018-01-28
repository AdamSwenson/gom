<template>
    <div class="feedback-panel">
        <h4 class="title is-4">Feedback for</h4>
        <h4 class="subtitle is-4">{{ studentName }}</h4>

        <grade-area :exam="exam" :student="student"></grade-area>

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
    import GradeArea from "./grade-area";

    export default {

        props: [ 'exam', 'student' ],

        components: {
            GradeArea,
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
            studentName: function () {
                return (! _.isUndefined(this.student) && ! _.isNull(this.student)) ? this.student.nameFirstLast : '';
            },

            topLevelItems: function () {
                if ( _.isUndefined( this.exam ) || _.isNull( this.exam ) ) return [];

                return this.$store.getters.getItemChildren( this.exam );
            },

        },

    }
</script>