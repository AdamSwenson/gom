<section id="{{\App\ViewTools\HelpLinks::$exportHow['id']}}" class="group">
    <div class="row">

        <div class="col-lg-6">
            <p>Through the grading process you've assigned grades to each student and created a bunch of important data for improving your teaching. To export the data so that you can use it in a spreadsheet, press the Export button </p>
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'export/export_export_button_circled.jpg',
'altText' =>"The reports page with export button circled.",
'caption' => "Click export"])
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'export/export_download_confirm.jpg',
'altText' =>"Sample browser dialog confirming that you want to download the spreadsheet.",
'caption' => "Download confirmation"])
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
            @include('help.partials.picture_container',
['imageFile' => 'export/export_output_file_example.jpg',
'altText' =>"Example of the spreadsheet downloaded with student scores and grades.",
'caption' => "Example of exported file"])
        </div>
    </div>
</section>