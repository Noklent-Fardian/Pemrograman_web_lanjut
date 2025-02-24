<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<div class="category-buttons d-flex justify-content-center flex-wrap my-4">
    <a href="{{ url('/category/food-beverage') }}" class="category-btn m-2">
        <i class="fas fa-utensils"></i>
        <span>Food & Beverage</span>
    </a>

    <a href="{{ url('/category/beauty-health') }}" class="category-btn m-2">
        <i class="fas fa-heartbeat"></i>
        <span>Beauty & Health</span>
    </a>

    <a href="{{ url('/category/home-care') }}" class="category-btn m-2">
        <i class="fas fa-home"></i>
        <span>Home Care</span>
    </a>

    <a href="{{ url('/category/baby-kid') }}" class="category-btn m-2">
        <i class="fas fa-baby"></i>
        <span>Baby & Kid</span>
    </a>
</div>

<style>
.category-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 15px 25px;
    background: #fff;
    border: 2px solid #007bff;
    border-radius: 10px;
    color: #007bff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.category-btn:hover {
    background: #007bff;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    text-decoration: none;
}

.category-btn i {
    font-size: 24px;
    margin-bottom: 8px;
}

.category-btn span {
    font-weight: 500;
}
</style>