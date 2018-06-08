
//The name of the tested component
var compName = 'input-and-selector-horizontal';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/setup/detail/input-and-selector-horizontal.vue');


require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    let item, itemProp;
    let payload, test;

    beforeEach( (  ) => {
        item = factories.itemFactory();
        itemProp = 'name';
        test = 392;
        payload = Payload.factory({
            obj: item,
            updateProp: itemProp,
            updateValue: test})

        getters = {   };

        mutations = { [mTypes.updateItem] : sinon.spy()};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
            propsData: {item, itemProp}
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe(" methods", () => {
        describe('handleValueChange', (  )=> {
            it('calls the appropriate mutation', (  ) => {

                wrapper.vm.handleValueChange(test);
                //check
                expect(mutations[mTypes.updateItem].calledOnce).toBe(true);
                expect(mutations[mTypes.updateItem].args[0][1]).toMatchObject(payload);
            });

            it('emits the appropriate event', () => {
                let test = 392;
                wrapper.vm.handleValueChange(test);
                //check
                expect(wrapper.emitted()).toBeTruthy();
                expect(wrapper.emitted().update).toBeTruthy();
            });
        })
    });


});
