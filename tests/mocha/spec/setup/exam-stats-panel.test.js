// //The name of the tested component
// var compName = 'exam-stats-panel';
// //The path to the tested component
// var Component = require( '../../../../resources/assets/js/development/components/setup/old/exam-stats-panel.vue' );
//
// require( '../../injectglobals' );
// import { mount, shallow, createLocalVue } from 'vue-test-utils';
//
// const localVue = createLocalVue();
// localVue.use( Vuex )
//
// describe( compName, () => {
//
//     let componentDivIdentifier = '.' + compName;
//
//     let getters, mutations, actions, store;
//
//     let wrapper;
//
//     let listOfValues, test;
//     let payload, exam, item, kumi, kumis, student, grade;
//
//     beforeEach( () => {
//         exam = factories.examFactory();
//         actions = {}
//         item = factories.itemFactory();
//         getters = {
//             rootItem: () => () => item
//         };
//
//         mutations = {};
//
//         store = new Vuex.Store( {
//             getters, mutations, actions
//         } );
//
//         wrapper = shallow( Component, {
//             store, localVue
//         } );
//
//     } );
//
//
//
//     describe( " loads into expected default state for testing ", () => {
//         it( 'should ', function () {
//             expect(item.isExam).toBe(false);
//         } );
//
//         it( 'displays the expected component div on first load', () => {
//             window.console.log( 'exam-stats-panel.test', 's', 46, wrapper.vm.item);
//             assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
//         } );
//     } );
//
//     describe.skip( "methods", () => {
//         it( " calls for the correct mutation when ....", () => {
//         } );
//     } )
//
//
// } );
