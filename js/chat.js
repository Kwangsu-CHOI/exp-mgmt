const searchBar = document.querySelector(".chat_search input"),
searchBtn = document.querySelector(".chat_search button"),
userList = document.querySelector(".user_list .user_lists");

if(searchBtn) {
  searchBtn.addEventListener('click', () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle('active');
  });
}

if(searchBar) {
  searchBar.addEventListener('keyup', () => {
    let searchTerm = searchBar.value;
  
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../exp-mgmt/searchUser.php", true);
    xhr.onload = () => {
      if(xhr.readyState === XMLHttpRequest.DONE) {
        if(xhr.status === 200) {
          let data = xhr.response;
          userList.innerHTML = data;
        }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
  });
}


const chatbox = document.querySelector('.typing_area'),
sendBtn = chatbox.querySelector('button'),
chatInput = chatbox.querySelector('.input_area'),
chatField = document.querySelector('.chat_box');

if(chatbox) {
  chatbox.addEventListener('submit', (e) => {
    e.preventDefault();
  })
}

if(sendBtn) {
  sendBtn.addEventListener('click', () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../exp-mgmt/chat-insert.php", true);
    xhr.onload = () => {
      if(xhr.readyState === XMLHttpRequest.DONE) {
        if(xhr.status === 200) {
          chatInput.value = "";
        }
      }
    }
    let formData = new FormData(chatbox);
    xhr.send(formData);
  });
}

setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../../exp-mgmt/chat-get.php", true);
  xhr.onload = () => {
    if(xhr.readyState === XMLHttpRequest.DONE) {
      if(xhr.status === 200) {
        let data = xhr.response;
        chatField.innerHTML = data;
        if(!chatField.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  }
  let formData = new FormData(chatbox);
  xhr.send(formData);
}, 500)

const scrollToBottom = () => {
  chatField.scrollTop = chatField.scrollHeight;
}
if(chatField) {
  chatField.addEventListener("mouseenter", () => {
    chatField.classList.add('active');
  });
  
  chatField.addEventListener("mouseleave", () => {
    chatField.classList.remove('active');
  });
}


//display toggling
const showChat = document.querySelectorAll('.user_lists a');
const chatWrapper = document.querySelector('.chat_wrapper');

if(showChat) {
  showChat.forEach((element) => {
    element.addEventListener('click', () => {
      
      let showClass = 'enable';
      localStorage.setItem("showClass", showClass);
      return false;
    });
  });
}

var currentClass = localStorage.getItem('showClass');
if(currentClass === 'enable') {
  chatWrapper.classList.add('show');
}

const backIcon = document.querySelector('.back-icon');

if(backIcon) {
  backIcon.addEventListener('click', () => {
    showClass = 'disable';
    localStorage.setItem("showClass", showClass);
    if(currentClass === 'disable') {
      chatWrapper.classList.remove('show');
    }
  });
}

// const chatShow = document.querySelector('.app-show .navItem.chat');

// if(chatShow) {
//   chatShow.addEventListener('click', () => {
//     if(chatWrapper.className.contains('show')) {
//       showClass = 'disable';
//       localStorage.setItem("showClass", showClass);
//       if(currentClass === 'disable') {
//         chatWrapper.classList.remove('show');
//       }
//     }
//   })
// }