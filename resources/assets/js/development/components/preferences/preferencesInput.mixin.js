// import gTypes from '../../../../store/getter-types';
import * as nggTypes from '../../../store/new-grading-getter-types';
import * as ngmTypes from '../../../store/new-grading-mutation-types';
import * as ngaTypes from '../../../store/new-grading-action-types';
import Payload from '../../../models/Payload';

// import Routes from '../../routes.preferences';

module.exports = {

    computed: {},

    methods: {
        handleToggle: function ( fieldName ) {
            let newVal = !this[ fieldName ];
            let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
            this.$store.commit( this.updateMutationName, pl );
        },
        handleValueChange: function ( obj ) {
            let fieldName = obj.fieldName;
            let newVal = obj.value;
            let pl = Payload.factory( { updateProp: fieldName, updateVal: newVal } );
            this.$store.commit( this.updateMutationName, pl );
        },
    }
};