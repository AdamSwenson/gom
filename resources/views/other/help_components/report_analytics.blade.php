<div class="row">
    <div class="col-lg-6">
        <p class="answer">
            The analytics page is currently under development and thus rather incomplete. Feel free to take a look and
            use
            the tools as they become available.
        </p>

        <p class="answer">Eventually, the analytics page will contain three kinds of tools.
        </p>
        <ol>
            <li>Tools for visualizing and analyzing student performance on the present exam at different levels of
                detail
            </li>
            <li>Tools for quality control in grading. These will help you identify exams on which you might have erred
                in
                grading so that you can return exams with confidence that the grades were fair.
            </li>
            <li>Tools for comparing student performance across different terms and exams. These will help you construct
                better exam questions and improve your teaching.
            </li>
        </ol>
    </div>
    <div class="col-lg-6"></div>
</div>


<h6>Currently available tools</h6>
<div class="row">
    <div class="col-lg-6">
        <p class="answer">Total score box plots: The first chart is a box plot detailing student score variation for
            each
            question. The lines show the lowest and highest grades, the bottom of the box the lowest quartile, the top
            of
            the box the third quartile, and the circles display the mean and median.
        </p>
    </div>
    <div class="col-lg-6">
        @include('other.help_components.picture_container',
    ['imageFile' => 'analytics/report_analytics_chart.jpg',
    'altText' =>"Two boxplots of student scores on questions.",
    'caption' => 'Question boxplots'])
    </div>
</div>
