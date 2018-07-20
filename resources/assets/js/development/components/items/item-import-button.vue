<template>
    <div class="item-import-button">
        <item-button-fillable
                :property-object="properties"
                v-on:button-clicked="handleClick"
        ></item-button-fillable>

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

    import itemButtonFillable from './item-button-fillable';
    import mixin from './item-buttons.mixin';

    export default {

        mixins: [ mixin ],

        props: [ 'item' ],

        components: {
            itemButtonFillable,
            itemSelectModal
        },

        data: function () {
            return {
                properties : {
                    buttonText:'Import',
                    icon: 'fa fa-mail-forward',
                    identifyingClass:'item-import-button',
                    linkClass:'is-primary is-outlined',
                    linkTitle:'Import an existing item ',
                    screenReaderText:'Click to import an item from another exam'
                },

                showModal: false,


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

    }
</script>