<template>
    <tr class="assignment-table-row "
        v-bind:class="styling">

        <th>{{ letterGrade }}</th>

        <td>
            <cutoff-entry :grade="grade"></cutoff-entry>
        </td>

        <td>
            {{ gradeFrequency }}
        </td>

    </tr>

</template>

<style lang="scss">

</style>


<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';
    import Payload from '../../../../models/Payload';

    import cutoffEntry from './cutoff-field.vue';

    export default {

        props: [
            'grade'
        ],

        components: {
            'cutoff-entry': cutoffEntry
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            styling: function () {
                if ( this.isInconsistent ) return 'is-selected';
                return '';
            },

            freqs: function () {
                return this.$store.getters[ gTypes.getGradeFrequencies ];
            },

            /**
             * If this is true, the min score is
             * out of order with its friends.
             */
            isInconsistent: function () {
                let inconsistentList = this.$store.getters[ gTypes.getInconsistentCutOffs ];
                if ( ! _.isUndefined(inconsistentList) && inconsistentList.indexOf( this.grade ) >= 0 ) return true;

                return false;
            },

            letterGrade: function () {
                return ! _.isUndefined(this.grade) ? this.grade.displayValue : '';
            },

            /**
             * Returns the number of students receiving
             * the present grade on the current assignment scheme
             */
            gradeFrequency: function () {
                if ( _.isUndefined( this.grade ) || _.isUndefined( this.freqs ) ) return false;

                return this.freqs[ this.letterGrade ];
            }

        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>