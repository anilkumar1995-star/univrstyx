// /**
//  * App Chat
//  */

// 'use strict';

// document.addEventListener('DOMContentLoaded', function () {
//   (function () {
//     const chatContactsBody = document.querySelector('.app-chat-contacts .sidebar-body'),
//       chatContactListItems = [].slice.call(
//         document.querySelectorAll('.chat-contact-list-item:not(.chat-contact-list-item-title)')
//       ),
//       chatHistoryBody = document.querySelector('.chat-history-body'),
//       chatSidebarLeftBody = document.querySelector('.app-chat-sidebar-left .sidebar-body'),
//       chatSidebarRightBody = document.querySelector('.app-chat-sidebar-right .sidebar-body'),
//       chatUserStatus = [].slice.call(document.querySelectorAll(".form-check-input[name='chat-user-status']")),
//       chatSidebarLeftUserAbout = $('.chat-sidebar-left-user-about'),
//       formSendMessage = document.querySelector('.form-send-message'),
//       messageInput = document.querySelector('.message-input'),
//       searchInput = document.querySelector('.chat-search-input'),
//       speechToText = $('.speech-to-text'), // ! jQuery dependency for speech to text
//       userStatusObj = {
//         active: 'avatar-online',
//         offline: 'avatar-offline',
//         away: 'avatar-away',
//         busy: 'avatar-busy'
//       };

//     // Initialize PerfectScrollbar
//     // ------------------------------

//     // Chat contacts scrollbar
//     if (chatContactsBody) {
//       new PerfectScrollbar(chatContactsBody, {
//         wheelPropagation: false,
//         suppressScrollX: true
//       });
//     }

//     // Chat history scrollbar
//     if (chatHistoryBody) {
//       new PerfectScrollbar(chatHistoryBody, {
//         wheelPropagation: false,
//         suppressScrollX: true
//       });
//     }

//     // Sidebar left scrollbar
//     if (chatSidebarLeftBody) {
//       new PerfectScrollbar(chatSidebarLeftBody, {
//         wheelPropagation: false,
//         suppressScrollX: true
//       });
//     }

//     // Sidebar right scrollbar
// if (chatSidebarRightBody) {
//   new PerfectScrollbar(chatSidebarRightBody, {
//     wheelPropagation: false,
//     suppressScrollX: true
//   });
// }

//     // Scroll to bottom function
//     function scrollToBottom() {
//       chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
//     }
//     scrollToBottom();
//     // User About Maxlength Init
//     if (chatSidebarLeftUserAbout.length) {
//       // chatSidebarLeftUserAbout.maxlength({
//       //   alwaysShow: true,
//       //   warningClass: 'label label-success bg-success text-white',
//       //   limitReachedClass: 'label label-danger',
//       //   separator: '/',
//       //   validate: true,
//       //   threshold: 120
//       // });
//     }

//     // Update user status
//     chatUserStatus.forEach(el => {
//       el.addEventListener('click', e => {
//         let chatLeftSidebarUserAvatar = document.querySelector('.chat-sidebar-left-user .avatar'),
//           value = e.currentTarget.value;
//         //Update status in left sidebar user avatar
//         chatLeftSidebarUserAvatar.removeAttribute('class');
//         Helpers._addClass('avatar avatar-xl ' + userStatusObj[value] + '', chatLeftSidebarUserAvatar);
//         //Update status in contacts sidebar user avatar
//         let chatContactsUserAvatar = document.querySelector('.app-chat-contacts .avatar');
//         chatContactsUserAvatar.removeAttribute('class');
//         Helpers._addClass('flex-shrink-0 avatar ' + userStatusObj[value] + ' me-3', chatContactsUserAvatar);
//       });
//     });

//     // Select chat or contact
//     chatContactListItems.forEach(chatContactListItem => {
//       // Bind click event to each chat contact list item
//       chatContactListItem.addEventListener('click', e => {
//         // Remove active class from chat contact list item
//         chatContactListItems.forEach(chatContactListItem => {
//           chatContactListItem.classList.remove('active');
//         });
//         // Add active class to current chat contact list item
//         e.currentTarget.classList.add('active');
//       });
//     });

