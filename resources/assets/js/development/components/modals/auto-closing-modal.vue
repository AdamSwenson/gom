<template>
    <div class="auto-closing-modal modal"
         v-bind:class="[isModalVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background" v-on:click="closeModal"
        ></div>

        <div class="modal-content">
            <div class="notification"
                 v-bind:class="notificationStyles"
            >
                <button class="delete is-large"
                        aria-label="close"
                        v-on:click="closeModal"
                ></button>
                <slot name="modalBodyText">{{ modalText }}</slot>
            </div>
        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>

    import mixin from './modal.mixin';

    export default {
        mixins: [ mixin ],

        props: [ 'content', 'type', 'delay', 'show' ],

        data: function () {
            return {
                modalKind: 'auto-closing',

                mutationNames: {
                    toggleVisibility: 'toggleErrorModal'
                },

                getterNames: {
                    visibility: 'isErrorModalVisible'
                },


                defaults: {
                    delay: 3000,
                    bodyText: "There was a problem. "
                },

            }
        },

        watch: {

            /**
             * We need to watch the visibility property
             * so that if this modal is opened, we can set the
             * timer to automatically close it.
             */
            isModalVisible: function ( val, oldVal ) {
                if ( this.modalKind === 'auto-closing' ) {
                    // window.console.log( 'auto-closing-modal', 'isModalVisible', 58, val, oldVal );
                    //if modal was not visible and now is,
                    //we need to start the timer so it will automatically close
                    if ( val && !oldVal ) this.setAutoCloseDelayTimer();
                }
            }
        },

        computed: {
            // /**
            //  * Whether or not the modal is presently visible
            //  * @returns {*}
            //  */
            // isModalVisible: function () {
            //     //     //use the prop if provided
            //     //     if ( ! _.isUndefined( this.isVisible ) ) return this.isVisible;
            //
            //     //this is defined in the mixin
            //     // return this.isErrorModalVisible;
            //     return this.$store.getters[this.getterNames.visibility];
            // },


            notificationStyles: function () {
                switch ( this.type ) {
                    case 'error':
                        return "is-danger";
                        break;
                    case 'warn':
                        return "is-warning";
                    default:
                        return "is-danger";

                }
            },

            /**
             * How long to wait before closing the modal
             */
            closingDelay : function (  ) {
                if( ! _.isUndefined(this.modalObject) && ! _.isUndefined(this.modalObject.closingDelay)) return this.modalObject.closingDelay;

                return this.defaults.delay;
            }
        },

        methods: {

            /**
             * Sets a timer for the modal being displayed.
             * When time runs out, calls the method to close the modal
             */
            setAutoCloseDelayTimer: function () {
                let me = this;
                setTimeout( function () {
                    me.closeModal();
                }, me.closingDelay )
            },

        },

    }
</script>