{!! dynamic_sidebar('top_sidebar') !!}

@php
    Theme::set('pageTitle', 'Đánh Giá & Nhận Xét - ' . theme_option('site_title', 'BadmintonPro'));
    Theme::set('pageDescription', 'Chia sẻ trải nghiệm của bạn và xem ý kiến từ cộng đồng');
    $page = $page ?? null;
@endphp

@if(!empty($page))
    @php
        $pageContent = do_shortcode($page->content ?? "");
    @endphp
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
@endif

@php
    $memberName = '';
    $memberId = null;
    
    // Use the 'member' guard to get authenticated member
    if (auth('member')->check()) {
        $member = auth('member')->user();
        
        if ($member) {
            $memberId = $member->id;
            // Member model has a 'name' attribute accessor that combines first_name + last_name
            $memberName = $member->name ?? trim(($member->first_name ?? '') . ' ' . ($member->last_name ?? ''));
        }
    }
@endphp

<!-- Debug output (remove sau khi fix) -->
<!-- DEBUG: memberName = "{{ $memberName }}", memberId = "{{ $memberId }}" -->


<style>
    .reviews-page {
        min-height: 100vh;
        background: white;
    }
    
    /* Hero Banner Section */
    .reviews-hero {
        width: 100%;
        margin-bottom: 2rem;
    }
    
    
    /* Rating Overview Card */
    .rating-overview {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #f3f4f6;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    .rating-number {
        font-size: 3rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 0.5rem;
    }
    .star-display { color: #fbbf24; }
    .star-display .star-filled { fill: #fbbf24; }
    
    .rating-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .rating-bar-label {
        width: 3rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    .rating-bar-track {
        flex: 1;
        height: 0.5rem;
        background: #f3f4f6;
        border-radius: 9999px;
        overflow: hidden;
    }
    .rating-bar-fill {
        height: 100%;
        background: linear-gradient(to right, #fbbf24, #f59e0b);
        border-radius: 9999px;
    }
    .rating-bar-percent {
        width: 3rem;
        text-align: right;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    /* Filter Bar */
    .filter-bar {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #f3f4f6;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 1rem;
    }
    .filter-btn {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        background: #f3f4f6;
        color: #6b7280;
    }
    .filter-btn:hover { background: #e5e7eb; }
    .filter-btn.active {
        background: #065f46;
        color: white;
    }
    .filter-select {
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid #d1d5db;
        font-size: 0.875rem;
    }
    .filter-select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.5);
    }
    
    /* Review Card */
    .review-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #f3f4f6;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: box-shadow 0.2s;
    }
    .review-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
    }
    .review-author {
        font-weight: 600;
        color: #065f46;
        margin-bottom: 0.25rem;
    }
    .review-date {
        font-size: 0.875rem;
        color: #9ca3af;
    }
    .review-stars {
        display: flex;
        gap: 0.125rem;
        margin-bottom: 0.5rem;
    }
    .review-stars svg {
        width: 1rem;
        height: 1rem;
    }
    .review-content {
        color: #374151;
        line-height: 1.625;
        margin-bottom: 1rem;
    }
    .review-images {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    .review-images img {
        width: 100%;
        height: 8rem;
        object-fit: cover;
        border-radius: 0.5rem;
        transition: transform 0.3s;
    }
    .review-images img:hover {
        transform: scale(1.05);
    }
    .review-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .review-action-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        background: none;
        border: none;
        cursor: pointer;
        transition: color 0.2s;
    }
    .review-action-btn:hover { color: #059669; }
    .review-action-btn.active { color: #059669; }
    .review-action-btn svg {
        width: 1rem;
        height: 1rem;
    }
    
    /* Reply Box */
    .reply-box {
        background: #f0fdf4;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-left: 2rem;
        margin-top: 0.75rem;
    }
    .reply-author {
        font-weight: 600;
        color: #065f46;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }
    .reply-date {
        font-size: 0.75rem;
        color: #9ca3af;
    }
    .reply-content {
        font-size: 0.875rem;
        color: #374151;
        margin-top: 0.5rem;
    }
    
    /* Submit Form */
    .submit-form-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid #f3f4f6;
        padding: 1.5rem;
        position: sticky;
        top: 6rem;
    }
    .submit-form-card h2 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #065f46;
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    .form-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
    }
    .form-textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        resize: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-textarea:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.2);
    }
    .star-rating-input {
        display: flex;
        gap: 0.5rem;
    }
    .star-rating-input button {
        background: none;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .star-rating-input button:hover {
        transform: scale(1.1);
    }
    .star-rating-input svg {
        width: 2rem;
        height: 2rem;
        color: #d1d5db;
        transition: color 0.2s;
    }
    .star-rating-input svg.filled {
        color: #fbbf24;
        fill: #fbbf24;
    }
    .submit-btn {
        width: 100%;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(to right, #065f46, #059669);
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .submit-btn:hover {
        background: linear-gradient(to right, #059669, #10b981);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .submit-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    /* Image Upload */
    .image-upload-area {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .image-upload-area:hover {
        border-color: #059669;
        background: #f0fdf4;
    }
    .image-upload-area svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #6b7280;
    }
    .image-upload-area span {
        font-size: 0.875rem;
        color: #6b7280;
    }
    .uploaded-images {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    .uploaded-image-wrapper {
        position: relative;
    }
    .uploaded-image-wrapper img {
        width: 100%;
        height: 6rem;
        object-fit: cover;
        border-radius: 0.5rem;
    }
    .remove-image-btn {
        position: absolute;
        top: 0.25rem;
        right: 0.25rem;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 9999px;
        width: 1.25rem;
        height: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        opacity: 0;
        transition: opacity 0.2s;
    }
    .uploaded-image-wrapper:hover .remove-image-btn {
        opacity: 1;
    }
    
    /* Success State */
    .success-state {
        text-align: center;
        padding: 2rem;
    }
    .success-icon {
        width: 4rem;
        height: 4rem;
        background: #d1fae5;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    .success-icon svg {
        width: 2rem;
        height: 2rem;
        color: #059669;
    }
    .success-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #065f46;
        margin-bottom: 0.5rem;
    }
    .success-text {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        margin-top: 2rem;
    }
    .pagination-btn {
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: white;
        cursor: pointer;
        transition: all 0.2s;
    }
    .pagination-btn:hover {
        background: #f9fafb;
    }
    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .pagination-btn svg {
        width: 1.25rem;
        height: 1.25rem;
    }
    .pagination-page {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        background: white;
        border: 1px solid #d1d5db;
        color: #374151;
    }
    .pagination-page:hover {
        background: #f9fafb;
    }
    .pagination-page.active {
        background: #065f46;
        color: white;
        border-color: #065f46;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .reviews-grid {
            grid-template-columns: 1fr;
        }
        .submit-form-card {
            position: static;
        }
    }
    @media (max-width: 768px) {
        .rating-overview {
            flex-direction: column;
            text-align: center;
        }
        .filter-bar {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="reviews-page" 
    data-member-name="{{ $memberName }}" 
    data-member-id="{{ $memberId }}"
    data-csrf-token="{{ csrf_token() }}"
    data-api-reviews="{{ route('api.reviews.index') }}"
    data-api-submit="{{ route('api.reviews.store') }}">

    <div class="container mx-auto px-4 py-12">
        <div class="reviews-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 2rem;">
            <!-- Left Column - Overview & Reviews -->
            <div>
                <!-- Rating Overview -->
                <div class="rating-overview">
                    <div style="display: flex; align-items: center; gap: 2rem;">
                        <div style="text-align: center;">
                            <div class="rating-number" id="averageRating">0</div>
                            <div class="star-display" style="display: flex; gap: 0.125rem; margin-bottom: 0.5rem; justify-content: center;" id="averageStars">
                                <!-- Stars rendered by JS -->
                            </div>
                            <p style="font-size: 0.875rem; color: #6b7280;"><span id="totalReviews">0</span> đánh giá</p>
                        </div>
                        <div style="flex: 1;">
                            <div class="rating-bar">
                                <span class="rating-bar-label">5 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 0%;"></div></div>
                                <span class="rating-bar-percent">0%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">4 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 0%;"></div></div>
                                <span class="rating-bar-percent">0%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">3 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 0%;"></div></div>
                                <span class="rating-bar-percent">0%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">2 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 0%;"></div></div>
                                <span class="rating-bar-percent">0%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">1 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 0%;"></div></div>
                                <span class="rating-bar-percent">0%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Bar -->
                <div class="filter-bar">
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        <span style="font-weight: 500; color: #374151;">Bộ lọc:</span>
                    </div>
                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;" id="filterButtons">
                        <button class="filter-btn active" data-filter="all">Tất cả</button>
                        <button class="filter-btn" data-filter="5">5 ⭐</button>
                        <button class="filter-btn" data-filter="4">4 ⭐</button>
                        <button class="filter-btn" data-filter="3">3 ⭐</button>
                        <button class="filter-btn" data-filter="2">2 ⭐</button>
                        <button class="filter-btn" data-filter="1">1 ⭐</button>
                    </div>
                    <div style="height: 1.5rem; width: 1px; background: #d1d5db;"></div>
                    <select class="filter-select" id="sortSelect">
                        <option value="newest">Mới nhất</option>
                        <option value="oldest">Cũ nhất</option>
                        <option value="highest">Đánh giá cao nhất</option>
                        <option value="lowest">Đánh giá thấp nhất</option>
                    </select>
                </div>

                <!-- Reviews List -->
                <div>
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #065f46; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        Nhận Xét Từ Khách Hàng (<span id="filteredCount">0</span>)
                    </h2>

                    <div id="reviewsList">
                        <!-- Reviews rendered by JS -->
                    </div>

                    <!-- Pagination -->
                    <div class="pagination" id="pagination">
                        <!-- Pagination rendered by JS -->
                    </div>
                </div>
            </div>

            <!-- Right Column - Submit Form -->
            <div>
                <div class="submit-form-card">
                    <h2>Gửi Đánh Giá Của Bạn</h2>

                    <div id="submitSuccess" style="display: none;">
                        <div class="success-state">
                            <div class="success-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <h3 class="success-title">Cảm ơn bạn!</h3>
                            <p class="success-text">Đánh giá của bạn đã được gửi thành công</p>
                        </div>
                    </div>

                    <form id="reviewForm" style="display: block;">
                        <!-- Star Rating -->
                        <div style="margin-bottom: 1rem;">
                            <label class="form-label">Đánh giá của bạn</label>
                            <div class="star-rating-input" id="starRatingInput">
                                <button type="button" data-star="1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></button>
                                <button type="button" data-star="2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></button>
                                <button type="button" data-star="3"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></button>
                                <button type="button" data-star="4"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></button>
                                <button type="button" data-star="5"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></button>
                            </div>
                        </div>

                        <!-- Name -->
                        <div style="margin-bottom: 1rem;">
                            <label class="form-label" for="reviewName">Tên của bạn</label>
                            <input type="text" id="reviewName" class="form-input" placeholder="Nhập tên của bạn" value="{{ $memberName }}" required>
                        </div>

                        <!-- Comment -->
                        <div style="margin-bottom: 1rem;">
                            <label class="form-label" for="reviewComment">Nhận xét</label>
                            <textarea id="reviewComment" class="form-textarea" rows="5" placeholder="Chia sẻ trải nghiệm của bạn..." required></textarea>
                        </div>

                        <!-- Image Upload -->
                        <div style="margin-bottom: 1rem;">
                            <label class="form-label">Thêm hình ảnh (Tối đa 3 ảnh)</label>
                            <div class="uploaded-images" id="uploadedImages"></div>
                            <label class="image-upload-area" id="imageUploadArea">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span>Chọn hình ảnh</span>
                                <input type="file" id="imageInput" accept="image/*" multiple style="display: none;">
                            </label>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="submit-btn" id="submitBtn" disabled>Gửi Đánh Giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


