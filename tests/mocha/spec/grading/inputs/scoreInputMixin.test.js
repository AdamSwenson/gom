//The name of the tested component
import { factories } from "../../../../spec/helpers/vuex.spec.helpers";

var compName = 'scoreInputMixin';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/grading/inputs/scoreInputMixin.js' );

require( '../../../injectglobals' );

import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

import mixinComponent from '../../../helpers/dummy-component';


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;
    let obj;
    let actions;
    let getters;
    let mutations;
    let store;
    let wrapper;
    let actionSpy;
    let getterStub;

    let itemScore;
    let item, student, exam;

    beforeEach( () => {
        item = factories.itemFactory();
        student = factories.studentFactory();
        itemScore = factories.itemScoreFactory();
        exam = factories.examFactory();

        actionSpy = sinon.spy();

        let actions = {
            'initializeItemScore': actionSpy,
            [ ngaTypes.recordItemScore ]: actionSpy
        };

        getterStub = sinon.stub();
        getterStub.returns( itemScore );

        getters = {
            [ nggTypes.getItemScoreObject ]: () => getterStub,
            [ nggTypes.getActiveExam ]: function () {
                return exam;
            }
        }

        mutations = {};

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        wrapper = shallow( mixinComponent, {
            store, localVue, mixins: [ Component ]
        } );

        wrapper.setProps( { item, student } );

    } );

    describe( " loads into expected default state for testing ", () => {
        it( 'loaded instance', () => {
            expect( wrapper.exists() ).toBe( true );
        } );
    } );

    describe( " computed properties ", () => {

        describe( 'score -- get', () => {
            it( "returns the expected score when a score object already exists", () => {
                expect( wrapper.vm.score ).toBe( itemScore.score );
            } );

            it( "dispatches initialization request when no score currently exists", () => {
                getterStub.returns( null );
                let pl = {
                    exam,
                    item,
                    student
                };
                (function ( wrapper ) {
                    return wrapper.vm.score
                })( wrapper );
                expect( actionSpy.callCount ).toBe( 1 );
                // expect(actionSpy.args[0][0]).toBe(ngaTypes.recordItemScore);
                expect( actionSpy.args[ 0 ][ 1 ] ).toMatchObject( pl );

            } );

        } );

        describe( 'score -- set', () => {
            it( "dispatches the expected action ", () => {
                let test = helpers.randomInteger();
                wrapper.vm.score = test;
                //check

                let pl = {
                    exam,
                    item,
                    student,
                    score: test
                };
                expect( actionSpy.callCount ).toBe( 1 );
                // expect(actionSpy.args[0][0]).toBe(ngaTypes.recordItemScore);
                expect( actionSpy.args[ 0 ][ 1 ] ).toMatchObject( pl );

            } );
        } )

        describe( 'exam', () => {
            it( 'returns expected value ', () => {
                expect( wrapper.vm.exam ).toBe( exam );
            } );
        } );

        describe( 'maxScore ', () => {
            it( 'returns expected values ', () => {
                expect( wrapper.vm.maxScore ).toBe( item.maxScore );
            } );
        } );
    } );

    describe( " methods ", () => {
        it( ' isReady -- true when both student and item present', () => {
            expect( wrapper.vm.isReady() ).toBe( true );
        } );

        it( 'isReady -- false if no item', () => {
            wrapper = shallow( mixinComponent, {
                store, localVue, mixins: [ Component ]
            } );
            wrapper.setProps( { student } );
            //check
            expect( wrapper.vm.isReady() ).toBe( false );
        } );
        it( 'isReady -- false if no student', () => {
            wrapper = shallow( mixinComponent, {
                store, localVue, mixins: [ Component ]
            } );
            wrapper.setProps( { item } );
            //check
            expect( wrapper.vm.isReady() ).toBe( false );
        } )
    } );


} );
