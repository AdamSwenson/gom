<template>
    <div class="cutoff-field">

        <div class="field has-addons">
            <p class="control">
                <span class="sr-only">{{letterGrade}}</span>
                <input class="input minScore"
                       type="number"
                       placeholder="Cutoff score"
                       v-model="minScore"
                >
            </p>
            <p v-if="showButtons" class="control">
                <a class="button is-primary " v-on:click="increment">
                    <span class="icon">
                        <i class="fa fa-plus" aria-hidden="true"></i></span>
                </a>
            </p>
            <p v-if="showButtons" class="control">
                <a class="button is-info "
                   v-on:click="decrement">
                    <span class="icon"><i class="fa fa-minus" aria-hidden="true"></i></span>
                </a>
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
                showButtons: false,
                defaults: {}
            }
        },

        asyncComputed: {},

        computed: {

            letterGrade: function () {
                return !_.isUndefined(this.grade) ? this.grade.displayValue : '';
            },

            /**
             * The lowest score one can receive and still
             * get the represented grade
             */
            minScore: {
                get: function () {
                    return !_.isUndefined(this.grade) ? this.formatForDisplay(this.grade.minScore) : '';
                },

                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.grade,
                        //these will be used by the mutation, though not the
                        //request to the server which just sends the object
                        updateProp: 'minScore',
                        updateVal: Number.parseFloat(v)
                    } );
                    this.$store.dispatch(aTypes.updateCutoff, pl);
                    // this.$store.commit( mTypes.updateGradeCutoffs, pl );
                }
            },

        },

        methods: {
            increment: function () {
                this.minScore += 1;
            },
            decrement: function () {
                this.minScore -= 1;
            },
            formatForDisplay: function ( value ) {
                return _.round( value, 2 );
            },

        },

        directives: {},

        events: {},

    }
</script>