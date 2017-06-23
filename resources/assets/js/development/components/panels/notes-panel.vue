<!--For adding arbitrary notes visible only to the user with access to the setup page-->

<template>
    <div class="panel-notes-component">
        <div class="field">
            <label class="label">Add a new note to your future self</label>
            <p class="control">
                        <textarea class="textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="noteText">
                        </textarea>
            </p>
        </div>

        <div class="field">
            <p class="control">
                <button class="button is-success is-outlined"
                        v-on:click="saveNote">
                    <span class="icon">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </span>
                    <span>Add Note</span>
                </button>
            </p>
        </div>

        <div class="container">
            <h3 class="title is-3">Things your past self wanted you to remember</h3>
        </div>

    </div>
</template>

<style lang="scss">

    .panel-notes-component {
        label{
            text-align: left;
        }
    }
</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload'

    export default {
//        props: ['index'],

        data: function () {
            return {
                serialNumber: _.toInteger(this.$route.params.serialNumber),
//                active: this.serialNumber,

                placeholders: {

                    noteText: "Write something you want to remember about this item here"
                },
            };
        },

        computed: {
            noteText: {
                get: function () {
                },
                set: function ( v ) {
                }
            }

        },

        methods: {
            saveNote: function () {
                window.console.log( 'panel.notes.component', 'saveNote', 65, );
            }
        }
    }
</script>
