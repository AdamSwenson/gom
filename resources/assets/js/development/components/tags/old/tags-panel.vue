<template>

    <div class="panel-tags-component">

        <tag-menu :object-serial-number="serialNumber" object-type="objectType"></tag-menu>

    </div>

</template>
<style>

</style>
<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';

    import Payload from '../../../../models/Payload'

    import { loadAllUserTagsRequest, loadTagsForItemRequest } from '../../../../api/requests/tagRequests';

    import tagMenu from '../tags-menu.vue';

    /**
     * This is a display area for editing, creating, and
     * otherwise managing tags
     */
    export default {

        components: { 'tag-menu': tagMenu },
        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),

                objectType: this.$route.params.objectType,

                active: this.serialNumber,

                placeholders: {

                    noteText: ""
                },
            };
        },

        computed: {

            parentObject: function () {
                switch ( this.objectType ) {
                    case 'item':
                        return  this.$store.getters[ gTypes.getItemBySerialNumber ]( this.serialNumber );

                        break;
                    case 'exam':
                        return  this.$store.getters[ gTypes.getExamBySerialNumber ]( this.serialNumber );
                        break;
                    case 'student':
                        break;
                    default:
                }

            }

        },

        methods: {},

        created: function () {

            //Get all tags, not just those used on this
//            loadAllUserTagsRequest(this.$store);

//            switch ( this.objectType ) {
//                case 'item':
//                    window.console.log( 'tags-panel', 'mounted', 65);
//                    loadTagsForItemRequest( this.$store, this.parentObject );
//                    break;
//                case 'exam':
////                    loadExamTagsRequest( this.$store, this.parentObject );
//                    break;
//                case 'student':
////                    loadStudentTagsRequest(this.$store, this.parentObject);
//                    break;
//                default:
//            }
//
        }
    }
</script>
