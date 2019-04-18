<template>
    <nav class="navbar top-navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <!-- navbar items, navbar burger... -->

            <a role="button"
               class="navbar-burger"
               aria-label="menu"
               aria-expanded="false"
               v-on:click="toggleNavMenu"
               v-bind:class="burgerActiveClass"
            >
                <!--These empty tags are required by bulma-->
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu" v-bind:class="burgerActiveClass">
            <div class="navbar-start"></div>
            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <create-exam-button></create-exam-button>

                        <!--<div class="navbar-item">-->
                        <select-exam-button></select-exam-button>
                        <!--</div>-->

                        <!--<div class="navbar-item">-->
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
                <div class="navbar-item">
                    <backup-button :exam="exam"></backup-button>
                </div>

                <div class="navbar-item">
                    <settings-button-menu></settings-button-menu>
                </div>

                <div class="navbar-item">
                    <logout-button></logout-button>
                </div>

            </div>
        </div>

    </nav>

</template>

<style lang="scss">

    .top-navbar {
        /*.exam-selection-bar {*/
        /*padding-top: 1em;*/
        /*padding-right: 1em;*/
        /*padding-bottom: 1em;*/
        background-color: inherit;
        //$main-background-color-gradient-limit;

        .navbar-burger {
            color: #DDDDDD;
        }

    }
</style>

<script>


    import gradeButton from './grade-exam-button.vue';
    import examSelectionModal from './exam-selection-modal.vue';
    import CreateExamButton from "./create-exam-button";
    import SelectExamButton from "./select-exam-button";
    import ManageExamButton from "./manage-exam-button";
    import LogoutButton from "./logout-button";
    import SettingsButtonMenu from "./settings-button-menu";

    import BackupButton from './backup-button';

    export default {

        //the currently active exam
        props: [ 'exam', 'pageType' ],

        components: {
            BackupButton,
            SettingsButtonMenu,
            LogoutButton,
            ManageExamButton,
            SelectExamButton,
            CreateExamButton,
            'grade-exam-button': gradeButton,
            'exam-selection-modal': examSelectionModal

        },

        data: function () {
            return {
                showModal: false,
                showMenu: false,
                defaults: {}
            }
        },

        computed: {
            burgerActiveClass: function () {
                if ( this.showMenu ) return 'is-active'
            }
        },

        methods: {
            toggleNavMenu: function () {
                // window.console.log( 'top-navbar', 'toggleNavMenu', 190, this.showMenu);
                this.showMenu = !this.showMenu;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>