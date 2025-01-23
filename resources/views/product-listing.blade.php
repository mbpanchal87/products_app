<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap 5 Product Listing Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <!-- Header -->
  <header class="bg-primary text-white py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <h1 class="h3 mb-0">Welcome to the Store</h1>
      <div class="d-flex align-items-center">
        <input type="text" id="search-input" class="form-control me-3" placeholder="Search Products..." style="width: 400px;" onkeyup="searchProduct()">
        <a href="#" class="text-white me-3">Welcome, {{ $user->firstname ." ". $user->lastname }}</a>
        <a href="{{ route('logout') }}" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
  </header>

  <div class="container-fluid">
    <div class="row">
      <!-- Left Navigation -->
      <nav class="col-md-2 bg-light p-3 border-end">
        <h4 class="h5">Menu</h4>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('product-listing') }}" class="nav-link"><i class="fas fa-home me-2"></i> Electronic Products</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product-listing') }}" class="nav-link"><i class="fab fa-bandcamp me-2"></i> Fashion</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product-listing') }}" class="nav-link"><i class="fas fa-bed me-2"></i> Home & Living</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('product-listing') }}" class="nav-link"><i class="fas fa-baseball-ball me-2"></i> Sports & Outdoors</a>
          </li>
        </ul>
      </nav>

      <!-- Middle Wrapper -->
      <main class="col-md-10 p-3">
        <h2>Product Listing</h2>
        <div class="row row-cols-1 row-cols-md-4 g-4" id="product-list">
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    
    document.addEventListener("DOMContentLoaded", () => {
        fetchProducts();
    });

    function fetchProducts() {
        const username = 'admin'; // Replace with your static username
        const password = 'admin'; // Replace with your static password
        const base64Credentials = btoa(username + ':' + password); // Encode credentials in base64

        fetch('/api/products', {
            headers: {
                'Authorization': 'Basic ' + base64Credentials
            }
        })
            .then(response => response.json())
            .then(data => {
                let productList = document.getElementById('product-list');
                productList.innerHTML = '';
                data.products.forEach(product => {
                    const imagePath = `/${product.image}`;
                    productList.innerHTML += `
                        <div class="col">
                            <div class="card h-100">
                              <img src="${imagePath}" class="card-img-top w-100" alt="${product.name}">
                              <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.description}</p>
                                <p class="text-primary fw-bold">$${product.price}</p>
                                <button onclick="deleteProduct(${product.id})" class="btn btn-danger btn-sm">Delete</button>
                              </div>
                            </div>
                          </div>
                    `;
                });
            });
    }
    function searchProduct() {
        let query = document.getElementById('search-input').value;
        const username = 'admin'; // Replace with your static username
        const password = 'admin'; // Replace with your static password
        const base64Credentials = btoa(username + ':' + password); // Encode credentials in base64

        fetch(`/api/products/search?query=${query}`, {
            headers: {
                'Authorization': 'Basic ' + base64Credentials
            }
        })
            .then(response => response.json())
            .then(data => {
                let productList = document.getElementById('product-list');
                productList.innerHTML = '';
                data.products.forEach(product => {
                    const imagePath = `/${product.image}`;
                    productList.innerHTML += `
                        <div class="col">
                            <div class="card h-100">
                              <img src="${imagePath}" class="card-img-top w-100" alt="${product.name}">
                              <div class="card-body">
                                <h5 class="card-title">${product.name}</h5>
                                <p class="card-text">${product.description}</p>
                                <p class="text-primary fw-bold">$${product.price}</p>
                                <button onclick="deleteProduct(${product.id})" class="btn btn-danger btn-sm">Delete</button>
                              </div>
                            </div>
                          </div>
                    `;
                });
            });
    }

    function deleteProduct(id) {
        const username = 'admin';
        const password = 'admin';
        const base64Credentials = btoa(username + ':' + password);
        fetch(`/api/products/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Basic ' + base64Credentials
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product deleted successfully');
                searchProduct(); // Refresh the product list
            } else {
                alert('Error deleting product');
            }
        });
    }
</script>
</body>
</html>
