<template>
    <div class="feedback-preview-modal modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background" v-on:click="handleBackgroundClick"></div>
        <div class="modal-content">
            <div class="is-pulled-right">
            <button class="button " aria-label="close" v-on:click="handleClose">done</button>
            </div>
            <feedback-panel :exam="exam" :student="student"></feedback-panel>

        </div>

        <button class="modal-close is-large" aria-label="close" v-on:click="handleClose"></button>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';
    import FeedbackPanel from "./feedback-panel";

    export default {

        props: [ 'isVisible' ],

        components: { FeedbackPanel },

        data: function () {
            return {

                defaults: {}
            }
        },

        computed: {
            exam: function () {
                let e = this.$store.getters[ nggTypes.getActiveExam ];
                return !_.isUndefined( e ) ? e : null

            },

            student: function () {
                let s = this.$store.getters[ nggTypes.getActiveStudent ];
                return !_.isUndefined( s ) ? s : null
            },

        },

        methods: {
            handleClose: function () {
                this.$emit( 'close-modal' );
            },
            handleBackgroundClick: function () {
                this.$emit( 'close-modal' );

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>