<template>
    <!-- max grade -->
    <div class="max-score-area input-group">

        <span class="input-group-addon"
              id="basic-addon"
        >{{ title }}</span>
        <input
                type="number"
                min="0"
                title="maximum score for this question"
                class="form-control input"
                aria-describedby="basic-addon"
                v-model="maxScore"
        />
    </div>

</template>
<style>
    .max-score-area {
        text-align: left
    }

    input {
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
                title: 'Max Score',

                placeholders: {},
            };
        },

        computed: {

            maxScore: {
                get: function () {
                    return this.getter( 'maxScore' );
                },

                set: function ( v ) {
                    this.setter( 'maxScore', v )
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
