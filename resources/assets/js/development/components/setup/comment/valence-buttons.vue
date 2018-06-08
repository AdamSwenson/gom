<template>

    <div class="valence-buttons field ">
        <p class="control">
            <button type="button"
                    class="button valence-button"
                    v-bind:id="buttonId(valence)"
                    v-on:click="setValence(valence)"
                    v-bind:class="styling(valence)"
                    v-for="valence in valences" :key="valence">{{valence}}
            </button>
        </p>
    </div>

</template>
<style>

</style>
<script>

    import Comment from '../../../../models/Comment';

    export default{
        props: ['displayedValence'],

        data: function () {
            return {
                events: {
                    changeValence : 'please-change-valence'
                },
                valence: 'stock'
            }
        },


        computed: {
            valences: function () {
                return Comment.valences;
            },
            //
            // displayedValence: function () {
            //     return this.$parent.displayedValence;
            // }
        },

        methods: {
            buttonId: function ( valence ) {
                return valence + '-button';
            },

            styling: function ( valence ) {
                if ( valence === this.displayedValence ) {
                    return 'is-primary';
                }
                return 'is-info  is-outlined';
            },

            /**
             * Called when the valence button is clicked
             */
            setValence: function ( valence ) {
                this.valence = valence;
              this.$emit(this.events.changeValence, valence);
                //  this.$parent.changeDisplayedValence( valence );
            }

        }
    }
</script>
