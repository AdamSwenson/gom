//The name of the tested component
var compName = 'score-slider';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/grading/inputs/score-slider.vue' );

require( '../../../injectglobals' );


import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let actions;
    let getters;
    let mutations;
    let store;
    let event;

    let wrapper;

    let item, exam, student, score, scoreObj;

    let examGetterStub;
    let studentGetterStub;
    let scoreGetterStub;

    beforeEach( () => {
        //the event we'll need to call in our tests
        event = 'slideStop';
        //value for the slider to be set to
        score = 95;

        item = factories.itemFactory();
        item.maxScore = 100;

        exam = factories.examFactory();
        examGetterStub = sinon.stub();
        examGetterStub.returns( exam );

        student = factories.studentFactory();
        studentGetterStub = sinon.stub();
        studentGetterStub.returns( student );

        scoreObj = factories.itemScoreFactory( exam, item, student, score )
        scoreGetterStub = sinon.stub();
        scoreGetterStub.returns( scoreObj );


        getters = {
            [ nggTypes.getItemScoreObject ]: () => scoreGetterStub,
            [ nggTypes.getActiveExam ]: function () {
                return exam;
            },
            [ nggTypes.getActiveStudent ]: () => studentGetterStub
        };

        mutations = {};

        actions = {
            [ ngaTypes.recordItemScore ]: sinon.spy()
        }

        store = new Vuex.Store( {
            actions,
            getters,
            mutations
        } );

        wrapper = mount( Component, {
            store, localVue,
            attachToDocument: true,
            sync: false,

        } );
        wrapper.setProps( {item});

    } );

    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', (done) => {
            assertions.assertElementExists( wrapper, componentDivIdentifier );
            done();
        } );
    } );

    describe( " computed properties ", () => {
        it( 'valence cutoffs returns expected values', () => {
            expect( wrapper.vm.valenceCutoffs.length ).toBe( wrapper.vm.numberLabels );
        } );

        //todo re-enable once are able to load the displayed slider
        it.skip('valence cutoff expected values are displayed in the element', (  ) => {
            _.forEach(wrapper.vm.settings.ticks_labels, ( text ) => {
                expect( wrapper.find(componentDivIdentifier).html() ).toContain( text );
            })
        });
    } );

    describe( ' methods ', () => {
        describe(" createSlider ", (  ) => {
            it.skip(" sets the slider's initial value to 0 when the pre-existing score is undefined", (  done) => {
                let spy = sinon.stub();
                spy.resolves(true);
                getters[nggTypes.getItemScoreObject] = (  ) => (  ) => undefined;
                actions['initializeItemScore'] = spy;

                store = new Vuex.Store( {
                    actions,
                    getters,
                    mutations
                } );

                wrapper = mount( Component, {
                    store, localVue,
                    attachToDocument: true,
                    sync: false,
                    propsData : {item}
                } );


                let spy3 = sinon.spy();
                wrapper.setMethods({setSliderScore: spy3});
                //check
                // expect(spy.callCount).toBe(1);
                expect(spy3.args[0[0]]).toBe(0);
                done();

            });

            it.skip(" sets the slider's initial value to the pre-existing score when a score exists", (  ) => {

            });
        })

        it( " handleElementSliderStopEvent behaves as expected ", () => {
            let test = 74;

            let pl = {
                exam: exam,
                item: item,
                student: student,
                score: test
            };
            let dummyCallback = sinon.stub();

            //call
            wrapper.vm.handleElementSliderStopEvent( { value: test }, dummyCallback );

            //check
            let act = actions[ ngaTypes.recordItemScore ]
            expect( act.callCount ).toBe( 1 );
            expect( act.args[ 0 ][ 1 ].score ).toBe( test );

            //check that the callback was called
            expect( dummyCallback.callCount ).toBe( 1 );
        } );
    } );

    describe( " functional testing ", () => {
        //todo re-enable once are able to load the displayed slider
        it.skip( " when slider stop occurs, values update correctly and the appropriate actions are dispatched and  ", () => {
            let test = 67;
            wrapper.find( componentDivIdentifier ).trigger( event, { value: test } );

            //check
            expect( wrapper.vm.score ).toBe( test );

        } );
    } );

    describe( " async loading ", () => {
        it( 'awaits tests' );
    } );

} );
