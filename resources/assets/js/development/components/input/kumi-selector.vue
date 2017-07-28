<template>
    <div class="control ">
        <label for="kumi-selector">{{ selectorLabel }}</label>
        <br/>
        <select
                id="kumi-selector"
                class="select"
                v-bind:class="styling"
                v-model="selected"
                v-on:change="handleSelect"
        >
            <option disabled value="">Please select a group / class </option>
            <option v-for="kumi in kumis"
                    :key="kumi.serialNumber"
                    v-bind:value="kumi.serialNumber"
            >{{ kumi.name }}
            </option>
        </select>
    </div>

</template>

<style lang="scss">
    .kumi-name-field {
        /* todo Add max width and require it to adjust under that*/

        .borderless {
            border: none;
        }

    }
</style>

<script>
    import Payload from '../../../models/Payload'
    import Kumi from '../../../models/Kumi'
    import * as mTypes from '../../../store/mutation-types';
    import * as aTypes from '../../../store/action-types';
    import * as gTypes from '../../../store/getter-types';

    //todo Adjust styling so that box of input is not visible except when selected
    export default {


        components: {},

        data: function () {
            return {
//                selected: [],
                selected: '',
//                isSelected: false,
                identifier: 'kumi-selector',
                defaults: {
                    label: 'Move selected students to group'
                }
            }
        },

        asyncComputed: {},

        computed: {
            kumis: function () {
                return this.$store.getters.getKumis;
//                return this.$store.getters.getExamKumis;
            },
            selectorLabel: function () {
                return this.defaults.label;
            },

            styling: function () {
                return this.identifier;
            },

            selectedKumi :function (  ) {
                if(this.selected > 0){
                    return this.$store.getters.getKumiBySerialNumber(this.selected);
                }
                return false;
            }

        },

        methods: {
            handleSelect: function () {
                let serialNumber = this.selected;
                window.console.log( 'kumi-selector', 'handleSelect', 71, serialNumber );
                this.$parent.$emit( 'kumi-selected', { serialNumber: serialNumber } );
               if(this.selectedKumi){
                   this.$parent.selectedKumis.push( this.selectedKumi );
               }

                this.$parent.selectedKumis.push( serialNumber );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>