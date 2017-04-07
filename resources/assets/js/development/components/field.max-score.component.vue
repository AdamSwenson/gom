<template>
    <!-- max grade -->
    <div class="max-score-area input-group">

        <span class="input-group-addon"
              id="max-score-addon"
        >{{ title }}</span>
        <input
                type="number"
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
//        props: [ 'index'],

        data: function () {
            return {
                index: this.$route.params.index,

                title: 'Max Score',

                placeholders: {
                    'score': 100
                },
            };
        },

        computed: {

            maxScore: {
                get: function () {
                    if ( typeof this.index !== 'undefined' ) {
                        let item = this.$store.getters.getItemByIndex(this.index);
                        if ( typeof item !== 'undefined' ) {
                            return item.maxScore
                        }
                    }

//                    return this.placeholders.score;
                },

                set: function ( value ) {
                    let pl = Payload.factory({
                        index: this.index,
                        updateProp: 'maxScore',
                        updateVal: value
                    });
                    this.$store.commit(mTypes.updateItem, pl);
                }

            },
        },

        methods: {}
    }


</script>
