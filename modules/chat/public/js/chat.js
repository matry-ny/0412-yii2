(function ($) {
    var socket = {
        socketUrl: 'ws://127.0.0.1:8888',

        /**
         * Init  socket connection
         */
        init: function () {
            this.connect();
        },
        connect: function () {
            var socketConnection = new ab.Session(
                this.socketUrl,
                function () {
                    $(socket).trigger('socketInit', [socketConnection]);
                },
                function () {
                    console.warn('Connection is broken');
                    setTimeout(function () {
                        socket.connect();
                    }, 500);
                },
                {
                    'skipSubprotocolCheck': true
                }
            );
        }
    };

    $(socket).on('socketInit', function (event, connection) {
        connection.subscribe('message', function (topic, data) {
            $('#chat-messages').append($('li').text(data));
        });

        $('#chat-form').on('submit', function () {
            var message = $(this).find('[name="message"]').val();

            connection.publish('message', message);
            
            return false;
        });
    });
    socket.init();

})(jQuery);
