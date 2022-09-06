const pickr = Pickr.create({
  el: '.color-picker',
  theme: 'nano', // or 'monolith', or 'nano'
  default: '#000000',
  appClass: 'custom-class',

  swatches: [
      'rgba(244, 67, 54, 1)',
      'rgba(233, 30, 99, 0.95)',
      'rgba(156, 39, 176, 0.9)',
      'rgba(103, 58, 183, 0.85)',
      'rgba(63, 81, 181, 0.8)',
      'rgba(33, 150, 243, 0.75)',
      'rgba(3, 169, 244, 0.7)',
      'rgba(0, 188, 212, 0.7)',
      'rgba(0, 150, 136, 0.75)',
      'rgba(76, 175, 80, 0.8)',
      'rgba(139, 195, 74, 0.85)',
      'rgba(205, 220, 57, 0.9)',
      'rgba(255, 235, 59, 0.95)',
      'rgba(255, 193, 7, 1)'
  ],

  components: {

      // Main components
      preview: true,
      opacity: true,
      hue: true,

      // Input / output Options
      interaction: {
          hex: true,
          rgba: true,
          input: true,
          cancel: true,
          save: true
      }
  },

  i18n: {
    'btn:cancel': 'RESET',
    'btn:save': 'SAVE'
  }
});


if(pickr) {
  pickr.on('save', (color, instance) => {
    const rgbaColor = color.toRGBA()
    
    var customColor_zero = `rgba(${rgbaColor[0]}, ${rgbaColor[1]+120}, ${rgbaColor[2]+120}, 1)`;
    var customColor_one = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.2)`;
    var customColor_two = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.3)`;
    var customColor_three = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.4)`;
    var customColor_four = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.55)`;
    var customColor_five = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.7)`;
    var customColor_six = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 0.85)`;
    var customColor_seven = `rgba(${rgbaColor[0]}, ${rgbaColor[1]}, ${rgbaColor[2]}, 1)`;
  
    const bod = document.querySelector('body');
    document.body.classList.toggle('custom-theme');
    const customTheme = document.querySelector('.custom-theme');
    customTheme.style.setProperty('--white', customColor_zero);
    customTheme.style.setProperty('--gray-100', customColor_one);
    customTheme.style.setProperty('--gray-200', customColor_two);
    customTheme.style.setProperty('--gray-300', customColor_three);
    customTheme.style.setProperty('--gray-400', customColor_four);
    customTheme.style.setProperty('--gray-500', customColor_five);
    customTheme.style.setProperty('--gray-600', customColor_six);
    customTheme.style.setProperty('--gray-700', customColor_seven);
  
    customTheme.style.setProperty('--primary-100', customColor_one);
    customTheme.style.setProperty('--primary-200', customColor_two);
    customTheme.style.setProperty('--primary-300', customColor_three);
    customTheme.style.setProperty('--primary-400', customColor_four);
    customTheme.style.setProperty('--primary-500', customColor_five);
    customTheme.style.setProperty('--primary-600', customColor_six);
    customTheme.style.setProperty('--primary-700', customColor_seven);
    customTheme.style.setProperty('--primary-800', customColor_seven);
  
    // const currentTheme = localStorage.getItem("theme");
    // if (currentTheme == "custom") {
    //   document.body.classList.add("custom-theme");
    // }
  
    let theme = "light";
    if (document.body.classList.contains("custom-theme")) {
      theme = "custom";
    } 
  
    localStorage.setItem("theme", theme);
  
    localStorage.setItem('--white', customColor_zero);
    localStorage.setItem('--gray-100', customColor_one);
    localStorage.setItem('--gray-200', customColor_two);
    localStorage.setItem('--gray-300', customColor_three);
    localStorage.setItem('--gray-400', customColor_four);
    localStorage.setItem('--gray-500', customColor_five);
    localStorage.setItem('--gray-600', customColor_six);
    localStorage.setItem('--gray-700', customColor_seven);
  
    customTheme.style.setItem('--primary-100', customColor_one);
    customTheme.style.setItem('--primary-200', customColor_two);
    customTheme.style.setItem('--primary-300', customColor_three);
    customTheme.style.setItem('--primary-400', customColor_four);
    customTheme.style.setItem('--primary-500', customColor_five);
    customTheme.style.setItem('--primary-600', customColor_six);
    customTheme.style.setItem('--primary-700', customColor_seven);
    customTheme.style.setItem('--primary-800', customColor_seven);
    
  }).on('cancel', instance => {
    
    const body = document.querySelector('body');
    if(document.querySelector('body').classList.contains('custom-theme')) {
      document.querySelector('body').classList.replace('custom-theme', 'default-theme');
      body.style.removeProperty('--white');
      body.style.removeProperty('--gray-100');
      body.style.removeProperty('--gray-200');
      body.style.removeProperty('--gray-300');
      body.style.removeProperty('--gray-400');
      body.style.removeProperty('--gray-500');
      body.style.removeProperty('--gray-600');
      body.style.removeProperty('--gray-700');
  
      body.style.removeProperty('--primary-100');
      body.style.removeProperty('--primary-200');
      body.style.removeProperty('--primary-300');
      body.style.removeProperty('--primary-400');
      body.style.removeProperty('--primary-500');
      body.style.removeProperty('--primary-600');
      body.style.removeProperty('--primary-700');
      body.style.removeProperty('--primary-800');
      
      let theme = "light";
      if (document.body.classList.contains("default-theme")) {
        theme = "default";
      } 
      localStorage.setItem("theme", theme);
      body.classList.remove('default-theme');
      body.classList.remove('dark-theme');
    }
  });

}


