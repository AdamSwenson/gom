<template>



    <div class="valence-buttons field ">
          <p class="control">
              <button type="button"
                     class="button is-outlined is-info"
                    v-on:click="setValence(valence)"
                    v-for="valence in valences" :key="valence">{{valence}}
              </button>
          </p>
    </div>
    <!--</div>-->
    <!--<div class="valence-buttons form-group ">-->
            <!--<b-button-group-->
                <!--size="sm"-->
            <!--&gt;-->
            <!--<b-button-->
            <!--variant="primary"-->
            <!--v-on:click="setValence(valence)"-->
            <!--v-for="valence in valences" :key="valence">{{valence}}</b-button>-->
        <!--</b-button-group>-->

    <!--</div>-->

        <!--<div class="btn-group" role="group">-->

        <!--<button type="button" class="btn btn-small valence-button"-->
        <!--v-bind:class="classObject"-->
        <!--v-on:click="selectValence"-->
        <!--&gt;{{ valence }}</button>-->
    <!--</div>-->

</template>
<style>

</style>
<script>

    import Comment from '../../../models/Comment';

    export default{
        props: ['index', 'valence', 'serialNumber', 'isExam'],

        data: function () {
            return {}
        },

        computed: {
            valences: function () {
                return Comment.valences;
            },

            active: function () {
                return this.$parent.displayedValence === this.valence;
            },

            classObject: function () {
                return {
                    'btn-info': this.active,
                    'btn-primary': !this.active
                }
            }

        }
        ,
        methods: {
            /**
             * Called when the valence button is clicked
             */
            setValence: function (valence) {
                this.$parent.changeDisplayedValence(valence);

//            this.$store.commit(mTypes.setElementComment, Payload.factory({
//            index : this.index,
//                index: this.index,
//                updateProp: name,
//                updateVal: value
//            }))
//                return this.sendRequest();
            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
              //  return emit('please-change-valence', this.valence);
            }
        }
    }
</script>