//     // Filter Chats
//     if (searchInput) {
//       searchInput.addEventListener('keyup', e => {
//         let searchValue = e.currentTarget.value.toLowerCase(),
//           searchChatListItemsCount = 0,
//           searchContactListItemsCount = 0,
//           chatListItem0 = document.querySelector('.chat-list-item-0'),
//           contactListItem0 = document.querySelector('.contact-list-item-0'),
//           searchChatListItems = [].slice.call(
//             document.querySelectorAll('#chat-list li:not(.chat-contact-list-item-title)')
//           ),
//           searchContactListItems = [].slice.call(
//             document.querySelectorAll('#contact-list li:not(.chat-contact-list-item-title)')
//           );

//         // Search in chats
//         searchChatContacts(searchChatListItems, searchChatListItemsCount, searchValue, chatListItem0);
//         // Search in contacts
//         searchChatContacts(searchContactListItems, searchContactListItemsCount, searchValue, contactListItem0);
//       });
//     }

//     // Search chat and contacts function
//     function searchChatContacts(searchListItems, searchListItemsCount, searchValue, listItem0) {
//       searchListItems.forEach(searchListItem => {
//         let searchListItemText = searchListItem.textContent.toLowerCase();
//         if (searchValue) {
//           if (-1 < searchListItemText.indexOf(searchValue)) {
//             searchListItem.classList.add('d-flex');
//             searchListItem.classList.remove('d-none');
//             searchListItemsCount++;
//           } else {
//             searchListItem.classList.add('d-none');
//           }
//         } else {
//           searchListItem.classList.add('d-flex');
//           searchListItem.classList.remove('d-none');
//           searchListItemsCount++;
//         }
//       });
//       // Display no search fount if searchListItemsCount == 0
//       if (searchListItemsCount == 0) {
//         listItem0.classList.remove('d-none');
//       } else {
//         listItem0.classList.add('d-none');
//       }
//     }

//     // Send Message
//     formSendMessage.addEventListener('submit', e => {
//       e.preventDefault();
//       if (messageInput.value) {
//         // Create a div and add a class
//         let renderMsg = document.createElement('div');
//         renderMsg.className = 'chat-message-text mt-2';
//         renderMsg.innerHTML = '<p class="mb-0">' + messageInput.value + '</p>';
//         document.querySelector('li:last-child .chat-message-wrapper').appendChild(renderMsg);
//         messageInput.value = '';
//         scrollToBottom();
//       }
//     });

//     // on click of chatHistoryHeaderMenu, Remove data-overlay attribute from chatSidebarLeftClose to resolve overlay overlapping issue for two sidebar
//     let chatHistoryHeaderMenu = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
//       chatSidebarLeftClose = document.querySelector('.app-chat-sidebar-left .close-sidebar');
//     chatHistoryHeaderMenu.addEventListener('click', e => {
//       chatSidebarLeftClose.removeAttribute('data-overlay');
//     });
//     // }

