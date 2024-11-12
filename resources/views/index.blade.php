<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product entry and display Form</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-4">

<div class="row">
    <div class="text-center"> <strong>Enter Product Details</strong></div>
</div>
 <form id="productsForm"  class="mb-4 p-3 border rounded">
@csrf
<div class="mb-3">
 <label for="first_name">Product Name
 <input type="text" name="product_name" Placeholder="Enter product name" required id="">
 </label>
</div>



<div class="mb-3">
 <label for="first_name"> Product Quantity
 <input type="number" name="product_quantity" Placeholder="Enter product quantity" required  id="">
 </label>
 </div>

 <div class="mb-3">
 <label for="first_name"> Product Price
 <input type="number" name="product_price" Placeholder="Enter product price" required  id="">
 </label>
 </div>

 <button type="submit">Submit</button>
 </form>
 <table class="table">
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Date</th>
            <th>Value</th>
        </tr>
    </thead>

    <tbody id="productRows">
    </tbody>
   <tfoot>
    <tr>
        <td colspan="4">Total Sum</td>
        <td id="totalSum"></td>
    </tr>
   </tfoot>
 </table>
<!-- saving and retriving data -->
<script>
document.getElementById('productsForm').addEventListener('submit', function(e){
    e.preventDefault();
    let productFormData = new FormData(this);
    fetch('/submit-product', {
        method : 'POST',
        headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
        body : productFormData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            displayProductsFromJson(data.products);
            this.reset();
        }
    })
})

function displayProductsFromJson(products) {
        let tableBody = '';
        let sumTotal = 0;

        products.forEach(product => {
            sumTotal += product.total_value;
            tableBody += `<tr>
                <td>${product.product_name}</td>
                <td>${product.product_quantity}</td>
                <td>${product.product_price}</td>
                <td>${product.datetime}</td>
                <td>${product.total_value}</td>
            </tr>`;
        });

        document.getElementById('productRows').innerHTML = tableBody;
        document.getElementById('totalSum').innerText = sumTotal;
    }
</script>

<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
