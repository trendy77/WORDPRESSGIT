/**
 * Created by jaskokoyn on 11/21/2015.
 */
(function($,w){
    var app                             =   $("#pollApp");
    var animation                       =   app.data("animation");
    var animationPlaying                =   false;

    $(document).on( 'click', '.btn-prev', function(e){
        e.preventDefault();

        var activeElem                  =   app.find(".poll-question-ctr.active");
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

        var activeElem                  =   app.find(".poll-question-ctr.active");
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

    $(".poll-question-ctr.poll-unanswered .poll-answer-ctr").hover(function(){
        $(this).find('.fa').removeClass('fa-circle-thin').addClass('fa-check');
    }, function(){
        $(this).find('.fa').removeClass('fa-check').addClass('fa-circle-thin');
    });

    $(document).on( 'click', ".poll-question-ctr.poll-unanswered .poll-answer-ctr", function(e){
        e.preventDefault();

        if(signin_required == 2 && user_signed_in == 1){
            location.href                   =   ajaxurl + '/login';
            return null;
        }

        var questionElem                    =   $(this).closest('.poll-question-ctr');
        var pollElem                        =   $(this).closest('.poll-ctr');
        var count                           =   parseInt( app.find(".progress-text span").text() );
        var question_count                  =   app.data("question-count");
        var answer_vote_count               =   parseInt($(this).data('total-votes')) + 1;
        var total_vote_count                =   parseInt(questionElem.data('total-votes')) + 1;
        count++;

        $(this).addClass("poll-answer-selected");
        $(this).find(".fa").addClass("fa-circle-thin").addClass("fa-check");
        $(this).data("total-votes", answer_vote_count);
        questionElem.addClass("poll-answered").removeClass("poll-unanswered");
        questionElem.find('.poll-answer-ctr').unbind('mouseenter mouseleave');
        questionElem.find(".poll-txt").text( "You voted " + $(this).text() );

        questionElem.find(".poll-answer-ctr").each(function(){
            $(this).append("<small><em>(" + $(this).data("total-votes") + " " + i18n_votes + ")</em></small>");
            $(this).append('<span class="pull-right">' + Math.round(parseInt($(this).data('total-votes')) / total_vote_count * 100) + '%</span>');
            $(this).find(".fa").remove();
        });

        var formData                        =   {
            _token:                             $("input[name=_token]").val(),
            question_key:                       pollElem.find(".poll-question-ctr").index(questionElem),
            answer_key:                         questionElem.find(".poll-answer-ctr").index( this)
        };

        $.post( "",  formData);

        app.find(".progress-text span").text( count );
        app.find(".progressFinishedBar").animate({ width:  (count / question_count * 100) + '%'});

        // Increment User Points
        $.post( ajaxurl + "/process/user-media-award-points", {
            mid:                            mid,
            _token:                         point_token
        });

        if( auto_scroll == 2 ){
            setTimeout(function(){
                if(poll_style == 2){
                    $(".btn-next").click();
                }else{
                    $('html, body').animate({
                        scrollTop: questionElem.next().offset().top
                    }, 500);
                }
            }, auto_scroll_timer);
        }
    });
})(jQuery, window);