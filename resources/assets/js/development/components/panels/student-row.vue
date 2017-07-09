<template>
    <a class="panel-block student-row">
        <span class="panel-icon"><i class="fa fa-user"></i></span>
        <input type="text" class="input" v-model="firstName"/>
        <input type="text" class="input" v-model="lastName"/>
        <input type="text" class="input" v-model="identifier"/>
        <input type="text" class="input" v-model="email" />

        <div v-show="showGradeInfo">
            <input type="text" class="input" v-model="score" />
            <input type="text" class="input" v-model="grade" />
        </div>
    </a>

</template>

<style lang="scss">

</style>

<script>
    export default{

        props: [ 'serialNumber' ],

        components: {},

        data: function () {
            return {
                defaults: {
                    firstName: '-',
                    lastName: '-',
                    email: '-',
                    identifier: '-'
                }
            }
        },
        computed: {

//        asyncComputed: {
            student: function () {
                return this.$store.getters.getStudentFromRosterBySerialNumber( this.serialNumber );
            },
            firstName: function () {
                return this.student.firstName;
//                return !_.isUndefined( this.student ) ? this.student.firstName : this.defaults.firstName;
            },
            lastName: function () {
                 if( this.student )
                    return this.student.lastName;
            },
            identifier: function () {
                return this.student.identifier;
//                return !_.isUndefined( this.student ) ? this.student.identifier : this.defaults.identifier;
            },
            email: function () {
               return this.student.email;
//                return !_.isUndefined( this.student ) ? this.student.email : this.defaults.email;
            },
//        },

//        computed: {

            /**
             * Whether to display score and other
             * info about how the student has done.
             * (Note 'done on what?' is resolved by context
             * since we want to be able to call this menu
             * up in many contexts ---maybe on item score, exam score
             */
            showGradeInfo: function () {
                return false;
            },
            grade: function () {

            },
            score: function () {
            }
        },

        methods: {},

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>