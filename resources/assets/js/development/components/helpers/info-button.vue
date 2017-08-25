<template>
    <div class="info-button">
        <span class="icon"
             v-on:click="toggleHelp"
        >
            <i class="fa fa-question-circle"></i>
        </span>

        <div class="modal"
             v-bind:class="isActive"
        >
            <div class="modal-background"
                 v-on:click="toggleHelp"></div>
            <div class="modal-content">
                {{ displayText }}
            </div>
            <button class="modal-close is-large" aria-label="close"v-on:click="toggleHelp" ></button>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [ 'helpText' ],

        components: {},

        data: function () {
            return {
                showHelp: false,
                defaults: {}
            }
        },

        computed: {
            //Separated off in case we later
            //want to apply some standard transformation or styling
            //to help text
            displayText: function (  ) {
                return this.helpText;
            },

            isActive: function (  ) {
                if(this.showHelp) return 'is-active';
                return '';
            }
        },

        methods: {
            toggleHelp: function () {
                window.console.log( 'info-button', 'toggleHelp', 43, this.showHelp);
                this.showHelp = ! this.showHelp;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>