const activate = (el) => {
  $(el).attr('class', 'activate');
}

const updateValue = (el,column,id) => {
  var value = el.innerText;

  $.ajax({
    url: 'updateTransaction.php',
    type: 'post',
    data: {
      value: value,
      column: column,
      id: id
    },
    success: function(php_result) {
      console.log(php_result);
      $(el).removeAttr('class');
    }
  })
}

const editBtn = document.querySelectorAll('.edit_btn');
const saveBtn = document.querySelectorAll('.edit_btn .save');
// const editDiv = 

// for (i=0; i < changeTr.length; i++) {
//   changeTr[i].addEventListener('click', () => {
//     var b = document.querySelectorAll('.edit_btn');
//     b.classList.add('red');
    
//   })
// }
if(editBtn) {
  for (i=0; i < editBtn.length; i++) {
    editBtn[i].addEventListener('click', e => {
      var id = e.target.parentNode.parentNode.parentNode.id;
      var data = document.getElementById(id).querySelectorAll(":scope > .row-data div");
      var d = document.getElementById(id)
      var icon = document.getElementById(id).querySelectorAll(":scope > td .edit_btn i")
      var deleteIcon = document.getElementById(id).querySelectorAll(":scope > td .delete_btn i")
      var deleteBtn = document.getElementById(id).querySelectorAll(":scope > td .delete_btn")
      var cell = document.getElementById(id).querySelectorAll(":scope > td div")
      
      for(j=1;j<5;j++) {
        data.item(j).setAttribute("contenteditable", "true");
        data.item(j).setAttribute("onClick", "activate(this)");
      }
      editBtn[id].classList.toggle('save')
      if(editBtn[id].className === 'edit_btn save') {
        d.classList.add('editMode');
        icon.item(0).classList.replace('fa-pencil-square-o', 'fa-check-square-o')
        deleteIcon.item(0).classList.replace('fa-arrow-left', 'fa-trash-o')
        deleteBtn.item(0).setAttribute("href", `delete-post.php?id=${cell[0].innerHTML.trim()}`)
      } else {
        d.classList.remove('editMode');
        icon.item(0).classList.replace('fa-check-square-o', 'fa-pencil-square-o')
        deleteIcon.item(0).classList.replace('fa-trash-o', 'fa-arrow-left')
        deleteBtn.item(0).removeAttribute("href")
        for(j=1;j<5;j++) {
          data.item(j).setAttribute("contenteditable", "false");
        }
      }
      console.log(editBtn[id].className)
    })
  }
}



