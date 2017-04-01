<template>

    <div class="question-num-area">
        <label for="question-number-label"
        >{{ displayType }}</label>
        <input
                id="question-number-label"
                type="number"
                min="0"
                title="order of the item on the assignment"
                v-model="questionNumber"/>
    </div>

</template>
<style>
    .item-type {
        font-weight: bold;
    }

    input {
        width: 4em;
        outline: none;
    }

</style>
<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
        props: [ 'index' ],
        data: function () {
            return {
                placeholders: {},
            };
        },

        computed: {

            displayType: {
                get: function () {
                    //if question, return q number
                    return '#';
                    //if element, return order
                },
                set: function ( v ) {
                }
            },

            questionNumber: {
                get: function () {
                    return this.index;
//                    return this.getter( 'number' );
                },

                set: function ( v ) {
//                    this.setter( 'number', v );
                    let pl = Payload.factory({index: this.index, updateProp: name, updateVal: value});
                    this.$store.commit(mTypes.updateItem, pl);
                    // let pl = Payload.factory( {index: this.index, updateProp: 'number', updateVal: v} );
                    // this.$store.commit( mTypes.updateItem, pl );
                }

            },

        },

        methods: {}
    }

</script>
