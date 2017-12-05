<template>
    <tr class="assignment-table-row ">

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

    import cutoffEntry from './cutoff-field';

    export default {

        props: [
            'grade'
        ],

        components: {
            'cutoff-entry' :cutoffEntry
        },

        data: function () {
            return {

            defaults: {}
            }
        },

        computed: {
            freqs : function() {
                return this.$store.getters[ gTypes.getGradeFrequencies ];
            },

            letterGrade : function (  ) {
                return this.grade.displayValue;
            },

            /**
             * Returns the number of students receiving
             * the present grade on the current assignment scheme
             */
            gradeFrequency: function () {
                if(_.isUndefined(this.grade) || _.isUndefined(this.freqs)) return false;

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