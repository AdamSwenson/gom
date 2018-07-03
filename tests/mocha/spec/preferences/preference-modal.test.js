//
// //The name of the tested component
// var compName = 'preference-modal';
// //The path to the tested component
// var Component = require('../../../../resources/assets/js/development/components/preferences/preference-modal.vue');
//
// require( '../../injectglobals' );
//
// import { mount, shallow, createLocalVue } from 'vue-test-utils';
//
// import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';
//
// const localVue = createLocalVue();
//
// localVue.use( Vuex )
// localVue.use( VueRouter );
// // const router = new VueRouter();
//
//
//
// describe(  compName , () => {
//
//     let componentDivIdentifier = '.' + compName;
//
//     let getters;
//     let mutations;
//     let store;
//     let wrapper;
//
//     beforeEach( (  ) => {
//
//         getters = {   };
//
//         mutations = {};
//
//         store = new Vuex.Store( {
//             getters,
//             mutations
//         } );
//         // let $router = sinon.spy();
//         wrapper = shallow( Component, {
//             store, localVue, propsData: {isVisible: true, 'type': ''},
//             // mocks: { $router}
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
//     describe.skip(" TESTS NEEDED", () => {
//         it('awaits tests')
//     });
//
//
// });
