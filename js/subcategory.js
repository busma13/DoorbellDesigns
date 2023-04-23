const links = document.querySelectorAll('.product-link');

window.onload = (event) => {
    const href = event.target.location.href;
    let hash = "%";
    if (href.lastIndexOf("#") != -1) {
        hash = href.slice(href.lastIndexOf("#") + 1);
    }
    if (hash === "all") {
        hash = "%";
    }
    links.forEach(el => el.href = el.href + '&subcategory=' + hash);
}

window.addEventListener('hashchange', (event) => {
    const url = event.newURL;
    let hash = url.slice(url.lastIndexOf("#") + 1);
    if (hash === "all") {
        hash = "%";
    }
    links.forEach(el => {
        el.href = el.href.slice(0, el.href.lastIndexOf("&")) + '&subcategory=' + hash;
    })
}, false);

