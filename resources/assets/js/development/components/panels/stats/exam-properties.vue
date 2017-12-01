<template>
    <div class="exam-properties">
        <p class="h4">Exam properties</p>
        <div class="box">
            <div v-if="isLoading"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="exam-properties-list"
                 v-if="! isLoading"
            >

                <stat-display>
                    <div slot="label">Items</div>
                    <div slot="value">{{numberItems}}</div>
                </stat-display>

                <stat-display>
                    <div slot="label">Students</div>
                    <div slot="value">{{numberStudents}}</div>
                </stat-display>

                <stat-display>
                    <div slot="label">Groups</div>
                    <div slot="value">{{numberGroups}}</div>
                </stat-display>


            </div>
        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload';

    import loadingIndicator from '../../helpers/loading-indicator.vue';
    import statDisplay from './stat-display.vue';


    export default {

        props: [
            'exam'
        ],

        components: {
            'loading-indicator': loadingIndicator,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                isLoading: false,

                placeholders: {
                    numberItems: ''
                },
                defaults: {}
            }
        },

        computed: {
            item: function () {
                return this.exam;
            },

            numberItems: function () {
                let v = this.$store.getters[ gTypes.getItemCount ];
                //if not set return placeholder
                return typeof v != 'undefined' ? v : this.placeHolders.numberItems;

            },

            numberStudents: function () {
                let v = this.$store.getters[ gTypes.getStudentCount ];
                //if not set return placeholder
                return typeof v != 'undefined' ? v : this.placeHolders.numberItems;
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            numberGroups: function () {
                let v = this.$store.getters[ gTypes.getKumiCount ];
                //if not set return placeholder
                return typeof v != 'undefined' ? v : this.placeHolders.numberItems;

            },

        },

        methods: {
            formatForDisplay: function ( value ) {
                return _.round( value );
            }

        },

    }
</script>