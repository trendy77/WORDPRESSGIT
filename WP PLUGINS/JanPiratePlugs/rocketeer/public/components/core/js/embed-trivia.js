/**
 * Created by jaskokoyn on 2/26/2016.
 */
(function($, w){
    var app                             =   $("#quizApp");
    var questionsAnswered               =   0;
    var totalCorrect                    =   0;
    var timer                           =   null;
    var result_index                    =   0;
    var result_share_txt                =   '';
    var animation                       =   triviaObj.animation;
    var animationPlaying                =   false;

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

    $(document).on( 'click', '.btn-start-quiz', function(e){
        e.preventDefault();

        app.find(".timeStartCtr").hide();
        app.find(".quiz-main-questions-ctr").show();
        app.find(".quiz-timer-ctr").show();

        timer                           =   setInterval(function(){
            var cur_time                =   parseInt( app.find(".quiz-timer-ctr").text() );
            cur_time--;

            if(cur_time == 0){
                processQuiz();
            }else{
                app.find(".quiz-timer-ctr").text( cur_time );
            }
        }, 1000);
    });

    $(".answers-ctr.question-unanswered .single-answer-ctr").hover(function(){
        $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-check');
    }, function(){
        $(this).find('.fa').removeClass('fa-check').addClass('fa-circle-thin');
    });

    $(document).on( 'click', '.answers-ctr.question-unanswered .single-answer-ctr', function(e){
        e.preventDefault();

        var questionElem                =   $(this).closest('.question-ctr');
        var isCorrect                   =   parseInt( $(this).data('is-correct') );
        totalCorrect                    =   isCorrect == 2 ? totalCorrect+1 : totalCorrect;

        questionElem.find('.answers-ctr').removeClass('question-unanswered');
        questionElem.find('.single-answer-ctr').unbind('mouseenter mouseleave');

        // Update Question Element
        if(isCorrect == 2){
            $(this).addClass('correct');
            $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-check');
            questionElem.find('.question-txt').text('Correct!');
            questionElem.find('.question-txt').addClass('correct');
        }else{
            $(this).addClass('incorrect');
            $(this).find('.fa').removeClass('fa-circle-thin fa-check').addClass('fa-remove');
            questionElem.find('.question-txt').text('Incorrect!');
            questionElem.find('.question-txt').addClass('incorrect');

            // Show Correct Answer
            if(triviaObj.show_correct_answer == 2){
                questionElem.find(".single-answer-ctr").each(function(){
                    if( parseInt( $(this).data('is-correct') ) == 2 ){
                        $(this).addClass('correct');
                        questionElem.find('.question-txt').append( ' ' + the_correct_answer_is + ' ' + $(this).text() );
                        return null;
                    }
                });
            }
        }

        // Progress Bar
        questionsAnswered++;
        app.find(".progress-text span").text( questionsAnswered );
        app.find(".progressFinishedBar").animate({ width:  (questionsAnswered / triviaObj.questions.length * 100) + '%'});

        // Show Explanation
        var explanation                 =   questionElem.find(".explanation-ctr");

        if(explanation.text().length > 0){
            explanation.slideDown();
        }

        // Check if Finished
        if(questionsAnswered !== triviaObj.questions.length){
            if( auto_scroll == 2 ){
                setTimeout(function(){
                    if(triviaObj.style == 1){
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

        processQuiz();
    });

    function processQuiz(){
        var finalScore                  =   parseInt(totalCorrect / triviaObj.questions.length * 100);
        var result_id                   =   0;

        triviaObj.results.forEach(function(ele,ind,arr){
            if( ele.min <= totalCorrect && ele.max >= totalCorrect ){
                result_id               =   ind;
                result_index            =   ind;
                result_share_txt        =   i_got + ' ' + ele.title;
            }
        });

        app.find(".resultScoreText").text(finalScore);
        app.find(".questions-ctr").hide();
        app.find(".quiz-timer-ctr").hide();
        app.find("#result-" + result_id).show();
        clearInterval(timer);

        // Modal
        $("#modalQuizResultTxt").text( triviaObj.results[result_index].title );
        $("#modalQuizResultImg").attr( 'src', ajaxurl + '/public/uploads/' + triviaObj.results[result_index].main_img );
        $("#modalQuizResultDesc").text( triviaObj.results[result_index].desc );
        $("#resultModal").modal('show');
    }

    $(document).on( 'click', '.btn-retake-quiz', function(e){
        e.preventDefault();

        questionsAnswered               =   0;
        totalCorrect                    =   0;

        app.find('.answers-ctr').addClass('question-unanswered');

        // Update Question Element
        app.find('.single-answer-ctr').removeClass('correct incorrect');
        app.find('.single-answer-ctr .fa').removeClass('fa-check fa-remove').addClass('fa-circle-thin');
        $(".question-ctr").each(function(){
            $(this).removeClass('active');
            $(this).find('.question-txt').removeClass('correct incorrect');
            $(this).find('.question-txt').text( $(this).find('.question-txt').data('question') );
            $(this).find(".explanation-ctr").hide();
        });

        // Progress Bar
        app.find(".progress-text span").text("0");
        app.find(".progressFinishedBar").animate({ width: '0%'});

        // Hide Result Show Question
        app.find(".result-ctr").hide();
        app.find(".questions-ctr").show();
        app.find(".question-ctr").removeClass("transition hidden visible active");
        app.find(".question-ctr").removeAttr('style');
        app.find(".question-ctr:first-child").addClass('active');

        // Timer Settings
        if(triviaObj.is_timed == 2){
            app.find(".timeStartCtr").show();
            app.find(".quiz-main-questions-ctr").hide();
            app.find(".quiz-timer-ctr").hide();
            app.find(".quiz-timer-ctr").text( triviaObj.timer );
        }

        $(".answers-ctr.question-unanswered .single-answer-ctr").hover(function(){
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

    app.show();
})(jQuery, window);