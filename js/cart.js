// List of all products
// store this elsewhere in the future
let productList = [
    {
        name: 'Bamboo Doorbell',
        categories: ['Doorbells', "Plants"],
        price: 59,
        qtyInCart: 0,
        pageUrl: 'bamboo-doorbell.html',
        imgUrl: 'images/doorbells/bamboo_9to10.jpg'
    },
    {
        name: 'Release The Hounds Doorbell',
        categories: ['Doorbells', "Dog Lovers"],
        price: 169,
        qtyInCart: 0,
        pageUrl: 'release-the-hounds.html',
        imgUrl: 'images/doorbells/to-release-the-hounds-1_9to10.jpg'
    },
    {
        name: 'Buffalo Shaman Doorbell',
        categories: ['Doorbells', "Petroglyphs"],
        price: 49,
        qtyInCart: 0,
        pageUrl: 'bamboo-doorbell.html',
        imgUrl: 'images/doorbells/buffalo-shaman_9to10.jpg'
    },
    {
        name: 'Grapes Doorbell',
        categories: ['Doorbells', "Plants"],
        price: 29,
        qtyInCart: 0,
        pageUrl: 'bamboo-doorbell.html',
        imgUrl: 'images/doorbells/grapes_9to10.jpg'
    },
    {
        name: 'Green Lizard Doorbell',
        categories: ['Doorbells', "Animals"],
        price: 99,
        qtyInCart: 0,
        pageUrl: 'bamboo-doorbell.html',
        imgUrl: 'images/doorbells/lizard-green_9to10.jpg'
    },
];


// Grab all the buttons that add items on a shop page
let addToCartBtns = document.querySelectorAll('.add-to-cart');

for (let i = 0; i < addToCartBtns.length; i++) {
    addToCartBtns[i].addEventListener('click', (event) => {
        let productName = event.currentTarget.id;
        let product = productList.find(product => product.name === productName)
        console.log(event.currentTarget);
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

// Update the localStorage cartItemCount and display to nav bar 
function cartItemCount(qty, product) {
    console.log(qty, product);
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

// When page loads/changes get the number of items in the shopping cart and display
// it in the nav bar.
function updateCartCount() {
    let numOfItems = Number(localStorage.getItem('cartItemCount'));
    if(numOfItems != undefined) {
        document.querySelector('.cartCount').textContent = numOfItems;
    }
}

// Update local storage with the total cost of all items in the cart.
function updateTotalCost(qty, product) {
    let cartTotal = Number(localStorage.getItem('cartTotal'));
    if (cartTotal) {
        localStorage.setItem('cartTotal', cartTotal + product.price * qty)
    } else {
        localStorage.setItem('cartTotal', product.price * qty);
    }
}

function displayCart() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    //console.log(productsInCart);
    let productTable = document.querySelector('.cart-table-body')
    if ( productsInCart && productTable ) {
        productTable.innerHTML = '';
        Object.values(productsInCart).map(item => {
            productTable.innerHTML += `
            <tr class="cart-item">
                <td class="image"><a href="${item.pageUrl}"><img src="${item.imgUrl}" alt=""></a></td>
                <td><a href="${item.pageUrl}">${item.name}</a></td>
                <td>$${item.price}</td>
                <td class="qty"><input type="number" step="1" min="1" name="cart" value="${item.qtyInCart}" title="Qty" class="input-text qty text qty-input-box" size="4"></td>
                <td>$${item.price * item.qtyInCart}</td>
                <td class="remove"><a href="#x" class="btn btn-danger-filled x-remove">×</a></td>
            </tr>
            `; 
        });
        
        updateSingleProductTotals()
        removeProductFromCart()
        updateCartTotals()
    }
}

// Updates a single products total price when quantity is changed in the shopping cart. Updates the localStorage cartItemCount and the products qtyInCart
function updateSingleProductTotals() {
    let qtyBoxes = document.querySelectorAll('.qty-input-box');
    qtyBoxes.forEach(qtyBox => {
        qtyBox.addEventListener('input', (e) => {
            let qty = e.currentTarget.value;
            if (qty != '') {
                let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
                let tdQty = e.currentTarget.parentNode;
                let tableRow = tdQty.parentNode;
                let product = cartProducts[tableRow.childNodes[3].innerText]
                let qtyToAdd = qty - product.qtyInCart;

                // Update the total price in the DOM
                tdQty.nextElementSibling.textContent = `$${tdQty.previousElementSibling.textContent.slice(1) * qty}`;
                
                // Update the localStorage cartItemCount value
                
                cartItemCount(qtyToAdd, product)
                
                //Update the localStorage cartTotal value
                updateTotalCost(qtyToAdd, product)

                // update cart total in the nav bar
                updateCartCount()

                updateCartTotals()
            }
        });
    });
}

// Removes a product from the cart when you click the X button
function removeProductFromCart() {
    let removeBtns = document.querySelectorAll('.x-remove');
    removeBtns.forEach(removeBtn => {
        removeBtn.addEventListener('click', (e) => {
            let tableRow = e.currentTarget.parentNode.parentNode;
            let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
            let qty = tableRow.childNodes[7].firstElementChild.value;
            let product = cartProducts[tableRow.childNodes[3].innerText]

            //update the localStorage cartTotal value
            updateTotalCost(-qty, product)

            // update the localStorage cartItemCount value
            cartItemCount(-qty, product)

            // update the localStorage cartProducts value
            delete cartProducts[tableRow.childNodes[3].innerText];
            localStorage.setItem('cartProducts', JSON.stringify(cartProducts));

            // remove the tableRow that holds all the product info
            tableRow.parentNode.removeChild(e.currentTarget.parentNode.parentNode);
            
            // update cart total in the nav bar
            updateCartCount();

            updateCartTotals()
            
        })
    });
}

function updateCartTotals() {
    let subtotal = Number(localStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal}`;

    let shipping = 25; //figure this out
    document.querySelector('.shipping').textContent = `$${shipping}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total}`;
}

updateCartCount();
displayCart()