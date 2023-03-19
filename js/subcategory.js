const links = document.querySelectorAll('.product-link');

window.onload = (event) => {
    const href = event.target.location.href;
    let hash = "%";
    if (href.lastIndexOf("#") != -1) {
        hash = href.slice(href.lastIndexOf("#") + 1);
    }
    links.forEach(el => el.href = el.href + '&subcategory=' + hash);
    console.log('hash: ', hash);
}

window.addEventListener('hashchange', (event) => {
    const url = event.newURL;
    const hash = url.slice(url.lastIndexOf("#") + 1);
    console.log(hash);
    links.forEach(el => {
        console.log(el.href);
        el.href = el.href.slice(0, el.href.lastIndexOf("&")) + '&subcategory=' + hash;
    })
}, false);

