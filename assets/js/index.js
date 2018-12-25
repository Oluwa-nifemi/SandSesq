document.querySelectorAll('nav ul li').forEach(e => {
   const target = e.dataset.target;
   e.addEventListener('click',() => {
       let scrollPosition = document.querySelector(`#${target}`).offsetTop;
       if(window.innerWidth > 700){
            scrollPosition -= document.querySelector('nav').offsetHeight;
       }
       window.scroll(0,scrollPosition);
   })
});
document.querySelectorAll('#navsmall ul li').forEach(e => {
    e.addEventListener('click',() => {
        document.querySelector('#navsmall').classList.remove('active');
        document.querySelector('#navsmallbtn').classList.remove('active');
    })
});
window.addEventListener('scroll',(e) => {
    if(window.pageYOffset >= document.querySelector('#description').offsetTop){
        document.querySelector('nav').classList.add('active')
    }else{
        document.querySelector('nav').classList.remove('active')
    }
});

document.querySelector('#navsmallbtn').addEventListener('click', () => {
   document.querySelector('#navsmall').classList.add('active');
    document.querySelector('#navsmallbtn').classList.add('active');
});

document.querySelector('#navsmall button').addEventListener('click',() => {
    document.querySelector('#navsmall').classList.remove('active');
    document.querySelector('#navsmallbtn').classList.remove('active');
});