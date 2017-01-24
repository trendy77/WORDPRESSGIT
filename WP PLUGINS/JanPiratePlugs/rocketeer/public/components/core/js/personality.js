/**
 * Created by jaskokoyn on 11/22/2015.
 */
(function($, w){
    var app                             =   $("#quizApp");
    var questionsAnswered               =   0;
    var totalPoints                     =   0;
    var result_index                    =   0;
    var result_share_txt                =   '';
    var animation                       =   personalityObj.animation;
    var animationPlaying                =   false;

    app.show();

    $(document).on( 'click', '.btn-prev', function(e){
        e.preventDefault();

        var activeElem                  =   app.find(".question-ctr.active");
        var prevElem                    =   activeElem.prev();

        if(!prevElem.length){
            return null;
        }

        if(animation){
            if(animationPlaying){
                return false;
            }

            animationPlaying            =   true;

            activeElem.transition({
                animation  : animation,
                onComplete : function() {
                    activeElem.removeClass("active");
                    prevElem.transition({
                        animation  : animation,
                        onComplete : function() {
                            prevElem.addClass("active");
                            animationPlaying    =   false;
                        }
                    });
                }
            });
        }else{
            activeElem.removeClass("active");
            prevElem.addClass("active");
        }
    });

    $(document).on( 'click', '.btn-next', function(e){
        e.preventDefault();

        var activeElem                  =   app.find(".question-ctr.active");
        var nextElem                    =   activeElem.next();

        if(!nextElem.length){
            return null;
        }

        if(animation){
            if(animationPlaying){
                return false;
            }

            animationPlaying            =   true;

            activeElem.transition({
                animation  : animation,
                onComplete : function() {
                    activeElem.removeClass("active");
                    nextElem.transition({
                        animation  : animation,
                        onComplete : function() {
                            nextElem.addClass("active");
                            animationPlaying    =   false;
                        }
                    });
                }
            });
        }else{
            activeElem.removeClass("active");
            nextElem.addClass("active");
        }
    });

    $(".single-answer-ctr:not(.answer-selected)").hover(function(){
        $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-check');
    }, function(){
        $(this).find('.fa').removeClass('fa-check').addClass('fa-circle-thin');
    });

    $(document).on( 'click', '.single-answer-ctr', function(e){
        e.preventDefault();

        var questionElem                =   $(this).closest('.question-ctr');

        // Update Question Element
        questionElem.find(".single-answer-ctr").removeClass("answer-selected");
        questionElem.find(".single-answer-ctr .fa").removeClass("fa-check").addClass("fa-circle-thin");
        $(this).addClass("answer-selected");
        $(this).find('.fa').removeClass('fa-circle-thin').addClass('fa-check');
        questionElem.find('.single-answer-ctr').unbind('mouseenter mouseleave');
        $(".single-answer-ctr:not(.answer-selected)").hover(function(){
            $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-check');
        }, function(){
            $(this).find('.fa').removeClass('fa-check').addClass('fa-circle-thin');
        });

        // Progress Bar
        if(questionElem.find(".pers-answers-ctr").hasClass("question-unanswered")){
            questionsAnswered++;
            app.find(".progress-text span").text( questionsAnswered );
            app.find(".progressFinishedBar").animate({ width:  (questionsAnswered / personalityObj.questions.length * 100) + '%'});
            questionElem.find(".pers-answers-ctr").removeClass("question-unanswered");
        }

        // Check if Finished
        if(questionsAnswered !== personalityObj.questions.length){
            if( auto_scroll == 2 ){
                setTimeout(function(){
                    if(personalityObj.style == 1){
                        $(".btn-next").click();
                    }else{
                        $('html, body').animate({
                            scrollTop: questionElem.next().offset().top
                        }, 500);
                    }
                }, auto_scroll_timer);
            }
            return null;
        }

        // Scroll back to top of quiz
        app[0].scrollIntoView();

        var finalScore                  =   0;
        var result_id                   =   0;

        app.find(".answer-selected").each(function(){
            totalPoints                 +=  parseInt( $(this).data('points') );
        });

        personalityObj.results.forEach(function(ele,ind,arr){
            if( ele.min <= totalPoints && ele.max >= totalPoints ){
                result_id               =   ind;
                result_index            =   ind;
                result_share_txt        =   i_got + ' ' + ele.title;
            }
        });

        app.find(".resultScoreText").text(finalScore);
        app.find(".questions-ctr").hide();
        app.find("#result-" + result_id).show();

        // Modal
        $("#modalQuizResultTxt").html( personalityObj.results[result_index].title );
        $("#modalQuizResultImg").attr( 'src', ajaxurl + '/public/uploads/' + personalityObj.results[result_index].main_img );
        $("#modalQuizResultDesc").html( personalityObj.results[result_index].desc );
        $("#resultModal").modal('show');

        // Increment User Points
        $.post( ajaxurl + "/process/user-media-award-points", {
            mid:                            mid,
            _token:                         point_token
        });
    });

    $(document).on( 'click', '.btn-retake-quiz', function(e){
        e.preventDefault();

        questionsAnswered               =   0;
        totalPoints                     =   0;

        app.find('.pers-answers-ctr').addClass('question-unanswered');

        // Update Question Element
        app.find(".single-answer-ctr").removeClass("answer-selected");
        app.find(".single-answer-ctr .fa").removeClass("fa-check").addClass("fa-circle-thin");
        app.find('.single-answer-ctr').unbind('mouseenter mouseleave');

        // Progress Bar
        app.find(".progress-text span").text("0");
        app.find(".progressFinishedBar").animate({ width: '0%'});

        // Hide Result Show Question
        app.find(".result-ctr").hide();
        app.find(".questions-ctr").show();
        app.find(".question-ctr").removeClass("transition hidden visible active");
        app.find(".question-ctr").removeAttr('style');


        if(personalityObj.style == 2){
            app.find(".question-ctr").addClass('active');
        }else{
            app.find(".question-ctr:first-child").addClass('active');
        }

        $(".single-answer-ctr:not(.answer-selected)").hover(function(){
            $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-check');
        }, function(){
            $(this).find('.fa').removeClass('fa-check').addClass('fa-circle-thin');
        });
    });

    $(document).on( 'click', '.btn-fb-share', function(e){
        e.preventDefault();

        FB.ui({
            method: 'share',
            href: location.href + '?r=' + (result_index+1)
        }, function(response){});
    });

    $(document).on( 'click', '.btn-twitter-share', function(e){
        e.preventDefault();

        window.open(
            "https://twitter.com/share?url=" + encodeURI(location.href + '?r=' + (result_index+1) ) + '&text=' + encodeURI(result_share_txt),
            "_blank",
            "width=500, height=300"
        );
    });
})(jQuery, window);