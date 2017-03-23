<template>

    <div class="question-num-area input-group">
        <span class="input-group-addon"
              id="basic-addon11111"
        >{{ displayType }}</span>
        <input
               type="number"
               min="0"
               title="order of the question on the exam"
               class="form-control input"
               aria-describedby="basic-addon11111"
               v-model="questionNumber"/>
    </div>

</template>
<style>
    input{
        width: 6em;
    }

</style>
<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
        props: [ 'index', 'id' ],
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
                    this.setter( 'number', v );
                    // let pl = Payload.factory( {index: this.index, updateProp: 'number', updateVal: v} );
                    // this.$store.commit( mTypes.updateItem, pl );
                }

            },

        },

        methods: {
            getter: function ( name ) {
                let item = this.$store.getters.getItemById( this.id );
                if ( typeof item != 'undefined' ) {
                    return item[ name ]
                }
            },

            setter: function ( name, value ) {
                let pl = Payload.factory( {index: this.index, updateProp: name, updateVal: value} );
                this.$store.commit( mTypes.updateItem, pl );
            }
        }
    }

</script>
