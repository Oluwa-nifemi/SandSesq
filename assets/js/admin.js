document.querySelectorAll('nav ul li').forEach(e => {
    const target = e.dataset.target;
    e.addEventListener('click',() => {
        let scrollPosition = document.querySelector(`#${target}`).offsetTop;
        window.scroll(0,scrollPosition);
    })
});
document.querySelector('#navsmallbtn').addEventListener('click', () => {
    document.querySelector('#navsmall').classList.add('active');
    document.querySelector('#navsmallbtn').classList.add('active');
});

document.querySelector('#navsmall button').addEventListener('click',() => {
    document.querySelector('#navsmall').classList.remove('active');
    document.querySelector('#navsmallbtn').classList.remove('active');
});
document.querySelectorAll('#navsmall ul li').forEach(e => {
    e.addEventListener('click',() => {
        document.querySelector('#navsmall').classList.remove('active');
        document.querySelector('#navsmallbtn').classList.remove('active');
    })
});

document.querySelector('#edit-desc').addEventListener('click',(e) => {
    document.querySelector('#about-desc').classList.add('edit');
    e.target.classList.add('edit');
});

document.querySelector('#edit-desc-cancel').addEventListener('click',() => {
    document.querySelector('#about-desc').classList.remove('edit');
    document.querySelector('#edit-desc').classList.remove('edit');

});
document.querySelectorAll('.cancel-edit').forEach(e => {
    e.addEventListener('click',()=> {
        e.parentElement.parentElement.classList.remove('edit')
    })
});
document.querySelectorAll('.item-edit').forEach(e => {
    e.addEventListener('click',()=> {
        e.parentElement.parentElement.classList.add('edit')
    })
});
document.querySelector('#add_review_btn').addEventListener('click',() => {
    document.querySelector('#add_review_btn').parentElement.parentElement.classList.add('edit')
});
