<template>
    <div class="feedback-preview">
        <a class="button is-info is-outlined"
           aria-haspopup="true"
           aria-controls="dropdown-menu"
           v-on:click="toggleModal"
        >Preview feedback </a>

        <feedback-preview-modal
                :is-visible="isVisible"
                v-on:close-modal="toggleModal"
        ></feedback-preview-modal>

    </div>

</template>

<style lang="scss">

</style>

<script>
    import FeedbackPreviewModal from "./feedback-preview-modal";

    export default {

        props: [],

        components: { FeedbackPreviewModal },

        data: function () {
            return {
                isVisible: false,
                defaults: {}
            }
        },

        computed: {},

        methods: {
            toggleModal: function () {
                window.console.log( 'feedback-preview-button', 'toggleModal', 41, );
                this.isVisible = !this.isVisible;
            },
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>