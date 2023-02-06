// This script file controls all shopping cart functionality

const goToCheckoutBtn = document.querySelector('.go-to-checkout')

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
    updateLocalStorageCartItemCount(qty);
    updateLocalStorageCartContents(qty, product);
    const cartContents = JSON.parse(localStorage.getItem('cartProducts'));
    console.log(cartContents)
    const cartProduct = cartContents[productName + options.optionsIDString];
    console.log(cartProduct)
    updateLocalStorageCartTotal();
    bootoast.toast();
    return false;
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
    console.log(confPage)
    localStorage.removeItem('cartList')
    localStorage.removeItem('shippingTotal')
    localStorage.removeItem('cartTotal')
    localStorage.removeItem('cartItemCount')
    localStorage.removeItem('cartProducts')
}


// Update the localStorage cartItemCount
function updateLocalStorageCartItemCount(qty) {
    console.log(qty);
    let numOfItems = Number(localStorage.getItem('cartItemCount'));

    if (numOfItems) {
        localStorage.setItem('cartItemCount', numOfItems + qty);
        document.querySelector('.cartCount').textContent = numOfItems + qty;
    } else {
        localStorage.setItem('cartItemCount', qty);
        document.querySelector('.cartCount').textContent = qty;
    }
}

// Add product to local storage and update quantity
function updateLocalStorageCartContents(qtyToAdd, product) {
    console.log(qtyToAdd, product);
    let cartContents = JSON.parse(localStorage.getItem('cartProducts'));
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
    
    localStorage.setItem('cartProducts', JSON.stringify(cartContents))
}

