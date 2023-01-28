const modal = document.querySelectorAll(".modal");
const btnCancel = document.querySelectorAll(".btn-cancel");
const scheduleDatePickers = document.querySelectorAll('.scheduleDate');
const addImageSelect = document.querySelector('#productImageUploadSelect');
let urlString = window.location.href;
let paramString = urlString.split('?')[1];

// Update Product List
if (paramString && paramString.includes('success')) {
    getProductList();
}

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

// Get the product list
async function getProductList() {
    try{
        const response = await fetch ('./includes/get-product-list.inc.php', {
            dataType: "json",
            contentType: 'application/json',
            mimeType: 'application/json'
        });
        data = await response.json();
        console.log(data);

        ls.set('productList', data, 86400000)
        console.log('product list set');
    } 
    catch(error) {
        console.error(`Could not get product list: ${error}`);
    }
}
// End Update Product List

// Cloudinary Upload Widget
var myWidget = cloudinary.createUploadWidget({
    cloudName: 'doorbelldesigns', 
    uploadPreset: 'preset1',
    resourceType: 'image',
    multiple: false,
    cropping: true,
    croppingAspectRatio: 0.9,}, (error, result) => { 
        if (!error && result && result.event === "success") { 
            // console.log('Done! Here is the image info: ', result.info); 
            const selection = addImageSelect.options[addImageSelect.selectedIndex];
            const picNumber = Number(selection.dataset.numpics) + 1;
            selection.dataset.numpics = picNumber;
            productId = selection.dataset.id;
            console.log(productId); 
            updateImageUrl(result.info, picNumber, productId);
        }
    }
)
  
// Open Cloudinary upload widget
document.getElementById("upload_widget").addEventListener("click", function(){
    const productName = addImageSelect.value;
    const alt = addImageSelect.options[addImageSelect.selectedIndex].innerText;
    const picNumber = Number(addImageSelect.options[addImageSelect.selectedIndex].dataset.numpics) + 1;
    console.log(productName, alt, picNumber)
    myWidget.update({publicId: `${productName}${picNumber}`, folder: `products/${productName}`, context: { alt: alt}})
    myWidget.open();
}, false);

async function updateImageUrl(picInfo, numberOfPics, productId) {
    const obj = { 
        picInfo: picInfo,
        numberOfPics: numberOfPics,
        productId: productId,
    }

    try{
        const response = await fetch (
        './includes/add-image.inc.php', 
            {
                method:'POST',
                mode: "same-origin",
                cache: 'no-cache',
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "Accept":       "application/json"
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(obj)
            }
        )
        data = await response.json();
        console.log(data);

        const responseMessageAddImage = document.querySelector('.responseMessageAddImage');

        if (data === 'success') {
            responseMessageAddImage.textContent = 'Image successfully added. Refresh page to load thumbnail below.';
        } else if (data === 'add-image-failed') {
            responseMessageAddImage.textContent = 'Error adding image. Please try again.'
        } else {
            responseMessageAddImage.textContent = 'Error adding image';
        }
    } 
    catch(error) {
        console.error(`Error uploading image: ${error}`);
    }
}

// Start Edit Show Table / Edit Product Table

// Controls cells that are editable (not date cells)
// (A) INITIALIZE - DOUBLE CLICK TO EDIT CELL
window.addEventListener("DOMContentLoaded", () => {
  for (let cell of document.querySelectorAll(".can-edit")) {
    cell.ondblclick = () => { editable.edit(cell); };
  }
});

var editable = {
  // (B) "CONVERT" TO EDITABLE CELL
  edit : (cell) => {
    // (B1) REMOVE "DOUBLE CLICK TO EDIT"
    cell.ondblclick = "";

    // (B2) EDITABLE CONTENT
    cell.contentEditable = true;
    cell.focus();

    // (B3) "MARK" CURRENT SELECTED CELL
    cell.classList.add("edit");
    editable.selected = cell;

    // (B4) PRESS ENTER OR CLICK OUTSIDE TO END EDIT
    window.addEventListener("click", editable.close);
    cell.onkeydown = (evt) => { if (evt.key=="Enter") {
      editable.close(true);
      return false;
    }};
  },

  // (C) END "EDIT MODE"
  selected : null,  // current selected cell
  close : (evt) => { if (evt.target != editable.selected) {
    // (C1) send values to server
    sendValuesToServer(editable.selected);

    // (C2) REMOVE "EDITABLE"
    window.getSelection().removeAllRanges();
    editable.selected.contentEditable = false;

    // (C3) RESTORE CLICK LISTENERS
    window.removeEventListener("click", editable.close);
    let cell = editable.selected;
    editable.selected.ondblclick = () => { editable.edit(cell); };

    // (C4) "UNMARK" CURRENT SELECTED CELL
    editable.selected.classList.remove("edit");
    editable.selected = null;
  }}
};

