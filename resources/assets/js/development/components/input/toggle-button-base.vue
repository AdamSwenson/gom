<script>
    /**
     * This is the parent of buttons which toggle between
     * two states and have their icon, text, and screen reader properties
     * change with the state.
     */

    export default {

        props: [],

        components: {},
        data: function () {
            return {
                buttonId: "",
                styling: '',
                icons: {
                    off: '',
                    on: ''
                },

                text: {
                    on: "",
                    off: "",
                },
                srText: {
                    on: '',
                    off: ''
                },

                title: "",

            }
        },

        computed: {
            buttonText: function () {
            },
            srTextDisplay: function () {
            },
            computedStyling: function () {
                return this.styling;
            }
        },

        methods: {
            toggle: function () {
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>

<template>

    <a class=" button "
       v-bind:id="buttonId"
       v-bind:title="title"
       v-bind:class="computedStyling"
       v-on:click="toggle"
    >
        <span class="sr-only">{{ srTextDisplay }}</span>

        <span class="icon is-small">
              <i v-bind:class="icon" aria-hidden="true"></i>
        </span>
        <span class="button-text"> {{ buttonText }} </span>

    </a>

</template>

<style lang="scss">

</style>
