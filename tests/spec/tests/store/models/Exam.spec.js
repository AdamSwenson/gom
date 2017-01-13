
//test libraries
require('jasmine-jquery');
require('sinon');

const faker = require('faker');

//tested stuff
import Exam from  "../../../../../resources/assets/js/store/models/Exam.js" ;


describe(" store.models.Exam | ", function () {

    beforeEach(function () {
        this.examId = faker.random.number();
        this.object = new Exam(this.examId);
    });


    describe("getters and setters | ", () => {
        xit("happy path | ", () => {
            //todo
        });
    });

    describe("factory | ", () => {
        xit("happy path | ", () => {
            //todo
        });
    });

});