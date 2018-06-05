<template>
    <div class="item-selection-modal modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="modalTitle">
                        <h3 class="title is-3">Previously created items</h3>
                    </slot>
                </p>
                <a class="button is-primary" aria-label="close" v-on:click="toggleModal">Done</a>
            </header>

            <section class="modal-card-body">
                <item-list
                        :hidden-items="hiddenItems"
                        :selected-items="selectedItems"
                        v-on:item-selected="handleSelection"
                >

                    <h4 slot="heading" class="subtitle is-5">Clicking an item imports it into this exam. You will be able to directly compare student performance across different exams.</h4>

                </item-list>
                <slot name="modalBody"></slot>
            </section>

            <footer class="modal-card-foot">
                <button class="button" v-on:click="toggleModal">Cancel</button>
            </footer>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import itemList from '../menus/existing-items-list.vue';

    export default {

        props: [
            'isVisible', //whether the modal is currently visible
            'selectAction' //what to do with rows when they are selected
        ],

        components: {
            'item-list': itemList
        },

        data: function () {
            return {

                //items which the list will not display
                hiddenItems: [],
                //items which the list will display as active
                selectedItems: [],
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleSelection: function ( itemObject ) {
                this.$emit( 'item-selected', itemObject );
                switch ( this.selectAction ) {
                    case 'highlight':
                        this.selectedItems.push(itemObject);
                        break
                    case 'remove':
                        this.hiddenItems.push(itemObject);
                        break;
                }

            },

            toggleModal: function () {
                this.$emit( 'toggle-modal' )

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>