<template>
    <div class="columns">
        <div class="column is-one-quarter stat-label">
            <slot name="label"></slot>
        </div>
        <div class="column stat-value">
            <slot name="value" ></slot>
        </div>
    </div>

</template>

<style lang="scss">
.stat-label{
    font-weight: bold;
}
    .stat-value{

    }
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

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>