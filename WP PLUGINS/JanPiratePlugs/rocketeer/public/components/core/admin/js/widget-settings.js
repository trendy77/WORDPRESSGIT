/**
 * Created by jaskokoyn on 12/8/2015.
 */
(function($, w){
    var vm                          =   new Vue({
        el:                             '#widgetApp',
        data:                           {
            widgets:                    widgetsObj,
            edit_index:                 0,
            show_editor:                false,
            show_alert:                 false,
            alert_class:                'alert-info',
            alert_message:              'Please wait while your widget settings are saved.'
        },
        methods:                        {
            addWidget:                  function(){
                this.widgets.push({
                    title:              'Widget #' + (this.widgets.length+1),
                    type:               1,
                    category:           0,
                    html:               '',
                    category_item_count:0,
                    leaderboard_count:  3,
                    trending_count:     3,
                    newsletter_action_call: 'Top stories in your inbox'
                });
            },
            removeWidget:               function($index){
                if(!confirm("Are you sure you want to do this?")){
                    return null;
                }
                this.widgets.splice($index, 1);
            },
            moveDown:                   function($index){
                var saved_widgets   =   this.widgets[$index];
                var nextIndex       =   $index+1;

                if(!this.widgets[nextIndex]){
                    console.log('down no exist');
                    return null;
                }

                this.widgets.splice($index, 1);
                this.widgets.splice(nextIndex, 0, saved_widgets);
            },
            moveUp:                     function($index){
                var saved_widgets   =   this.widgets[$index];
                var prevIndex       =   $index-1;

                if(!this.widgets[prevIndex]){
                    console.log('down no exist');
                    return null;
                }

                this.widgets.splice($index, 1);
                this.widgets.splice(prevIndex, 0, saved_widgets);
            },
            showEditor:                 function($index){
                this.edit_index     =   $index;
                this.show_editor    =   true;
            },
            closeEditor:                function(){
                this.edit_index     =   0;
                this.show_editor    =   false;
            },
            save_widgets:               function(){
                this.show_editor    =   false;
                this.edit_index     =   0;
                this.show_alert     =   true;
                this.alert_class    =   'alert-info';
                this.alert_message  =   'Please wait while your widget settings are saved.';

                var formObj         =   {
                    _token:             $("input[name=_token]").val(),
                    widgets:            this.widgets
                };

                $.post( '', formObj).always(function(response){
                    if(response.status == 2){
                        vm.alert_class  =   'alert-success';
                        vm.alert_message=   'Success!';
                    }else{
                        vm.alert_class  =   'alert-danger';
                        vm.alert_message=   'Something went wrong! Try again later.';
                    }
                });
            }
        }
    });
})(jQuery, window);