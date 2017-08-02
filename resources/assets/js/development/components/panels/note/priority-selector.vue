<template>
    <div class="field">
        <label class="label">Priority</label>
        <div class="control">
            <label v-for="priorityLevel in priorities"
                   class="radio"
            >
                {{ priorityLevel }}
                <input type="radio"
                       name="priority-radio"
                       v-model="priority"
                       v-bind:value="priorityLevel"
                >
            </label>
        </div>
    </div>

</template>

<style lang="scss">

</style>

<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';
    import Note from '../../../../models/Note';
    import Payload from '../../../../models/Payload';


    export default {

        props: [
            'serialNumber'
        ],

        components: {},

        data: function () {
            return {

                defaults: {}
            }
        },

        computed: {
            priorities: function () {
                return Object.keys( Note.priorityStyles() );
            },

            priority: {
                get: function () {
                    return this.$parent.newNote ? this.$parent.newNote.priority : '';

                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.$parent.newNote,
                        updateProp: 'priority',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );

                }
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>