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

    $(socket).on('socketInit', function (connection) {
        console.log('Opened', $('#chat-form'));
    });
    socket.init();

})(jQuery);