//     // Speech To Text
//     if (speechToText.length) {
//       var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
//       if (SpeechRecognition !== undefined && SpeechRecognition !== null) {
//         var recognition = new SpeechRecognition(),
//           listening = false;
//         speechToText.on('click', function () {
//           const $this = $(this);
//           recognition.onspeechstart = function () {
//             listening = true;
//           };
//           if (listening === false) {
//             recognition.start();
//           }
//           recognition.onerror = function (event) {
//             listening = false;
//           };
//           recognition.onresult = function (event) {
//             $this.closest('.form-send-message').find('.message-input').val(event.results[0][0].transcript);
//           };
//           recognition.onspeechend = function (event) {
//             listening = false;
//             recognition.stop();
//           };
//         });
//       }
//     }
//   })();
// });
function debounce(t, a) {
  let c;
  return (...e) => {
    clearTimeout(c),
      c = setTimeout(() => t.apply(this, e), a)
  }
}
document.addEventListener("DOMContentLoaded", () => {
  let c = {
    chatContactsBody: document.querySelector(".app-chat-contacts .sidebar-body"),
    chatHistoryBody: document.querySelector(".chat-history-body"),
    chatSidebarLeftBody: document.querySelector(".app-chat-sidebar-left .sidebar-body"),
    chatSidebarRightBody: document.querySelector(".app-chat-sidebar-right .sidebar-body"),
    chatUserStatus: [...document.querySelectorAll(".form-check-input[name='chat-user-status']")],
    chatSidebarLeftUserAbout: document.getElementById("chat-sidebar-left-user-about"),
    formSendMessage: document.querySelector(".form-send-message"),
    messageInput: document.querySelector(".message-input"),
    searchInput: document.querySelector(".chat-search-input"),
    // chatContactListItems: [...document.querySelectorAll(".chat-contact-list-item:not(.chat-contact-list-item-title)")],
    textareaInfo: document.getElementById("textarea-maxlength-info"),
    conversationButton: document.getElementById("app-chat-conversation-btn"),
    chatHistoryHeader: document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
    speechToText: $(".speech-to-text"),
    appChatConversation: document.getElementById("app-chat-conversation"),
    appChatHistory: document.getElementById("app-chat-history")
  }, a = {
    active: "avatar-online",
    offline: "avatar-offline",
    away: "avatar-away",
    busy: "avatar-busy"
  };
  let o = () => c.chatHistoryBody?.scrollTo(0, c.chatHistoryBody.scrollHeight);
  function e(e, t, a) {
    var e = e.value.length
      , c = a - e;
    t.className = "maxLength label-success",
      0 <= c && (t.textContent = e + "/" + a),
      c <= 0 && (t.textContent = e + "/" + a,
        t.classList.remove("label-success"),
        t.classList.add("label-danger"))
  }
  let t = () => {
    c.appChatConversation.classList.replace("d-flex", "d-none"),
      c.appChatHistory.classList.replace("d-none", "d-block")
  }
    , s = (e, a, t) => {
      e = document.querySelectorAll(e + ":not(.chat-contact-list-item-title)");
      let c = 0;
      e.forEach(e => {
        var t = e.textContent.toLowerCase().includes(a);
        e.classList.toggle("d-flex", t),
          e.classList.toggle("d-none", !t),
          t && c++
      }
      ),
        document.querySelector(t)?.classList.toggle("d-none", 0 < c)
    }
    ;
  [c.chatContactsBody, c.chatHistoryBody, c.chatSidebarLeftBody, c.chatSidebarRightBody].forEach(e => {
    // e && new PerfectScrollbar(e, {
    //   wheelPropagation: !1,
    //   suppressScrollX: !0
    // })
  }
  ),
    o(),
    c.chatUserStatus.forEach(e => {
      e.addEventListener("click", () => {
        var t;
        t = e.value,
          [document.querySelector(".chat-sidebar-left-user .avatar"), document.querySelector(".app-chat-contacts .avatar")].forEach(e => {
            e && (e.className = e.className.replace(/avatar-\w+/, a[t]))
          }
          )
      }
      )
    }
    );
  // let r = parseInt(c.chatSidebarLeftUserAbout.getAttribute("maxlength"), 10);
  // e(c.chatSidebarLeftUserAbout, c.textareaInfo, r),
  //   c.chatSidebarLeftUserAbout.addEventListener("input", () => {
  //     e(c.chatSidebarLeftUserAbout, c.textareaInfo, r)
  //   }
  //   ),
  // c.conversationButton?.addEventListener("click", t), c.chatContactListItems.forEach(e => {
  //   e.addEventListener("click", () => {
  //     c.chatContactListItems.forEach(e => e.classList.remove("active")),
  //       e.classList.add("active"),
  //       t()
  //   }
  //   )
  // }
  // ),
    c.searchInput?.addEventListener("keyup", debounce(e => {
      e = e.target.value.toLowerCase();
      s("#chat-list li", e, ".chat-list-item-0"),
        s("#contact-list li", e, ".contact-list-item-0")
    }
      , 300)),
    c.formSendMessage?.addEventListener("submit", e => {
      e.preventDefault();
      var t, e = c.messageInput.value.trim();
      e && ((t = document.createElement("div")).className = "chat-message-text mt-2",
        t.innerHTML = `<p class="mb-0 text-break">${e}</p>`,
        document.querySelector("li:last-child .chat-message-wrapper")?.appendChild(t),
        c.messageInput.value = "",
        o())
    }
    ),
    c.chatHistoryHeader?.addEventListener("click", () => {
      document.querySelector(".app-chat-sidebar-left .close-sidebar")?.removeAttribute("data-overlay")
    }
    ),
    (() => {
      var a = window.SpeechRecognition || window.webkitSpeechRecognition;
      if (a && 0 !== c.speechToText.length) {
        let e = new a
          , t = !1;
        c.speechToText.on("click", function () {
          t || e.start(),
            e.onspeechstart = () => t = !0,
            e.onresult = e => {
              $(this).closest(".form-send-message").find(".message-input").val(e.results[0][0].transcript)
            }
            ,
            e.onspeechend = () => t = !1,
            e.onerror = () => t = !1
        })
      }
    }
    )()
}
);
