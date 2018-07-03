// //The name of the tested component
// var compName = 'user-preferences';
// //The path to the tested component
// var Component = require( '../../../../../resources/assets/js/development/components/preferences/user/user-preferences.vue' );
//
// require( '../../../injectglobals' );
//
//
// import { mount, shallow, createLocalVue } from 'vue-test-utils';
// import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
//
// const localVue = createLocalVue();
//
// localVue.use( Vuex )
// // localVue.use( VueRouter );
//
//
// //tested stuff
//
//
// describe( compName, () => {
//
//     let componentDivIdentifier = '.' + compName;
//
//     let getters;
//     let mutations;
//     let store;
//     let wrapper, actions;
//     let $route = { params: { serialNumber: null } };
//
//     beforeEach( () => {
//
//         getters = {};
//         actions = { [ ngaTypes.loadUserPreferencesFromServer ]: () => () => sinon.spy() };
//         mutations = {};
//
//         store = new Vuex.Store( {
//             getters,
//             actions,
//             mutations
//         } );
//
//         wrapper = shallow( Component, {
//             store, localVue, mocks: { $route }
//         } );
//
//     } );
//
//
//     describe( " loads into expected default state for testing ", () => {
//         it( 'displays the expected component div on first load', () => {
//             assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
//         } );
//     } );
//
//     describe( " TESTS NEEDED", () => {
//         it( 'awaits tests' )
//     } );
//
//
// } );
