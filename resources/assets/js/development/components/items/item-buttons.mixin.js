export default {


    computed: {

        isExam: function () {
            return ! _.isUndefined(this.item) ? this.item.isExam() : false;
        },

        isItem: function () {
            return !this.isExam;
        },


        serialNumber: function () {
            return this.item.serialNumber;
            return this.item ? this.item.serialNumber : null;
        },

        node: function () {
            if ( !_.isNull( this.serialNumber ) ) {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            }
        },


        parentSerialNumber: function () {
            if(! _.isNull(this.parent))return this.parent.data;
            if(! _.isNull(this.serialNumber)) return this.node.parent;
        },

        parent: function () {
            return this.$store.getters.getItemNodeFromOrder( this.node.parent );
        },

        id : function(){
            return this.identifier + '-' + this.serialNumber;
        },

    }
}