
import Payload from "../../../../models/Payload";
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

    },

    methods: {
        toggle: function () {
            let v = ! this.isActive;
            let pl = Payload.factory({ updateProp: this.preferenceName, updateVal :  v});
            this.$store.commit( this.updateMutationName, pl );
        },
    },
};