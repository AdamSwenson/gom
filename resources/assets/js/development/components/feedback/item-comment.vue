<template>
    <p class="item-comment">
             {{text}}
    </p>
</template>

<style lang="scss">

</style>

<script>
    import * as nggTypes from '../../../store/new-grading-getter-types';

    import feedbackMixin from './feedback.mixin';

    export default {
        mixins: [ feedbackMixin ],
        props: [ 'item', 'student' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {

            text: function () {
                return this.scoreObject ? this.scoreObject.text : '';
            },

        },

    }
</script>