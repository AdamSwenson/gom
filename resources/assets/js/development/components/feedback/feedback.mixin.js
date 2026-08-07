import * as nggTypes from '../../../store/new-grading-getter-types';

export default {
    computed: {

        itemChildren: function () {
            return this.$store.getters.getItemChildren( this.item );
        },

        scoreObject: function () {
            if(! this.isReady()) return false;
            // if(_.isUndefined(this.item) || _.isNull(this.item)) return false;
            // if(_.isUndefined(this.student) || _.isNull(this.student)) return false;

            return this.$store.getters[ nggTypes.getItemScoreObject ]( {
                item: this.item,
                student: this.student
            } );
        }
    },

    methods: {
        isReady: function (  ) {
            if ( _.isUndefined( this.item ) || _.isNull(this.item)) return false;
            if( _.isUndefined( this.student ) || _.isNull(this.student) ) return false;
            return true;
        },
    }
} ;