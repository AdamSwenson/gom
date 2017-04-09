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
window._ = require('lodash');
    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'
    import Item from '../../models/Item'

    export default {
//        props: [ 'index'],

        data: function () {
            return {
                index: this.$route.params.index,

                title: 'Max Score',

                placeholders: {
                    'score': 100
                },
                defaults:{
                    score:100
                }
            };
        },

        computed: {

            maxScore: {
                get: function () {
                    let item = this.$store.getters.getItemByIndex(this.index);
                    if (item instanceof Item){
                        return item.maxScore
                    }
//
//                    if ( typeof this.index !== 'undefined' ) {
//                        let item = this.$store.getters.getItemByIndex(this.index);
//                        if ( typeof item !== 'undefined' ) {
//                            if (typeof item.maxScore === 'undefined'){
//                                return this.defaults.score;
//                            }
//                            return item.maxScore
//                        }
//                    }
                },

                set: function ( value ) {
                    let item = this.$store.getters.getItemByIndex(this.index);
                    if ( item instanceof Item ) {
                        let pl = Payload.factory({
                            index: this.index,
                            updateProp: 'maxScore',
                            updateVal: _.toInteger(value)
                        });
                        this.$store.commit(mTypes.updateItem, pl);
                    }
                }
            },
        },

        methods: {}
    }


</script>
