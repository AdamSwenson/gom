<template>
    <div id="year-input">

        <input-and-selector
                :item="exam"
                item-prop="year"
                :options="years"
                :input-value="year"
                type="year"
                v-on:update="handleValueChange"
        >
            <!--<div slot="label">Year</div>-->
            <div slot="disabledOption">{{ disabledOption }}</div>
            <div slot="helpText">{{ helpText }}</div>

        </input-and-selector>

    </div>

</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload'

    import InputAndSelector from "./input-and-selector.vue";

    export default {

        props: [
            'exam',
            'numberYearsForward', //how far in the future to display
            'numberYearsBack' //how far in the past to display
        ],

        components: { InputAndSelector },

        data: function () {
            return {
                disabledOption: 'Year',
                helpText: 'years re good',

                defaults: {


                    numberYearsForward: 2,
                    numberYearsBack: 0,
                }
            }
        },

        computed: {
            year: function () {
                let i = this.$store.getters.getItemBySerialNumber( this.exam.serialNumber );
                return i.year;
            },

            currentYear: function () {
                return new Date.getFullYear();
            },

            /**
             * The list of years
             *
             * @returns {number[]}
             */
            years: function () {
                return [ 2017, 2018 ];

                let yl = [];

                //add future years
                for (let i = 0; i < this.defaults.numberYearsForward; i++) {
                    yl.push( this.currentYear + i );
                }
                return yl;
            },


        },

        methods: {
            handleValueChange: function ( v ) {
                // window.console.log( 'year-input', 'handleValueChange', 76, v );
                // this.$store.commit( mTypes.updateItem, Payload.factory( {
                //     index: 0,
                //     updateProp: 'year',
                //     updateVal: v
                // } ) );

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>