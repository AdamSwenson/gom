<template>

            <a class="button is-primary"
               id="nameVisibilityControl"
               title="Click to hide or show student names"
               v-on:click="toggleNameVisibility"
            >  <span class="sr-only">{{ srText.nameVisibility }}</span>

                <span class="icon is-small">
                            <i v-if="!isBlind" class="fa fa-pencil" aria-hidden="true"></i>
                        </span>

                <!--<i v-if="isBlind"  class="fa fa-space-shuttle"></i>-->
                                        <!--<i v-if="! isBlind "  class="fa fa-fighter-plane"></i>-->
                <!--</span>-->
            </a>

</template>

<style lang="scss">

</style>

<script>


    import * as ngmTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as ngaTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as nggTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    export default {

        props: [],

        components: {},

        data: function () {
            return {

                icons: {
                    namesVisible: 'fa fa-space-shuttle',
                    namesBlind: 'fa fa-rocket'
                },

                srText: {
                    nameVisibility: 'Click to hide student names and grade blind',
                },
                defaults: {}
            }
        },

        computed: {
            icon: function () {
                return this.studentNamesVisible ? this.icons.namesVisible : this.icons.namesBlind;
            },

            /**
             * Whether student names should be hidden
             * with only the identifiers displayed
             */
            isBlind: function () {
                return this.$store.getters[ nggTypes.areStudentNamesVisible ];
            }

        },

        methods: {
            toggleNameVisibility: function () {
                this.$store.commit( ngmTypes.toggleStudentNameVisibility );
            },

        },
    }
</script>