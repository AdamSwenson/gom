<template>
    <div class="dist-area">

        <table class="table is-narrow">
            <thead>
            <tr>
                <th>
                    <slot name="heading"></slot>
                </th>
            </tr>

            </thead>
            <tbody>
            <stat-row>
                <div slot="label">Average</div>
                <div slot="value">{{ average }} {{ averageLetter }}</div>
            </stat-row>

            <stat-row>
                <div slot="label">Median</div>
                <div slot="value">{{ median }} {{ medianLetter }}</div>
            </stat-row>

            <stat-row>
                <div slot="label">SD</div>
                <div slot="value">{{ standardDeviation }}</div>
            </stat-row>

            <stat-row>
                <div slot="label">Count</div>
                <div slot="value">{{ count }}</div>
            </stat-row>

            </tbody>
        </table>
    </div>

    <!--<stat-display>-->
    <!--<div slot="label">Average</div>-->
    <!--<div slot="value">{{ average }} {{ averageLetter }}</div>-->
    <!--</stat-display>-->

    <!--<stat-display>-->
    <!--<div slot="label">Median</div>-->
    <!--<div slot="value">{{ median }} {{ medianLetter }}</div>-->
    <!--</stat-display>-->
    <!--<stat-display>-->
    <!--<div slot="label">Standard deviation</div>-->
    <!--<div slot="value">{{ standardDeviation }}</div>-->
    <!--</stat-display>-->

    <!--<stat-display>-->
    <!--<div slot="label">Count</div>-->
    <!--<div slot="value">{{ count }}</div>-->
    <!--</stat-display>-->
    <!--</div>&lt;!&ndash;&ndash;&gt;-->
    <!--</div>-->
</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import statDisplay from '../stats/stat-display';
    import statRow from './stat-row';

    export default {

        props: [
            'listOfValues'
        ],

        components: {
            'stat-display': statDisplay,
            'stat-row': statRow
        },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            sortedValues: function () {
                let newList = [];

                _.forEach( this.listOfValues, function ( v ) {
                    //Get the index of where it should go
                    let idx = _.sortedIndex( newList, v );
                    //push it into the new array
                    newList.splice( idx, 0, v );
                } );
                return newList;

            },
            average: function () {
                return this.formatForDisplay( _.mean( this.listOfValues ) );
            },

            averageLetter: function () {
                let letter = this.$store.getters[ gTypes.getGradeForScore ]( this.average );
                if ( _.isUndefined( letter ) ) return '';
                return '( ' + letter + ')';
            },

            count: function () {
                return _.size( this.listOfValues );
            },

            median: function () {
                if ( _.isUndefined( this.listOfValues ) ) return false;

                // this.sortedValues.sort( ( a, b ) => a - b );
                let lowMiddle = Math.floor( (this.sortedValues.length - 1) / 2 );
                let highMiddle = Math.ceil( (this.sortedValues.length - 1) / 2 );
                return (this.sortedValues[ lowMiddle ] + this.sortedValues[ highMiddle ]) / 2;
            },

            medianLetter: function () {
                let letter = this.$store.getters[ gTypes.getGradeForScore ]( this.median );
                if ( _.isUndefined( letter ) ) return '';
                return '( ' + letter + ')';
            },

            standardDeviation: function () {
                var avg = _.mean( this.listOfValues );

                var squareDiffs = this.listOfValues.map( function ( value ) {
                    var diff = value - avg;
                    var sqrDiff = diff * diff;
                    return sqrDiff;
                } );

                var avgSquareDiff = _.mean( squareDiffs );

                var stdDev = Math.sqrt( avgSquareDiff );
                return this.formatForDisplay( stdDev );
            }


        },

        methods: {
            formatForDisplay: function ( value ) {
                return _.round( value, 2 );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>