<script>
    /**
     * This defines the parent class for all buttons in the top navbar
     * Inheritors of this class need to define the following properties:
     *      buttonText (optional)
     *      screenReaderText: '',
     *      icon: "",
     *      linkTitle: '',
     *      linkClass: '',
     *      identifyingClass: '',
     * and the method:
     *      handleClick
     */
    export default {
        name: "navbar-button-base",

        data: function () {
            return {
                screenReaderText: '',
                icon: "",
                linkTitle: '',
                linkClass: '',
                identifyingClass: '',
                buttonText: '',
                defaults: {}
            }
        },

        computed: {
            iconSize: function () {
                if ( this.buttonText.length > 0 ) return 'is-small'
            }
        },

        methods: {
            handleClick: function () {

            }
        }
    }
</script>
<template>
    <p class="field"
       v-bind:class="identifyingClass"
    >
        <a class="button "
           v-bind:class="linkClass"
           v-bind:title="linkTitle"
           v-on:click="handleClick"
        >
            <span class="icon "
                  v-bind:class="iconSize"
            >
                <i aria-hidden="true"
                   v-bind:class="icon"
                >
                    <span class="sr-only">{{screenReaderText}}</span>
                </i>
            </span>

            <span
            v-if="buttonText.length >0">{{buttonText}}</span>
        </a>
    </p>

</template>

<style scoped>

</style>