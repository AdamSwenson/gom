<template>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-small valence-button"
                v-bind:class="classObject"
                v-on:click="selectValence"
        >{{ valence }}</button>
    </div>

</template>
<style>

</style>
<script>
    export default{
        props: [ 'valence' ],

        data: function () {
            return {

            }
        },

        computed: {

            active: function () {
                if ( this.$parent.displayedValence == this.valence ) {
                    return true
                }
                return false;
            }
            ,

            classObject: function(){
                return {
                    'btn-info': this.active,
                    'btn-primary': ! this.active
                }
            }

        }
        ,
        methods: {
            /**
             * Called when the valence button is clicked
             */
            selectValence: function () {
                return this.sendRequest();
            }
            ,

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
                return this.$store.dispatch( 'please-change-valence', this.valence );
            }
        }
    }
</script>
