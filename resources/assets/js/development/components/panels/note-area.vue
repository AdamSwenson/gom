<template>

    <div class="note-area"
         v-bind:id="getId"
    >

        <div class="field"
             v-if="isEditable">
            <label class="label">Add a new note to your future self</label>

            <p class="control">
            <textarea class="textarea"
                      rows="3"
                      v-bind:placeholder="placeholders.noteText"
                      v-model="text">
            </textarea>
            </p>

            <div class="field">
                <p class="control">
                    <button class="button is-outlined"
                            v-on:click="handleSave">Save
                    </button>
                </p>
                <p class="control">
                    <button v-on:click="handleClear"
                            class="button is-outlined">Clear
                    </button>
                </p>
            </div>
        </div>


        <div class="notification "
             v-else
             v-bind:class="priorityClass">
            <button class="delete"></button>
            {{ text }}
        </div>


        <div class="timestampArea">
            <p class="is-size-6">Created: {{ creationTimestamp }}  |  Updated: {{ updatedTimestamp }}</p>
        </div>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    export default {

        props: [ 'serialNumber' ],

        components: {},

        data: function () {
            return {
                priorityStyles: {
                    0: 'is-primary',
                    1: 'is-info',
                    2: 'is-warning',
                    3: 'is-danger'
                },

                isEditable: false,

                defaults: {},
                placeholders: {
                    noteText: "Add a note to your future self here"

                }
            }
        },

        computed: {
            /**
             * The actual note object
             */
            note: function () {
                return this.$store[ gTypes.getNoteBySerialNumber ]( this.serialNumber );
            },

            creationTimestamp: function () {
                return this.note.createdAt;
            },

            updatedTimestamp: function () {
                return this.note.updatedAt;
            },

            name: {
                get: function () {
                },
                set: function ( v ) {

                }
            },

            text: {
                get: function () {
                    return this.note.text;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'text',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            },

            priorityClass: function () {
                if ( this.note.priority ) {
                    return this.priorityStyles[ this.note.priority ];
                }
            },

            priority: {
                get: function () {
                    return this.note.priority;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'priority',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            },

            props: {
                get: function () {
                    return this.note.props;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'props',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            }


        },

        methods: {
            getId: function () {
                return 'note-area-' + this.serialNumber;
            },

            handleDeleteClick: function () {

            },

            handleClear: function () {

            },

            handleSave: function () {

            },

            handleEditClick: function () {

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>