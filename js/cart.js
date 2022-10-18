// This script file controls all shopping cart functionality

// Stores an item in local storage with an expiration
var ls = {
    set: function (variable, value, ttl_ms) {
        var data = {value: value, expires_at: new Date().getTime() + ttl_ms / 1};
        localStorage.setItem(variable.toString(), JSON.stringify(data));
    },
    get: function (variable) {
        var data = JSON.parse(localStorage.getItem(variable.toString()));
        if (data !== null) {
            if (data.expires_at !== null && data.expires_at < new Date().getTime()) {
                localStorage.removeItem(variable.toString());
            } else {
                return data.value;
            }
        }
        return null;
    }
};

// load the product list from local storage or retrieve from database
let productList = ls.get('productList')
console.log(productList);
if (productList === null) {
    getProductList();   
}
// console.log(productList[0])
// console.log(Object.keys(productList))

// // Grab all the buttons that add items on a shop page
// let addToCartBtns = document.querySelectorAll('.add-to-cart');

// // Add event listeners to buttons
// for (let i = 0; i < addToCartBtns.length; i++) {
//     addToCartBtns[i].addEventListener('click', addToCart)
// }

// async function addToCart(event) {
//     let productName = event.currentTarget.id;
//     let product;
//     console.log(ls.get('productList'))
//     if (ls.get('productList') === null) {
//         console.log('if')
//         await getProductList();
//         console.log(ls.get('productList'))
//         product = ls.get('productList').find(product => product.itemName === productName);
//     } else {
//         console.log('else')
//         product = ls.get('productList').find(product => product.itemName === productName);
//     }
//     console.log(event.currentTarget);
//     cartItemCount(1, product);
//     updateTotalCost(1, product);
// }

// Grab the button that adds items on a single product page
let addToCartBtnSinglePage = document.querySelector('.add-to-cart-single');

// Add event listener to button
if (addToCartBtnSinglePage) {
    addToCartBtnSinglePage.addEventListener('click', addToCartSingle)
}
    
async function addToCartSingle(event) {
    let qty = Number(document.querySelector('.input-text').value);
    let color;
    if (document.querySelector('.selectpicker')) {
        color = document.querySelector('.selectpicker').selectedOptions[0].innerText;
    } else {
        color = 'N/A';
    }
    console.log(color);
    let productName = event.currentTarget.id;
    let product;
    console.log(ls.get('productList'))
    if (ls.get('productList') === null) {
        console.log('if')
        await getProductList();
        console.log(ls.get('productList'))
        product = ls.get('productList').find(product => product.itemName === productName);
    } else {
        console.log('else')
        product = ls.get('productList').find(product => product.itemName === productName);
    }
    product.baseColor = color;
    console.log(event.currentTarget);
    console.log(productName, product)
    cartItemCount(qty, product);
    updateTotalCost(qty, product);
}

// Get the product list
async function getProductList() {
    try{
        const response = await fetch ('./includes/get-product-list.inc.php', {
            dataType: "json",
            contentType: 'application/json',
            mimeType: 'application/json'
        });
        data = await response.json();
        // console.log(data);

        ls.set('productList', data, 86400000)
        productList = JSON.parse(ls.get('productList'))
        console.log('product list set');
    } 
    catch(error) {
        console.error(`Could not get product list: ${error}`);
    }
}

//Clear the shopping cart on confirmation of a succesful checkout.
const confPage = document.querySelector('#confirmation');
if (confPage) {
    console.log(confPage)
    localStorage.removeItem('cartList')
    localStorage.removeItem('shippingTotal')
    localStorage.removeItem('cartTotal')
    localStorage.removeItem('cartItemCount')
    localStorage.removeItem('cartProducts')
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
    
    if(cartContents) {//there are items in the cart
        if (!cartContents[product.itemName+'Base'+product.baseColor]) {//no product with this name in cart
            console.log(1)
            product.qtyInCart = qty;
            cartContents = {
                ...cartContents,
                [product.itemName+'Base'+product.baseColor]: product
            }
        } else {//product with this name is in the cart

            if (!cartContents[product.itemName+'Base'+product.baseColor]) {//no product with this base color
                console.log(2)
                product.qtyInCart = qty;
                cartContents = {
                    ...cartContents,
                    [product.itemName]: product
                }
            } else {//product with this base color is in the cart
                console.log(3)
                cartContents[product.itemName+'Base'+product.baseColor].qtyInCart += qty;
            }
        }
    } else {//there are no items in the cart
        console.log(4)
        product.qtyInCart = qty;
        cartContents = {
            [product.itemName+'Base'+product.baseColor]: product
        }
    }
    
    localStorage.setItem('cartProducts', JSON.stringify(cartContents))
}

// When page loads/changes get the number of items in the shopping cart and display it in the nav bar.
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
        localStorage.setItem('cartTotal', (cartTotal + product.price * qty).toFixed(2))
    } else {
        localStorage.setItem('cartTotal', (product.price * qty).toFixed(2));
    }
}

