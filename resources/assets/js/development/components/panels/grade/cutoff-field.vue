<template>
    <div class="cut-off-field">

        <div class="field">
            <p class="control">
                <span class="sr-only">{{letterGrade}}</span>
                <input class="input minScore"
                       type="number"
                       placeholder="Cutoff score"
                       v-model="minScore"
                >
            </p>
        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';
    import Payload from '../../../../models/Payload';

    export default {

        props: [
            'grade'
        ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        asyncComputed: {},

        computed: {
            letterGrade: function () {
                return this.grade ? this.grade.displayValue : '';
            },

            /**
             * The lowest score one can receive and still
             * get the represented grade
             */
            minScore: {
                get: function () {
                    return this.grade ? this.grade.minScore : '';
                },

                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.grade,
                        updateProp: 'minScore',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateGradeCutoffs, pl );
                }
            },

        },

        methods: {},

        directives: {},

        events: {},

    }
</script>