<!--For adding arbitrary notes visible only to the user with access to the setup page-->

<template>
    <div class="panel-notes-component">
        <div class="field">
            <label class="label">Add a new note to your future self</label>
            <p class="control">
                <input class="text"
                       v-bind:placeholder="placeholders.noteText"
                       v-model="name">
            </p>

            <p class="control">
                        <textarea class="textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="text">
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

            <note-area
                 v-for="note in notes"
                 v-bind:key="note.serialNumber"
            ></note-area>


        </div>


    </div>
</template>

<style lang="scss">

    .panel-notes-component {
        label {
            text-align: left;
        }
    }
</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Payload from '../../../models/Payload';
    import noteArea from './note-area.vue';

    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            'note-area': noteArea
        },

        data: function () {
            return {
                //The serial number of the item the notes belong to
                itemSerialNumber: _.toInteger( this.$route.params.serialNumber ),

                placeholders: {
                    noteText: "Write something you want to remember about this item here"
                },
            };
        },

        computed: {
            /**
             * The exam or item the note is associated with
             *
             */
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.itemSerialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },


            notes: function () {
                return this.$store[ gTypes.getNotesForItem ]( this.itemSerialNumber );
            },

        },

        methods: {
            saveNote: function () {
                window.console.log( 'panel.notes.component', 'saveNote', 65, );
                //switch the dialog back
            }
        }
    }
</script>
