<template>

    <a class="show-all-kumi-control"
       v-if="isVisible"
       v-on:click="showAllKumi"
       v-bind:class="styling"
    >All</a>

</template>

<style lang="scss">

</style>

<script>

    export default {

        props: [ 'type', 'isActive', 'isVisible' ],

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            /**
             * List of kumis which we are currently filtering by
             * @returns {module.exports.getters.getKumisToFilterStudentsBy}
             */
            displayedKumis: function () {
                return this.$store.getters.getKumisToFilterStudentsBy;
            },


            styling: function () {
                let out = '';
                switch ( this.type ) {
                    case  'tab':
                        out += ' tab ';
                        break;

                    case 'button':
                        out += ' button ';
                        out += 'is-outlined is-primary';
                        break;
                }

                return out;
            }
        },

        methods: {
            showAllKumi: function () {
                this.$store.commit( 'clearKumisToFilterStudentsBy' );
            },
        },

    }
</script>