<template>

    <!-- save & finish button -->
    <a id="finishButton"
       class="button is-success "
       v-if="isFinishButtonVisible"
       v-on="handleFinishClick"
    >
        <span class="icon">
            <i class="fa fa-save" aria-hidden="true"><i> Save & Finish </span>
    </a>
</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleFinishClick: function () {

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>