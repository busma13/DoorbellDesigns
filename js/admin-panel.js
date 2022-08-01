
// Update Product List
let urlString = window.location.href;
console.log(urlString);
let paramString = urlString.split('?')[1];
console.log(paramString);
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
        // console.log(data);

        ls.set('productList', data, 86400000)
        productList = JSON.parse(localStorage.getItem('productList'))
        console.log('product list set');
    } 
    catch(error) {
        console.error(`Could not get product list: ${error}`);
    }
}
// End Update Product List

// Ajax Request
document.querySelector('#selectProduct').addEventListener('click', getProductInfo);

async function getProductInfo() {
    let productInput = document.querySelector("#selectProductName")
    let productName = productInput.value;
    let data;
    if (productName !== '') {
        editProduct = {
            'name': productName
        }
        try{
            const response = await fetch (
            './includes/get-edit-product-info.inc.php', 
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
                    body: JSON.stringify(editProduct)
                }
            )
            data = await response.json();
        
            const errorLine = document.querySelector('#select-product-error');
            const editForm = document.querySelector('#edit-product');
            const tableContainer = document.querySelector('#table-container');
            const tableRow = document.querySelector('.table-data');
            if (data === 'not-found') {
                errorLine.hidden = false;
                errorLine.textContent = 'Product not found.';
                editForm.hidden = true;
                tableContainer.hidden = true;
            } else if (data === 'retreive-fail') {
                errorLine.hidden = false;
                errorLine.textContent = 'Failed to retrieve item data. Please try again.'
                editForm.hidden = true;
                tableContainer.hidden = true;
            } else {
                productInput.value = '';
                originalProductName.value = productName;
                tableContainer.hidden = false;
                errorLine.hidden = true;
                errorLine.textContent = '';
                editForm.hidden = false;
                console.log(data);
                let td = document.createElement('td');
                td.textContent = data['itemNameString'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['mainCategory'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['subCategories'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['price'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['shipping'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['dimensions'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['imgUrl'];
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['active'] == 1 ? 'active' : 'inactive';
                tableRow.appendChild(td);
                td = document.createElement('td');
                td.textContent = data['featured'] == 1 ? 'featured' : 'not featured';
                tableRow.appendChild(td);
            }
        } 
        catch(error) {
            console.error(`Could not get product: ${error}`);
        }
    }
}
// End Ajax Request

// Start Edit Show Table
// (A) INITIALIZE - DOUBLE CLICK TO EDIT CELL
window.addEventListener("DOMContentLoaded", () => {
  for (let cell of document.querySelectorAll(".editable td")) {
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
    // (C1) send value to server
    let cell = editable.selected;
    let column = cell.classList[0];
    let date = cell.parentNode.id;
    let dateString = cell.parentNode.children[1].textContent;
    let name = cell.parentNode.children[2].textContent;
    let location = cell.parentNode.children[3].textContent;
    console.log(cell);
    console.log(column);
    console.log(date);
    console.log(dateString);
    console.log(name);
    console.log(location);

    async function updateSchedule() {
      let obj = {
        'date': date,
        'dateString': dateString,
        'name': name,
        'location': location,
        'column': column
      }
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
    
        // const errorLine = document.querySelector('#select-product-error');
        // const editForm = document.querySelector('#edit-product');
        // const tableContainer = document.querySelector('#table-container');
        // const tableRow = document.querySelector('.table-data');
        // if (data === 'not-found') {
        //     errorLine.hidden = false;
        //     errorLine.textContent = 'Product not found.';
        //     editForm.hidden = true;
        //     tableContainer.hidden = true;
        // } else if (data === 'retreive-fail') {
        //     errorLine.hidden = false;
        //     errorLine.textContent = 'Failed to retrieve item data. Please try again.'
        //     editForm.hidden = true;
        //     tableContainer.hidden = true;
        // } else {
            
        // }
      } 
      catch(error) {
          console.error(`Could not update schedule: ${error}`);
      }
    }

    updateSchedule()

    // (C2) REMOVE "EDITABLE"
    window.getSelection().removeAllRanges();
    editable.selected.contentEditable = false;

    // (C3) RESTORE CLICK LISTENERS
    window.removeEventListener("click", editable.close);
    // let cell = editable.selected;
    cell.ondblclick = () => { editable.edit(cell); };

    // (C4) "UNMARK" CURRENT SELECTED CELL
    editable.selected.classList.remove("edit");
    editable.selected = null;
  }}
};

// Delete buttons
let trashCans = document.querySelectorAll('.deleteShowButton')
trashCans.forEach(can => {
  can.addEventListener('click', deleteShow);
})
  
async function deleteShow(event) {
  let row = event.currentTarget.parentNode.parentNode;
  let rowId = event.currentTarget.parentNode.parentNode.id;
  console.log(rowId);
  // if (rowId === '0000-00-00') {
    
  // }

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

    const responseMessage = document.querySelector('.responseMessage');
    // const editForm = document.querySelector('#edit-product');
    // const tableContainer = document.querySelector('#table-container');
    // const tableRow = document.querySelector('.table-data');
    if (data === 'success') {
        row.parentNode.removeChild(row);
        responseMessage.textContent = 'Show successfully deleted.';
    } else if (data === 'delete-failed') {
        responseMessage.textContent = 'Failed to delete show. Please try again.'
    } else {
      responseMessage.textContent = 'Error deleting show';
    }
  } 
  catch(error) {
      console.error(`Could not delete show: ${error}`);
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
  td2.classList.add("scheduleDateString");
  td2.innerHTML = '<time>Date</time>';
  td2.ondblclick = () => { editable.edit(td2); };
  row.appendChild(td2);

  td3= document.createElement('td');
  td3.classList.add("scheduleName");
  td3.innerHTML = 'Show Name';
  td3.ondblclick = () => { editable.edit(td3); };
  row.appendChild(td3);

  
  td4 = document.createElement('td');
  td4.classList.add("scheduleLocation");
  td4.innerHTML = 'Location';
  td4.ondblclick = () => { editable.edit(td4); };
  row.appendChild(td4);
                
  document.querySelector('#tableBody').appendChild(row); 
}

// End Edit Show Table