/**
 * Created by adam on 1/10/17.
 */


/**
 * Returns true if at least one question has received
 * a score for the student.
 */
export const isGraded = (state, studentIndex) => {
    state.updateExamGrade(studentIndex)
    if (state.examGrades[studentIndex] != "Letter grade" && state.examGrades[studentIndex] >= 0) {
        return true;
    }
    return false;
};



/* ------------ Utilities --------------*/

/**
 * Checks to make sure that a property has had its
 * values loaded before trying to do stuff with it
 *
 * @param propertyName
 */
export const checkValid = (state, propertyName) => {
    if (typeof state[propertyName] != 'undefined') {
        throw propertyName + " is undefined";
    }
    if (state[propertyName] == null) {
        throw propertyName + " is null";
    }
    if (state[propertyName] == {}) {
        throw propertyName + " was empty. Probably because it wasn't initialized";
    }

    return true;
};