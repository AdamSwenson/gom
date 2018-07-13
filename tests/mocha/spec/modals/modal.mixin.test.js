//The name of the tested component
var compName = 'modal.mixin';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/modals/modal.mixin.js' );

require( '../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';


import mixinComponent from '../../helpers/dummy-component';


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff


describe( compName, () => {
    let obj;
    let actions;
    let getters;
    let mutations;
    let store;
    let wrapper;
    let actionSpy;
    let getterStub;
    let show;

    beforeEach( () => {
        show = true;
        getterStub = sinon.stub();
        getterStub.returns( true );

        mutations = {
            toggleTacoVisibility: sinon.spy()
        };
        getters = {
            isErrorModalVisible: () => show,
            isConfirmationModalVisible: () => show,
            getModalData: () => show,
            isTacoModalVisible:  getterStub

        }

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        Component.data = function(){
            return{
                getterNames : {
                    visibility : 'isTacoModalVisible'
                }
            }
        };

        wrapper = shallow( mixinComponent, {
            store, localVue, mixins: [ Component ]
        } );
    } );


    describe( " computed ", () => {
        it( 'isModalVisible defines getter by data.getterNames.visibility', () => {
            // let gn = {visibility: 'isTacoModalVisible'};
            // wrapper.setData( { getterNames: gn } );

            expect( wrapper.vm.isModalVisible ).toBe( true );
            expect( getterStub.callCount ).toBe( 1 );


        } )
    } );


} )
;
