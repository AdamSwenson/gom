<template>

    <div class="field is-horizontal">
        <div class="field-body">

            <div class="control delete-operation-area"
                 v-show="showDeleteOperationArea">
                <label class="checkbox"><input class="checkbox student-operation-checkbox"
                                               type="checkbox"
                                               v-bind:id="checkboxId"
                                               v-model="isSelected">Delete</label>
            </div>

            <div class="control remove-operation-area"
                 v-show="showRemoveOperationArea">
                <label class="checkbox">
                    <input class="checkbox student-operation-checkbox"
                           type="checkbox"
                           v-bind:id="checkboxId"
                           v-model="isSelected"
                    />Remove</label>
            </div>

            <div class="control move-operation-area"
                 v-show="showMoveOperationArea"
            >
                <label class="checkbox student-operation-checkbox">
                    <input type="checkbox"
                           class="checkbox"
                           v-bind:id="checkboxId"
                           v-model="isSelected"
                    >Add</label>
            </div>

        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ['serialNumber'],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showOperationCheckbox: function () {
                return this.$parent.showDeleteOperationArea;
            },

            /**
             * Gets the label to display with the checkbox
             * i.e., Delete, Move, Remove
             */
//            operationCheckboxLabel: 'Delete | Move | Remove',


            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showDeleteOperationArea: function () {
                return this.$parent.showDeleteOperationArea;
            },

            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showMoveOperationArea: function () {
                return this.$parent.showMoveOperationArea;
            },

            /**
             * Whether to display the checkbox by which
             * the student is selected for being moved,
             * removed, or deleted
             */
            showRemoveOperationArea: function () {
                return this.$parent.showRemoveOperationArea;
            },

            /**
             * Whether this row is selected
             */
            isSelected: {
                get: function () {
                    return this.$parent.isSelected;
                },
                set: function ( v ) {
                    this.$parent.isSelected = v;
                }
            },
        },

        methods: {

            checkboxId: function () {
                return 'student-operation-checkbox-' + this.serialNumber;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>