<template>
    <!-- max grade -->
    <div class="max-score-area input-group">

        <span class="input-group-addon"
              id="max-score-addon"
        >{{ title }}</span>
        <input
                type="number"
                min="0"
                title="maximum score for this question"
                class="form-control input max-score-input"
                aria-describedby="max-score-addon"
                v-model="maxScore"
        />
    </div>

</template>
<style lang="scss">
    .max-score-area {
        text-align: left;

    }

    input {
        width: 4em;
        outline: none;
    }

    .max-score-input {
        width: 3em;
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

                placeholders: {
                    'score': 100
                },
            };
        },

        computed: {

            maxScore: {
                get: function () {
                    if ( typeof this.index != 'undefined' ) {
                        let item = this.$store.getters.getItemByIndex( this.index );
                        if ( typeof item != 'undefined' ) {
                            return item.maxScore
                        }
                    }
                    return this.placeholders.score;
//                        return this.getter( 'maxScore' );
                },

                set: function ( v ) {
                    this.setter( 'maxScore', v )
                }

            },
        },

        methods: {
            getter: function ( name ) {
                if ( typeof this.id != 'undefined' ) {
                    let item = this.$store.getters.getItemById( this.id );
                    if ( typeof item != 'undefined' ) {
                        return item[ name ]
                    }
                }
            },

            setter: function ( name, value ) {
                let pl = Payload.factory( {index: this.index, updateProp: name, updateVal: value} );
                this.$store.commit( mTypes.updateItem, pl );
            }
        }
    }


</script>
