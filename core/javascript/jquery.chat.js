(function($){
    $.fn.chat = function(options){
        var options = $.extend({
            html :  '<div class="chat">\
            <div class="note_up">\
                <h2>{{pseudo}}<h2>\
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

(function($){
    $.fn.chat = function(options){
        var options = $.extend({
            html : '<section class="win">\
                        <div class="chatHead">\
                            <h2>{{title}}<h2>\
                        </div>\
                        <div class="chatContent">\
                        <div>{{content}}</div>\
                        </div>\
                    </section>'
                }, options);

        return this.each(function(){
            var $this = $(this);
            var $chats = $('>.win', this);
            var $chat = $(Mustache.render(options.html, options));

            if ($chats.length == 0){
                $chats = $('<div class="win"/>');
            }
            //  $this.append($chats);
            // }
            $chats.append($chat);
        })
    }

    $('#chatbtn').click(function(event){
        event.preventDefault();
        $('.Chatbox').chat({title:'montitre', content:'moncontenue'});
    })
})(jQuery);