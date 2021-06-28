
let conversationID;
let botId;
var CHATTY = CHATTY || (function(){
    var _args = {}; // private

    return {
        init : function(Args) {
            _args = Args;
            // some other initialising
        },
        generateChatbot : function() {
            conversationID = _args.conversationID;
            botId = _args.botID;

            var head  = document.getElementsByTagName('head')[0];
            var link  = document.createElement('link');
            link.rel  = 'stylesheet';
            link.type = 'text/css';
            link.href = 'http://localhost:8000/css/chatStyle.css';
            head.appendChild(link);


            var fabs = document.createElement('div');
            fabs.className="fabs";


            var chat = document.createElement('div');
            chat.className="chat";

            var chat_header = document.createElement('div');
            chat_header.className="chat_header";

            var chat_option = document.createElement('div');
            chat_option.className="chat_option";

            var header_img = document.createElement('div');
            header_img.className="header_img";

            var img = document.createElement('img');
            img.src="http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg";
            header_img.appendChild(img);
            chat_option.appendChild(header_img);

            var chat_head = document.createElement('span');
            chat_head.id="chat_head";
            chat_head.innerHTML="Achraf Baby";
            var br = document.createElement('br');

            var agent = document.createElement('span');
            agent.className="agent";
            agent.innerHTML="Agent ";

            var online = document.createElement('span');
            online.className="online";
            online.innerHTML="(Online)";

            chat_option.appendChild(chat_head);
            chat_option.appendChild(br);
            chat_option.appendChild(agent);
            chat_option.appendChild(online);

            chat_header.appendChild(chat_option);
            chat.appendChild(chat_header);

            var chat_converse = document.createElement('div');
            chat_converse.className="chat_conversion chat_converse";
            chat_converse.id="chat_converse";
            chat.appendChild(chat_converse);


            var fab_field = document.createElement('div');
            fab_field.className="fab_field";

            var fab_camera = document.createElement('a');
            fab_camera.id="fab_camera";
            fab_camera.className="fab";

            var iCamera = document.createElement('i');
            iCamera.className="zmdi zmdi-camera";
            fab_camera.appendChild(iCamera);

            var fab_send = document.createElement('a');
            fab_send.id="fab_send";
            fab_send.className="fab";

            var iSend = document.createElement('i');
            iSend.className="zmdi zmdi-mail-send";
            fab_send.appendChild(iSend);

            var textarea = document.createElement('textarea');
            textarea.className="chat_field chat_message";
            textarea.id="chatSend";
            textarea.placeholder="Send a message";


            fab_field.appendChild(fab_camera);
            fab_field.appendChild(fab_send);
            fab_field.appendChild(textarea);
            chat.appendChild(fab_field);

            var prime = document.createElement('a');
            prime.id="prime";
            prime.className="fab";

            var iPrime = document.createElement('i');
            iPrime.className="prime zmdi zmdi-comment-outline";
            prime.appendChild(iPrime);

            fabs.appendChild(chat);
            fabs.appendChild(prime);

            document.body.appendChild(fabs);

            var js = document.createElement('script');
            js.type = 'text/javascript';
            js.src = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js' ;
            document.body.appendChild(js);

            var js = document.createElement('script');
            js.type = 'text/javascript';
            js.src = 'http://localhost:8000/js/chatScript.js' ;
            document.body.appendChild(js);
        }
    };
}());







