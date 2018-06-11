<template>
    <div class="exam-properties">
        <div class="box">

            <p class="h4">Exam properties</p>
            <div v-if="isLoading"
            >
                <loading-indicator
                        :is-loading="isLoading"
                ></loading-indicator>
            </div>

            <div class="exam-properties-list"
            v-if="showTables">
                <table class="table is-narrow">

                    <stat-display-table-row>
                        <div slot="label">Items</div>
                        <div slot="value">{{numberItems}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Students</div>
                        <div slot="value">{{numberStudents}}</div>
                    </stat-display-table-row>

                    <stat-display-table-row>
                        <div slot="label">Groups</div>
                        <div slot="value">{{numberGroups}}</div>
                    </stat-display-table-row>

                </table>
                
            </div>
            
            
            <div class="exam-properties-list"
                 v-if="showColumns"
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
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload';

    import loadingIndicator from '../helpers/loading-indicator.vue';
    import statDisplay from './stat-display-columns.vue';
    import StatDisplayTableRow from "./stat-display-table-row.vue";


    export default {

        props: [
            'exam'
        ],

        components: {
            StatDisplayTableRow,
            'loading-indicator': loadingIndicator,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                isLoading: false,

                format : 'table',
                formats : ['columns', 'table'],

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

            showColumns: function (  ) {
                if(! this.isLoading && this.format === 'columns') return true;
                return false;
            },
            showTables: function (  ) {
                if(! this.isLoading && this.format === 'table') return true;
                return false;
            },


        },

        methods: {
            formatForDisplay: function ( value ) {
                return _.round( value );
            }

        },

    }
</script>