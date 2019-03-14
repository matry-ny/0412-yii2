(function ($) {
    var conn = new ab.Session('ws://127.0.0.1:8888',
        function() {
            // eventMonitoring идентификатор, который мы передаём в push класс.
            // conn.subscribe('eventMonitoring', function(topic, data) {
            //     // Сюда будут прилетать данные от вашего веб приложения.
            //     console.log(data);
            // });
        },
        function() {
            console.warn('WebSocket connection closed');
        },
        {'skipSubprotocolCheck': true}
    );
})(jQuery);
