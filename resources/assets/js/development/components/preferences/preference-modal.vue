<!--This holds the displayed preference area  -->
<template>
    <div class="preference-modal modal"
         v-bind:class="[isVisible ? 'is-active' : '' ]"
    >
        <div class="modal-background" v-on:click="handleBackgroundClick"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">
                    <slot name="modalTitle">
                        <h3 class="title is-3">{{ title }}</h3>
                    </slot>
                </p>
                <a class="button is-primary" aria-label="close" v-on:click="toggleModal">Done</a>
            </header>

            <section class="modal-card-body">
                <user-preferences v-if="type == 'user'"></user-preferences>
                <grade-page-preferences v-if="type == 'grade'"></grade-page-preferences>
                <setup-page-preferences v-if="type == 'setup'"></setup-page-preferences>
            </section>
        </div>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import UserPreferences from "./user/user-preferences";
    import GradePagePreferences from "./grade/grade-page-preferences";
    import SetupPagePreferences from "./setup/setup-page-preferences";

    import { SettingsLinks } from '../../../api/apiSettings';

    export default {

        props: [ 'type', 'isVisible', //whether the modal is currently visible
        ],


        components: {
            SetupPagePreferences,
            GradePagePreferences,
            UserPreferences
        },

        data: function () {
            return {
                links: SettingsLinks,
                defaults: {}
            }
        },

        computed: {
            title: function () {
                if(_.isUndefined(this.type) || _.isUndefined(this.links)) return '';

                let t = _.find( this.links, { type: this.type } );

                return ! _.isUndefined(t) ? t.text : '';
            }
        },

        methods: {
            toggleModal: function () {
                this.$router.push('/');
                this.$emit( 'toggle-modal' )
            },
            handleBackgroundClick: function (  ) {
                this.toggleModal();
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>