// This script file controls all shopping cart functionality
const goToCheckoutBtn = document.querySelector('.go-to-checkout')
const toastContainer = document.querySelector('.toast-container')

localStorage.clear()
// Stores an item in local storage with an expiration
var ls = {
    set: function (variable, value, ttl_ms) {
        var data = {value: value, expires_at: new Date().getTime() + ttl_ms / 1};
        sessionStorage.setItem(variable.toString(), JSON.stringify(data));
    },
    get: function (variable) {
        var data = JSON.parse(sessionStorage.getItem(variable.toString()));
        if (data !== null) {
            if (data.expires_at !== null && data.expires_at < new Date().getTime()) {
                sessionStorage.removeItem(variable.toString());
            } else {
                return data.value;
            }
        }
        return null;
    }
};

// load the product list from local storage or retrieve from database
let productList = ls.get('productList')
if (productList === null) {
    getProductList();   
}
    
function addToCart(event) {

    const qty = Number(document.querySelector('.input-text').value);
    const selectPickers = document.querySelectorAll('.selectpicker');
    const productName = event.submitter.id;
    const options = { optionsIDString: '', optionsPairStrings: []};
    let product;

    if (selectPickers.length > 0) {
        for (const select of selectPickers) {
            const optionKey = select.dataset.id; 
            const newValue = Number(select.selectedOptions[0].dataset.id);
            options.optionsIDString += newValue;
            options[optionKey] = newValue;
            const stringKey = select.childNodes[1].innerText;
            const stringValue = select.selectedOptions[0].innerText;
            options.optionsPairStrings.push({ stringKey, stringValue })
        }
    }
    
    if (ls.get('productList') === null) {
        getProductList();
    } 
    product = ls.get('productList').find(product => product.itemName === productName);
    product.options = options;
    updateSessionStorageCartItemCount(qty);
    updateSessionStorageCartContents(qty, product);
    const cartContents = JSON.parse(sessionStorage.getItem('cartProducts'));
    const cartProduct = cartContents[productName + options.optionsIDString];
    updateSessionStorageCartTotal();
    toast()
    return false;
}

function toast() {
    console.log(toastContainer)
    toastContainer.style.display='block'

    const toastBody = document.createElement('div')
    toastBody.classList.add('toast-body')
    toastBody.innerHTML = '<button type="button" class="close-toast aria-label="Close"><span aria-hidden="true">&times;</span></button> <span class="lnr lnr-cart"></span><span> Added To Cart!</span>'
    toastContainer.appendChild(toastBody)
    document.querySelector('.close-toast').addEventListener('click', hideToast)

    //make toast disappear
    setTimeout(hideToast, 3000)
}

function hideToast() {
    toastContainer.style.display = 'none'
    document.querySelector('.toast-body').remove()
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
        ls.set('productList', data, 86400000)
        productList = ls.get('productList')
        console.log('product list set');
    } 
    catch(error) {
        console.error(`Could not get product list: ${error}`);
    }
}

//Clear the shopping cart on confirmation of a succesful checkout.
const confPage = document.querySelector('#confirmation');
if (confPage) {
    sessionStorage.removeItem('cartList')
    sessionStorage.removeItem('shippingTotal')
    sessionStorage.removeItem('cartTotal')
    sessionStorage.removeItem('cartItemCount')
    sessionStorage.removeItem('cartProducts')
}


// Update the sessionStorage cartItemCount
function updateSessionStorageCartItemCount(qty) {
    let numOfItems = Number(sessionStorage.getItem('cartItemCount'));

    if (numOfItems) {
        sessionStorage.setItem('cartItemCount', numOfItems + qty);
    } else {
        sessionStorage.setItem('cartItemCount', qty);
    }
    updateCartCountDisplay()
}

// Add product to local storage and update quantity
function updateSessionStorageCartContents(qtyToAdd, product) {
    let cartContents = JSON.parse(sessionStorage.getItem('cartProducts'));
    const optionsIDString = product.options.optionsIDString;
    const key = product.itemName+optionsIDString;
    if(cartContents) {//there are items in the cart
        if (!cartContents[key]) {//no product with this name & options in cart
            product.priceInCart = calculateLineItemTotal(qtyToAdd, product);
            product.qtyInCart = qtyToAdd;
            cartContents = {
                ...cartContents,
                [key]: product
            }
        } else {//product with this name & options is in the cart
            cartContents[key].priceInCart = calculateLineItemTotal(qtyToAdd, cartContents[key]);
            cartContents[key].qtyInCart += qtyToAdd;
        }
    } else {//there are no items in the cart
        product.priceInCart = calculateLineItemTotal(qtyToAdd, product);
        product.qtyInCart = qtyToAdd;
        cartContents = {
            [key]: product
        }
    }
    
    sessionStorage.setItem('cartProducts', JSON.stringify(cartContents))
}

