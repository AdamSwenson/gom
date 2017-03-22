export default{
    props: [ 'valence' ],

    template: require( '../templates/valence-button.template.html' ),

    data: function () {
        return {

        }
    },

    computed: {

        active: function () {
            if ( this.$parent.displayedValence == this.valence ) {
                return true
            }
            return false;
        }
        ,

        classObject: function(){
            return {
                'btn-info': this.active,
                'btn-primary': ! this.active
            }
        }

    }
    ,
    methods: {
        /**
         * Called when the valence button is clicked
         */
        selectValence: function () {
            return this.sendRequest();
        }
        ,

        /**
         * This sends the actual request(s)
         */
        sendRequest: function () {
            return this.$store.dispatch( 'please-change-valence', this.valence );
        }
    }
}