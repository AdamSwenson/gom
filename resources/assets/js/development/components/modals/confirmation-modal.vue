<template>
    <div class="confirmation-modal modal"
         v-bind:class="[isModalVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"
             v-on:click="handleCancellation"
        ></div>

        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">

                    <slot name="modalTitle"></slot>

                </p>
                <button class="delete"
                        aria-label="close"
                        v-on:click="handleCancellation"></button>
            </header>

            <section class="modal-card-body">

                <slot name="modalBody">{{ modalText}}</slot>

            </section>

            <footer class="modal-card-foot ">
                <div class="container">
                    <div class="content has-text-right">
                        <a class="button is-warning "
                           v-on:click="handleCancellation"
                        >Cancel
                        </a>

                        <a class="button is-success "
                           v-on:click="handleConfirmation"
                        >
                            <slot name="confirmationButtonLabel">Confirm</slot>
                        </a>

                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>

    import mixin from './modal.mixin';

    /**
     * This is the confirmation modal used by lots of stuff
     * At the very least, it needs to be provided text to go
     * in the main modal body area using the slot `modalBody`
     *
     * Clicking on the background fires the cancellation event.
     *
     * Other slots include:
     *      modalTitle
     *      confirmationButtonLabel
     */
    export default {

        mixins: [ mixin ],

        props: [ 'isVisible' ],

        components: {},

        data: function () {
            return {
                mutationNames: {
                    toggleVisibility: 'toggleConfirmationModal'
                },

                getterNames: {
                    visibility: 'isConfirmationModalVisible'
                },

                defaults: {
                    bodyText: "Are you sure. "
                },
            }
        },

        computed: {
            isModalVisible: function () {
                //If the prop is set, use it
                if ( !_.isUndefined( this.isVisible ) ) return this.isVisible;

                return this.isConfirmationModalVisible;
            },

        },

        methods: {
        },

    }
</script>