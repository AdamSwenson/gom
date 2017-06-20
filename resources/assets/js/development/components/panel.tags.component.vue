<template>

<div class="panel-notes-component">
    <!--tab-pane"-->
    <!--role="tabpanel"-->
<p>tags happen here</p>

</div>

</template>
<style>

</style>
<script>
    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
//        props: ['index'],

        data: function () {
            return {
                index: this.$route.params.index,
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
                window.console.log('panel.notes.component', 'saveNote', 65,);
            }
        }
    }
</script>
