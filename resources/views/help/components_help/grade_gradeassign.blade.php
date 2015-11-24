<div class="row">
    <div class="col-lg-6">
        <p class="answer">If you want to use the gradeomatic to assign grades, click the Assign button on the grade exam
            select page. </p>
    </div>
    <div class="col-lg-6">
        @include('help.partials.picture_container',
        ['imageFile' => 'grade_assign/grade_select_page_assign_circled.jpg',
        'altText' =>"Circle around the Assign button on exam selection page.",
        'caption' => 'Manage grade distribution'])
    </div>
</div>


<section id="{{\App\ViewTools\HelpLinks::$assignSetCutoffs['id']}}" class="group">
    <h4 class="text-center">Score adjustment area</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">The gradeomatic calculates the maximum possible score on the exam from the maximum
                scores of each question. It then provides suggestions for the minimum total score necessary for each
                letter grade. </p>

            <p class="answer">To adjust the grade distribution, alter the values in the boxes. The accompanying charts
                will update to show the new distributions. </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade_assign/grade_assign_score_entry.jpg',
            'altText' =>"The portion of the grade assignment page with boxes for the minimum scores of each letter grade.",
            'caption' => 'Adjust cutoffs for grades'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">If you don't want to use a letter, empty the corresponding box and it will not be a possible
                grade.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade_assign/grade_assign_no_plus_minus.jpg',
            'altText' =>"Scores in boxes for plus or minus grades like B+ have been removed so students will only get straight letter grades.",
            'caption' => 'No plus or minus grades'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$assignSave['id']}}" class="group">
    <h4 class="text-center">Save assignments</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">Once you've made the necessary adjustments, click Save Assignments.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade_assign/grade_assign_altered_dist_save_circled.jpg',
            'altText' =>"Grade assignment page with default scores altered and Save Assignments button circled.",
            'caption' => 'Save grade assignments'])
        </div>
    </div>
</section>


<section id="{{\App\ViewTools\HelpLinks::$assignVisualize['id']}}" class="group">
    <h4 class="text-center">Visualizations</h4>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">The upper chart on the right-hand side of the page is a histogram of the number of
                students currently receiving each grade.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade_assign/grade_assign_grade_dist_chart.jpg',
            'altText' =>"Histogram of number of each grade assigned.",
            'caption' => 'Visualizing grade distribution'])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <p class="answer">When assigning grades, it is often helpful to look for natural gaps in student scores. The
                bar chart on the lower right-hand side of the page shows the total exam score for each student along with
                the grade that they would receive under the present distribution.</p>

            <p class="answer"> To help you impartially assign grades, each number on the x axis
                identifies a student ordered by total score from low to high.</p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
            ['imageFile' => 'grade_assign/grade_assign_student_score_chart.jpg',
            'altText' =>"Bar chart showing anonymous students' total exam score and grade.",
            'caption' => 'Visualizing total score distribution'])
        </div>
    </div>
</section>