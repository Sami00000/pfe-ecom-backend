const copyIcons = document.querySelectorAll(".copy-icon");
copyIcons.forEach((icon) => {
    icon.addEventListener('click' , (e) => {
        const parentNode = e.target.parentNode.parentNode;
        console.log(parentNode)
        const p = parentNode.querySelector('p');
        let text = p.innerText;
        navigator.clipboard.writeText(text)
    })
})