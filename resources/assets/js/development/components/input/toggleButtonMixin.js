/**
 * This controls the toggle-button-base.vue
 * but since these are not needed for every use case, it is
 * kept separate from the base component
 */


module.exports ={


    computed: {

        buttonText: function () {
            return this.isActive ? this.text.on : this.text.off;
        },

        icon: function () {
            return this.isActive ? this.icons.on : this.icons.off;
        },

        isActive: function () {
            return this.$store.getters[ this.toggleStateGetterName ];
        },

        srTextDisplay: function (  ) {
            return this.isActive ? this.srText.on : this.srText.off;
        }

    }
};