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
                <div slot="value">{{ averageDisplay }} </div>
            </stat-row>

            <stat-row>
                <div slot="label">Median</div>
                <div slot="value">{{ medianDisplay }}</div>
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

</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import statDisplay from '../stats/stat-display-columns';
    import statRow from './stat-row';

    export default {

        props: [
            'listOfValues',
            'showLetter'
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
                return  _.mean( this.listOfValues ) ;
            },
            averageDisplay : function (  ) {
                let out = this.formatForDisplay(this.average);
                if(this.showLetter) out += ' ' + this.averageLetter;
                return out;
            },

            averageLetter: function () {
                let ga = this.$store.getters[ gTypes.getGradeAssignmentForScore ]( this.average );
                return this.formatLetterForDisplay(ga);
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

            /**
             * The value shown to the user
             * @returns {*}
             */
            medianDisplay : function (  ) {
              let out = this.formatForDisplay(this.median);
              if(this.showLetter) out += ' ' + this.medianLetter;
              return out;
            },

            medianLetter: function () {
                let ga = this.$store.getters[ gTypes.getGradeAssignmentForScore ]( this.median );
                return this.formatLetterForDisplay(ga);
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
            },

            formatLetterForDisplay: function ( gradeAssignment ) {
                if ( _.isUndefined( gradeAssignment ) ) return '';
                return '( ' + gradeAssignment.displayValue + ' )';
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>