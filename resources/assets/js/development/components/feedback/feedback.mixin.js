import * as nggTypes from '../../../store/modules/newgrading/new-grading-getter-types';

module.exports = {
    computed: {

        scoreObject: function () {
            if(! this.isReady()) return '';
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
            if ( _.isUndefined( this.item ) || _.isNull(this.item) || _.isUndefined( this.student ) || _.isNull(this.student) ) return false;
            return true;
        },
    }
} ;