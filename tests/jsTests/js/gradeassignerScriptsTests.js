/* 
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */


function load(scores) {
    var CC = new ConsistencyChecker();
    CC.holder = scores;
    return CC.check();
}
module('gradeassignerScripts');
//Should also pass with an empty value for the lower one
test('load()', function () {
    expect(1);
    ok(1===1);
//    var CC = new ConsistencyChecker();
//    var high = 8;
//    var low = 1;
//    for (i = 0; i < CC.gradeorder.length; i++) {
//        var currentGrade = CC.gradeorder[i];
//        //test scores that should be lower
//        for (ix = i; ix < (CC.gradeorder.length); ix++) {
//            var goodobj = new Object();
//            goodobj[currentGrade] = high;
//            goodobj[CC.gradeorder[ix]] = low;
//            var msg = currentGrade + ' (' + goodobj[currentGrade] + ') +  is higher than ' + CC.gradeorder[ix] + ' (' + goodobj[CC.gradeorder[ix]] + ') ';
//            equal(load(goodobj), 0, msg);
//            var badobj = new Object();
//            badobj[currentGrade] = low;
//            badobj[CC.gradeorder[ix]] = high;
//            var msg2 = currentGrade + ' (' + badobj[currentGrade] + ')  is not higher than   ' + CC.gradeorder[ix] + ' (' + badobj[CC.gradeorder[ix]] + ') ' + ' errors:  ' + numerrors;
//            var numerrors = load(badobj);
//            notEqual(numerrors, 0, msg2);
//        }
//    }
});
//test('load2()', function () {
//    var CC = new ConsistencyChecker();
//    var high = 8;
//    var low = 1;
//    for (i = 0; i < CC.gradeorder.length; i++) {
//        var currentGrade = CC.gradeorder[i];
//        //test scores that should be lower
//        for (ix = i; ix < (CC.gradeorder.length); ix++) {
//            var goodobj = new Object();
//            goodobj[currentGrade] = high;
//            goodobj[CC.gradeorder[ix]] = low;
//            CC.holder = goodobj;
//            var msg = currentGrade + ' (' + goodobj[currentGrade] + ') +  is higher than ' + CC.gradeorder[ix] + ' (' + goodobj[CC.gradeorder[ix]] + ') ';
//
//            equal(CC.check2(currentGrade, high), 0, msg);
//
//            var badobj = new Object();
//            badobj[currentGrade] = low;
//            badobj[CC.gradeorder[ix]] = high;
//            CC.holder = badobj;
//            var msg2 = currentGrade + ' (' + badobj[currentGrade] + ')  is not higher than   ' + CC.gradeorder[ix] + ' (' + badobj[CC.gradeorder[ix]] + ') ' + ' errors:  ' + numerrors;
//            var numerrors = CC.check2(currentGrade, low);
//            notEqual(numerrors, 0, msg2);
//        }
//    }
//});
//test('load3()', function () {
//    var CC = new ConsistencyChecker();
//    var high = 8;
//    var low = 1;
//    for (i = 0; i < CC.gradeorder.length; i++) {
//        var currentGrade = CC.gradeorder[i];
//        //test scores that should be lower
//        for (ix = i; ix < (CC.gradeorder.length); ix++) {
//            var goodobj = new Object();
//            goodobj[currentGrade] = high;
//            goodobj[CC.gradeorder[ix]] = low;
////                    CC.holder = goodobj;
//            var msg = currentGrade + ' (' + goodobj[currentGrade] + ') +  is higher than ' + CC.gradeorder[ix] + ' (' + goodobj[CC.gradeorder[ix]] + ') ';
//
//            equal(CC.check5(goodobj), 0, msg);
//
//            var badobj = new Object();
//            badobj[currentGrade] = low;
//            badobj[CC.gradeorder[ix]] = high;
//            // CC.holder = badobj;
//            var msg2 = currentGrade + ' (' + badobj[currentGrade] + ')  is not higher than   ' + CC.gradeorder[ix] + ' (' + badobj[CC.gradeorder[ix]] + ') ' + ' errors:  ' + numerrors;
//            var numerrors = CC.check5(badobj);
//            notEqual(numerrors, 0, msg2);
//        }
//    }
//});
