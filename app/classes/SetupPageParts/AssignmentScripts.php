<?php /*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */ ?>
<div class="scriptBox">
    <script id="qListItem" type="text/x-jQuery-tmpl">
        <p>
        <strong>Question ${questionNumber}</strong> <br />
        Question name: ${questionName} <br />
        Question Description: ${questionTitle}<br />
        <input type="button" class="prettyButton" id="removeQ${questionID}" name="${examID}" data="${questionID}" value="Remove"/>

        <!--Working on this--> <input type="text" class="usedQuestionID" data="${questionID}" />
        <!--Working on this--> <input type="text" class="usedQuestionNumber" value="${questionNumber}" />
        </p>
        <ul id="q${questionNumber}ElementList"></ul>
    </script>

    <script id="eListItem" type="text/x-jQuery-tmpl">
        <li><input type="button" class="prettyButton removeElement" id="removeE${elementID}" name="${examID}" data="${elementID}" value="Remove"/> (${elementAbbr})  ${elementEnglish}  Subtask: ${subtask} </li>
    </script>
</div>
