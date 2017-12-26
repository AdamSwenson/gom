<template>
    <a class="button is-primary is-small"
       v-on:click="handleClick"
    >Reset score</a>
</template>

<style lang="scss">

</style>

<script>

    import scoreInputMixin from './scoreInputMixin';

    export default {
        mixins: [
            scoreInputMixin
        ],

        props: [ 'item', 'student' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {},

        methods: {
            handleClick: function () {
                this.$store.dispatch( 'resetItemScore', {
                    exam: this.exam,
                    item: this.item,
                    student: this.student
                } );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>