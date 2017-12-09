<template>
        <a class="edit-kumi-button button is-outlined "
           v-on:click="toggleEditable"
        >
                <span v-if="isEditable">
                    <span class="icon"><i class="fa fa-check-circle-o " aria-hidden="true"></i></span>
                    <span class="">Edit</span>
                    <span class="sr-only">Edit button in selected state</span>
                </span>

            <span v-else>
                    <span class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></span>
                    <span class="">Edit</span>
                    <span class="sr-only">Edit button in unselected state</span>
                </span>

        </a>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ['isEditable', 'type', 'isActive' , 'isVisible'],
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

                if ( this.isActive ) out += ' is-active ';

                return out;
            }
        },

        methods: {
            toggleEditable: function () {
                this.$emit('toggleKumiEditable');
            },

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>