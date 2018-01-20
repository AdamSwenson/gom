<template>

    <a v-if="isVisible"
       v-on:click="showAllKumi"
       v-bind:class="styling"
    >All</a>

</template>

<style lang="scss">

</style>

<script>

    export default {

        props: [ 'type', 'isActive' , 'isVisible'],

        components: {},

        data: function () {
            return {

                defaults: {}
            }
        },

        computed: {
            displayedKumis: function () {
                return this.$store.getters.getDisplayedKumis;
            },

            styling: function () {
                let out = '';
                switch ( this.type ) {
                    case  'tab':
                        out += ' tab ';

                        if(this.displayedKumis && this.displayedKumis.length === 0) out += 'is-active';

                        break;
                    case 'button':
                        out += ' button ';
                        out += 'is-outlined is-primary';
                        break;
                }

                if ( this.isActive ) out += ' is-active ';

                return out;
            }
        },

        methods: {
            showAllKumi: function () {
                this.$store.commit( 'clearDisplayedKumis' );
            },

        },

    }
</script>