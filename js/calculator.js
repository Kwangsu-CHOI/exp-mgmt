var buttons = document.querySelector('.calc_buttons'),
btn = document.querySelectorAll('.calc_buttons span'),
value = document.getElementById('values');

for(var i=0; i<btn.length; i++) {
  btn[i].addEventListener('click', (e) => {
    
    if(e.target.innerText === '=') {
      value.innerText = eval(value.innerText);
    } else {
      if(e.target.innerText === 'CLEAR') {
        value.innerText = '';
      } else {
        value.innerText += e.target.innerText;
        
      }
    }
  })
}

const calcBtn = document.querySelector('.calc_toggle'),
calcContainer = document.querySelector('.calculator__container');

if(calcBtn) {
  calcBtn.addEventListener('click', () => {
    calcContainer.classList.toggle('active');
  })
}