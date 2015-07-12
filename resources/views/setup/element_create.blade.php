@extends('layouts.master')

@section('pageTitle', 'Create and setup tasks')

@section('cssLinks')
    <link href="<?php echo asset('inc/css/navMenuStyles.css');?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/standardStyles.css");?>" type="text/css" rel="stylesheet"/>
    <link href="<?php echo asset("inc/css/commentsetup_new.css");?>" type="text/css" rel="stylesheet"/>
@endsection

@section('body')
    @include("layouts.topbar")
    <div class="pageComponent">

        @for ($qnum = 1; $qnum <= $numberOfQuestions; $qnum++)
            <div class="accordion">
                <h3><a href="#">Q{{$qnum}} No title for now</a></h3>
                <div id='q{{$qnum}}_setup_area' class='commentSetupArea' data="{{$qnum}}">
                    @for($subnum = 1; $subnum <= $numberOfSubtasks; $subnum++)
                        <div id='q{{$qnum}}_sub{{$subnum}}_area' data-questionNumber='{{$qnum}}' data-subtask='{{$subnum}}' class='subtaskArea'>
                            <div class='taskNum'>
                                {{$subnum}} <br/>
                                <div id="s{{$qnum}}_{{$subnum}}_status" class="updateStatus"></div>
                            </div>

                            <div data-elementid="" class="subtask draggable ui-draggable ui-draggable-handle"
                                 id="s{{$qnum}}_{{$subnum}}" style="position: relative;">
                                <div class="subtaskPart elementInfo">
                                    <div class="elementNamesArea">
                                        <div class="elementTextHolder">
                                            <label for="s{{$qnum}}_{{$subnum}}_displayText">Text to display while
                                                grading</label><br>
                                            <input type="text" id="s{{$qnum}}_{{$subnum}}_displayText"
                                                   class="displayText">
                                        </div>
                                        <div class="elementNicknameHolder">
                                            <label for="s{{$qnum}}_{{$subnum}}_element">Task Nickname</label> <br>
                                            <input type="text" class="elementName" id="s{{$qnum}}_{{$subnum}}_element">
                                            <input type="hidden" id="s{{$qnum}}_{{$subnum}}_elementID" value="">
                                        </div>
                                    </div>
                                    <div class="elementSelectArea">
                                        <select data="s{{$qnum}}_{{$subnum}}" id="s{{$qnum}}_{{$subnum}}_element_select"
                                                class="elementSelect">
                                            <option>--past exam subtasks--</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="s{{$qnum}}_{{$subnum}}_commentArea" class="centralComment subtaskPart">
                                    <label for="s{{$qnum}}_{{$subnum}}_commentID">What students needed to do</label><br>
                                    <input type="hidden" class="commentID" id="s{{$qnum}}_{{$subnum}}_commentID"
                                           value="1">
                                    <textarea id="s{{$qnum}}_{{$subnum}}_comment" class="centralComment commentText"
                                              cols="80" rows="6"></textarea>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endfor
    </div>

    <div class="errorArea"></div>
    <div class="pageComponent buttonArea">
        <input type="button" class="prettyButton ui-button ui-widget ui-state-default ui-corner-all" value="Record"
               id="commentsCreate" role="button">
    </div>
    <div class="notes">
        <p>
            Nickname is optional to help reuse questions. If left blank, question will get default nickname
            (exam#question#)
        </p>
    </div>

@endsection

@section('jsArea')
    <script type="text/javascript">var API = 'api.php';
        var COOKIE_PAGENAME = 'examcreate'; </script
    <script type="text/javascript" src="<?php echo asset("inc/js/common.js");?>"></script>
    <script type="text/javascript" src="<?php echo asset("inc/js/examchoicebutton.js");?>"></script>
    <script type="text/javascript" src="<?php echo asset("inc/js/commentSetup.js");?>"></script>

    <input type="hidden" value="579c1b8cdea8240abd80eed3c0a5270003e01954a0d282c3fdc9af4713f739e2"
           data="commentsetup"
           name="formToken" id="formToken">

    <div id="scriptTemplates">
        <script type="text/x-jQuery-tmpl" id="ExamKumiOptionTemplate">
        &lt;option data='${classID}${examID}' value='${classID}${examID}'&gt;${year}  ${term}  ${course}  ${section}  ${examTopic}&lt;/option&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="ExamKumiListTemplate">
        &lt;li data='${classID}${examID}'&gt;${year}  ${term}  ${course}  ${section}  ${examTopic}&lt;/li&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="restrictorOptionTemplate">
        &lt;option data='${type}' value='${value}' class='${type}'&gt;${value}&lt;/option&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="restrictorListTemplate">
        &lt;li class='${type} restrictorListItem' data='${value}'&gt;
            ${value} &lt;input type='button' class='restrictorDelete prettyButton' value='Delete' data='${value}' /&gt;
        &lt;/li&gt;
    




        </script>

        <script type="text/x-jQuery-tmpl" id="lockedRestrictorListTemplate">
        &lt;li class='${type} restrictorListItem' data='${value}'&gt;
            ${value} &lt;span class="ui-icon ui-icon-locked" style="display: inline-block"&gt;&lt;/span&gt;
        &lt;/li&gt;
    




        </script>
    </div>
    <!--templates-->

    <script type="text/javascript">
        var currentExamComments;
        var comments = {
            "0": {
                "elementID": 1,
                "elementName": "repudiandae",
                "displayText": "Rerum ipsa.",
                "commentID": 1,
                "commentText": "Qui possimus quaerat ducimus. Perspiciatis qui et quod aspernatur architecto illum consequatur. Sed commodi voluptatem recusandae nihil. Numquam voluptatem consequuntur perspiciatis quaerat est sint.\nQuia corporis ut ullam et. Architecto quo eaque adipisci id ea deserunt est. Aut qui dolorem autem. Beatae itaque nemo et consequatur praesentium.\nRepudiandae culpa voluptatem id quibusdam itaque. Dolore delectus ipsa reprehenderit dicta. In sed voluptas doloribus. Ut vel alias adipisci qui illo perspiciatis occaecati.\nIpsum maxime dolor recusandae non. Magni vel velit dicta nemo minus maiores. Omnis in qui debitis molestiae aut voluptatem. Libero et quis itaque quis suscipit sit sequi.\nEt voluptas eum quibusdam architecto aspernatur earum repudiandae. Pariatur consequatur et laudantium rerum quae. Voluptatem earum vel aut est. Ratione quas est vitae."
            },
            "1": {
                "elementID": 2,
                "elementName": "nisi",
                "displayText": "Voluptatem.",
                "commentID": 2,
                "commentText": "Rerum sit amet fuga ipsum mollitia. Qui eaque sed cumque eveniet.\nDolore maxime explicabo iure et aut maiores nostrum. Culpa rerum voluptatem sunt voluptatem autem voluptates. Unde non recusandae neque voluptatem.\nVel vel nihil amet culpa veniam amet. Ipsam perspiciatis et magnam ut. Dolorem sed inventore ex culpa harum quos. Qui perferendis molestias ea qui.\nMinus est amet vel molestiae ut repellat. Ratione quae fugit quaerat ipsa enim quam quod.\nNobis sapiente minus voluptatibus eos qui voluptas sapiente. Eius autem magnam eligendi suscipit fuga deserunt architecto. Vel consequatur eius est nobis ut sit neque id.\nSunt placeat rerum dolorem ad eum aut sequi. Aut quisquam quis eos eum inventore sit. Sint et dolore dolore officia.\nOdio sed eius rerum esse est dolorum. Aut voluptas sint quis itaque explicabo. Dicta in non qui dolor natus dolorem."
            },
            "2": {
                "elementID": 3,
                "elementName": "rerum",
                "displayText": "Ad et illo.",
                "commentID": 3,
                "commentText": "Voluptas delectus cupiditate doloremque accusamus voluptatibus. At possimus ut veniam ea repudiandae distinctio fugiat.\nEveniet eos corporis voluptas. Vero beatae fugiat dolorum debitis. Qui debitis nulla dolor sint animi omnis. Aut nemo totam sed voluptatum consequatur.\nExplicabo eum est veritatis fugiat vel eos sit. Placeat corrupti nemo ratione. Voluptate quasi molestiae sapiente. Autem sit est laboriosam.\nLaudantium animi eos libero fugit nostrum voluptas omnis. Sequi provident ut qui sed aut qui. Dolor voluptas sed eligendi.\nIllo eos quibusdam facere quos. Omnis aut voluptate nisi qui aut eum. Consequuntur voluptas ipsam minus.\nAutem animi porro et blanditiis vel. Et et corporis explicabo magnam dolor velit quaerat.\nUt quis possimus ut quia blanditiis eveniet. Aut sunt velit quibusdam quia perspiciatis. Dolore soluta esse et ut aspernatur magnam doloremque."
            },
            "3": {
                "elementID": 4,
                "elementName": "quia",
                "displayText": "Quae in.",
                "commentID": 4,
                "commentText": "Et nesciunt maiores vitae eum. Nihil sed laudantium autem accusamus. Id et provident aliquam aliquid. Occaecati architecto illo voluptatem expedita sunt sunt culpa.\nDeleniti vero assumenda id dolorum error praesentium. Aliquid eum soluta dolorem voluptatem commodi. Ipsam non quia dignissimos sed debitis esse.\nQuia praesentium reiciendis aliquid aperiam voluptas numquam. Ipsum expedita vel doloremque architecto autem. Occaecati est quia molestias accusantium pariatur voluptatem.\nVitae vel sint modi qui architecto ipsum. Odio pariatur repellendus non magni unde. Incidunt sit distinctio sint non fugit aut voluptatem.\nNeque doloremque natus aliquam aliquam corporis voluptatem. Quidem veniam id possimus qui libero. Temporibus neque explicabo alias. Quia cum sint quia minima culpa aut."
            },
            "4": {
                "elementID": 5,
                "elementName": "saepe",
                "displayText": "Ut unde ab aut.",
                "commentID": 5,
                "commentText": "Voluptas tempora aspernatur porro est ipsa. Qui sit veniam iure. Id dolorem a repellat vel.\nPossimus quam consectetur dicta ratione. Suscipit sint eos dolore dignissimos dolorum error voluptas. Qui sint atque ut nobis nam.\nUt rem sed molestiae maiores distinctio. Voluptas debitis exercitationem illum quos explicabo et. Qui repellat architecto quia magni fuga similique.\nAccusamus ex maiores sapiente architecto aut adipisci voluptatum eos. Doloremque odit omnis accusamus accusamus sint. Ut culpa voluptatem numquam exercitationem.\nOmnis adipisci aut quis et sint blanditiis. Cum saepe odit asperiores qui eos. Est quam sint illo repellat nostrum. Consequatur animi voluptates soluta numquam itaque.\nSaepe consectetur sint beatae ut voluptatibus et accusamus. Qui repudiandae porro at pariatur iusto unde. Consequatur officiis dolorum enim eos quia provident."
            },
            "5": {
                "elementID": 6,
                "elementName": "ipsa",
                "displayText": "Ut sit eaque.",
                "commentID": 6,
                "commentText": "Cumque nemo rerum eaque. Quam dolorem aut rerum autem incidunt sapiente expedita soluta.\nImpedit harum vel dignissimos ex molestiae consequatur. Autem ex quo veritatis temporibus odio. Harum voluptas vel illo et necessitatibus.\nQuia aut at quia rerum enim. Odit et voluptatum possimus consequatur. Doloremque magnam nam distinctio neque sit ut. Consequuntur ducimus sunt rerum est enim.\nNon est libero quibusdam est. Amet aut vel sapiente ut eos.\nMolestias aliquam laborum explicabo possimus enim natus sunt. Eius dolor sed corrupti sunt. Aliquid ut sed natus officiis numquam quos ut. Quaerat iste qui nulla quidem non.\nPerspiciatis voluptate ut nihil accusantium ab ea. Facilis dolor dolore doloremque. Sit fuga explicabo totam est est in nihil."
            },
            "6": {
                "elementID": 7,
                "elementName": "aspernatur",
                "displayText": "Dolor est.",
                "commentID": 7,
                "commentText": "Animi magni quod provident in. Ut quaerat iste temporibus molestiae quia ipsa enim. Quia omnis et veniam libero. Qui sunt nam minima voluptatem debitis libero natus.\nNatus assumenda debitis aut ut. Debitis est vel suscipit asperiores beatae incidunt nam. Laudantium et quia sequi ut dignissimos.\nCorrupti aut explicabo qui adipisci. Ducimus animi inventore ut quia. Doloremque nostrum distinctio est. Quo quas voluptatem ea aut sint labore.\nSit aspernatur asperiores eveniet assumenda laboriosam et. Sit ratione minima modi itaque. Nihil velit et et autem. Ullam doloremque iure ut commodi.\nIpsum molestiae veniam qui rerum modi quo aut. Quis at consectetur et corporis. Enim ad rem nisi error voluptate molestiae architecto. Et id animi iure quia ut labore consequatur voluptatem."
            },
            "7": {
                "elementID": 8,
                "elementName": "est",
                "displayText": "Omnis qui.",
                "commentID": 8,
                "commentText": "Et tenetur necessitatibus sed rerum distinctio possimus voluptatem necessitatibus. Alias vel officiis exercitationem aperiam. Consequatur dolorem sunt quaerat.\nVoluptas voluptas quo impedit ipsum et repellendus. Est delectus cupiditate deserunt quod. Natus tempora aut dolor voluptatem ex consequatur dolores. Dolor debitis non in ut amet.\nIn eos ut aut dolorum. Ut voluptas in mollitia illo facere. Eaque itaque ipsa modi est aspernatur.\nAut doloribus doloribus sit architecto sunt et. Quos velit omnis quo commodi et perspiciatis sint quia. Consequatur dignissimos itaque in earum perspiciatis.\nUt dignissimos sunt aliquam eveniet fuga reprehenderit. Aut voluptatem laborum minima qui eaque consequatur. Debitis accusamus qui quo voluptas impedit."
            },
            "8": {
                "elementID": 9,
                "elementName": "qui",
                "displayText": "Id omnis atque.",
                "commentID": 9,
                "commentText": "Quasi quia accusamus dolor. Nisi accusamus nam atque est inventore. Accusamus assumenda dolorem doloribus magnam necessitatibus maxime. Consequatur autem cum velit culpa iste praesentium ullam facere.\nOccaecati harum blanditiis qui et debitis iusto quia. Fugiat atque tempore asperiores explicabo in non ea. Eaque enim nihil aut quasi. Nostrum facilis architecto placeat sequi.\nConsequatur alias est nihil qui nam accusamus. Ut voluptatibus laudantium facere beatae illo dolorum.\nEveniet voluptas voluptates quibusdam rem. Eveniet et alias quisquam est hic. Corporis est omnis fuga. Rerum harum laborum et.\nBeatae quia in suscipit quam corporis. Quam quisquam omnis beatae nam facere. Molestiae nam dolores officiis qui voluptas.\nEx id voluptas et veritatis incidunt. Facilis inventore dolore blanditiis molestiae minima voluptatum sit."
            },
            "9": {
                "elementID": 10,
                "elementName": "consequatur",
                "displayText": "Cupiditate.",
                "commentID": 10,
                "commentText": "Tempora explicabo nisi facere aliquid. Architecto amet enim ut laborum. Atque deserunt rem itaque.\nA possimus consequatur magnam dolorem officiis fuga esse. Dolor molestiae error vero facilis deserunt. Cupiditate tempore praesentium voluptatem hic modi ratione. Necessitatibus id molestias ad quidem harum ad unde aliquam.\nConsequatur magni quae in perspiciatis. Distinctio dolore consequatur reiciendis. Ullam sunt qui nihil. Animi quia quam non consequatur veritatis.\nEt illum dolores illum sit sed quas et dolorem. Et cupiditate totam animi expedita qui. Amet cupiditate nostrum illum aliquam. Non repellendus fugit quam ex et.\nMolestiae enim in ut. Non nostrum quos rerum consequuntur. Voluptas illo exercitationem est iusto voluptate vero."
            },
            "10": {
                "elementID": 11,
                "elementName": "et",
                "displayText": "Velit.",
                "commentID": 11,
                "commentText": "Atque quo distinctio quibusdam quia qui dolorem rem qui. Dolore sed voluptatem magni aut exercitationem ut nostrum. Et dolore voluptatem velit et. Sunt est pariatur quos ullam repudiandae.\nCum id aut ut. Aspernatur ea dolorum numquam impedit ut pariatur voluptatem. Aliquid commodi tempora quasi culpa ipsa labore magnam.\nCulpa dicta exercitationem et. Dolor numquam quo odio voluptates officia nam. Occaecati et dicta omnis ut officiis voluptas.\nMinima debitis culpa provident numquam. Et qui esse non corrupti. Asperiores sit dolor illo eligendi fugiat corporis. Voluptatum reiciendis ad iste et facere.\nAccusamus et voluptates delectus nam hic. Voluptas corrupti facilis dolorum nam. Et velit laudantium repellendus minima. Sed quisquam nisi sint."
            },
            "11": {
                "elementID": 12,
                "elementName": "omnis",
                "displayText": "Enim ex quas.",
                "commentID": 12,
                "commentText": "Est perferendis pariatur itaque atque et labore. Laudantium assumenda maiores deleniti dolores iste voluptas sit. Magni enim enim dignissimos quos natus ut. Aut tempora delectus quibusdam velit est fuga animi.\nUt quia suscipit voluptate. Aut dolores et illo quasi maxime est quasi. Tenetur in sequi sit. Quo quia quibusdam et asperiores non alias ratione magni.\nA enim est alias porro. Iure ad autem velit laudantium quia nobis qui. Voluptatibus et incidunt et laboriosam. Possimus sit commodi accusamus fugiat corporis expedita enim voluptates.\nSaepe ipsam maxime doloribus debitis consectetur ut voluptatem. Id nam qui id. Nemo maxime facilis ducimus quis.\nEt dignissimos sit recusandae quisquam reprehenderit quae reprehenderit. Quas cum sequi aut ullam et harum. Qui repellendus sapiente est consequatur."
            },
            "12": {
                "elementID": 13,
                "elementName": "incidunt",
                "displayText": "Et iusto nam.",
                "commentID": 13,
                "commentText": "Aut est sequi nobis sit odit. Modi iusto assumenda est vitae cum aperiam. Dolore molestiae eligendi et ipsam rerum tempora. Ducimus aperiam quia consequuntur ad.\nOfficia nisi sapiente aliquid temporibus similique. Et non vel voluptatum. Vel laudantium architecto ut.\nIn fuga rerum totam corrupti. Animi consequatur eaque exercitationem velit. In rerum neque dolor in quis. Alias tempora fuga nobis nihil.\nOmnis quisquam enim molestiae. Laboriosam sit illo autem distinctio ipsam quo. Minus rerum velit repudiandae. Officia natus suscipit consequatur consequatur nulla.\nQuia quam occaecati aut veniam laborum. Porro temporibus minima recusandae harum facere voluptatibus quasi. Velit optio recusandae dolor voluptas.\nUnde et dolore exercitationem qui harum. Quas et rem dolor neque aliquid. Fugiat vel pariatur quod et."
            },
            "13": {
                "elementID": 14,
                "elementName": "voluptas",
                "displayText": "Quo quia.",
                "commentID": 14,
                "commentText": "Animi consequatur rerum ducimus ut sint. Eum et veniam ea consectetur dolores illum. Sint nostrum corrupti quod ducimus.\nEligendi iure non similique aliquid qui in ipsum voluptatem. Maxime deserunt recusandae pariatur fugiat rem omnis nam libero. Qui sunt expedita eveniet.\nAspernatur provident dolores ut maiores et sit qui. Voluptate dignissimos corrupti natus quis a. Vitae quo sit aliquid doloremque molestias.\nQui occaecati amet quasi dignissimos omnis laudantium. Est nemo nihil harum vel maiores veritatis facilis sit. Numquam doloribus consequatur sequi iste neque et.\nOdit nulla est qui voluptate necessitatibus sint nemo. Nostrum doloribus enim sed. Tempora accusamus ullam molestias esse nihil praesentium consequatur ad. Sint aliquid itaque libero et amet molestiae."
            },
            "14": {
                "elementID": 15,
                "elementName": "laboriosam",
                "displayText": "Harum et vero.",
                "commentID": 15,
                "commentText": "Vel possimus qui soluta. Tempora quis recusandae sit quis voluptates sit. Voluptatem reprehenderit ipsa velit aut. Corrupti pariatur cumque omnis vero omnis quam. Est quia debitis magni rem distinctio.\nItaque nostrum et aliquid blanditiis. Sed architecto excepturi harum voluptas tempore. Quo delectus magnam nihil nihil. Facere a sit sed id vitae ipsam quibusdam et. Delectus soluta necessitatibus inventore consequatur assumenda qui.\nNam et deserunt corporis ullam. In autem unde quidem impedit est et at. Sed omnis doloribus quos quis. Sit molestias dolores deserunt saepe minima dignissimos quasi.\nQuibusdam voluptatem voluptas facere praesentium aut. Accusamus iste pariatur iure ducimus. Rem nihil voluptas explicabo nisi at itaque esse. Voluptas in nostrum iure velit.\nRecusandae eum dignissimos ut sint non molestiae. Iste optio minus accusamus."
            },
            "15": {
                "elementID": 16,
                "elementName": "quam",
                "displayText": "Expedita omnis.",
                "commentID": 16,
                "commentText": "Alias at in consequuntur consequatur. Dolorem sit cum repellat ut veritatis voluptates hic. Voluptas quis dolores sint. Quam quis officiis animi consequatur.\nQuia eligendi est aut sed omnis molestiae sed illo. Laboriosam sit molestiae autem.\nArchitecto quod incidunt aliquam officia non optio ad. Voluptatibus aliquid nesciunt quidem. Est non et beatae quibusdam. Aut repudiandae aut odit.\nLaborum eum ut repellat similique est. Ex placeat nulla omnis delectus in autem. Perferendis nam quia nulla dolores sit soluta et.\nPerspiciatis dolore autem excepturi perspiciatis. Et dignissimos consequatur deleniti est. Quia autem dignissimos occaecati iure. Velit magni perferendis itaque ab.\nExplicabo magnam temporibus quis qui animi. Sed ea aperiam voluptatem repudiandae dolore cupiditate. Possimus suscipit odit facere voluptas maxime eius qui."
            },
            "16": {
                "elementID": 17,
                "elementName": "quam",
                "displayText": "Quam cumque.",
                "commentID": 17,
                "commentText": "Rem quia soluta magnam nihil quasi qui voluptas voluptas. Quas repellendus recusandae eos fuga et ipsa. Laboriosam harum iste adipisci sed.\nCulpa ut omnis voluptates ullam enim officia. Quam aut id minus omnis quia blanditiis. Qui quo et illo vel ipsum distinctio optio.\nDeserunt et et exercitationem aliquam placeat numquam. Expedita facere pariatur odio nobis atque delectus quae. Sed inventore quis sit ratione ut reprehenderit ea.\nEius ullam quae quae animi quaerat dolores ad. Totam aspernatur provident ut laboriosam adipisci officiis itaque. Sit alias aut placeat eos maxime blanditiis.\nLaborum tempora itaque pariatur fugiat quisquam quasi. Vero possimus consequuntur quis voluptas dolorem. Culpa vitae occaecati suscipit iste ullam. Ipsa quia fugit quae ut temporibus ut.\nQui in ut voluptatem non accusamus voluptatum. Rerum possimus beatae et qui. Est est ex rerum eum dolorem non."
            },
            "17": {
                "elementID": 18,
                "elementName": "excepturi",
                "displayText": "Qui minima.",
                "commentID": 18,
                "commentText": "Quis tenetur non molestias ea et blanditiis quod saepe. Explicabo est quo et deserunt reprehenderit delectus omnis ullam. Esse assumenda laboriosam et quis.\nExpedita aut corporis est qui ad. Harum omnis quaerat libero consequatur. Expedita quos suscipit qui eligendi quas.\nConsequatur voluptatem eligendi est perferendis error dicta deserunt. Dolor vel excepturi amet ipsum nobis culpa voluptatem. Nam velit ad assumenda nulla voluptatum accusantium est.\nVoluptas facilis esse et. Laboriosam dolores doloribus et ut ipsam porro. Error quo et aut tempora ullam quo.\nCupiditate quibusdam sed reiciendis id tempore porro a. Vero et totam non esse magni qui placeat. Eum consectetur vero fugit pariatur sint quisquam.\nDolore qui id deleniti fugit possimus veritatis ipsum. Non ipsum esse quia est sunt est labore."
            },
            "18": {
                "elementID": 19,
                "elementName": "excepturi",
                "displayText": "Nostrum.",
                "commentID": 19,
                "commentText": "Molestias facere deserunt molestiae deserunt aut. Id eveniet libero optio ratione dolorem quia sit. Sit ab nihil consequatur dicta est autem a.\nEum aut voluptatem et excepturi modi doloribus aliquid. Aut consectetur dolorem in sunt.\nAutem sed repellendus in et exercitationem. Iure in veniam qui sequi et soluta. Asperiores eligendi aliquam iste quibusdam. Itaque perspiciatis et dolor sapiente molestiae.\nQuia quia mollitia perspiciatis reiciendis iure voluptas fugiat. Atque voluptatem asperiores impedit iste est adipisci. Tempore sint quia facere aut amet vero sed. Cum optio nulla ut eos laudantium dolores repudiandae.\nQuaerat eaque est voluptatum officia. Illo ducimus commodi quia cupiditate quaerat est aut. In quam aut vitae assumenda."
            },
            "19": {
                "elementID": 20,
                "elementName": "dolorem",
                "displayText": "Ut doloribus.",
                "commentID": 20,
                "commentText": "Voluptatem corrupti minima velit voluptatem. Ex sint tenetur recusandae. Voluptas aut voluptas enim sint ducimus. Voluptas illum aut tempora assumenda dolor aut quis ipsam.\nAccusantium quis deserunt expedita ratione qui. Odio dolor dolor vitae molestiae ad iusto dolorem voluptates. Nam repellat provident inventore recusandae. Voluptates est labore quia iusto sint ipsam qui.\nOfficia doloremque dolorem quam. Quidem sed asperiores iusto.\nMolestiae atque deserunt est fugit. Sapiente quia dolorem tempore consequatur iusto voluptate fugit. Voluptate et dolore perspiciatis asperiores accusantium.\nUt ut vel consectetur ut in quam voluptatibus. Vel vitae sed quaerat quibusdam deserunt. Magni impedit voluptatum nemo cupiditate quibusdam.\nFacilis quo dolores nam veniam neque error totam. Hic quia harum expedita veritatis molestias ipsa officiis. Debitis amet qui ea eum."
            },
            "20": {
                "elementID": 21,
                "elementName": "animi",
                "displayText": "Facere beatae.",
                "commentID": 21,
                "commentText": "Cupiditate fugiat amet harum nesciunt. Nihil deserunt voluptas et magnam vel. Assumenda tempore dolorum quis est. Consequatur quis expedita excepturi numquam.\nDolorem id enim suscipit quis numquam odit facere accusamus. Quisquam molestias incidunt quos recusandae quia facilis voluptatem. Sit itaque molestiae asperiores.\nPerferendis sint consequatur et saepe amet est in. Suscipit corporis vel et sed perferendis incidunt fuga. Nemo dolor et sapiente. Et architecto et tempora aut rerum qui voluptatem.\nMaxime recusandae officia odit rerum. Aut qui sit reprehenderit et. Saepe a tenetur illo odit ipsa unde et iure. Id voluptates harum porro quae reiciendis nam."
            },
            "21": {
                "elementID": 22,
                "elementName": "odio",
                "displayText": "Laboriosam sit.",
                "commentID": 22,
                "commentText": "Non odio ullam reiciendis modi in. Aperiam natus reprehenderit consequatur eveniet nisi. Aut consequatur ducimus earum autem eius sint. Quae numquam perferendis et eum dolores voluptatem.\nAccusantium sint odit in et. Temporibus facere enim fuga doloremque dolores. Repudiandae libero aut mollitia quia vel. Rerum doloremque natus officia ducimus et eos sunt.\nExercitationem enim voluptatem qui in itaque nesciunt. Odit autem tenetur et excepturi aut tenetur velit. Consequatur sed molestiae a cumque rerum. Esse iste reprehenderit omnis et quia et optio.\nNisi officiis aliquam totam fugit. Quisquam officiis tempore molestiae. Dicta provident sint aut sit itaque fugiat aliquam natus.\nReiciendis exercitationem possimus fuga odit totam deleniti nihil. Architecto recusandae corporis eveniet esse commodi ut quibusdam. Quisquam eius suscipit odit dolor sequi."
            },
            "22": {
                "elementID": 23,
                "elementName": "et",
                "displayText": "Vitae error.",
                "commentID": 23,
                "commentText": "Voluptatem quaerat aut ex autem magnam eum consequuntur. Est saepe quaerat doloremque officia consequatur. Nobis dolorum a autem.\nMinima sed excepturi ducimus molestiae consequatur. Nihil doloremque odit aspernatur error ut corporis. Asperiores sit sit commodi assumenda qui. Placeat nulla commodi velit ut.\nOdit quia dolorum aspernatur cupiditate harum. Excepturi illum nam laudantium.\nNobis quas repellat optio quia praesentium nisi corporis ducimus. Ipsa et voluptatum praesentium quo iure. Non delectus expedita qui mollitia et est.\nDucimus expedita fugiat quia ut beatae. Accusamus molestias in totam illum ut error facere. Quam laborum rerum velit recusandae dolores minus. Quas ut rerum occaecati tempora praesentium veniam dolor. Velit modi quidem voluptate et iure qui et deserunt."
            },
            "23": {
                "elementID": 24,
                "elementName": "perferendis",
                "displayText": "Quia et.",
                "commentID": 24,
                "commentText": "Voluptate voluptas pariatur explicabo et. Consectetur in autem consequatur doloribus. Aut beatae aut quisquam facere autem a et.\nNatus deleniti voluptatem dolorum nihil aliquid nihil voluptas. Recusandae saepe nisi totam vitae est officiis labore. Architecto consequatur neque similique suscipit rem.\nQuis omnis animi asperiores repellat in. Libero sed esse et aut. Maiores quo id at asperiores et et. Quia sint omnis optio est qui eos distinctio cumque.\nQuam ut saepe non quo sit hic quod repellendus. Eum et voluptas aut quo occaecati doloremque dolore. Sed accusantium quo expedita eveniet ad incidunt maxime et. Dolor explicabo repellat consequatur itaque et.\nTemporibus esse dolore qui doloribus. Ducimus voluptatibus libero animi voluptatibus cumque sit eum. Fugit praesentium id occaecati amet qui quia. Nostrum temporibus ea voluptatem eaque qui quae."
            },
            "24": {
                "elementID": 25,
                "elementName": "sunt",
                "displayText": "Animi iste ut.",
                "commentID": 25,
                "commentText": "Voluptatem accusamus illo cum reprehenderit itaque dolorum nemo recusandae. Hic sed et quod quos ut. Et natus cumque quas et magni sunt eum. Eos quia sapiente rem nemo dolore.\nLabore et praesentium blanditiis eius. Maxime impedit sit esse voluptatem ea sint soluta aperiam. Quae quibusdam quo odit incidunt.\nVitae soluta tempore minus. Omnis veritatis quasi optio dicta maiores consectetur iusto. Aut aliquid quam repellat. Et maxime id similique vel.\nUt assumenda magnam nostrum. Qui temporibus explicabo modi aut eum. Ut qui aut est omnis.\nQui aut voluptatem non dolor occaecati sit. Illo itaque vitae vero eius quia odit. Laborum rerum recusandae possimus sequi ad. Facere est et voluptatibus odio ut quis nisi. Ex qui nisi voluptatem non.\nNesciunt suscipit sit aut aut. Similique quae nam ipsa et saepe. Quod magni consectetur illo quia. Rem aut sit ut libero et minus ea eum."
            },
            "25": {
                "elementID": 26,
                "elementName": "unde",
                "displayText": "Provident.",
                "commentID": 26,
                "commentText": "Quo voluptatem qui omnis quia hic tempore rerum aliquid. Est dicta et cum eius. Accusantium doloribus provident dicta ipsa molestias totam. Odit voluptas quas qui dicta ex doloremque est.\nDebitis voluptas architecto ut magni aliquid omnis. Deleniti nulla quo quisquam voluptatem et omnis. Quia voluptas ea deleniti quia temporibus dolores atque sint. Quia qui et commodi veritatis est odit quia.\nVoluptas error facilis quia. Hic eum quo tenetur itaque. Ut doloribus ex placeat aut fugiat est nemo.\nQui earum dolorem unde vel et tenetur. Beatae quisquam iure natus voluptas sed. Temporibus fugit quo sunt est ad enim. Et tenetur quaerat et similique nulla. Velit autem adipisci consectetur omnis minus cum.\nExpedita deserunt ipsum nobis illum suscipit quis. Hic quia suscipit ut debitis nam nulla. Ab beatae omnis culpa sapiente veniam voluptatem. Et eos temporibus labore ut."
            },
            "26": {
                "elementID": 27,
                "elementName": "quia",
                "displayText": "Laudantium.",
                "commentID": 27,
                "commentText": "Accusantium laudantium quia fuga nesciunt nihil consectetur. Et accusantium earum nisi animi. At saepe sit voluptatem sequi est. Cupiditate consequuntur vel voluptate labore praesentium.\nQui laboriosam dolore eos aperiam hic consequatur assumenda. Ut mollitia qui iste expedita neque similique. Aspernatur tenetur sequi itaque aut accusamus. Est ullam beatae in totam.\nOdio ipsa ut exercitationem rem numquam esse. Quibusdam placeat molestiae repellat consequatur. Provident et qui iusto consequatur doloribus.\nEos corporis beatae voluptates dignissimos. Consequuntur possimus nihil et delectus nostrum eos. Non adipisci facere et velit impedit fuga esse.\nHarum qui possimus ducimus excepturi velit. Quos velit voluptas atque quo odit repudiandae. Pariatur omnis quia provident ut asperiores nihil. Debitis adipisci neque ea sit."
            },
            "27": {
                "elementID": 28,
                "elementName": "eum",
                "displayText": "Dignissimos.",
                "commentID": 28,
                "commentText": "Hic illum eius a est. Quam iusto sequi dolor veritatis voluptas. Modi expedita sapiente molestiae ipsam cum fugit. Repellendus quasi doloremque quasi placeat temporibus.\nSuscipit dolor dolorum in fuga ducimus. Exercitationem ipsam nulla dicta non ex quia esse. Expedita voluptatem modi eligendi quam ut voluptatibus.\nEst saepe iusto est accusamus in quos occaecati. Non culpa beatae sint odio eos velit tenetur. In quidem eos enim itaque rerum qui adipisci.\nAut consequatur labore qui distinctio optio provident. Ut laborum alias est magni. Pariatur sed et consequatur velit dolor.\nConsequatur veritatis rerum quaerat nostrum nemo rerum veniam. Inventore ipsum enim rerum voluptatem. Tempora magnam possimus veniam a.\nUt nemo quia sunt tenetur facere reiciendis. Vel harum quidem est fugit. Quia assumenda est nam omnis aliquid porro."
            },
            "28": {
                "elementID": 29,
                "elementName": "labore",
                "displayText": "Magnam.",
                "commentID": 29,
                "commentText": "Tempore deleniti nobis necessitatibus unde. Aperiam eum qui praesentium illum voluptatum natus ut. Non nisi repudiandae et earum nam. Magni voluptatibus molestias doloremque provident vitae omnis consectetur.\nPerspiciatis magni aliquid fugiat reiciendis. Temporibus repellat corrupti est et sunt esse ullam. Placeat enim impedit error quo dolores sint. Quia non rerum ut id asperiores enim.\nEst quisquam quaerat ut eos. Unde iure sit et explicabo et inventore dicta earum. Voluptatem sed accusantium iusto qui a atque aut.\nQuia qui earum voluptatem aperiam sunt sunt sint. Rerum et consequatur quidem ipsa voluptatum. Itaque illo facere distinctio voluptatem. Id consequatur necessitatibus voluptatem quam et consequuntur.\nAd quidem odit ut ipsa quis. Qui blanditiis autem error consequatur velit quo rerum. Voluptas voluptate blanditiis beatae sit."
            },
            "29": {
                "elementID": 30,
                "elementName": "ad",
                "displayText": "Blanditiis ea.",
                "commentID": 30,
                "commentText": "Qui sint nostrum qui necessitatibus. Vitae sint inventore vero at quod sed doloremque. Vitae eos est iusto vero iste corporis sapiente. Atque deserunt aut exercitationem asperiores exercitationem nihil numquam.\nQuis nesciunt reiciendis et possimus vel eos. Alias officiis doloribus reprehenderit repudiandae. Saepe impedit odio error sit qui suscipit asperiores eveniet. Aliquid at eos aut exercitationem facilis voluptas sit deserunt.\nRerum officia odio neque quis provident soluta temporibus. Dignissimos facere aut voluptatem error consectetur saepe possimus itaque. Id expedita aliquam rerum pariatur numquam vero.\nAccusamus quibusdam in ut magnam vero non. Et deserunt corporis perferendis eaque nesciunt. Error facere neque illum et laborum voluptatem non. Ullam nemo in velit. Sapiente ut architecto repellat aut sunt."
            },
            "30": {
                "elementID": 31,
                "elementName": "testelement name",
                "displayText": "",
                "commentID": 31,
                "commentText": null
            }
        };
    </script>
    <script type="text/javascript">
        currentExamComments = {
            "0": {
                "subtask": 1,
                "questionNumber": 1,
                "elementID": 1,
                "questionID": 2,
                "elementName": "repudiandae",
                "elementText": "Rerum ipsa.",
                "commentID": 1,
                "commentText": "Qui possimus quaerat ducimus. Perspiciatis qui et quod aspernatur architecto illum consequatur. Sed commodi voluptatem recusandae nihil. Numquam voluptatem consequuntur perspiciatis quaerat est sint.\nQuia corporis ut ullam et. Architecto quo eaque adipisci id ea deserunt est. Aut qui dolorem autem. Beatae itaque nemo et consequatur praesentium.\nRepudiandae culpa voluptatem id quibusdam itaque. Dolore delectus ipsa reprehenderit dicta. In sed voluptas doloribus. Ut vel alias adipisci qui illo perspiciatis occaecati.\nIpsum maxime dolor recusandae non. Magni vel velit dicta nemo minus maiores. Omnis in qui debitis molestiae aut voluptatem. Libero et quis itaque quis suscipit sit sequi.\nEt voluptas eum quibusdam architecto aspernatur earum repudiandae. Pariatur consequatur et laudantium rerum quae. Voluptatem earum vel aut est. Ratione quas est vitae."
            },
            "1": {
                "subtask": 2,
                "questionNumber": 1,
                "elementID": 2,
                "questionID": 2,
                "elementName": "nisi",
                "elementText": "Voluptatem.",
                "commentID": 2,
                "commentText": "Rerum sit amet fuga ipsum mollitia. Qui eaque sed cumque eveniet.\nDolore maxime explicabo iure et aut maiores nostrum. Culpa rerum voluptatem sunt voluptatem autem voluptates. Unde non recusandae neque voluptatem.\nVel vel nihil amet culpa veniam amet. Ipsam perspiciatis et magnam ut. Dolorem sed inventore ex culpa harum quos. Qui perferendis molestias ea qui.\nMinus est amet vel molestiae ut repellat. Ratione quae fugit quaerat ipsa enim quam quod.\nNobis sapiente minus voluptatibus eos qui voluptas sapiente. Eius autem magnam eligendi suscipit fuga deserunt architecto. Vel consequatur eius est nobis ut sit neque id.\nSunt placeat rerum dolorem ad eum aut sequi. Aut quisquam quis eos eum inventore sit. Sint et dolore dolore officia.\nOdio sed eius rerum esse est dolorum. Aut voluptas sint quis itaque explicabo. Dicta in non qui dolor natus dolorem."
            },
            "2": {
                "subtask": 3,
                "questionNumber": 1,
                "elementID": 3,
                "questionID": 2,
                "elementName": "rerum",
                "elementText": "Ad et illo.",
                "commentID": 3,
                "commentText": "Voluptas delectus cupiditate doloremque accusamus voluptatibus. At possimus ut veniam ea repudiandae distinctio fugiat.\nEveniet eos corporis voluptas. Vero beatae fugiat dolorum debitis. Qui debitis nulla dolor sint animi omnis. Aut nemo totam sed voluptatum consequatur.\nExplicabo eum est veritatis fugiat vel eos sit. Placeat corrupti nemo ratione. Voluptate quasi molestiae sapiente. Autem sit est laboriosam.\nLaudantium animi eos libero fugit nostrum voluptas omnis. Sequi provident ut qui sed aut qui. Dolor voluptas sed eligendi.\nIllo eos quibusdam facere quos. Omnis aut voluptate nisi qui aut eum. Consequuntur voluptas ipsam minus.\nAutem animi porro et blanditiis vel. Et et corporis explicabo magnam dolor velit quaerat.\nUt quis possimus ut quia blanditiis eveniet. Aut sunt velit quibusdam quia perspiciatis. Dolore soluta esse et ut aspernatur magnam doloremque."
            },
            "3": {
                "subtask": 4,
                "questionNumber": 1,
                "elementID": 4,
                "questionID": 2,
                "elementName": "quia",
                "elementText": "Quae in.",
                "commentID": 4,
                "commentText": "Et nesciunt maiores vitae eum. Nihil sed laudantium autem accusamus. Id et provident aliquam aliquid. Occaecati architecto illo voluptatem expedita sunt sunt culpa.\nDeleniti vero assumenda id dolorum error praesentium. Aliquid eum soluta dolorem voluptatem commodi. Ipsam non quia dignissimos sed debitis esse.\nQuia praesentium reiciendis aliquid aperiam voluptas numquam. Ipsum expedita vel doloremque architecto autem. Occaecati est quia molestias accusantium pariatur voluptatem.\nVitae vel sint modi qui architecto ipsum. Odio pariatur repellendus non magni unde. Incidunt sit distinctio sint non fugit aut voluptatem.\nNeque doloremque natus aliquam aliquam corporis voluptatem. Quidem veniam id possimus qui libero. Temporibus neque explicabo alias. Quia cum sint quia minima culpa aut."
            },
            "4": {
                "subtask": 5,
                "questionNumber": 1,
                "elementID": 5,
                "questionID": 2,
                "elementName": "saepe",
                "elementText": "Ut unde ab aut.",
                "commentID": 5,
                "commentText": "Voluptas tempora aspernatur porro est ipsa. Qui sit veniam iure. Id dolorem a repellat vel.\nPossimus quam consectetur dicta ratione. Suscipit sint eos dolore dignissimos dolorum error voluptas. Qui sint atque ut nobis nam.\nUt rem sed molestiae maiores distinctio. Voluptas debitis exercitationem illum quos explicabo et. Qui repellat architecto quia magni fuga similique.\nAccusamus ex maiores sapiente architecto aut adipisci voluptatum eos. Doloremque odit omnis accusamus accusamus sint. Ut culpa voluptatem numquam exercitationem.\nOmnis adipisci aut quis et sint blanditiis. Cum saepe odit asperiores qui eos. Est quam sint illo repellat nostrum. Consequatur animi voluptates soluta numquam itaque.\nSaepe consectetur sint beatae ut voluptatibus et accusamus. Qui repudiandae porro at pariatur iusto unde. Consequatur officiis dolorum enim eos quia provident."
            },
            "5": {
                "subtask": 1,
                "questionNumber": 2,
                "elementID": 6,
                "questionID": 3,
                "elementName": "ipsa",
                "elementText": "Ut sit eaque.",
                "commentID": 6,
                "commentText": "Cumque nemo rerum eaque. Quam dolorem aut rerum autem incidunt sapiente expedita soluta.\nImpedit harum vel dignissimos ex molestiae consequatur. Autem ex quo veritatis temporibus odio. Harum voluptas vel illo et necessitatibus.\nQuia aut at quia rerum enim. Odit et voluptatum possimus consequatur. Doloremque magnam nam distinctio neque sit ut. Consequuntur ducimus sunt rerum est enim.\nNon est libero quibusdam est. Amet aut vel sapiente ut eos.\nMolestias aliquam laborum explicabo possimus enim natus sunt. Eius dolor sed corrupti sunt. Aliquid ut sed natus officiis numquam quos ut. Quaerat iste qui nulla quidem non.\nPerspiciatis voluptate ut nihil accusantium ab ea. Facilis dolor dolore doloremque. Sit fuga explicabo totam est est in nihil."
            },
            "6": {
                "subtask": 2,
                "questionNumber": 2,
                "elementID": 7,
                "questionID": 3,
                "elementName": "aspernatur",
                "elementText": "Dolor est.",
                "commentID": 7,
                "commentText": "Animi magni quod provident in. Ut quaerat iste temporibus molestiae quia ipsa enim. Quia omnis et veniam libero. Qui sunt nam minima voluptatem debitis libero natus.\nNatus assumenda debitis aut ut. Debitis est vel suscipit asperiores beatae incidunt nam. Laudantium et quia sequi ut dignissimos.\nCorrupti aut explicabo qui adipisci. Ducimus animi inventore ut quia. Doloremque nostrum distinctio est. Quo quas voluptatem ea aut sint labore.\nSit aspernatur asperiores eveniet assumenda laboriosam et. Sit ratione minima modi itaque. Nihil velit et et autem. Ullam doloremque iure ut commodi.\nIpsum molestiae veniam qui rerum modi quo aut. Quis at consectetur et corporis. Enim ad rem nisi error voluptate molestiae architecto. Et id animi iure quia ut labore consequatur voluptatem."
            },
            "7": {
                "subtask": 3,
                "questionNumber": 2,
                "elementID": 8,
                "questionID": 3,
                "elementName": "est",
                "elementText": "Omnis qui.",
                "commentID": 8,
                "commentText": "Et tenetur necessitatibus sed rerum distinctio possimus voluptatem necessitatibus. Alias vel officiis exercitationem aperiam. Consequatur dolorem sunt quaerat.\nVoluptas voluptas quo impedit ipsum et repellendus. Est delectus cupiditate deserunt quod. Natus tempora aut dolor voluptatem ex consequatur dolores. Dolor debitis non in ut amet.\nIn eos ut aut dolorum. Ut voluptas in mollitia illo facere. Eaque itaque ipsa modi est aspernatur.\nAut doloribus doloribus sit architecto sunt et. Quos velit omnis quo commodi et perspiciatis sint quia. Consequatur dignissimos itaque in earum perspiciatis.\nUt dignissimos sunt aliquam eveniet fuga reprehenderit. Aut voluptatem laborum minima qui eaque consequatur. Debitis accusamus qui quo voluptas impedit."
            },
            "8": {
                "subtask": 4,
                "questionNumber": 2,
                "elementID": 9,
                "questionID": 3,
                "elementName": "qui",
                "elementText": "Id omnis atque.",
                "commentID": 9,
                "commentText": "Quasi quia accusamus dolor. Nisi accusamus nam atque est inventore. Accusamus assumenda dolorem doloribus magnam necessitatibus maxime. Consequatur autem cum velit culpa iste praesentium ullam facere.\nOccaecati harum blanditiis qui et debitis iusto quia. Fugiat atque tempore asperiores explicabo in non ea. Eaque enim nihil aut quasi. Nostrum facilis architecto placeat sequi.\nConsequatur alias est nihil qui nam accusamus. Ut voluptatibus laudantium facere beatae illo dolorum.\nEveniet voluptas voluptates quibusdam rem. Eveniet et alias quisquam est hic. Corporis est omnis fuga. Rerum harum laborum et.\nBeatae quia in suscipit quam corporis. Quam quisquam omnis beatae nam facere. Molestiae nam dolores officiis qui voluptas.\nEx id voluptas et veritatis incidunt. Facilis inventore dolore blanditiis molestiae minima voluptatum sit."
            },
            "9": {
                "subtask": 5,
                "questionNumber": 2,
                "elementID": 10,
                "questionID": 3,
                "elementName": "consequatur",
                "elementText": "Cupiditate.",
                "commentID": 10,
                "commentText": "Tempora explicabo nisi facere aliquid. Architecto amet enim ut laborum. Atque deserunt rem itaque.\nA possimus consequatur magnam dolorem officiis fuga esse. Dolor molestiae error vero facilis deserunt. Cupiditate tempore praesentium voluptatem hic modi ratione. Necessitatibus id molestias ad quidem harum ad unde aliquam.\nConsequatur magni quae in perspiciatis. Distinctio dolore consequatur reiciendis. Ullam sunt qui nihil. Animi quia quam non consequatur veritatis.\nEt illum dolores illum sit sed quas et dolorem. Et cupiditate totam animi expedita qui. Amet cupiditate nostrum illum aliquam. Non repellendus fugit quam ex et.\nMolestiae enim in ut. Non nostrum quos rerum consequuntur. Voluptas illo exercitationem est iusto voluptate vero."
            },
            "10": {
                "subtask": 1,
                "questionNumber": 3,
                "elementID": 11,
                "questionID": 4,
                "elementName": "et",
                "elementText": "Velit.",
                "commentID": 11,
                "commentText": "Atque quo distinctio quibusdam quia qui dolorem rem qui. Dolore sed voluptatem magni aut exercitationem ut nostrum. Et dolore voluptatem velit et. Sunt est pariatur quos ullam repudiandae.\nCum id aut ut. Aspernatur ea dolorum numquam impedit ut pariatur voluptatem. Aliquid commodi tempora quasi culpa ipsa labore magnam.\nCulpa dicta exercitationem et. Dolor numquam quo odio voluptates officia nam. Occaecati et dicta omnis ut officiis voluptas.\nMinima debitis culpa provident numquam. Et qui esse non corrupti. Asperiores sit dolor illo eligendi fugiat corporis. Voluptatum reiciendis ad iste et facere.\nAccusamus et voluptates delectus nam hic. Voluptas corrupti facilis dolorum nam. Et velit laudantium repellendus minima. Sed quisquam nisi sint."
            },
            "11": {
                "subtask": 2,
                "questionNumber": 3,
                "elementID": 12,
                "questionID": 4,
                "elementName": "omnis",
                "elementText": "Enim ex quas.",
                "commentID": 12,
                "commentText": "Est perferendis pariatur itaque atque et labore. Laudantium assumenda maiores deleniti dolores iste voluptas sit. Magni enim enim dignissimos quos natus ut. Aut tempora delectus quibusdam velit est fuga animi.\nUt quia suscipit voluptate. Aut dolores et illo quasi maxime est quasi. Tenetur in sequi sit. Quo quia quibusdam et asperiores non alias ratione magni.\nA enim est alias porro. Iure ad autem velit laudantium quia nobis qui. Voluptatibus et incidunt et laboriosam. Possimus sit commodi accusamus fugiat corporis expedita enim voluptates.\nSaepe ipsam maxime doloribus debitis consectetur ut voluptatem. Id nam qui id. Nemo maxime facilis ducimus quis.\nEt dignissimos sit recusandae quisquam reprehenderit quae reprehenderit. Quas cum sequi aut ullam et harum. Qui repellendus sapiente est consequatur."
            },
            "12": {
                "subtask": 3,
                "questionNumber": 3,
                "elementID": 13,
                "questionID": 4,
                "elementName": "incidunt",
                "elementText": "Et iusto nam.",
                "commentID": 13,
                "commentText": "Aut est sequi nobis sit odit. Modi iusto assumenda est vitae cum aperiam. Dolore molestiae eligendi et ipsam rerum tempora. Ducimus aperiam quia consequuntur ad.\nOfficia nisi sapiente aliquid temporibus similique. Et non vel voluptatum. Vel laudantium architecto ut.\nIn fuga rerum totam corrupti. Animi consequatur eaque exercitationem velit. In rerum neque dolor in quis. Alias tempora fuga nobis nihil.\nOmnis quisquam enim molestiae. Laboriosam sit illo autem distinctio ipsam quo. Minus rerum velit repudiandae. Officia natus suscipit consequatur consequatur nulla.\nQuia quam occaecati aut veniam laborum. Porro temporibus minima recusandae harum facere voluptatibus quasi. Velit optio recusandae dolor voluptas.\nUnde et dolore exercitationem qui harum. Quas et rem dolor neque aliquid. Fugiat vel pariatur quod et."
            },
            "13": {
                "subtask": 4,
                "questionNumber": 3,
                "elementID": 14,
                "questionID": 4,
                "elementName": "voluptas",
                "elementText": "Quo quia.",
                "commentID": 14,
                "commentText": "Animi consequatur rerum ducimus ut sint. Eum et veniam ea consectetur dolores illum. Sint nostrum corrupti quod ducimus.\nEligendi iure non similique aliquid qui in ipsum voluptatem. Maxime deserunt recusandae pariatur fugiat rem omnis nam libero. Qui sunt expedita eveniet.\nAspernatur provident dolores ut maiores et sit qui. Voluptate dignissimos corrupti natus quis a. Vitae quo sit aliquid doloremque molestias.\nQui occaecati amet quasi dignissimos omnis laudantium. Est nemo nihil harum vel maiores veritatis facilis sit. Numquam doloribus consequatur sequi iste neque et.\nOdit nulla est qui voluptate necessitatibus sint nemo. Nostrum doloribus enim sed. Tempora accusamus ullam molestias esse nihil praesentium consequatur ad. Sint aliquid itaque libero et amet molestiae."
            },
            "14": {
                "subtask": 5,
                "questionNumber": 3,
                "elementID": 15,
                "questionID": 4,
                "elementName": "laboriosam",
                "elementText": "Harum et vero.",
                "commentID": 15,
                "commentText": "Vel possimus qui soluta. Tempora quis recusandae sit quis voluptates sit. Voluptatem reprehenderit ipsa velit aut. Corrupti pariatur cumque omnis vero omnis quam. Est quia debitis magni rem distinctio.\nItaque nostrum et aliquid blanditiis. Sed architecto excepturi harum voluptas tempore. Quo delectus magnam nihil nihil. Facere a sit sed id vitae ipsam quibusdam et. Delectus soluta necessitatibus inventore consequatur assumenda qui.\nNam et deserunt corporis ullam. In autem unde quidem impedit est et at. Sed omnis doloribus quos quis. Sit molestias dolores deserunt saepe minima dignissimos quasi.\nQuibusdam voluptatem voluptas facere praesentium aut. Accusamus iste pariatur iure ducimus. Rem nihil voluptas explicabo nisi at itaque esse. Voluptas in nostrum iure velit.\nRecusandae eum dignissimos ut sint non molestiae. Iste optio minus accusamus."
            },
            "15": {
                "subtask": 1,
                "questionNumber": 4,
                "elementID": 16,
                "questionID": 5,
                "elementName": "quam",
                "elementText": "Expedita omnis.",
                "commentID": 16,
                "commentText": "Alias at in consequuntur consequatur. Dolorem sit cum repellat ut veritatis voluptates hic. Voluptas quis dolores sint. Quam quis officiis animi consequatur.\nQuia eligendi est aut sed omnis molestiae sed illo. Laboriosam sit molestiae autem.\nArchitecto quod incidunt aliquam officia non optio ad. Voluptatibus aliquid nesciunt quidem. Est non et beatae quibusdam. Aut repudiandae aut odit.\nLaborum eum ut repellat similique est. Ex placeat nulla omnis delectus in autem. Perferendis nam quia nulla dolores sit soluta et.\nPerspiciatis dolore autem excepturi perspiciatis. Et dignissimos consequatur deleniti est. Quia autem dignissimos occaecati iure. Velit magni perferendis itaque ab.\nExplicabo magnam temporibus quis qui animi. Sed ea aperiam voluptatem repudiandae dolore cupiditate. Possimus suscipit odit facere voluptas maxime eius qui."
            },
            "16": {
                "subtask": 2,
                "questionNumber": 4,
                "elementID": 17,
                "questionID": 5,
                "elementName": "quam",
                "elementText": "Quam cumque.",
                "commentID": 17,
                "commentText": "Rem quia soluta magnam nihil quasi qui voluptas voluptas. Quas repellendus recusandae eos fuga et ipsa. Laboriosam harum iste adipisci sed.\nCulpa ut omnis voluptates ullam enim officia. Quam aut id minus omnis quia blanditiis. Qui quo et illo vel ipsum distinctio optio.\nDeserunt et et exercitationem aliquam placeat numquam. Expedita facere pariatur odio nobis atque delectus quae. Sed inventore quis sit ratione ut reprehenderit ea.\nEius ullam quae quae animi quaerat dolores ad. Totam aspernatur provident ut laboriosam adipisci officiis itaque. Sit alias aut placeat eos maxime blanditiis.\nLaborum tempora itaque pariatur fugiat quisquam quasi. Vero possimus consequuntur quis voluptas dolorem. Culpa vitae occaecati suscipit iste ullam. Ipsa quia fugit quae ut temporibus ut.\nQui in ut voluptatem non accusamus voluptatum. Rerum possimus beatae et qui. Est est ex rerum eum dolorem non."
            },
            "17": {
                "subtask": 3,
                "questionNumber": 4,
                "elementID": 18,
                "questionID": 5,
                "elementName": "excepturi",
                "elementText": "Qui minima.",
                "commentID": 18,
                "commentText": "Quis tenetur non molestias ea et blanditiis quod saepe. Explicabo est quo et deserunt reprehenderit delectus omnis ullam. Esse assumenda laboriosam et quis.\nExpedita aut corporis est qui ad. Harum omnis quaerat libero consequatur. Expedita quos suscipit qui eligendi quas.\nConsequatur voluptatem eligendi est perferendis error dicta deserunt. Dolor vel excepturi amet ipsum nobis culpa voluptatem. Nam velit ad assumenda nulla voluptatum accusantium est.\nVoluptas facilis esse et. Laboriosam dolores doloribus et ut ipsam porro. Error quo et aut tempora ullam quo.\nCupiditate quibusdam sed reiciendis id tempore porro a. Vero et totam non esse magni qui placeat. Eum consectetur vero fugit pariatur sint quisquam.\nDolore qui id deleniti fugit possimus veritatis ipsum. Non ipsum esse quia est sunt est labore."
            },
            "18": {
                "subtask": 4,
                "questionNumber": 4,
                "elementID": 19,
                "questionID": 5,
                "elementName": "excepturi",
                "elementText": "Nostrum.",
                "commentID": 19,
                "commentText": "Molestias facere deserunt molestiae deserunt aut. Id eveniet libero optio ratione dolorem quia sit. Sit ab nihil consequatur dicta est autem a.\nEum aut voluptatem et excepturi modi doloribus aliquid. Aut consectetur dolorem in sunt.\nAutem sed repellendus in et exercitationem. Iure in veniam qui sequi et soluta. Asperiores eligendi aliquam iste quibusdam. Itaque perspiciatis et dolor sapiente molestiae.\nQuia quia mollitia perspiciatis reiciendis iure voluptas fugiat. Atque voluptatem asperiores impedit iste est adipisci. Tempore sint quia facere aut amet vero sed. Cum optio nulla ut eos laudantium dolores repudiandae.\nQuaerat eaque est voluptatum officia. Illo ducimus commodi quia cupiditate quaerat est aut. In quam aut vitae assumenda."
            },
            "19": {
                "subtask": 5,
                "questionNumber": 4,
                "elementID": 20,
                "questionID": 5,
                "elementName": "dolorem",
                "elementText": "Ut doloribus.",
                "commentID": 20,
                "commentText": "Voluptatem corrupti minima velit voluptatem. Ex sint tenetur recusandae. Voluptas aut voluptas enim sint ducimus. Voluptas illum aut tempora assumenda dolor aut quis ipsam.\nAccusantium quis deserunt expedita ratione qui. Odio dolor dolor vitae molestiae ad iusto dolorem voluptates. Nam repellat provident inventore recusandae. Voluptates est labore quia iusto sint ipsam qui.\nOfficia doloremque dolorem quam. Quidem sed asperiores iusto.\nMolestiae atque deserunt est fugit. Sapiente quia dolorem tempore consequatur iusto voluptate fugit. Voluptate et dolore perspiciatis asperiores accusantium.\nUt ut vel consectetur ut in quam voluptatibus. Vel vitae sed quaerat quibusdam deserunt. Magni impedit voluptatum nemo cupiditate quibusdam.\nFacilis quo dolores nam veniam neque error totam. Hic quia harum expedita veritatis molestias ipsa officiis. Debitis amet qui ea eum."
            },
            "20": {
                "subtask": 1,
                "questionNumber": 5,
                "elementID": 21,
                "questionID": 6,
                "elementName": "animi",
                "elementText": "Facere beatae.",
                "commentID": 21,
                "commentText": "Cupiditate fugiat amet harum nesciunt. Nihil deserunt voluptas et magnam vel. Assumenda tempore dolorum quis est. Consequatur quis expedita excepturi numquam.\nDolorem id enim suscipit quis numquam odit facere accusamus. Quisquam molestias incidunt quos recusandae quia facilis voluptatem. Sit itaque molestiae asperiores.\nPerferendis sint consequatur et saepe amet est in. Suscipit corporis vel et sed perferendis incidunt fuga. Nemo dolor et sapiente. Et architecto et tempora aut rerum qui voluptatem.\nMaxime recusandae officia odit rerum. Aut qui sit reprehenderit et. Saepe a tenetur illo odit ipsa unde et iure. Id voluptates harum porro quae reiciendis nam."
            },
            "21": {
                "subtask": 2,
                "questionNumber": 5,
                "elementID": 22,
                "questionID": 6,
                "elementName": "odio",
                "elementText": "Laboriosam sit.",
                "commentID": 22,
                "commentText": "Non odio ullam reiciendis modi in. Aperiam natus reprehenderit consequatur eveniet nisi. Aut consequatur ducimus earum autem eius sint. Quae numquam perferendis et eum dolores voluptatem.\nAccusantium sint odit in et. Temporibus facere enim fuga doloremque dolores. Repudiandae libero aut mollitia quia vel. Rerum doloremque natus officia ducimus et eos sunt.\nExercitationem enim voluptatem qui in itaque nesciunt. Odit autem tenetur et excepturi aut tenetur velit. Consequatur sed molestiae a cumque rerum. Esse iste reprehenderit omnis et quia et optio.\nNisi officiis aliquam totam fugit. Quisquam officiis tempore molestiae. Dicta provident sint aut sit itaque fugiat aliquam natus.\nReiciendis exercitationem possimus fuga odit totam deleniti nihil. Architecto recusandae corporis eveniet esse commodi ut quibusdam. Quisquam eius suscipit odit dolor sequi."
            },
            "22": {
                "subtask": 3,
                "questionNumber": 5,
                "elementID": 23,
                "questionID": 6,
                "elementName": "et",
                "elementText": "Vitae error.",
                "commentID": 23,
                "commentText": "Voluptatem quaerat aut ex autem magnam eum consequuntur. Est saepe quaerat doloremque officia consequatur. Nobis dolorum a autem.\nMinima sed excepturi ducimus molestiae consequatur. Nihil doloremque odit aspernatur error ut corporis. Asperiores sit sit commodi assumenda qui. Placeat nulla commodi velit ut.\nOdit quia dolorum aspernatur cupiditate harum. Excepturi illum nam laudantium.\nNobis quas repellat optio quia praesentium nisi corporis ducimus. Ipsa et voluptatum praesentium quo iure. Non delectus expedita qui mollitia et est.\nDucimus expedita fugiat quia ut beatae. Accusamus molestias in totam illum ut error facere. Quam laborum rerum velit recusandae dolores minus. Quas ut rerum occaecati tempora praesentium veniam dolor. Velit modi quidem voluptate et iure qui et deserunt."
            },
            "23": {
                "subtask": 4,
                "questionNumber": 5,
                "elementID": 24,
                "questionID": 6,
                "elementName": "perferendis",
                "elementText": "Quia et.",
                "commentID": 24,
                "commentText": "Voluptate voluptas pariatur explicabo et. Consectetur in autem consequatur doloribus. Aut beatae aut quisquam facere autem a et.\nNatus deleniti voluptatem dolorum nihil aliquid nihil voluptas. Recusandae saepe nisi totam vitae est officiis labore. Architecto consequatur neque similique suscipit rem.\nQuis omnis animi asperiores repellat in. Libero sed esse et aut. Maiores quo id at asperiores et et. Quia sint omnis optio est qui eos distinctio cumque.\nQuam ut saepe non quo sit hic quod repellendus. Eum et voluptas aut quo occaecati doloremque dolore. Sed accusantium quo expedita eveniet ad incidunt maxime et. Dolor explicabo repellat consequatur itaque et.\nTemporibus esse dolore qui doloribus. Ducimus voluptatibus libero animi voluptatibus cumque sit eum. Fugit praesentium id occaecati amet qui quia. Nostrum temporibus ea voluptatem eaque qui quae."
            },
            "24": {
                "subtask": 5,
                "questionNumber": 5,
                "elementID": 25,
                "questionID": 6,
                "elementName": "sunt",
                "elementText": "Animi iste ut.",
                "commentID": 25,
                "commentText": "Voluptatem accusamus illo cum reprehenderit itaque dolorum nemo recusandae. Hic sed et quod quos ut. Et natus cumque quas et magni sunt eum. Eos quia sapiente rem nemo dolore.\nLabore et praesentium blanditiis eius. Maxime impedit sit esse voluptatem ea sint soluta aperiam. Quae quibusdam quo odit incidunt.\nVitae soluta tempore minus. Omnis veritatis quasi optio dicta maiores consectetur iusto. Aut aliquid quam repellat. Et maxime id similique vel.\nUt assumenda magnam nostrum. Qui temporibus explicabo modi aut eum. Ut qui aut est omnis.\nQui aut voluptatem non dolor occaecati sit. Illo itaque vitae vero eius quia odit. Laborum rerum recusandae possimus sequi ad. Facere est et voluptatibus odio ut quis nisi. Ex qui nisi voluptatem non.\nNesciunt suscipit sit aut aut. Similique quae nam ipsa et saepe. Quod magni consectetur illo quia. Rem aut sit ut libero et minus ea eum."
            }
        };
        ;
        ;
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var scripts = [
                "inc/js/common.js",
                "inc/js/commentSetup.js",
                "inc/js/examchoicebutton.js"
            ];

            /**
             * Do any styling or activities required by the page
             * @returns {undefined}
             */
            function onLoad() {
                $('.navMenuItem').menu();
                $(".accordion").accordion();
                $('.prettyButton').button();
                $(".spinner").spinner({
                    min: 0,
                    max: 10,
                    numberFormat: "n",
                    step: 0.25
                });

                $(".draggable").draggable({opacity: 0.35});
//                                        $(".draggable").draggable({snap: '.subtaskArea'});
                $(".subtaskArea").droppable({
                    accept: '.draggable',
                    drop: function (event, ui) {
                        $(event.target).append($(ui.draggable).detach());
                    }
                });

                console.log(comments.length);
                if (!comments) {
                    console.log('no comments');
                    $.post("api.php", {'task': 'getAllComments'}, function (response) {
                        console.log(response.data);
                    }, "JSON");
                }
                addComments(comments);
                if (currentExamComments.length != 0) {
                    var elements = processElementJson(currentExamComments);
                    $.each(elements, function () {
                        displayExisting(this);
                    });
                } else {
                    $.post("api.php", {'task': 'getCurrentExamComments'}, function (response) {
                        console.log('from server', response.data);
                        var elements = processElementJson(response.data);
                        if (elements.length != 1) {
                            $.each(elements, function () {
                                displayExisting(this);
                            });
                        } else {
                            $(".errorArea").append("Please assign some questions to the exam first. ");
                        }
                    }, "JSON");
                }
                bindListeners();
                bindExamEventListeners();
                console.log('onload fired');
            }

            onLoad();
            //  scriptLoader(scripts, scripts.length, onLoad, 0);
        });
    </script>
@endsection