<template>
    <a class="button grade-exam-button is-success is-outlined"
    v-on:click="handleClick"
    >
        <span class="icon is-small">
            <i class="fa fa-check" aria-hidden="true"></i>
        </span>
        <span>Grade it!</span>
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
            handleClick: function (  ) {
                this.$emit('grade-currently-selected-exam');
                //
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>