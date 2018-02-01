module.exports = {


    computed: {

        isExam: function () {
            return this.item ? this.item.isExam() : false;
        },

        isItem: function () {
            return !this.isExam;
        },


        serialNumber: function () {
            return this.item ? this.item.serialNumber : null;
        },

        node: function () {
            if ( !_.isNull( this.serialNumber ) ) {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber );
            }
        },


        parentSerialNumber: function () {
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