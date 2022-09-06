//toggling Navigation
const toggle = document.querySelector('.toggle'),
navigation = document.querySelector('.navigation'),
main = document.querySelector('.main');

if(toggle) {
  toggle.addEventListener('click', () => {
    let activeNav = 'active';
    toggle.classList.toggle('active');
    if(toggle.classList.contains('active')) {
      activeNav = 'active';
    } else {
      activeNav = '';
    }
    localStorage.setItem("activeNav", activeNav);
    
    navigation.classList.toggle('active');
    main.classList.toggle('active');
  });
}
const currentActiveNav = localStorage.getItem("activeNav");
if(currentActiveNav === 'active') {
  toggle.classList.add('active');
  navigation.classList.add('active');
  main.classList.add('active');
} else {
  toggle.classList.remove('active');
  navigation.classList.remove('active');
  main.classList.remove('active');
}

// toggling darkmode
const themeBtn  = document.querySelector('.profile .theme-btn'),
dayMode = document.querySelector('#dayMode'),
nightMode = document.querySelector('#nightMode');

const currentTheme = localStorage.getItem("theme");
if (currentTheme == "dark") {
  document.body.classList.add("dark-theme");
  nightMode.classList.add('active');
  dayMode.classList.remove('active');
} else if (currentTheme == "custom") {
  document.body.classList.add("custom-theme");
  document.querySelector('.custom-theme').style.setProperty('--white', localStorage.getItem('--white'));
  document.querySelector('.custom-theme').style.setProperty('--gray-100', localStorage.getItem('--gray-100'));
  document.querySelector('.custom-theme').style.setProperty('--gray-200', localStorage.getItem('--gray-200'));
  document.querySelector('.custom-theme').style.setProperty('--gray-300', localStorage.getItem('--gray-300'));
  document.querySelector('.custom-theme').style.setProperty('--gray-400', localStorage.getItem('--gray-400'));
  document.querySelector('.custom-theme').style.setProperty('--gray-500', localStorage.getItem('--gray-500'));
  document.querySelector('.custom-theme').style.setProperty('--gray-600', localStorage.getItem('--gray-600'));
  document.querySelector('.custom-theme').style.setProperty('--gray-700', localStorage.getItem('--gray-700'));
  
}
if(themeBtn) {
  themeBtn.addEventListener("click", function () {
    document.body.classList.toggle('dark-theme');
    
    let theme = "light";
    if (document.body.classList.contains("dark-theme")) {
      theme = "dark";
    } 
    
    nightMode.classList.toggle('active');
    dayMode.classList.toggle('active');
    localStorage.setItem("theme", theme);
  
  });
}


//active nav menu
const nav = document.querySelector('.navigation');
const activeMenu = document.querySelectorAll('.navItem');

for (var i = 0; i < activeMenu.length; i++) {
  if(activeMenu[i].href === location.href) {
    activeMenu[i].classList.add("active");
  } else if (location.href.includes("transactions")) {
    activeMenu[1].classList.add("active");
  } else {
    activeMenu[i].classList.remove("active");
  }
};

//toggle subnav menus
const appMenu = document.querySelector('.navigation ul .app-show');
const toggleList = document.querySelector('.app-btn');

if(toggleList) {
  toggleList.addEventListener('click', () => {
    appMenu.classList.toggle('show');
  });
}


// toggling transaction add form
const addform = document.querySelector('#addForm');
const formSwitch = document.querySelector('.switch');
if(formSwitch) {
  document.querySelector('.switch').addEventListener('click', e => { 
    addform.style.display = e.target.checked ? 'none' : 'flex';
    addform.style.display = e.target.checked ? 'flex' : 'none';
    document.querySelector('.switch-btn').style.marginBottom = '15px'
  });
}

//random color
const randomColor = "#" + Math.floor(Math.random()*16777215).toString(16);
document.documentElement.style.setProperty('--random', randomColor);


// toggling category add form
const changeIcon = document.querySelector('#addIcon');
const addCategory = document.querySelector('#addCategory');
if(changeIcon) {
  changeIcon.addEventListener('click', () => {
    if(changeIcon.classList.contains('fa-plus')) {
      changeIcon.classList.replace('fa-plus', 'fa-minus');
      addCategory.style.display = 'flex';
    } else {
      changeIcon.classList.replace('fa-minus', 'fa-plus');
      addCategory.style.display = 'none';
    }
  });
}

//active page btn

const pageBtn = document.querySelectorAll('.page-btn');
for (var i=0; i<pageBtn.length; i++) {
  if(pageBtn[i].href === location.href) {
    pageBtn[i].classList.add("active");
  } else {
    pageBtn[i].classList.remove("active");
  }
};



const lineSpacing = document.querySelectorAll('.line-spacing');
if(lineSpacing[0]) {
  lineSpacing[0].addEventListener('click', () => {
    document.body.style.lineHeight = 1;
  });
};
if(lineSpacing[1]) {
  lineSpacing[1].addEventListener('click', () => {
    document.body.style.lineHeight = 1.5;
  });
};
if(lineSpacing[2]) {
  lineSpacing[2].addEventListener('click', () => {
    document.body.style.lineHeight = 2;
  });
};
if(lineSpacing[3]) {
  lineSpacing[3].addEventListener('click', () => {
    document.body.style.lineHeight = 'normal';
  });
};


const letterSpacing = document.querySelectorAll('.letter-spacing');
if(letterSpacing[0]) {
  letterSpacing[0].addEventListener('click', () => {
    document.body.style.letterSpacing = '-0.5px';
  });
};
if(letterSpacing[1]) {
  letterSpacing[1].addEventListener('click', () => {
    document.body.style.letterSpacing = '1px';
  });
};
if(letterSpacing[2]) {
  letterSpacing[2].addEventListener('click', () => {
    document.body.style.letterSpacing = '2.5px';
  });
};
if(letterSpacing[3]) {
  letterSpacing[3].addEventListener('click', () => {
    document.body.style.letterSpacing = '4px';
  });
};
if(letterSpacing[4]) {
  letterSpacing[4].addEventListener('click', () => {
    document.body.style.letterSpacing = 'normal';
  });
};


//====== export table =======
const tableToExport = document.getElementById('export_table');
const exportPDF = document.querySelector('#export_pdf'),
exportExcel = document.querySelector('#export_excel');
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0');
var yyyy = today.getFullYear();
today = dd +  mm + yyyy;

// table to pdf
if(exportPDF) {
  exportPDF.addEventListener('click', () => {
    var opt = {
      margin:       1,
      filename:     `${today}record.pdf`,
      image:        { type: 'jpeg', quality: 0.98 },
      html2canvas:  { scale: 2 },
      jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().from(tableToExport).set(opt).save();
  });
}
//table to excel
$(function() {
  $("#export_excel").click(function(e) {
    $("#export_table").table2excel({
      exclude: ".excluded_column",
      name: "Exported Table",
      filename: "outputFile-" + today + "record.xls",
      exclude_img: true,
      exclude_links: true,
      exclude_inputs: true,
      preserveColors: false
    });
  })
})


