/**
 * Created by adam on 8/17/16.
 */
import Student from '../../../resources/assets/js/data/Student';


var Faker = require('faker');

module.exports = {

    /**
     * Makes a dummy student object
     * with keys studentIndex, //this is here so can use with component
     'studentId'
     'studentIdentifier'
     'firstName'
     'lastName'
     * @param id
     */
    makeStudent( id ){
        id = id ? id : Faker.random.number();
        let student = new Student(id);
        student.studentIndex = Faker.random.number();
        student.studentIdentifier = Faker.random.number();
        student.firstName = Faker.name.firstName();
        student.lastName = Faker.name.lastName();
        return student;
    }

}