// When page loads/changes get the number of items in the shopping cart and display it in the nav bar.
function updateCartCountDisplay() {
    let numOfItems = Number(sessionStorage.getItem('cartItemCount'));
    if(numOfItems != undefined) {
        const cartCountItems = document.querySelectorAll('.cartCount')
        for (item of cartCountItems) {
            item.textContent = numOfItems;   
        }
        if (goToCheckoutBtn) {
            if (numOfItems === 0) {
                goToCheckoutBtn.classList.add('disabled');
            } else {
                goToCheckoutBtn.classList.remove('disabled');
            }
        }
    }
}

// Update local storage with the total cost of all items in the cart.
function updateSessionStorageCartTotal() {
    let productsInCart = JSON.parse(sessionStorage.getItem('cartProducts'));
    let newTotal = 0;
    for (let product in productsInCart) {
        newTotal += Number(productsInCart[product].priceInCart);
    }
    sessionStorage.setItem('cartTotal', (newTotal))

}

// Loads all of the products into the shopping cart table and updates the cart totals
function displayCart() {
    let productsInCart = JSON.parse(sessionStorage.getItem('cartProducts'));
    let productTable = document.querySelector('.cart-table-body')
    if (productTable) {
        if (productsInCart && Object.entries(productsInCart).length > 0){
            productTable.innerHTML = '';
            Object.values(productsInCart).map(item => {
                const pairsArray = item.options.optionsPairStrings;
                let pairsArrayString = '';
                for (obj of pairsArray) {
                    pairsArrayString += `<span>${obj.stringKey} ${obj.stringValue}</span>`
                }
                const priceArray = JSON.parse(item.priceArray);
                const priceTotal = calculateLineItemTotal(0, item);

                productTable.innerHTML += `
                <tr class="cart-item" id="${item.itemName}${item.options.optionsIDString}">
                    <td class="image"><a href="single-product.php?category=${item.mainCategory}&product=${item.id}"><img src="${item.urlsArray[0]}" alt="${item.itemNameString}"></a></td>
                    <td><a href="single-product.php?category=${item.mainCategory}&product=${item.id}">${item.itemNameString}</a></td>
                    <td><div class="flex col">${pairsArrayString}</div></td>
                    <td>$${priceArray[0]}</td>
                    <td class="qty"><input type="number" step="1" min="1" name="cart" value="${item.qtyInCart}" title="Qty" class="input-text qty text qty-input-box" size="4"></td>
                    <td>$${priceTotal}</td>
                    <td class="remove"><a href="#x" class="btn btn-danger-filled x-remove">×</a></td>
                </tr>
                `; 
            });
            
            createEventListenersForQtyInputBoxes()
            createEventListenersForRemoveBtns()
            updateCartTotalDisplay()
        } else {
            productTable.innerHTML += '<tr><td>Your cart is empty</td></tr>'
        }
    }
}

function createEventListenersForQtyInputBoxes() {
    let qtyBoxes = document.querySelectorAll('.qty-input-box');
    qtyBoxes.forEach(qtyBox => {
        qtyBox.addEventListener('input', updateSingleProductTotals)
    })
}

// Updates a single products total price when quantity is changed in the shopping cart. Updates the sessionStorage cartItemCount and qtyInCart
function updateSingleProductTotals(e) {
    let newQty = Number(e.currentTarget.value);
    if (newQty != '') {
        let cartProducts = JSON.parse(sessionStorage.getItem('cartProducts'));
        let tdQty = e.currentTarget.parentNode;
        let tableRow = tdQty.parentNode;
        let cartProduct = cartProducts[tableRow.id];
        let qtyToAdd = newQty - cartProduct.qtyInCart;

        const priceTotal = calculateLineItemTotal(qtyToAdd, cartProduct);

        // Update the total price in the DOM
        tdQty.nextElementSibling.textContent = `$${priceTotal}`;

        // Update the sessionStorage cartItemCount value
        updateSessionStorageCartItemCount(qtyToAdd)
        updateSessionStorageCartContents(qtyToAdd, cartProduct)
        
        //Update the sessionStorage cartTotal value
        updateSessionStorageCartTotal()

        // update cart total in the nav bar
        updateCartCountDisplay()

        // update cart totals on the shupping cart page
        updateCartTotalDisplay()
    }
}

