<template>
    <div class="summary-stats-display ">

        <table class="table is-narrow">

        <stat-display-table-row>
            <div slot="label">Average</div>
            <div slot="value">{{meanDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">Median</div>
            <div slot="value">{{medianDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">SD</div>
            <div slot="value">{{sdDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">Count</div>
            <div slot="value">{{countDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">Max</div>
            <div slot="value">{{maxDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">Min</div>
            <div slot="value">{{minDisplay}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">25th</div>
            <div slot="value">{{percentile25Display}}</div>
        </stat-display-table-row>

        <stat-display-table-row>
            <div slot="label">75th</div>
            <div slot="value">{{percentile75Display}}</div>
        </stat-display-table-row>
        </table>
    </div>


</template>

<style lang="scss">
    .stat-label {
        font-weight: bold;
    }
</style>

<script>

    import statDisplay from './stat-display-columns.vue';
    import StatDisplayTableRow from "./stat-display-table-row.vue";

    export default {

        props: [ 'name', 'id', 'mean',
            'median', 'sd', 'min',
            'max', 'number', 'isLoading',
            'percentile25', 'percentile75',
            'name'
        ],

        components: {
            StatDisplayTableRow,
            'stat-display': statDisplay
        },

        data: function () {
            return {
                defaults: {
                    toDisplayIfNoValue: '-'
                }
            }
        },

        computed: {
            showName: function () {
                if ( _.isUndefined( this.name ) ) return false;
                return true;
            },

            meanDisplay: function () {
                return this.formatForDisplay( this.mean );
            },

            medianDisplay: function () {
                return this.formatForDisplay( this.median );
            },

            sdDisplay: function () {
                return this.formatForDisplay( this.sd );
            },

            maxDisplay: function () {
                return this.formatForDisplay( this.max );
            },
            minDisplay: function () {
                return this.formatForDisplay( this.min );
            },

            countDisplay: function () {
                return this.formatForDisplay( this.number );
},

            percentile25Display: function () {
                return this.formatForDisplay( this.percentile25 );
       },

            percentile75Display: function () {
                return this.formatForDisplay( this.percentile75 );
            }

        },

        methods: {
            formatForDisplay: function ( value ) {
                if ( _.isUndefined( value ) ) return this.toDisplayIfNoValue;
                if ( _.isNaN( value ) ) return this.toDisplayIfNoValue;
                return _.round( value, 2 );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>