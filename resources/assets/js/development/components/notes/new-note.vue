<template>
    <div class="edit-note"
         v-show="isVisible"
    >
        <h5 class="title is-5">Remind your future self...</h5>

        <div class="field">
            <label class="label">Title</label>
            <div class="control">
                <input type="text"
                       class="new-note-name"
                       v-model="noteName" lazy
                >
            </div>
            <p class="help"></p>
        </div>

        <div class="field">
            <div class="control">
                        <textarea id="new-note-text"
                                  class="new-note-text textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="noteText" lazy
                        >
                        </textarea>
            </div>
            <p class="help"></p>
        </div>

        <color-selector
                v-on:color-selected="handlePrioritySelection"
        ></color-selector>


        <div class="field is-grouped">

            <p class="control">
                <a class="button save-note-button is-success"
                   v-on:click="handleSaveClick"
                >Save</a>
            </p>

            <p class="control">
                <a class="button clear-note-button is-warning"
                   v-on:click="handleClearClick"
                >Clear</a>
            </p>
        </div>

    </div>

</template>

<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Note from '../../../models/Note';
    import Payload from '../../../models/Payload';

    import noteObject from './note-object.vue';

    import { createNoteRequest, loadNotesForItemRequest } from '../../../api/requests/noteRequests';

    // import prioritySelector from './note/priority-selector';
    import colorSelector from '../tags/color-selector.vue';
    import loadingIndicator from '../helpers/loading-indicator.vue';


    export default {
        name: "edit-note",

        // props : ['is-visible'],
        components: {
            'note-object': noteObject,
            // 'priority-selector': prioritySelector,
            colorSelector,
            loadingIndicator
        },

        data: function () {
            return {
                placeholders: {
                    noteText: "Add a new note to your future self here"
                },
            }
        },

        computed: {

            /**
             * The note object to edit
             * @returns {getNewNote|module.exports.getNewNote}
             */
            note: function () {
                //returns either false or the serial number of the new note
                let n = this.$store.getters.getNewNote;
                if ( n ) {
                    return n
                }
            },

            noteName: {
                get: function () {
                    if ( this.note ) return this.note.name;
                    return ''
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'name',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote , pl );
                }
            },

            noteText: {
                get: function () {
                    if ( this.note ) return this.note.text;
                    return ''
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'text',
                        updateVal: v
                    } );
                    this.$store.commit(  mTypes.updateNote , pl );
                }
            },

            isVisible: function () {
                if ( this.note ) return true;
            }

        },
        methods: {

            handleClearClick: function () {
                this.newNoteName = '';
                this.newNoteText = '';
                this.newNotePriority = 0;
            },

            /**
             * Doesn't actually save, since have been doing so already
             */
            handleSaveClick: function () {
                this.$store.commit( mTypes.resetNewNote )
                this.$emit('note-added')
            },

            handlePrioritySelection: function ( priority ) {
                window.console.log( 'notes-panel', 'handlePrioritySelection', 297, priority );
                let pl = Payload.factory( {
                    obj: this.note,
                    updateProp: 'priority',
                    updateVal: priority
                } );
                this.$store.commit(  mTypes.updateNote , pl );
            },

        }

    }

</script>

<style scoped>

</style>