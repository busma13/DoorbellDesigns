// List of all products
// store this elsewhere in the future
let productList = [
    {
        name: 'Bamboo Doorbell',
        categories: ['Doorbells', "Plants"],
        price: 59,
        qtyInCart: 0
    },
    {
        name: 'Release The Hounds Doorbell',
        categories: ['Doorbells', "Dog Lovers"],
        price: 169,
        qtyInCart: 0
    },
    {
        name: 'Buffalo Shaman Doorbell',
        categories: ['Doorbells', "Petroglyphs"],
        price: 49,
        qtyInCart: 0
    },
    {
        name: 'Grapes Doorbell',
        categories: ['Doorbells', "Plants"],
        price: 29,
        qtyInCart: 0
    },
    {
        name: 'Green Lizard Doorbell',
        categories: ['Doorbells', "Animals"],
        price: 99,
        qtyInCart: 0
    },
];


// Grab all the buttons that add items on a shop page
let addToCartBtns = document.querySelectorAll('.add-to-cart');

for (let i = 0; i < addToCartBtns.length; i++) {
    addToCartBtns[i].addEventListener('click', (event) => {
        let productName = event.currentTarget.id;
        let product = productList.find(product => product.name === productName)
        cartItemCount(1, product);
        updateTotalCost(1, product);
    })
}

// Grab the button that adds items on a single product page
let addToCartBtnSinglePage = document.querySelector('.add-to-cart-single');

if (addToCartBtnSinglePage) {
    addToCartBtnSinglePage.addEventListener('click', () => {
        let qty = Number(document.querySelector('.input-text').value);
        let productName = document.querySelector('.product-name').textContent;
        let product = productList.find(product => product.name === productName);
        cartItemCount(qty, product);
        updateTotalCost(qty, product);
    });
}

// Update the number of items in the cart
function cartItemCount(qty, product) {
    let numOfItems = Number(localStorage.getItem('cartItemCount'));

    if (numOfItems) {
        localStorage.setItem('cartItemCount', numOfItems + qty);
        document.querySelector('.cartCount').textContent = numOfItems + qty;
    } else {
        localStorage.setItem('cartItemCount', qty);
        document.querySelector('.cartCount').textContent = qty;
    }

    setItems(qty, product)
}

// Add product to local storage and update quantity
function setItems(qty, product) {
    let cartContents = JSON.parse(localStorage.getItem('cartProducts'));
    
    if(cartContents) {
        if(!cartContents[product.name]) {
            cartContents = {
                ...cartContents,
                [product.name]: product
            }
        }
        cartContents[product.name].qtyInCart += qty;
    } else {
        product.qtyInCart = qty;
        cartContents = {
            [product.name]: product
        }
    }
    
    localStorage.setItem('cartProducts', JSON.stringify(cartContents))
}

// When page loads get the number of items in the shopping cart and display
// it in the nav bar.
function onLoadCartCount() {
    let numOfItems = Number(localStorage.getItem('cartItemCount'));

    if(numOfItems) {
        document.querySelector('.cartCount').textContent = numOfItems;
    }
}

// Update local storage with the total cost of all items in the cart.
function updateTotalCost(qty, product) {
    console.log(qty, product);
    let cartTotal = Number(localStorage.getItem('cartTotal'));
    if (cartTotal) {
        localStorage.setItem('cartTotal', cartTotal + product.price * qty)
    } else {
        localStorage.setItem('cartTotal', product.price * qty);
    }
}

onLoadCartCount();