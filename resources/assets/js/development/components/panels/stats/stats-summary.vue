<template>
    <div class="stats-summary box">

        <p class="h4" v-if="showName">{{ name }}</p>
        <div v-if="isLoading">
            <loading-indicator :is-loading="isLoading"></loading-indicator>
        </div>

        <!--<div v-if="isLoading">-->
            <!--<loading-indicator :is-loading="isLoading"></loading-indicator>-->
        <!--</div>-->

        <!--<div v-else>-->
            <!--<div class="field is-horizontal">-->
            <!--<div class="field-label is-normal">-->
            <!--<label class="label">Mean</label>-->
            <!--</div>-->
            <!--<div class="field-body">-->
            <!--<div class="field is-narrow">-->
            <!--<div class="control">-->
            <!--{{ meanDisplay}}-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->
            <!--</div>-->

            <!--<dl>-->
            <!--<dt>Mean</dt>-->
            <!--<dd> {{ meanDisplay }}</dd>-->

            <!--<dt>Median</dt>-->
            <!--<dd>{{ medianDisplay}}</dd>-->

            <!--<dt>SD</dt>-->
            <!--<dd>{{ sdDisplay }}</dd>-->

            <!--<dt>25th Percentile</dt>-->
            <!--<dd>{{ percentile25Display}}</dd>-->

            <!--<dt>75th Percentile</dt>-->
            <!--<dd>{{ percentile75Display}}</dd>-->

            <!--<dt>Lowest</dt>-->
            <!--<dd> {{ minDisplay }}</dd>-->

            <!--<dt>Highest</dt>-->
            <!--<dd>{{ maxDisplay }}</dd>-->

            <!--<dt>Count</dt>-->
            <!--<dd>{{ countDisplay}}</dd>-->
            <!--</dl>-->
            <!--</div>-->

            <p><span class="stat-label has-text-weight-bold">Average:</span>  <span class="stat-value">{{ meanDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">Median:</span> <span class="stat-value">{{ medianDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">SD:</span> <span class="stat-value">{{ sdDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">Count:</span> <span class="stat-value">{{countDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">Lowest score:</span> <span class="stat-value">{{ minDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">Highest score:</span> <span class="stat-value">{{ maxDisplay }}</span></p>

            <p><span class="stat-label has-text-weight-bold">25th Percentile:</span> <span class="stat-value">{{ percentile25Display}}</span></p>

            <p><span class="stat-label has-text-weight-bold">75th Percentile:</span> <span class="stat-value">{{ percentile75Display}}</span></p>
        </div>


    <!--</div>-->
</template>

<style lang="scss">
.stat-label{
    font-weight: bold;
}
</style>

<script>
    import loadingIndicator from '../../helpers/loading-indicator.vue';

    export default {

        props: [ 'name', 'id', 'mean',
            'median', 'sd', 'min',
            'max', 'number', 'isLoading',
            'percentile25', 'percentile75'
        ],

        components: {},

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