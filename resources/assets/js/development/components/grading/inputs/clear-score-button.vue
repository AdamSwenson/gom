<template>
    <a class="clear-score-button button is-primary is-small"
       title="Set the item score to be blank, rather than 0"
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