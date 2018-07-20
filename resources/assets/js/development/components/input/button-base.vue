<script>
    /**
     * This defines the base class for all buttons.
     * Inheritors of this class need to define the following:
     *          buttonText (optional)
     *          screenReaderText: '',
     *          icon: "",
     *          linkTitle: '',
     *          linkClass: '',
     *          identifyingClass: '',
     * This should be done via one of three ways:
     * (1) Define in data like this:
     *  data : function() {
     *      local : {
     *          buttonText (optional)
     *          screenReaderText: '',
     *          icon: "",
     *          linkTitle: '',
     *          linkClass: '',
     *          identifyingClass: '',
     *      }
     *    }
     *
     * (2) A computed property named local
     *
     * (3) An object passed to the prop `propertyObject`
     *
     * Inheriting classes should define the method:
     *      handleClick
     */
    export default {
        name: "button-base",

        props: [ 'propertyObject' ],

        data: function () {
            return {
                // local: {
                //     buttonText: '',
                //     icon: "",
                //     identifyingClass: '',
                //     linkClass: '',
                //     linkTitle: '',
                //     screenReaderText: '',
                // }
            }
        },

        computed: {
            buttonText: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.buttonText ) ) {
                    return this.propertyObject.buttonText;
                }
                return this.local.buttonText;
            },

            icon: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.icon ) ) {
                    return this.propertyObject.icon;
                }
                return this.local.icon;
            },

            identifyingClass: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.identifyingClass ) ) {
                    return this.propertyObject.identifyingClass;
                }
                return this.local.identifyingClass;
            },

            linkClass: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.linkClass ) ) {
                    return this.propertyObject.linkClass;
                }
                return this.local.linkClass;

            },

            linkTitle: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.linkTitle ) ) {
                    return this.propertyObject.linkTitle;
                }
                return this.local.linkTitle;

            },

            screenReaderText: function () {
                if ( !_.isUndefined( this.propertyObject ) && !_.isUndefined( this.propertyObject.screenReaderText ) ) {
                    return this.propertyObject.screenReaderText;
                }
                return this.local.screenReaderText;
            },

            /**
             * Determines the size class added to the icon.
             * By default it makes the icon on the button small
             * if there is text. However, this could be overridden
             * to return something like is-large where necessary.
             * @returns {string}
             */
            iconSize: function () {
                if ( this.buttonText.length > 0 ) return 'is-small'
            },

            openingTag: function () {
                if ( this.isWrappedInField ) {
                    return '<p class="field' + this.identifyingClass + '">';
                }
                // return '<span>';
            },

            closingTag: function () {
                if ( this.isWrappedInField ) {
                    return '</p>';
                }
                // return '</span>';
            }
        },


        methods: {
            handleClick: function () {

            }
        }
    }
</script>
<template>
    <p class="field"
       v-bind:class="identifyingClass"
    >
        <a class="button "
           v-bind:class="linkClass"
           v-bind:title="linkTitle"
           v-on:click="handleClick"
        >
            <span class="icon "
                  v-bind:class="iconSize"
            >
                <i aria-hidden="true"
                   v-bind:class="icon"
                >
                    <span class="sr-only">{{screenReaderText}}</span>
                </i>
            </span>

            <span v-if="buttonText.length >0">{{buttonText}}</span>
        </a>
    </p>

</template>

<style scoped>

</style>