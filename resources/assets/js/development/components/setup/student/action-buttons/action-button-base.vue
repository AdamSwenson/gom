<template>
    <a class="button "
       v-bind:id="button.id"
       v-bind:class="button.class"
       v-on:click="handleClick"
    >{{ button.label }}</a>

</template>

<style lang="scss">

</style>

<script>
    // import AutoClosingModal from "../../../modals/auto-closing-modal";
    // import ConfirmationModal from "../../../modals/confirmation-modal";
    //
    // export default {
    //     components: {
    //         ConfirmationModal,
    //         AutoClosingModal
    //     },

        // mixins : [mixin]



    // }
</script>