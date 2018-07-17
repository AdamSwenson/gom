<template>

    <div class="max-score-input">
        <div class="field max-score-field">
            <label class="label max-score-label">{{labels.scoreInput}}</label>
            <p class="control">
                <input type="number"
                       class="input "
                       v-bind:id="maxScoreId"
                       v-bind:title="title"
                       v-model="maxScore"
                />
            </p>
            <p class="help">{{helpText.maxScore}}</p>
        </div>

        <div class="field">
            <p class="control">
                <label class="checkbox">
                    <input type="checkbox" v-model="countsInTotal" readonly>
                    {{labels.countsInTotal}}
                </label>
            </p>
            <p class="help">{{helpText.countsInTotal }} </p>

        </div>
    </div>

</template>
<style lang="scss">

    .max-score-input {
        .max-score-field {
            width: 7em;
            /*text-align: left;*/
        }

        /*input {*/
        /*width: 4em;*/
        /*outline: none;*/
        /*}*/

    }

</style>
<script>
    // window._ = require( 'lodash' );
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload'
    import Item from '../../../models/Item'

    export default {
        props: [ 'index', 'item' ],

        data: function () {
            return {
//                index: this.$route.params.index,
//                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                labels: {
                    scoreInput: 'Max Score',
                    countsInTotal: 'Counts toward total score'
                },

                helpText: {
                    countsInTotal: "Uncheck this to capture data and give feedback without the score affecting the overall exam grade. ",
                    maxScore: ''
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
            serialNumber: function () {
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
                    if ( !_.isUndefined( this.item ) ) return this.item.maxScore;
                },

                set: function ( value ) {
                    let pl = Payload.factory( {
                        obj: this.item,
                        updateProp: 'maxScore',
                        updateVal: _.toNumber( value )
                    } );
                    this.$store.commit( mTypes.updateItem, pl );
                }
            },

            countsInTotal: {
                get: function () {
                    if ( !_.isUndefined( this.item ) ) return this.item.countsInTotal;
                    return this.defaults.countsInTotal;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.item,
                        updateProp: 'countsInTotal',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateItem, pl );
            }
        }
    },

    methods: {
    }
    }


</script>
