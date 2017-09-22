<template>
    <div class="modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="modalTitle"></slot>
                </p>
                <button class="delete" aria-label="close" v-on:click="handleCancellation"></button>
            </header>

            <section class="modal-card-body">
                <slot name="modalBody"></slot>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-success"
                        v-on:click="handleConfirmation"
                >
                    <slot name="confirmationButtonLabel">Confirm</slot>
                </button>
                <button class="button" v-on:click="handleCancellation">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    //This is the confirmation modal used by lots of stuff
    export default {

        props: ['isVisible'],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleCancellation: function () {
                this.$emit( 'cancel-selected' );
            },
            handleConfirmation: function () {
                this.$emit( 'confirm-selected' );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>