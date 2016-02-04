/**
 * Created by adam on 2/3/16.
 */


var $ = require('jquery');
window.$ = $;
//require('jquery-ui');
require('bootstrap');
//require('bootstrap-slider')

var Slider = require("bootstrap-slider");

var Vue = require('vue');
Vue.config.debug = true;


new Vue({
    el: '#app',

    components: {
        'slider': require('./components/slider.js')
    },

    data: {
        questionScore: 0,

        qNumber: 1,

        questionName: "Descartes' Cogito argument",

        slider1: '',

        slider2: '',

        slider3: 0,

        grade: '',

        commentPara1: '',

        commentPara2: '',

        commentPara3: '',

        chartOptions: {
            title: "How you did versus class average ",
            width: 300,
            height: 200,
            bar: {groupWidth: "65%"},
            legend: {position: "top"},
            vAxis: {
                viewWindowMode: 'explicit',
                viewWindow: {
                    max: 10,
                    min: 0
                }
            }
        },
        elements: [
            "Explain Descartes' goal",
            'Explain role of doubt',
            'Explain the dreaming doubt'
        ],

        valenceCutoffs: [0, 3.25, 6.75, 10],
        valenceLabels: ["Missing", "Poor", "Fair", "Excellent"],
        valenceLabelPositions: [0, 33, 67, 100],
        sliderStep: .25,

        comments: {
            e1: ["In order to say why Descartes has adopted the skeptical method of the Meditations, you need to tell the reader what Descartes is hoping to achieve. However, you didn't do this. This leaves it up to your reader to figure out that Descartes is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge.  As you can see, this is pretty complicated. So you can't just assume that the reader will figure it out.",

                "In order to say why Descartes has adopted the skeptical method of the Meditations, you need to tell the reader what Descartes is hoping to achieve. You tried to do this. But it was not clear from your answer that his goal is to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge.",

                "You correctly recognized that in order to say why Descartes has adopted the skeptical method of the Meditations, reader needed to be told what Descartes is hoping to achieve. You did a pretty good job here. But it wasn't as clear as it could have been that he is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. That is, the idea is to find some beliefs which he can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge.",

                "You did a good job recognizing that in order to say why Descartes has adopted the skeptical method of the Meditations, the reader needed to be told what Descartes is hoping to achieve. It was completely clear from your answer that he is trying to discover what kinds of beliefs can be the completely certain foundations upon which the rest of our knowledge can be built. From your explanation I think a reader would have been able to see that the idea is to find some beliefs which Descartes can't be wrong about. Then he can work backwards to explaining why and when, for example, scientific beliefs count as certain knowledge."

            ],

            e2: ["You needed to explain the role doubt plays in Descartes method. But you forgot to do it. The reader needed to be shown that Descartes is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. So, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But then someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird.",

                "You remembered that you needed to explain the role doubt plays in Descartes method. However, from what you said, I don't think a reader would've understood that Descartes is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. I don't think a reader would've understood that, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird.",

                "You did a pretty good job explaining the role doubt plays in Descartes method. I think a reader would've basically understood that he is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. From your answer, a reader probably would've understood that, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird.",

                "You did a great job explaining the role doubt plays in Descartes method. A reader definitely would've understood that he is using a principle like 'If I can find grounds for doubting that a kind of belief is true, then no beliefs of that sort count as knowledge'. So, for example, if we're talking about beliefs based on seeing things in the distance, I might believe that I see a plane. But suppose someone points out that birds are often confused with faraway planes. Now I can't say that I know that object in the distance is a plane until I can be sure that it is not a bird."
            ],

            e3: ["It was extremely important to go through Descartes argument that when you are dreaming, things look just the way they do when you are awake. More importantly, in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs. Unfortunately, you didn't really explain this at all. That will make it very difficult for your reader to understand the reset of your answer.",

                "You remembered to do the crucial task of explaining Descartes' argument that when you are dreaming, things look just the way they do when you are awake. Unfortunately, I don't think you said enough for the reader to understand how this argument works. It needed to be clear that in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs.",

                "You did a pretty good job explaining Descartes' argument that when you are dreaming, things just the way they do when you are awake. It would've been mostly clear to a reader that in a dream you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. Since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs.",

                "From your excellent answer, I think any reader would've been able to understand why Descartes points out that when you are dreaming, things just the way they do when you are awake. It was completely clear that this matters because when you are dreaming you can't tell that you are dreaming. So, if Descartes were dreaming right now, he would not know that he was dreaming. Yet all of his beliefs about what is around him would be false ---he thinks he is in front of the fire, but actually he is snuggled up in bed. As was clear from your answer, since many beliefs based on his senses would be false if he were dreaming, he has found a reason to doubt all such beliefs."
            ],
        }

    },

    computed: {
        //questionScore: function(){
        //    this.slider1 + this.slider2
        //}
    },

    events: {
        slideStop: function () {
            window.console.log(this);
        }
    },

    methods: {
        chooseValence: function (val) {
            if (val <= 1) {
                return 0;
            }
            else if (val <= 3.25) {
                return 1;
            }
            else if (val <= 6.75) {
                return 2;
            }
            else if (val <= 10) {
                return 3
            }
        },

        updateComment: function (elementNumber, valence) {

            switch (elementNumber) {
                case 1:
                    this.commentPara1 = this.comments.e1[valence];
                    break;
                case 2:
                    this.commentPara2 = this.comments.e2[valence];
                    break;
                case 3:
                    this.commentPara3 = this.comments.e3[valence];
                    break;
                default:
                    var comment = '';
            }

        },

        updateSlider1: function () {
            window.console.log('updateSlider1', this.slider1);
            var index = this.chooseValence(this.slider1);
            this.commentPara1 = this.e1[index];
        },

        updateSlider2: function () {
            window.console.log('updateSlider2', this.slider2);
            var index = this.chooseValence(this.slider2);
            this.commentPara2 = this.e2[index];
        },

        updateSlider3: function () {
            window.console.log('updateSlider3', this.slider3);
            var index = this.chooseValence(this.slider3);
            this.commentPara3 = this.e3[index];
        },

        updateGrade: function () {
            window.console.log('updateGrade', this.questionScore);
            var me = this;
            var scores = [
                [55, 'F'],
                [78, 'C+'],
                [82, 'B-'],
                [92, 'A-'],
                [95, 'A']
            ];
            var limit = scores.length;
            for (var i = 0; i < limit; i++) {
                if (this.questionScore <= scores[0]) {
                    this.grade = scores[1];
                    i = limit;
                }

            }
            ;
        },

        drawChart: function (elementNumber, title, score, average) {
            //Prepare the data
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'question');
            data.addColumn('number', 'Your Score');
            data.addColumn('number', 'Class Average');

            data.addRow([title, score, average]);
            var chartTarget = 'chart' + elementNumber;
            var chart = new google.visualization.ColumnChart(document.getElementById(chartTarget));
            chart.draw(data, this.chartOptions);
        },

        report: function () {
            window.console.log(this);
        }

        //imposeContent: function (num, textArray, valence) {
        //    //  $('#comment' + num).empty().append(textArray[valence][1]);
        //    $('#commentPara' + num).empty().append(textArray[valence][1]);
        //    $('#slider' + num).slider('setValue', textArray[valence][0]);
        //},
        //
        //setGrade: function (index) {
        //    var scores = [
        //        [55, 'F'],
        //        [78, 'C+'],
        //        [82, 'B-'],
        //        [92, 'A-'],
        //        [95, 'A']
        //    ];
        //
        //    $('#questionScore').empty().val(scores[index][0]);
        //    $('#gradeSpot').empty().append(scores[index][1]);
        //}

    },

    ready: function () {
        var me = this;
        window.console.log('ready1');
        /* initialize Sliders with valenceCutoffs */
        var mySlider3 = new Slider("#slider3", {
            tooltip: 'show',
            value: 0,
            step: this.sliderStep,
            ticks: this.valenceCutoffs,
            ticks_labels: this.valenceLabels,
            ticks_position: this.valenceLabels
        }).on("slideStop", function () {
            me.updateSlider3();
            window.console.log('slideStop3', me.slider3, $(this).val());
        });

    }
});