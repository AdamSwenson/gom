<template>
    <div class="modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="modalTitle">
                        <h3 class="title is-3">Previously created exams</h3>
                    </slot>
                </p>
                <a class="button is-primary" aria-label="close" v-on:click="toggleModal">Done</a>
            </header>

            <section class="modal-card-body">
                <exam-list
                        :hidden-exams="hiddenExams"
                        :selected-exams="selectedExams"
                        v-on:exam-selected="handleSelection"
                >

                    <h4 slot="heading" class="subtitle is-5">Select the exam to switch to.</h4>

                </exam-list>
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
    import itemList from './existing-exams-list.vue';

    export default {

        props: [
            'isVisible', //whether the modal is currently visible
            'selectAction' //what to do with rows when they are selected
        ],

        components: {
            'exam-list': itemList
        },

        data: function () {
            return {

                //item object representing exams which the list will not display
                hiddenExams: [],
                //items which the list will display as active
                selectedExams   : [],
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleSelection: function ( itemObject ) {
                window.console.log( 'exam-selection-modal', 'handleSelection', 70, itemObject);
                this.$emit( 'exam-selected', itemObject );
                switch ( this.selectAction ) {
                    case 'highlight':
                        this.selectedExams.push(itemObject);
                        break
                    case 'remove':
                        this.hiddenExams.push(itemObject);
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