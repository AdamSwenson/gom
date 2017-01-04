<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <img
                    class="img-responsive"
                    src="{{asset('images')}}"
                    alt="Picture of a student's exam, ready for grading.">
            <div class="carousel-caption">
                <p>....a good exam is a graded exam</p>
            </div>
        </div>

        <div class="item">
            <img
                    class="img-responsive"
                    src="{{asset('images')}}"
                    alt="[TODO Add text version]">
            <div class="carousel-caption">
                <p>Actual student response!</p>
            </div>
        </div>

        <div class="item">
            <img
                    class="img-responsive"
                    src="{{asset('images')}}"
                    alt="[TODO Add text version]">
            <div class="carousel-caption">
                <p>Actual student response!</p>
            </div>
        </div>

        <div class="item">
            <img
                    class="img-responsive"
                    src="{{asset('images/home/partial_example_of_feedback_small.jpeg')}}"
                    alt="[TODO Add text version]">
            <div class="carousel-caption">
                <p>Give helpful feedback</p>
            </div>
        </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>
</div>
<div class="col-xs-1 col-md-2 col-lg-2"></div>
</div>
