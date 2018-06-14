<template>
    <div id="kumi-selection-area"
         class="kumi-selector"
         v-bind:class="injectableClass"
         v-show="isVisible"
    >
        <div class="field">

            <slot name="label">
                <label class="label">
                    {{ defaults.label }}

                </label>
            </slot>
            <div class="control">

                <div class="select is-multiple">

                    <select
                            id="kumi-selector"
                            class="select"
                            v-bind:class="styling"
                            v-model="selected"
                            multiple
                    >
                        <option disabled value="">Please select a group / class </option>
                        <option v-for="kumi in kumis"
                                :key="kumi.serialNumber"
                                v-bind:value="kumi"
                        >{{ kumi.name }}
                        </option>

                    </select>
                </div>
            </div>
        </div>
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

        /**
         * This allows control of the selector's visibility
         * from a parent's value. It overrides the value stored
         * in roster.display.kumiSelectVisible
         */
        props: [ 'visibilityOverride', 'injectableClass' ],
        components: {},

        data: function () {
            return {
                identifier: 'kumi-selector',
                defaults: {
                    label: 'Move selected students to group'
                }
            }
        },

        asyncComputed: {},

        computed: {
            kumis: function () {
                return this.$store.getters[gTypes.getAllKumis];
            },

            styling: function () {
                return this.identifier;
            },

            /**
             * Whether the selector is shown or visible.
             * It will use the value stored
             * in roster.display.kumiSelectVisible
             * Unless an override is passed in to the prop
             */
            isVisible: function () {
                if ( !_.isUndefined( this.visibilityOverride ) ) return this.visibilityOverride;
                return this.$store.getters.isKumiSelectVisible;
            },

            selected: {
                get: function () {
                    if ( _.isUndefined( this.$store.getters.getSelectedKumis ) ) return [];
                    return this.$store.getters.getSelectedKumis;
                },
                set: function ( v ) {
                    this.$store.commit( 'selectKumi', Payload.factory( { obj: v[ 0 ] } ) );
                }
            },

        },

    }
</script>