// When page loads/changes get the number of items in the shopping cart and display it in the nav bar.
function updateCartCountDisplay() {
    let numOfItems = Number(localStorage.getItem('cartItemCount'));
    if(numOfItems != undefined) {
        document.querySelector('.cartCount').textContent = numOfItems;
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
function updateLocalStorageCartTotal() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    console.log('productsInCart: ', productsInCart)
    let newTotal = 0;
    for (let product in productsInCart) {
        console.log('product: ', product)
        newTotal += Number(productsInCart[product].priceInCart);
    }
    console.log('newTotal: ',newTotal)
    localStorage.setItem('cartTotal', (newTotal))

}

// Loads all of the products into the shopping cart table and updates the cart totals
function displayCart() {
    console.log('displayCart')
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
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

                console.log(priceTotal)

                productTable.innerHTML += `
                <tr class="cart-item" id="${item.itemName}${item.options.optionsIDString}">
                    <td class="image"><a href="single-product.php?category=${item.mainCategory}&product=${item.id}"><img src="${item.urlsArray[0]}" alt="${item.itemNameString}"></a></td>
                    <td><a href="single-product.php?category=${item.mainCategory}&product=${item.id}">${item.itemNameString}</a></td>
                    <td><div class="flex-container col">${pairsArrayString}</div></td>
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
    console.log('end DisplayCart')
}

function createEventListenersForQtyInputBoxes() {
    let qtyBoxes = document.querySelectorAll('.qty-input-box');
    qtyBoxes.forEach(qtyBox => {
        qtyBox.addEventListener('input', updateSingleProductTotals)
    })
}

// Updates a single products total price when quantity is changed in the shopping cart. Updates the localStorage cartItemCount and qtyInCart
function updateSingleProductTotals(e) {
    console.log('updateSingleProductTotals')
    let newQty = Number(e.currentTarget.value);
    if (newQty != '') {
        let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
        let tdQty = e.currentTarget.parentNode;
        let tableRow = tdQty.parentNode;
        let cartProduct = cartProducts[tableRow.id];
        let qtyToAdd = newQty - cartProduct.qtyInCart;
        console.log(cartProduct, qtyToAdd)
        console.log(cartProduct, newQty)
        console.log(cartProduct.qtyInCart)

        const priceTotal = calculateLineItemTotal(qtyToAdd, cartProduct);
        console.log(priceTotal)

        // Update the total price in the DOM
        tdQty.nextElementSibling.textContent = `$${priceTotal}`;

        // Update the localStorage cartItemCount value
        updateLocalStorageCartItemCount(qtyToAdd)
        updateLocalStorageCartContents(qtyToAdd, cartProduct)
        
        //Update the localStorage cartTotal value
        updateLocalStorageCartTotal()

        // update cart total in the nav bar
        updateCartCountDisplay()

        // update cart totals on the shupping cart page
        updateCartTotalDisplay()
    }
    console.log('end updateSingleProductTotals')
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
    let cartProducts = JSON.parse(localStorage.getItem('cartProducts'));
    let qty = tableRow.childNodes[9].firstElementChild.value;
    let cartProduct = cartProducts[tableRow.id];

    // update the localStorage cartProducts value
    delete cartProducts[tableRow.id];
    localStorage.setItem('cartProducts', JSON.stringify(cartProducts));

    // update the localStorage cartItemCount value
    updateLocalStorageCartItemCount(-qty)

    //update the localStorage cartTotal value
    updateLocalStorageCartTotal()

    // remove the tableRow that holds all the product info
    tableRow.parentNode.removeChild(e.currentTarget.parentNode.parentNode);
    
    // update cart total in the nav bar
    updateCartCountDisplay();

    updateCartTotalDisplay()   
}

//Calculate shipping total
function calculateShippingTotal() {
    let productsInCart = JSON.parse(localStorage.getItem('cartProducts'));
    // console.log('productsInCart', productsInCart.bambooDoorbell);
    let shippingTotal = 0;
    let shippingQuantities = {'doorbells5': 0, 'doorbells3.5': 0, 'fanPulls': 0, 'airPlantCradles': 0};
    for (let product in productsInCart) {
        // console.log(product);
        // console.log(`${productsInCart[product].shipping}`);
        let itemCategory = productsInCart[product].mainCategory;
        let itemShipping = productsInCart[product].shipping;
        let itemQty = productsInCart[product].qtyInCart;

        if (itemCategory === 'Air-Plant-Cradles') {
            shippingQuantities['airPlantCradles'] += itemQty;
        }
        if (itemCategory === 'Doorbells') {
            if (itemShipping === '3.50') {
                shippingQuantities['doorbells3.5'] += itemQty;
            } else if (itemShipping === '5.00') {
                shippingQuantities['doorbells5'] += itemQty;
            }
        }
        if (itemCategory === 'Fan-Pulls') {
            shippingQuantities['fanPulls'] += itemQty;
        }

    }
    console.table(shippingQuantities)

    //update for fan pulls, artwork, etc
    for (let category in shippingQuantities) {
        // console.log('category: ',category);
        if (category == 'doorbells3.5') {
            if(shippingQuantities[category] % 2 === 0) {
                // console.log('even')
                // console.log(3.5 * shippingQuantities[category] / 2)
                shippingTotal += 3.5 * shippingQuantities[category] / 2;
                // console.log(shippingTotal)
            } else {
                // console.log('odd')
                shippingTotal += 3.5 * (shippingQuantities[category] + 1) / 2;
                // console.log(shippingTotal)
            }
        } else if (category === 'doorbells5') {
            // console.log(`${qtyAtEachShippingPrice[price]}`)
            shippingTotal += 5 * shippingQuantities[category];
            // console.log(shippingTotal)
        } else if (category === 'airPlantCradles') {
            shippingTotal += 5 * shippingQuantities[category];
        } else if (category === 'fanPulls') {
            if (shippingQuantities[category] > 0) shippingTotal += 5;
            // console.log(shippingTotal)
        }
    }
    localStorage.setItem('shippingTotal', shippingTotal);

    return shippingTotal;
}

//Updates all the prices in the Cart Total area of the shopping cart
function updateCartTotalDisplay() {
    let subtotal = Number(localStorage.getItem('cartTotal'));
    document.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;

    let shipping = calculateShippingTotal();

    document.querySelector('.shipping').textContent = `$${shipping.toFixed(2)}`;
    let total = subtotal + shipping;
    document.querySelector('.total').textContent = `$${total.toFixed(2)}`;
}

function calculateLineItemTotal(qtyToAdd, cartItem) {
    console.log('calculateLineItemTotal')
    console.log(cartItem)
    const priceArray = JSON.parse(cartItem.priceArray);
    const originalQty = cartItem.qtyInCart;
    const newQty = originalQty + qtyToAdd;
    console.log(newQty)

    if (priceArray.length === 2) {
        if (newQty % 2 === 0) {
            priceTotal = (Number(priceArray[1]) * newQty / 2).toFixed(2);
        } else {
            priceTotal = (Number(priceArray[0]) + (Number(priceArray[1]) * ((newQty - 1)/2))).toFixed(2);
        }
    } else {
        priceTotal = (Number(priceArray[0]) * newQty).toFixed(2)
    }
    console.log(priceTotal);
    console.log('end calculateLineItemTotal')

    return priceTotal;
}

updateCartCountDisplay();
displayCart();