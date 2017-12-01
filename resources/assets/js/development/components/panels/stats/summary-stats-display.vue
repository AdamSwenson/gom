<template>
    <div class="stats-summary ">


        <stat-display>
            <div slot="label">Average</div>
            <div slot="value">{{meanDisplay}}</div>
        </stat-display>


        <stat-display>
            <div slot="label">Median</div>
            <div slot="value">{{medianDisplay}}</div>
        </stat-display>


        <stat-display>
            <div slot="label">SD</div>
            <div slot="value">{{sdDisplay}}</div>
        </stat-display>



        <stat-display>
            <div slot="label">Count</div>
            <div slot="value">{{countDisplay}}</div>
        </stat-display>


        <stat-display>
            <div slot="label">Max</div>
            <div slot="value">{{maxDisplay}}</div>
        </stat-display>


        <stat-display>
            <div slot="label">Min</div>
            <div slot="value">{{minDisplay}}</div>
        </stat-display>

        <stat-display>
            <div slot="label">25th</div>
            <div slot="value">{{percentile25Display}}</div>
        </stat-display>

        <stat-display>
            <div slot="label">75th</div>
            <div slot="value">{{percentile75Display}}</div>
        </stat-display>




    </div>


</template>

<style lang="scss">
    .stat-label {
        font-weight: bold;
    }
</style>

<script>

    import statDisplay from './stat-display.vue';

    export default {

        props: [ 'name', 'id', 'mean',
            'median', 'sd', 'min',
            'max', 'number', 'isLoading',
            'percentile25', 'percentile75',
            'name'
        ],

        components: {
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
//                return _.round( this.mean, 2 );
            },

            medianDisplay: function () {
                return this.formatForDisplay( this.median );

//                return _.round( this.median, 2 );
            },

            sdDisplay: function () {
                return this.formatForDisplay( this.sd );

//                return _.round( this.sd, 2 );
            },

            maxDisplay: function () {
                return this.formatForDisplay( this.max );

//                return _.round( this.max, 2 );
            },
            minDisplay: function () {
                return this.formatForDisplay( this.min );

//                return _.round( this.min, 2 );
            },

            countDisplay: function () {
                return this.formatForDisplay( this.number );

//                return this.number;
            },

            percentile25Display: function () {
                return this.formatForDisplay( this.percentile25 );

//                return _.round( this.percentile25, 2 );

            },

            percentile75Display: function () {
                return this.formatForDisplay( this.percentile75 );
//                return _.round( this.percentile75, 2 );
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