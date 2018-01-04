<template>
    <a class="button new-kumi-control"
       v-bind:class="styling"
       v-on:click="newKumi"
    >
        <span class="icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
        <span class="">Create</span>
        <span class="sr-only">Create new group button</span>
    </a>

</template>

<style lang="scss">

</style>

<script>
    import Payload from "../../../../models/Payload";
    import Kumi from "../../../../models/Kumi";

    export default {

        props: ['type', 'isVisible'],

        components: {},

        data: function () {
            return {

                defaults: {}
            }
        },

        computed: {
            styling: function () {

                    let out = '';
                    switch ( this.type ) {
                        case  'tab':
                            out += ' tab ';
                            break;
                        case 'button':
                            out += ' button ';
                            out += 'is-outlined is-primary';
                            break;
                    }


                    return out;

            }
        },

        methods: {

            newKumi: function ( evt ) {
                //should open a pane for creating or editing kumi
                let kumi = new Kumi(); //completely empty
                this.$store.commit( 'addKumi', Payload.factory( { obj: kumi } ) );
                //toggle open the edit fields if not already displayed
                this.notifyParent();
            },


            /**
             * Let's any listening parent know that
             * the new kumi processes have been called
             */
            notifyParent: function () {
                return this.$emit( 'showKumiEditFields' );
            },
        },

    }
</script>