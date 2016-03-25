
module.exports = {

    template: require( '../templates/add-student-button.template.html' ),

    props: [],

    data: function () {
        return {};
    },

    computed: {},

    methods: {
        addEmptyRow: function(){
            this.$dispatch('please-add-empty-row');
        }
    },

    directives: {}
};