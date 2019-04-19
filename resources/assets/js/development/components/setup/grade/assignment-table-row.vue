<template>
    <tr class="assignment-table-row "
        v-bind:class="styling">

        <th>{{ letterGrade }}</th>

        <td>
            <cutoff-entry :grade="grade"
                          v-on:cutoff-change="handleChange"></cutoff-entry>
        </td>

        <td>
            {{ gradeFrequency }}
        </td>

    </tr>

</template>

<style lang="scss">

</style>


<script>

    import * as gTypes from '../../../../store/getter-types';

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

        watch: {},

        asyncComputed: {
        },

        computed: {
            styling: function () {
                if ( this.isInconsistent ) return 'is-selected';
                return '';
            },

            /**
             * If this is true, the min score is
             * out of order with its friends.
             */
            isInconsistent: function () {
                let inconsistentList = this.$store.getters[ gTypes.getInconsistentCutOffs ];
                if ( !_.isUndefined( inconsistentList ) && inconsistentList.indexOf( this.grade ) >= 0 ) return true;

                return false;
            },

            letterGrade: function () {
                return !_.isUndefined( this.grade ) ? this.grade.displayValue : '';
            },

            /**
             * Returns the number of students receiving
             * the present grade on the current assignment scheme
             */
            gradeFrequency: function () {
                let me = this;
                    let f = me.$store.getters[ gTypes.getGradeFrequencies ];
                    return f[ me.letterGrade ];
               }

        },

        methods: {
            handleChange: function () {
                // let freqs = this.$store.getters[ gTypes.getGradeFrequencies ];
                // this._gradeFrequency = freqs[ this.letterGrade ];
                // window.console.log( 'assignment-table-row', 'handleChange', 102, this._gradeFrequency, freqs );
                // //notify parent
                this.$emit( 'cutoff-change' );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>