<template>
    <div class="exam-selection-bar">
        <nav class="level is-mobile">
            <!-- Left side -->
            <div class="level-left">
                <!--<div class="level-item">-->
                <!--</div>-->
            </div>

            <!-- Right side -->
            <div class="level-right">
                <div class="level-item has-text-centered">
                    <a class="button is-primary is-outlined" v-on:click="handleNewExamClick">
                        <span>New exam</span>
                    </a>
                </div>

                <div class="level-item has-text-centered">
                    <a class="button is-warning is-outlined"
                       v-on:click="handleChangeExam">
                        <span>Change Exam</span>
                    </a>
                </div>

                <div class="level-item has-text-centered">
                    <grade-exam-button
                            v-on:grade-exam-clicked="handleGradeExamClick"
                    ></grade-exam-button>
                </div>

            </div>

        </nav>

        <exam-selection-modal
                :isVisible="showModal"
                v-on:toggle-modal="toggleModal"
                v-on:exam-selected="handleExamSelection"
        ></exam-selection-modal>

    </div>


</template>

<style lang="scss">
    .exam-selection-bar {
        padding-top: 1em;
        padding-right: 1em;
    }

</style>

<script>
    import gradeButton from './grade-exam-button.vue';
    import examSelectionModal from './exam-selection-modal.vue';
    import { Routes } from '../../../api/apiSettings';

    export default {

        props: [],

        components: {
            'grade-exam-button': gradeButton,
            'exam-selection-modal': examSelectionModal

        },

        data: function () {
            return {
                showModal: false,
                defaults: {}
            }
        },

        computed: {

            newExamPath: function () {
                return window.routeRoot + '/' + Routes.commonBaseRoute;
            },
        },

        methods: {
            handleGradeExamClick: function () {
                window.console.log( 'exam-selection-bar', 'handleGradeExamClick', 85, );
            },

            handleChangeExam: function () {
                this.toggleModal();
            },


            handleNewExamClick: function () {
                //handle redirection
                let route = window.routeRoot + '/' + Routes.commonBaseRoute;
                //handle redirection
//                return this.$router.go( route );
                return window.open( route, "_self" );
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

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>