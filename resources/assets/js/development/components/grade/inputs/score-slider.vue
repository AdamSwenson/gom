<template>
    <!-- score slider -->
    <div class="field">
        <label></label>
        <div class="control">
            <input type="text"
                   class="slider"
            >
        </div>
        <p class="help"></p>
    </div>

</template>

<style lang="scss">

</style>

<script>
    export default {

        props: ['item'],

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