(function($){
    $.fn.notif = function(options){
        var options = $.extend({
            html :  '<div class="notification">\
            <div class="left">\
            </div>\
            <div class="right">\
                <h2>{{title}}</h2>\
                <p>{{content}}</p>\
            </div>\
        </div>'
        }, options);
        
        return this.each(function(){
            var $this = $(this);
            var $notifs = $('> .notifications', this);
            var $notif  =  $(Mustache.render(options.html, options));
            
            if ($notifs.length == 0){
                $notifs = $('<div class="notifications"/>');
                $this.append($notifs);
            }
            $notifs.append($notif);
            $notif.click(function(event){
                event.preventDefault();
                $notif.slideUp();
            })
        })
    }

    // $('.add').click(function(event){
    //     event.preventDefault();
    //   $('.test').notif({title:'Mon titre', content:'Mon contenu'});
    // })
})(jQuery);