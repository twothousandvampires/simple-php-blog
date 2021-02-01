a = document.getElementsByClassName('scalable');
for(let i = 0; i < a.length; i++){    
    a[i].addEventListener('mouseenter', ()=>{
        a[i].style.transform = "scale(1.1)";
    })
    a[i].addEventListener('mouseout', ()=>{
        a[i].style.transform = "scale(1)";
    })
}