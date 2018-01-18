<template>

    <div id="term-input"
    >
        <input-and-selector
                :options="terms"
                :item="exam"
                item-prop="term"
                :input-value="term"
                type="term"
                v-on:update="handleValueChange"
        >
            <!--<div slot="label">Term</div>-->
            <div slot="disabledOption">{{disabledOption}}</div>
            <div slot="helpText">{{ helpText }}</div>

        </input-and-selector>

    </div>


</template>

<style lang="scss">

</style>

<script>
    import InputAndSelector from "./input-and-selector.vue";

    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload'

    export default {

        props: [
            'exam',
        ],

        components: { InputAndSelector },

        data: function () {
            return {
                disabledOption: 'Term',
                helpText: 'terms are good',

                defaults: {
                    terms: [ 'fall', 'winter', 'spring', 'summer' ],
                }
            }
        },

        computed: {

            terms: function () {
                return this.defaults.terms;
            },

            term: function (  ) {
                if(this.exam) return this.exam.term;
                return '';
            }

        },

        methods: {
            handleValueChange: function ( v ) {
                window.console.log( 'term-input', 'handleValueChange', 57, v);
                this.$store.commit( mTypes.updateItem, Payload.factory( {
                    index: 0,
                    updateProp: 'term',
                    updateVal: v
                } ) );

            }
        },

    }
</script>