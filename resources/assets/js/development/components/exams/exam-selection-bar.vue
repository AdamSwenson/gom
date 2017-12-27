<template>
    <div class="exam-selection-bar">
        <nav class="level is-mobile">
            <!-- Left side -->
            <div class="level-left">

                <div class="level-item">
                    <slot name="level-left"></slot>
                </div>
            </div>

            <!-- Right side -->
            <div class="level-right">
                <div class="level-item has-text-centered">
                    <create-exam-button></create-exam-button>
                </div>

                <div class="level-item has-text-centered">
                    <select-exam-button></select-exam-button>
                </div>

                <div class="level-item has-text-centered">
                    <grade-exam-button
                            v-if="pageType === 'setup'"
                            :exam="exam"
                    ></grade-exam-button>

                    <manage-exam-button
                            v-if="pageType === 'grade'"
                            :exam="exam"
                    ></manage-exam-button>
                </div>

            </div>

        </nav>

    </div>


</template>

<style lang="scss">
    .exam-selection-bar {
        padding-top: 1em;
        padding-right: 1em;
        padding-bottom: 1em;

        .level-left {
            p {
                color: #DDDDDD;
                margin-left: 1em;
            }
        }
    }
</style>

<script>
    import gradeButton from './grade-exam-button.vue';
    import examSelectionModal from './exam-selection-modal.vue';
    import { Routes } from '../../../api/apiSettings';
    import * as gTypes from '../../../store/getter-types';
    import CreateExamButton from "./create-exam-button";
    import SelectExamButton from "./select-exam-button";
    import ManageExamButton from "./manage-exam-button";

    export default {

        //the currently active exam
        props: [ 'exam' , 'pageType'],

        components: {
            ManageExamButton,
            SelectExamButton,
            CreateExamButton,
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
        },

        methods: {

        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>