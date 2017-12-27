<template>
    <span>
    <a class="button select-exam-button is-warning is-outlined"
       v-on:click="handleClick"
    >
        <span>{{ label }}</span>
    </a>

        <exam-selection-modal
                :isVisible="showModal"
                v-on:toggle-modal="toggleModal"
                v-on:exam-selected="handleExamSelection"
        ></exam-selection-modal>
    </span>
</template>

<style lang="scss">

</style>

<script>
    import { Routes } from '../../../api/apiSettings';
    import ExamSelectionModal from "./exam-selection-modal";

    export default {

        props: [ 'exam' ],

        components: { ExamSelectionModal },

        data: function () {
            return {
                showModal: false,
                label: 'Change Exam',
                icon: '',
                defaults: {}
            }
        },

        computed: {
            route: function () {
                return window.routeRoot + '/' + Routes.gradeExam( this.exam.id );
            }
        },

        methods: {
            handleClick: function () {
                this.toggleModal();

            },

            handleExamSelection: function ( examObject ) {
                window.console.log( 'exam-selection-bar', 'handleExamSelection', 98, examObject );
                this.toggleModal();
                let route = window.routeRoot + '/' + Routes.setupExam( examObject );
                //handle redirection
//                return this.$router.go( route );

                return window.open( route, "_self" );
//                return window.axios.get( Routes.setupExam( examObject ) );
            },

            toggleModal: function () {
                this.showModal = !this.showModal;
            }
        },

    }
</script>