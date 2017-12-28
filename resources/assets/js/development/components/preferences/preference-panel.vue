<!--This holds the displayed preference area  -->
<template>
    <div class="preference-panel">

        <div class="container">

            <router-view name="preferencePanelArea"></router-view>

        </div>
    </div>
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
         },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>