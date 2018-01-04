<template>
    <a class="button remove-kumi-control"
       v-bind:class="styling"
       v-on:click="removeKumi"
    >
        <span class="icon is-small"><i class="fa fa-recycle" aria-hidden="true"></i></span>
        <span class="is-small">Remove</span>
        <span class="sr-only">Remove group button</span>
    </a>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            styling: function () {
                return 'is-outlined is-small';
            }

        },

        methods: {

            removeKumi: function ( evt ) {
                //should open a pane for creating or editing kumi
                let kumi = new Kumi(); //completely empty
                this.$store.dispatch( 'removeKumi', Payload.factory( { obj: kumi } ) );
                //toggle open the edit fields if not already displayed
                this.notifyParent();
            },


            /**
             * Let's any listening parent know that
             * the new kumi processes have been called
             */
            notifyParent: function () {
               return this.$emit( 'removeKumi' );
            },
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>