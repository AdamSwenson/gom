<template>
    <div id="student-action-buttons"
         v-bind:class="styling"
    >
        <div id="confirmationButtonsArea"
             class="field is-grouped is-fullwidth"
             v-if="isKumiSelectorVisible"
        >
            <p class="control">
                <kumi-selector-visibility-button v-on:toggled="operationType = false">
                    <span slot="label">Cancel</span>
                </kumi-selector-visibility-button>
            </p>

            <p class="control" v-if="operationType === 'add'">
                <add-students-to-group-button></add-students-to-group-button>
            </p>

            <p class="control" v-if="operationType === 'remove'">
                <remove-students-from-group-button></remove-students-from-group-button>
            </p>
        </div>

        <div id="kumi-selector-area"
             v-else
        >
            <div class="buttons">
             <!--class="field is-grouped is-fullwidth"-->

            <!--<p class="control">-->
                <kumi-selector-visibility-button v-on:toggled="operationType = 'add'">
                    <span slot="label">Add to groups</span>
                </kumi-selector-visibility-button>
            <!--</p>-->

            <!--<p class="control">-->
                <kumi-selector-visibility-button v-on:toggled="operationType = 'remove'">
                    <span slot="label">Remove from groups</span>
                </kumi-selector-visibility-button>
            <!--</p>-->

            <!--<p class="control">-->
                <remove-students-from-roster-button></remove-students-from-roster-button>
            <!--</p>-->
            </div>
        </div>

        <auto-closing-modal></auto-closing-modal>
        <confirmation-modal></confirmation-modal>
    </div>

</template>

<style lang="scss">

</style>

<script>

    import RemoveStudentsFromRosterButton from "./remove-students-from-roster-button";
    import AddStudentsToGroupButton from "./add-students-to-group-button";
    import RemoveStudentsFromGroupButton from "./remove-students-from-group-button";
    import KumiSelectorVisibilityButton from "../../kumi/kumi-selector-visibility-button";
    import AutoClosingModal from "../../../modals/auto-closing-modal";
    import ConfirmationModal from "../../../modals/confirmation-modal";

    export default {

        props: [ '' ],

        components: {
            ConfirmationModal,
            AutoClosingModal,
            KumiSelectorVisibilityButton,
            RemoveStudentsFromGroupButton,
            AddStudentsToGroupButton,
            RemoveStudentsFromRosterButton,
        },


        data: function () {
            return {
                operationType: false,
            }
        },

        computed: {
            styling: function () {
                return this.injectableClasses;
            },

            /** Includes kumiSelectorVisible so that anything in the label
             * can change with the list state
             */
            isKumiSelectorVisible: function () {
                return this.$store.getters.isKumiSelectVisible;
            },

        }
    }
</script>