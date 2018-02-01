<template>
    <div class="item-import">
        <a class="button is-primary is-outlined item-import-button"
           v-on:click="handleClick"
        >
        <span class="icon is-small">
            <i class="fa fa-mail-forward" aria-hidden="true"></i>
        </span>
            <span>Import</span>
        </a>
        <item-select-modal
                :is-visible="showModal"
                select-action="remove"
                v-on:item-selected="handleSelection"
                v-on:toggle-modal="toggleModal"
        ></item-select-modal>
    </div>
</template>


<style lang="scss">

</style>

<script>
    import itemSelectModal from './item-selection-modal.vue';

    import mixin from './item-buttons.mixin';
    export default {
        mixins: [mixin],

        props: ['item'],

        components: {
            'item-select-modal': itemSelectModal
        },

        data: function () {
            return {
                showModal: false,
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleClick: function () {
                //display modal with item selection area
                this.toggleModal();
            },

            handleSelection: function ( itemObject ) {
                //when an item is selected, dispatch the actions to add it
                window.console.log( 'item-import-button', 'handleSelection', 55, itemObject );
                this.$store.dispatch( 'importItem', { parent: this.parentSerialNumber, obj: itemObject } );
            },

            toggleModal: function () {
                this.showModal = !this.showModal;
            }

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>