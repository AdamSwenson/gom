<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/28/15
 * Time: 10:07 AM
 */?>


<div id="templates">
<script id="questionResult" type="text/x-jQuery-tmpl">
<div id="q${questionNumber}">
<h1 class="mainHeading">Q${questionNumber}: ${questionTitle}</h1>
<p class="stockText generalStock"></p>
<ul id="q${questionNumber}Comments"></ul>
</div>
</script>
<script id="commentTemplate" type="text/x-jQuery-tmpl">
<li class="subtask${subtask} commentParagraph" id="el${elementID}" data="${elementScore}">${content}</li>
<div id="el${elementID}Chart"></div>
</script>
</div>

<script type="text/javascript">
$.ajaxSetup({cache: false});
var gradeArray = ['A-', 'B-', 'C+', 'D'];
var selGrade = gradeArray[Math.floor(Math.random() * gradeArray.length)];
var studentGrade = [{'gradeLetter' : selGrade}];
//                    var studentGrade = [<?php //echo $grade_getter->returnJson(); ?>];

var elementScores = <?php $student_scores->json_element_scores(); ?>;
var questionScores = <?php $student_scores->json_question_scores(); ?>;
var elementAverages = <?php echo $exam_stats->averages($exam, new \Element()); ?>;
var questionAverages = <?php echo $exam_stats->averages($exam, new \Question()); ?>;
//var comments = <?php //echo /$student_scores->json_comments(); ?>;
$(document).ready(function () {
var scripts = [
"",
""
];

/**
* Do any styling or activities required by the page
* @returns {undefined}
*/
function onLoad() {
$('.prettyButton').button();
fillGrade(studentGrade);
//makeComments(comments);
//prepare data for charts
var questionHolder = new QuestionHolder();
questionHolder.loadScores(questionScores);
questionHolder.loadAverages(questionAverages);
questionHolder.setAnsweredQuestions();
//  console.log('questionHolder', questionHolder);
var elementHolder = new ElementHolder();
var elScores = consolidateElementScores(elementScores);
elementHolder.loadScores(elScores);
elementHolder.loadAverages(elementAverages);
//console.log('elementHolder', elementHolder);
//divMaker(questionHolder);
//Make charts
makeOverallChart(questionHolder);
makeElementCharts(elementHolder, questionHolder);
};
scriptLoader(scripts, scripts.length, onLoad, 0);
});
</script>




{{--            $comment_maker = new \OutputClasses\display\CommentsMaker();--}}
{{--            $question_div_maker = new \OutputClasses\display\QuestionDivMaker();--}}
{{--            //            $q_assign = \QuestionAssignerQuery::create()--}}
{{--            //                ->filterByExamid($visitor->examID())--}}
{{--            //                ->orderByQuestionnumber()->find();--}}
{{--            foreach ($student_scores->question_assigns as $qa) {--}}
{{--            $dao = new \ScoreClasses\dao\ScoreDAO();--}}
{{--            $dao->setExam($exam);--}}
{{--            $student = \StudentQuery::create()->filterById($visitor->studentID())->findOne();--}}
{{--            $dao->setStudent($student);--}}
{{--            $score = $dao->load('question', 'questionnumber', $qa->getQuestionnumber());--}}
{{--            //                $question = $qa->getQuestion();--}}
{{--            //                $score = \QuestionScoreQuery::create()--}}
{{--            //                    ->filterByExamid($visitor->examID())--}}
{{--            //                    ->filterByStudentid($visitor->studentID())--}}
{{--            //                    ->filterByQuestion($question)--}}
{{--            //                    ->findOne();--}}
{{----}}
{{--            if ($score && ($score->getQuestionscore() != null)) {--}}
{{--            echo $question_div_maker->makeOpeningDivTag($qa);--}}
{{--            echo $question_div_maker->makeHeading($qa);--}}
{{----}}
{{--            $ck = new \OutputClasses\service\CommentKludge();--}}
{{--            $ck->setDao(new \ScoreClasses\dao\ScoreDAO());--}}
{{--            $cm = $ck->load_comments_for_question($exam, $student, $qa->getQuestionnumber());--}}
{{--            echo $comment_maker->makeCommentsListOpening($qa->getQuestionnumber());--}}
{{--            foreach ($cm as $c) {--}}
{{--            $txt = $c->modified_comment;--}}
{{--            //                        $txt = '[' . $c->getElementscore() . '] ' . $c->modified_comment;--}}
{{--            echo $comment_maker->addComment($c->getElement()->getId(), $txt);--}}
{{--            }--}}
{{--            echo $comment_maker->makeCommentsListClosing();--}}
{{--            echo $question_div_maker->makeQuestionChartDiv($qa);--}}
{{--            echo $question_div_maker->makeClosingDivTag();--}}
{{--            }--}}
{{--            }--}}