// controls date cells
scheduleDatePickers.forEach(picker => {
    picker.addEventListener('focusout', pickerFocusOut);
    picker.addEventListener('keydown', pickerKeyDown);
}); 

function pickerFocusOut(event) {
    cell = event.currentTarget;
    sendValuesToServer(cell);
}

function pickerKeyDown(event) {
    if (event.key === 'Enter') {
        cell = event.currentTarget;
        sendValuesToServer(cell)
    }
}

//choose which table is being updated and send info to the proper function
function sendValuesToServer(cell) {
    let date, startDateString, endDateString, name, location, id, value;
    let column = cell.classList[0];
    console.log(cell.parentNode.id.length);
    if (cell.parentNode.id.length > 4) {//cell is from show table
        date = cell.parentNode.id;
        startDateString = cell.parentNode.children[1].children[0].value;
        endDateString = cell.parentNode.children[2].children[0].value;
        name = cell.parentNode.children[3].textContent;
        location = cell.parentNode.children[4].textContent;
        booth = cell.parentNode.children[5].textContent;
        console.log(cell);
        console.log(column);
        console.log(date);
        console.log(startDateString);
        console.log(endDateString);
        console.log(name);
        console.log(location);
        console.log(booth);
        let obj = {
            'date': date,
            'startDateString': startDateString,
            'endDateString': endDateString,
            'name': name,
            'location': location,
            'booth': booth,
            'column': column
        }
        updateSchedule(obj);
    } else {//cell is from product table
        id = cell.parentNode.id;
        value = cell.textContent;
        console.log(column)
        console.log(id)
        console.log(value)
        let obj = {
            'id': id,
            'value': value,
            'column': column
        }
        updateProduct(obj);
    }
}

async function updateSchedule(obj) {
    try{
        const response = await fetch (
        './includes/edit-show-schedule.inc.php', 
            {
                method:'POST',
                mode: "same-origin",
                cache: 'no-cache',
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "Accept":       "application/json"
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(obj)
            }
        )
        data = await response.json();
        console.log(data);
        location.reload();

    } 
    catch(error) {
        console.error(`Could not update schedule: ${error}`);
    }
}

async function updateProduct(obj) {
    try{
        const response = await fetch (
        './includes/edit-product.inc.php', 
            {
                method:'POST',
                mode: "same-origin",
                cache: 'no-cache',
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "Accept":       "application/json"
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(obj)
            }
        )
        console.log(response)
        data = await response.json();
        console.log(data);
            
        const responseMessageProduct = document.querySelector('.responseMessageProduct');

        if (data === 'success') {
            responseMessageProduct.textContent = 'Product successfully edited.';
        } else if (data === 'image-resize error') {
            responseMessageProduct.textContent = 'Failed to resize images. Please try again.'
        } else {
            responseMessageProduct.textContent = 'Error editing product: ' + data;
        }
    } 
    catch(error) {
        console.error(`Could not update product: ${error}`);
    }
}

// Delete show buttons
let showTrashCans = document.querySelectorAll('.deleteShowButton')
showTrashCans.forEach(can => {
  can.addEventListener('click', openDeleteShowModal);
})

function openDeleteShowModal(event) {
    document.getElementById('deleteConfShow').style.display='block';
    let row = event.currentTarget.parentNode.parentNode;
    let rowId = row.id;
    console.log(rowId);
    let showDelete = document.querySelector('#btn-delete-show');
    showDelete.dataset['id'] = rowId;
    showDelete.addEventListener('click', deleteShow);
}
  
async function deleteShow(event) {
    let rowId = event.currentTarget.dataset.id;
    let row = document.getElementById(rowId);
    console.log(rowId);

    let obj = {
        'date': rowId
    }

    try{
        const response = await fetch (
        './includes/delete-show.inc.php', 
            {
                method:'POST',
                mode: "same-origin",
                cache: 'no-cache',
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "Accept":       "application/json"
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(obj)
            }
        )
        data = await response.json();
        console.log(data);

        const responseMessageShow = document.querySelector('#responseMessageShow');

        if (data === 'success') {
            row.parentNode.removeChild(row);
            responseMessageShow.textContent = 'Show successfully deleted.';
            modal[1].style.display = "none";
        } else if (data === 'delete-failed') {
            responseMessageShow.textContent = 'Failed to delete show. Please try again.'
        } else {
            responseMessageShow.textContent = 'Error deleting show';
        }
    } 
    catch(error) {
        console.error(`Could not delete show: ${error}`);
    }
}

