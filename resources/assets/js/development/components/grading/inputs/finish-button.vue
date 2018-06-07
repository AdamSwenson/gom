<template>
    <a class="finish-button button is-success "
       v-if="isFinishButtonVisible"
       v-on="handleFinishClick"
    >
        <span class="icon">
            <i class="fa fa-save" aria-hidden="true"> Save & Finish </i></span>
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

        computed: {
            isFinishButtonVisible : function (  ) {
                return false;
            }
        },

        methods: {
            handleFinishClick: function () {
                window.console.log( 'finish-button', 'handleFinishClick', 39, );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>