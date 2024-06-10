
  function flight(){
    window.location.href = "./flight search.html";
  }
  function contact(){
    window.location.href = "./contact.html";
  }
  function login(){
    window.location.href = "./login.html";
  }
  function home(){
    window.location.href = "./index.html";
  }
  

  const classbuttons = document.querySelectorAll('.booking__nav span');

  for(let i=0; i < classbuttons.length; i++){
    classbuttons[i].addEventListener('click', (e) => {
      for(let j=0; j < classbuttons.length; j++){
        classbuttons[j].classList.remove('active');
      }
    classbuttons[i].classList.add('active');
  });
}

  