// Delete product buttons
let productTrashCans = document.querySelectorAll('.deleteProductButton')
productTrashCans.forEach(can => {
  can.addEventListener('click', openDeleteProductModal);
})

function openDeleteProductModal(event) {
    document.getElementById('deleteConfProduct').style.display='block';
    let rowId = event.currentTarget.id;
    console.log(rowId);
    let mainCategory = event.currentTarget.dataset.mainCategory;
    console.log(mainCategory);

    let productDelete = document.querySelector('#btn-delete-product');
    productDelete.dataset['id'] = rowId;
    productDelete.dataset['mainCategory'] = mainCategory;
    productDelete.addEventListener('click', deleteProduct);
}

async function deleteProduct(event) {
    let rowId = event.currentTarget.dataset.id;
    let mainCategory = event.currentTarget.dataset.mainCategory;

    let row = document.getElementById(rowId);

    let obj = {
        'deletedId': rowId,
        'deletedMainCategory': mainCategory
    }

    try{
        const response = await fetch (
        './includes/delete-product.inc.php', 
            {
                method:'POST',
                mode: "same-origin",
                cache: 'no-cache',
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/json",
                    "Accept":       "application/json"
                },
                redirect: 'follow',
                referrerPolicy: 'no-referrer',
                body: JSON.stringify(obj)
            }
        )
        data = await response.json();
        console.log(data);

        const responseMessageProduct = document.querySelector('.responseMessageProduct');

        if (data === 'success') {
            row.parentNode.removeChild(row);
            responseMessageProduct.textContent = 'Product successfully deleted.';
            modal[0].style.display = "none";
        } else if (data === 'delete-failed') {
            responseMessageProduct.textContent = 'Failed to delete product. Please try again.'
        } else {
            responseMessageProduct.textContent = 'Error deleting product';
        }
    } 
    catch(error) {
        console.error(`Could not delete product: ${error}`);
    }
}

// Add show button
document.querySelector('#addShowButton').addEventListener('click', addShow);

function addShow(event) {
  const row = document.createElement('tr');
  
  row.id = '1970-01-01';
  
  let td1 = document.createElement('td');
  const button = document.createElement('button');
  button.addEventListener('click', deleteShow);
  button.classList.add("deleteShowButton");
  button.innerHTML = '<i class="lnr lnr-trash"></i>';
  td1.appendChild(button);
  row.appendChild(td1);

  td2 = document.createElement('td');
  td2.classList.add("scheduleStartDate");
  td2.innerHTML = '<input type="date"/>';
  td2.ondblclick = () => { editable.edit(td2); };
  row.appendChild(td2);
  
  td3 = document.createElement('td');
  td3.classList.add("scheduleEndDate");
  td3.innerHTML = '<input type="date"/>';
  td3.ondblclick = () => { editable.edit(td3); };
  row.appendChild(td3);

  td4= document.createElement('td');
  td4.classList.add("scheduleName");
  td4.innerHTML = 'Show Name';
  td4.ondblclick = () => { editable.edit(td4); };
  row.appendChild(td4);

  td5 = document.createElement('td');
  td5.classList.add("scheduleLocation");
  td5.innerHTML = 'Location';
  td5.ondblclick = () => { editable.edit(td5); };
  row.appendChild(td5);
  
  td6 = document.createElement('td');
  td6.classList.add("scheduleBooth");
  td6.innerHTML = 'TBD';
  td6.ondblclick = () => { editable.edit(td6); };
  row.appendChild(td6);

  document.querySelector('#show-table-body').appendChild(row); 
}

// End Edit Show Table

// Modal

window.addEventListener("click", windowOnClick);

// Exit the modal if the background or cancel button is clicked
function windowOnClick(event) {
    if (event.target === modal[0] || event.target === btnCancel[0]) {
        modal[0].style.display = "none";
    } else if (event.target === modal[1]  || event.target === btnCancel[1]) {
        modal[1].style.display = "none";
    }
}

// End Modal