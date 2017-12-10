<template>
    <div class="field">
        <label></label>
        <div class="control">
            <span class="sr-only">{{ srText.nameVisibility }}</span>
            <a class="button is-primary"
               id="nameVisibilityControl"
               title="Click to hide or show student names"
               v-on:click="toggleNameVisibility"
            >
                <span class="icon"> {{ icon }}</span>
            </a>
        </div>
        <p class="help"></p>
    </div>

</template>

<style lang="scss">

</style>

<script>


    import * as mTypes from '../../../../store/modules/newgrading/new-grading-mutation-types';
    import * as aTypes from '../../../../store/modules/newgrading/new-grading-action-types';
    import * as gTypes from '../../../../store/modules/newgrading/new-grading-getter-types';

    export default {

        props: [],

        components: {},

        data: function () {
            return {

                icons: {
                    namesVisible: '',
                    namesBlind: ''
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

            isBlind: function () {
                return this.$store.getters[ gTypes.areStudentNamesVisible ];
            }

        },

        methods: {
            toggleNameVisibility: function () {
                this.$store.commit( mTypes.toggleStudentNameVisibility );
            }
        },
    }
</script>