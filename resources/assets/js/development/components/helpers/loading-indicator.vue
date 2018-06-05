<template>

    <div class="loading-indicator "
         v-if="isLoading"
    >
        <div class="has-text-centered">
            <i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: [ 'isLoading' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>