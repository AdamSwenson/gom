<template>
    <div class="modal"
         v-bind:class="[isModalVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"></div>

        <div class="modal-content">
            <div class="notification"
                 v-bind:class="notificationStyles"
            >
                <button class="delete is-large"
                        aria-label="close"
                        v-on:click="closeModal"
                ></button>
                {{content}}
            </div>
        </div>

    </div>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ['content', 'type', 'delay', 'show'],

        data: function () {
            return {
                defaults: {
                    delay: 3000
                },

                isModalVisible: false
            }
        },

        watch:{
          show: function(val, oldVal){
              this.isModalVisible = val;
          }
        },

        computed: {

            notificationStyles: function (  ) {
                switch(this.type){
                    case 'error':
                        return "is-danger";
                        break;
                    default:
                        return "is-danger";

                }
            }
        },

        methods: {
            closeModal: function () {
                this.isModalVisible = false;
            },

            /**
             * Opens the modal for the set amount of time
             * then closes it
             */
            openAutoClosingModal: function (  ) {
                delay = ! _.isUndefined(delay) ? delay : this.defaults.delay;

                this.isModalVisible = true;
                let me = this;
                setTimeout( function () {
                    me.closeModal();
                }, delay )
            },


        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>