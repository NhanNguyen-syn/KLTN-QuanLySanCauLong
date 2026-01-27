<style>
    .products-section { padding: 3rem 0; }
    .products-section .section-title { font-size: 1.5rem; font-weight: 700; color: #0a2818; margin-bottom: 2rem; }
    .category-filter { display: flex; gap: 0.5rem; margin-bottom: 2rem; overflow-x: auto; padding-bottom: 0.5rem; }
    .category-btn { padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; white-space: nowrap; transition: all 0.2s; background: white; border: 2px solid #d1f2e8; color: #0a2818; cursor: pointer; }
    .category-btn:hover { border-color: #065f46; }
    .category-btn.active { background: #065f46; color: white; border-color: #065f46; }
    .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    @media (max-width: 1024px) { .products-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .products-grid { grid-template-columns: 1fr; } }
    .product-card { background: white; border-radius: 0.5rem; border: 2px solid #d1f2e8; overflow: hidden; transition: box-shadow 0.2s; }
    .product-card:hover { box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .product-image { width: 100%; height: 12rem; object-fit: cover; background: #ecf5f1; }
    .product-content { padding: 1rem; }
    .product-name { font-size: 1.125rem; font-weight: 700; color: #0a2818; margin-bottom: 0.25rem; }
    .product-description { font-size: 0.875rem; color: #4a7c6f; margin-bottom: 1rem; }
    .product-footer { display: flex; justify-content: space-between; align-items: center; }
    .product-price { font-size: 1.125rem; font-weight: 700; color: #065f46; }
    .product-btn { padding: 0.5rem 1rem; background: #065f46; color: white; border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; transition: background 0.2s; font-size: 0.875rem; }
    .product-btn:hover { background: #14b8a6; }
    .products-empty { text-align: center; padding: 2rem; color: #4a7c6f; grid-column: 1/-1; }
</style>

<section class="products-section">
    <div class="container mx-auto px-4" style="max-width: 80rem;">
        <h2 class="section-title">{{ $shortcode->title ?: 'Sản Phẩm' }}</h2>

        <!-- Category Filter -->
        <div class="category-filter" id="categoryFilter">
            <button class="category-btn active" data-category="all">Tất Cả</button>
            @foreach($categories as $category)
                <button class="category-btn" data-category="{{ $category->id }}">
                    {{ $category->icon ? $category->icon . ' ' : '' }}{{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
                <div class="product-card" data-category-id="{{ $product['category_id'] }}">
                    @if($product['image'])
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image">
                    @else
                        <div class="product-image" style="display: flex; align-items: center; justify-content: center; font-size: 3rem;">🏸</div>
                    @endif
                    <div class="product-content">
                        <h3 class="product-name">{{ $product['name'] }}</h3>
                        <p class="product-description">{{ $product['description'] ?? '' }}</p>
                        <div class="product-footer">
                            <span class="product-price">{{ number_format($product['price'], 0, ',', '.') }}đ</span>
                            <button class="product-btn" onclick="alert('Vui lòng liên hệ trực tiếp tại quầy lễ tân.')">Liên hệ tại quầy</button>
                        </div>
                    </div>
                </div>
            @empty
                <p class="products-empty">Không có sản phẩm nào.</p>
            @endforelse
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('#categoryFilter .category-btn');
    const productCards = document.querySelectorAll('#productsGrid .product-card');
    const productsGrid = document.getElementById('productsGrid');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const selectedCategory = this.dataset.category;
            let visibleCount = 0;
            
            productCards.forEach(card => {
                if (selectedCategory === 'all' || card.dataset.categoryId === selectedCategory) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Show empty message if no products visible
            let emptyMsg = productsGrid.querySelector('.products-empty-dynamic');
            if (visibleCount === 0) {
                if (!emptyMsg) {
                    emptyMsg = document.createElement('p');
                    emptyMsg.className = 'products-empty products-empty-dynamic';
                    emptyMsg.textContent = 'Không có sản phẩm nào trong danh mục này.';
                    productsGrid.appendChild(emptyMsg);
                }
                emptyMsg.style.display = 'block';
            } else if (emptyMsg) {
                emptyMsg.style.display = 'none';
            }
        });
    });
});
</script>