// Loads all of the products into the shopping cart table and updates the cart totals
function displayCart() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    console.log(Object.entries(productsInCart).length);
    let productTable = document.querySelector('.cart-table-body')
    if ( productTable) {
        if (Object.entries(productsInCart).length > 0){
            productTable.innerHTML = '';
            Object.values(productsInCart).map(item => {
                productTable.innerHTML += `
                <tr class="cart-item" id="${item.itemName}Base${item.baseColor}">
                    <td class="image"><a href="single-product.php?category=${item.mainCategory}&product=${item.id}"><img src="images/${(item.mainCategory).toLowerCase()}-small/${item.imgUrl}" alt="${item.itemNameString}"></a></td>
                    <td><a href="single-product.php?category=${item.mainCategory}&product=${item.id}">${item.itemNameString}</a></td>
                    <td><span>${item.baseColor}</span></td>
                    <td>$${item.price}</td>
                    <td class="qty"><input type="number" step="1" min="1" name="cart" value="${item.qtyInCart}" title="Qty" class="input-text qty text qty-input-box" size="4"></td>
                    <td>$${(item.price * item.qtyInCart).toFixed(2)}</td>
                    <td class="remove"><a href="#x" class="btn btn-danger-filled x-remove">×</a></td>
                </tr>
                `; 
            });
            
            updateSingleProductTotals()
            removeProductFromCart()
            updateCartTotals()
        } else {
            productTable.innerHTML += '<tr><td>Your cart is empty</td></tr>'
        }
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
                let product = cartProducts[tableRow.id];
                let qtyToAdd = qty - product.qtyInCart;

                // Update the total price in the DOM
                tdQty.nextElementSibling.textContent = `$${(tdQty.previousElementSibling.textContent.slice(1) * qty).toFixed(2)}`;
                
                // Update the localStorage cartItemCount value
                cartItemCount(qtyToAdd, product)
                
                //Update the localStorage cartTotal value
                updateTotalCost(qtyToAdd, product)

                // update cart total in the nav bar
                updateCartCount()

                // update cart totals on the shupping cart page
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
            let qty = tableRow.childNodes[9].firstElementChild.value;
            let product = cartProducts[tableRow.id];

            //update the localStorage cartTotal value
            updateTotalCost(-qty, product)

            // update the localStorage cartItemCount value
            cartItemCount(-qty, product)

            // update the localStorage cartProducts value
            delete cartProducts[tableRow.id];
            localStorage.setItem('cartProducts', JSON.stringify(cartProducts));

            // remove the tableRow that holds all the product info
            tableRow.parentNode.removeChild(e.currentTarget.parentNode.parentNode);
            
            // update cart total in the nav bar
            updateCartCount();

            updateCartTotals()
            
        })
    });
}

//Calculate shipping total
function calculateShippingTotal() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    // console.log('productsInCart', productsInCart.bambooDoorbell);
    let shippingTotal = 0;
    let qtyAtEachShippingPrice = {};
    for (let product in productsInCart) {
        // console.log(product);
        // console.log(`${productsInCart[product].shipping}`);
        let itemShipping = productsInCart[product].shipping;
        let itemQty = productsInCart[product].qtyInCart;

        if (!qtyAtEachShippingPrice[itemShipping]) {
            qtyAtEachShippingPrice[itemShipping] = 0;
        }
        qtyAtEachShippingPrice[itemShipping] += itemQty;

    }
    console.table(qtyAtEachShippingPrice)

    //update for fan pulls, artwork, etc
    for (let price in qtyAtEachShippingPrice) {
        // console.log(`${qtyAtEachShippingPrice[price]}`)
        if (price == 3.5) {
            if(qtyAtEachShippingPrice[price] % 2 === 0) {
                // console.log('even')
                // console.log(Number(price) * qtyAtEachShippingPrice[price] / 2)
                shippingTotal += Number(price) * qtyAtEachShippingPrice[price] / 2;
                console.log(shippingTotal)
            } else {
                // console.log('odd')
                shippingTotal += Number(price) * (qtyAtEachShippingPrice[price] + 1) / 2;
                console.log(shippingTotal)
            }
        } else {
            // console.log(`${qtyAtEachShippingPrice[price]}`)
            shippingTotal += Number(price) * qtyAtEachShippingPrice[price]; // fix for other prices
            console.log(shippingTotal)
        }
    }
    localStorage.setItem('shippingTotal', shippingTotal);

    return shippingTotal;
}

//Updates all the prices in the Cart Total area of the shopping cart
function updateCartTotals() {
    let subtotal = Number(localStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

    let shipping = calculateShippingTotal();

    document.querySelector('.shipping').textContent = `$${shipping.toFixed(2)}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total.toFixed(2)}`;
}

updateCartCount();
displayCart();