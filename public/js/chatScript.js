hideChat(0);

let searchParams = new URLSearchParams(window.location.search);
let nodeId = 1;
let nextNode = 1;
let keyRequest = "";
let typeRequest = "";
let waitForResponse = false;
let editor;
let userID = "";
let validationMessage = "";

$.getJSON('http://www.geoplugin.net/json.gp?jsoncallback=?', function(data) {
  userId = data['geoplugin_request'];

});
$('#prime').click(function() {
  toggleFab();
});
function displayUserMsg(msgToDisplay){
      var msg = '<span class="chat_msg_item chat_msg_item_user">'
      + msgToDisplay;
   //    +'</span><span class="status">20m ago</span>'

      $('#chat_converse').append(msg);
      $('.chat_converse').scrollTop(1E10);

}


function send(msgToSend, typeMessage){


      var respondMsg = "<span class='chat_msg_item chat_msg_item_admin'>"
      + "<div class='chat_avatar'>"
      + "<img src='http://res.cloudinary.com/dqvwa7vpe/image/upload/v1496415051/avatar_ma6vug.jpg'/>"
      + "</div>";
      var options = "<span class='chat_msg_item'>"
                     +"<ul class='tags'>";
                  
      
      $.post("http://localhost:8000/communicate",
      {
        message: msgToSend,
        type: typeMessage,
        nextNode: nextNode,
        nodeId: nodeId,
        nextNode: nextNode,
        keyRequest: keyRequest,
        typeRequest: typeRequest,
        waitForResponse : waitForResponse,
        validationMessage: validationMessage,
        userID: userID,
        conversationID: conversationID,
        botId: botId
      },
      function(data, status){

        waitForResponse = false;
        if(status == 'success'){
         response = data.response;

         var nbOptions = 0;
      //    var lastOption = false;
         for (var j = 0; j < response.length; j++) {
               var allOptions = options;
               
               (function(j){
               setTimeout(() =>{
                    if(response[j].type != "option" && nbOptions > 0){
                        $('#chat_converse').append(allOptions + "</ul></span>");
                        $('.chat_converse').scrollTop(1E10);
                        $('li').click(function() {
                           displayUserMsg($(this).html());
                           nextNode = $(this).data("flow");
                           send($(this).html(), "interactive");
                        });
                    }

                     if(response[j].type == "message"){
                           $('#chat_converse').append(respondMsg + response[j].content + "</span>");
                           $('.chat_converse').scrollTop(1E10);
                     }else if(response[j].type == "option"){
                           lastOption = true;
                           nbOptions ++;
                           allOptions += "<li data-flow='"+response[j].nextFlow +"'>" + response[j].content + "</li>";
                           console.log(allOptions);
                           if(j == response.length - 1){
                              $('#chat_converse').append(allOptions + "</ul></span>");
                              $('.chat_converse').scrollTop(1E10);
                              $('li').click(function() {
                                 displayUserMsg($(this).html());
                                 nextNode = $(this).data("flow");
                                 send($(this).html(), "interactive");
                              });
                        }
                     }else if(response[j].type == "request_message"){
                            nodeId = response[j].id;
                            nextNode = response[j].nextNode;
                            keyRequest = response[j].key;
                            typeRequest = response[j].typeRequest;
                            validationMessage = response[j].validationMessage;
                            waitForResponse = true;
                            $('#chat_converse').append(respondMsg + response[j].content + "</span>");
                            $('.chat_converse').scrollTop(1E10);
                     }else if(response[j].type == "image"){
                            let img = "<img src='"+ response[j].content +"' class='discImg'/>";
                            $('#chat_converse').append(respondMsg + img + "</span>");
                            $('.chat_converse').scrollTop(1E10);
                     }
                     
               }, j * 1000);
                }(j));

         }
      //    setTimeout(() =>{
      //    if(nbOptions > 0){
      //          $('#chat_converse').append(allOptions + "</ul></span>");
      //          $('.chat_converse').scrollTop(1E10);
      //          $('li').click(function() {
      //             displayUserMsg($(this).html());
      //             nextNode = $(this).data("flow");
      //             send($(this).html(), "interactive");
      //          });
      //    }
      //          }, j * 1000);
      }
      
      });
   }

$('#chatSend').on('keypress', function (e) {
      if(e.which === 13){
         e.preventDefault();
         $(this).attr("disabled", "disabled");
         displayUserMsg($(this).val());
         var msgToSend = $(this).val();
         $(this).val('');
         $(this).removeAttr("disabled");
         $(this).focus();
         send(msgToSend, "message");
      } 
});

// $('#chatSend').bind("enterKey",function(e){
// var msg = '<span class="chat_msg_item chat_msg_item_user">'+ 'My MSG'
// +'Hello!</span>'
// +'<span class="status">20m ago</span>'
// $('#chat_converse').append(msg)
// });

// $('textarea').keyup(function(e){
//       if(e.keyCode == 13)
//       {
//       $(this).trigger("enterKey");
//       }
// });
//Toggle chat and links
function toggleFab() {
  $('.prime').toggleClass('zmdi-comment-outline');
  $('.prime').toggleClass('zmdi-close');
  $('.prime').toggleClass('is-active');
  $('.prime').toggleClass('is-visible');
  $('#prime').toggleClass('is-float');
  $('.chat').toggleClass('is-visible');
  $('.fab').toggleClass('is-visible');
  
}

  $('#chat_first_screen').click(function(e) {
        hideChat(1);
  });

  $('#chat_second_screen').click(function(e) {
        hideChat(2);
  });

  $('#chat_third_screen').click(function(e) {
        hideChat(3);
  });

  $('#chat_fourth_screen').click(function(e) {
        hideChat(4);
  });

  $('#chat_fullscreen_loader').click(function(e) {
      $('.fullscreen').toggleClass('zmdi-window-maximize');
      $('.fullscreen').toggleClass('zmdi-window-restore');
      $('.chat').toggleClass('chat_fullscreen');
      $('.fab').toggleClass('is-hide');
      $('.header_img').toggleClass('change_img');
      $('.img_container').toggleClass('change_img');
      $('.chat_header').toggleClass('chat_header2');
      $('.fab_field').toggleClass('fab_field2');
      //$('.chat_converse').toggleClass('chat_converse2');
      //$('#chat_converse').css('display', 'none');
     // $('#chat_body').css('display', 'none');
     // $('#chat_form').css('display', 'none');
     // $('.chat_login').css('display', 'none');
     // $('#chat_fullscreen').css('display', 'block');
  });

function hideChat(hide) {
    switch (hide) {
      case 1:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'block');
            $('.chat_fullscreen_loader').css('display', 'none');
             $('#chat_fullscreen').css('display', 'none');
            break;
      case 1:
            $('#chat_converse').css('display', 'block');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
      case 2:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'block');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
      case 3:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'block');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            break;
      case 4:
            $('#chat_converse').css('display', 'none');
            $('#chat_body').css('display', 'none');
            $('#chat_form').css('display', 'none');
            $('.chat_login').css('display', 'none');
            $('.chat_fullscreen_loader').css('display', 'block');
            $('#chat_fullscreen').css('display', 'block');
            break;
    }
}