function createEventListenersForRemoveBtns() {
    let removeBtns = document.querySelectorAll('.x-remove');
    removeBtns.forEach(removeBtn => {
        removeBtn.addEventListener('click', removeProductFromCart)
    })
}

// Removes a product from the cart when you click the X button
function removeProductFromCart(e) {
    let tableRow = e.currentTarget.parentNode.parentNode;
    let cartProducts = JSON.parse(sessionStorage.getItem('cartProducts'));
    let qty = tableRow.childNodes[9].firstElementChild.value;
    let cartProduct = cartProducts[tableRow.id];

    // update the sessionStorage cartProducts value
    delete cartProducts[tableRow.id];
    sessionStorage.setItem('cartProducts', JSON.stringify(cartProducts));

    // update the sessionStorage cartItemCount value
    updateSessionStorageCartItemCount(-qty)

    //update the sessionStorage cartTotal value
    updateSessionStorageCartTotal()

    // remove the tableRow that holds all the product info
    tableRow.parentNode.removeChild(e.currentTarget.parentNode.parentNode);
    
    // update cart total in the nav bar
    updateCartCountDisplay();

    updateCartTotalDisplay()   
}

//Calculate shipping total
function calculateShippingTotal() {
    let productsInCart = JSON.parse(sessionStorage.getItem('cartProducts'));
    let shippingTotal = 0;
    let shippingQuantities = {'doorbells5': 0, 'doorbells10': 0, 'fanPulls': 0, 'airPlantCradles': 0};
    for (let product in productsInCart) {
        let itemCategory = productsInCart[product].mainCategory;
        let itemShipping = productsInCart[product].shipping;
        let itemQty = productsInCart[product].qtyInCart;

        if (itemCategory === 'Air-Plant-Cradles') {
            shippingQuantities['airPlantCradles'] += itemQty;
        }
        if (itemCategory === 'Doorbells') {
            if (itemShipping === '5.00') {
                shippingQuantities['doorbells5'] += itemQty;
            } else if (itemShipping === '10.00') {
                shippingQuantities['doorbells10'] += itemQty;
            }
        }
        if (itemCategory === 'Fan-Pulls') {
            shippingQuantities['fanPulls'] += itemQty;
        }

    }

    //update for fan pulls, artwork, etc
    for (let category in shippingQuantities) {
        if (category == 'doorbells10') {
                shippingTotal += 10 * shippingQuantities[category]
        } else if (category === 'doorbells5') {
            shippingTotal += 5 * shippingQuantities[category];
        } else if (category === 'airPlantCradles') {
            shippingTotal += 5 * shippingQuantities[category];
        } else if (category === 'fanPulls') {
            if (shippingQuantities[category] > 0) shippingTotal += 5;
        }
    }
    sessionStorage.setItem('shippingTotal', shippingTotal);

    return shippingTotal;
}

//Updates all the prices in the Cart Total area of the shopping cart
function updateCartTotalDisplay() {
    let subtotal = Number(sessionStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

    let shipping = calculateShippingTotal();

    document.querySelector('.shipping').textContent = `$${shipping.toFixed(2)}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total.toFixed(2)}`;
}

function calculateLineItemTotal(qtyToAdd, cartItem) {
    const priceArray = JSON.parse(cartItem.priceArray);
    const originalQty = cartItem.qtyInCart;
    const newQty = originalQty + qtyToAdd;

    if (priceArray.length === 2) {
        if (newQty % 2 === 0) {
            priceTotal = (Number(priceArray[1]) * newQty / 2).toFixed(2);
        } else {
            priceTotal = (Number(priceArray[0]) + (Number(priceArray[1]) * ((newQty - 1)/2))).toFixed(2);
        }
    } else {
        priceTotal = (Number(priceArray[0]) * newQty).toFixed(2)
    }

    return priceTotal;
}

updateCartCountDisplay();
displayCart();