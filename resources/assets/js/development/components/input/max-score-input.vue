<template>
    <!-- max grade -->

    <div class="max-score-input">
        <div class="field">
            <label class="label max-score-label">{{labels.scoreInput}}</label>
            <p class="control">
                <input type="number"
                       class="input max-score-field"
                       v-bind:id="maxScoreId"
                       v-bind:title="title"
                       v-model="maxScore"
                />
            </p>
        </div>

        <div class="field">
            <p class="control">
                <label class="checkbox">
                    <input type="checkbox" v-model="countsInTotal">
                    {{labels.countsInTotal}}
                </label>
            </p>

        </div>
    </div>

</template>
<style lang="scss">
    .max-score-field {
        text-align: left;
    }

    /*input {*/
    /*width: 4em;*/
    /*outline: none;*/
    /*}*/

    .max-score-input {
        width: 5em;
    }

</style>
<script>
    window._ = require( 'lodash' );
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload'
    import Item from '../../../models/Item'

    export default {
        props: [ 'index' , 'item'],

        data: function () {
            return {
//                index: this.$route.params.index,
//                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                labels: {
                    scoreInput: 'Max Score',
                    countsInTotal: 'Counts toward total score'
                },

                title: 'Maximum possible score for this item',

                placeholders: {
                    'score': 100
                },
                defaults: {
                    score: 100,
                    countsInTotal: true
                }
            };
        },

        computed: {
            serialNumber: function (  ) {
                return _.toInteger( this.item.serialNumber );
            },

            // item: function () {
            //     return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            // },

            maxScoreId: function () {
                return 'max-score-' + this.index;
            },

            maxScore: {
                get: function () {
                    if ( ! _.isUndefined(this.item)) return this.item.maxScore;
                },

                set: function ( value ) {
                        let pl = Payload.factory( {
                            obj: this.item,
                            updateProp: 'maxScore',
                            updateVal: _.toInteger( value )
                        } );
                        this.$store.commit( mTypes.updateItem, pl );
                    }
            },

            countsInTotal: {
                get: function () {
                    return this.defaults.countsInTotal;
                },
                set: function ( v ) {

                }
            }
        },

        methods: {}
    }


</script>
