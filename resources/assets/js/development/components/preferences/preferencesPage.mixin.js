// import gTypes from '../../../../store/getter-types';
import * as nggTypes from '../../../store/new-grading-getter-types';
import * as ngmTypes from '../../../store/new-grading-mutation-types';
import * as ngaTypes from '../../../store/new-grading-action-types';

import Routes from '../../routes.preferences';

export default {

    computed: {
        routes: function () {
            return _.filter( Routes, { group: this.routeGroup } );
        },
        defaultRoute: function () {
            return _.find( this.routes, { isDefaultRoute: true } );
        }
    },

    methods : {
        loadDefaultRoute : function (  ) {
            this.$router.push(this.defaultRoute.path);
        }
    },

    mounted: function () {
        this.$store.dispatch(this.loadAction);
        this.loadDefaultRoute();
        // this.$router.push(this.defaultRoute.path);
    }
};