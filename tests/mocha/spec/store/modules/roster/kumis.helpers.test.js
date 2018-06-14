
//The name of the tested component
var compName = 'kumis.helpers';
//The path to the tested component
var Component = require( '../../../../../../resources/assets/js/store/modules/roster/kumis.helpers.js' );


require( '../../../../injectglobals' );

//tested object


describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let state;
    
    beforeEach( () => {
        state = {
            kumis: [],
            studentKumiAssociations: [],
            examKumiAssociations: []
        };

        exam = factories.examFactory();
        kumi = factories.kumiFactory();

    } );

    describe('areKumiAndExamAssociated', (  ) => {
        it('returns true when associated', (  ) => {
            state.examKumiAssociations.push({
                examId: exam.id,
                kumiId: kumi.id
            });
            expect(state.examKumiAssociations.length).toBe(1);
            //call
            let result = Component.areKumiAndExamAssociated(state, exam, kumi);
            expect(result).toBe(true);

        });
        it('returns false when not associated', (  ) => {
            let numKumis = 3;
            let kumis = factories.makeKumis(numKumis);
            _.forEach(kumis, function(k){
                let ex = factories.examFactory();
                let o = {examId: ex.id, kumiId: k.id};
                state.examKumiAssociations.push(o);
            });
            expect(state.examKumiAssociations.length).toBe(numKumis);
            //call
            let result = Component.areKumiAndExamAssociated(state, exam, kumi);
            expect(result).toBe(false);
        });
    });

} );
