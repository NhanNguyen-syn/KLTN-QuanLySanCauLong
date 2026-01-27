@php
    Theme::set('pageTitle', 'Đánh Giá & Nhận Xét - ' . theme_option('site_title', 'BadmintonPro'));
    Theme::set('pageDescription', 'Chia sẻ trải nghiệm của bạn và xem ý kiến từ cộng đồng');
@endphp

<style>
    .reviews-page {
        min-height: 100vh;
        background: linear-gradient(to bottom, #f0fdf4, white);
    }
    
    /* Hero Section */
    .reviews-hero {
        position: relative;
        padding: 4rem 0;
        background: linear-gradient(to right, #065f46, #059669);
        color: white;
        overflow: hidden;
    }
    .reviews-hero::before {
        content: '';
        position: absolute;
        top: 2.5rem;
        left: 2.5rem;
        width: 8rem;
        height: 8rem;
        background: white;
        border-radius: 9999px;
        filter: blur(3rem);
        opacity: 0.1;
    }
    .reviews-hero::after {
        content: '';
        position: absolute;
        bottom: 2.5rem;
        right: 2.5rem;
        width: 10rem;
        height: 10rem;
        background: white;
        border-radius: 9999px;
        filter: blur(3rem);
        opacity: 0.1;
    }
    .reviews-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    .reviews-hero p {
        font-size: 1.125rem;
        color: rgba(236, 253, 245, 0.9);
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
        .reviews-hero h1 {
            font-size: 2rem;
        }
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

<div class="reviews-page">
    <!-- Hero Section -->
    <section class="reviews-hero">
        <div class="container mx-auto px-4 text-center" style="position: relative; z-index: 10;">
            <h1>Đánh Giá & Nhận Xét</h1>
            <p>Chia sẻ trải nghiệm của bạn và xem ý kiến từ cộng đồng</p>
        </div>
    </section>

    <div class="container mx-auto px-4 py-12">
        <div class="reviews-grid" style="display: grid; grid-template-columns: 1fr 380px; gap: 2rem;">
            <!-- Left Column - Overview & Reviews -->
            <div>
                <!-- Rating Overview -->
                <div class="rating-overview">
                    <div style="display: flex; align-items: center; gap: 2rem;">
                        <div style="text-align: center;">
                            <div class="rating-number" id="averageRating">4.8</div>
                            <div class="star-display" style="display: flex; gap: 0.125rem; margin-bottom: 0.5rem; justify-content: center;" id="averageStars">
                                <!-- Stars rendered by JS -->
                            </div>
                            <p style="font-size: 0.875rem; color: #6b7280;"><span id="totalReviews">8</span> đánh giá</p>
                        </div>
                        <div style="flex: 1;">
                            <div class="rating-bar">
                                <span class="rating-bar-label">5 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 75%;"></div></div>
                                <span class="rating-bar-percent">75%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">4 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 20%;"></div></div>
                                <span class="rating-bar-percent">20%</span>
                            </div>
                            <div class="rating-bar">
                                <span class="rating-bar-label">3 sao</span>
                                <div class="rating-bar-track"><div class="rating-bar-fill" style="width: 5%;"></div></div>
                                <span class="rating-bar-percent">5%</span>
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
                        Nhận Xét Từ Khách Hàng (<span id="filteredCount">8</span>)
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
                            <input type="text" id="reviewName" class="form-input" placeholder="Nhập tên của bạn" required>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mock data
    const initialReviews = [
        { id: 1, name: "Nguyễn Văn A", rating: 5, date: "15/01/2025", comment: "Sân cầu lông rất tốt, sạch sẽ, ánh sáng đầy đủ. Nhân viên phục vụ nhiệt tình. Tôi sẽ quay lại!", helpful: 24, images: [], replies: [{ name: "BadmintonPro Admin", date: "16/01/2025", comment: "Cảm ơn bạn đã đánh giá! Chúng tôi rất vui vì bạn hài lòng với dịch vụ." }] },
        { id: 2, name: "Trần Thị B", rating: 5, date: "12/01/2025", comment: "Đặt sân online rất tiện lợi, giá cả hợp lý. Sân chất lượng cao, phù hợp thi đấu.", helpful: 18, images: [], replies: [] },
        { id: 3, name: "Lê Văn C", rating: 4, date: "10/01/2025", comment: "Sân đẹp, thoáng mát. Dịch vụ tốt. Chỉ có điều bãi đỗ xe hơi nhỏ vào giờ cao điểm.", helpful: 12, images: [], replies: [] },
        { id: 4, name: "Phạm Thị D", rating: 5, date: "08/01/2025", comment: "Mình là thành viên cố định, rất hài lòng với chất lượng sân và ưu đãi đặc biệt. Recommend!", helpful: 32, images: [], replies: [] },
        { id: 5, name: "Hoàng Văn E", rating: 4, date: "05/01/2025", comment: "Sân tốt, giá ổn. Có thể cải thiện thêm về chỗ ngồi chờ cho người chơi.", helpful: 9, images: [], replies: [] },
        { id: 6, name: "Võ Thị F", rating: 5, date: "03/01/2025", comment: "Cơ sở vật chất hiện đại, nhân viên thân thiện. Giá thành viên rất ưu đãi!", helpful: 15, images: [], replies: [] },
        { id: 7, name: "Đỗ Văn G", rating: 3, date: "01/01/2025", comment: "Sân tạm ổn nhưng giờ cao điểm hơi đông, khó book được sân.", helpful: 5, images: [], replies: [] },
        { id: 8, name: "Ngô Thị H", rating: 5, date: "28/12/2024", comment: "Tuyệt vời! Đây là sân cầu lông tốt nhất mà tôi từng chơi. Ánh sáng chuẩn thi đấu.", helpful: 28, images: [], replies: [{ name: "BadmintonPro Admin", date: "29/12/2024", comment: "Cảm ơn bạn rất nhiều! Hy vọng được phục vụ bạn trong những lần tiếp theo." }] }
    ];

    let reviews = [...initialReviews];
    let filterRating = null;
    let sortBy = 'newest';
    let currentPage = 1;
    const reviewsPerPage = 5;
    let selectedRating = 0;
    let uploadedImages = [];
    let helpfulVoted = [];

    // Render functions
    function renderStars(rating, size = '1rem') {
        let html = '';
        for (let i = 1; i <= 5; i++) {
            html += `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 24 24" fill="${i <= rating ? '#fbbf24' : 'none'}" stroke="${i <= rating ? '#fbbf24' : '#d1d5db'}" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
        }
        return html;
    }

    function updateStats() {
        const avg = reviews.length > 0 ? (reviews.reduce((sum, r) => sum + r.rating, 0) / reviews.length).toFixed(1) : '0';
        document.getElementById('averageRating').textContent = avg;
        document.getElementById('averageStars').innerHTML = renderStars(Math.round(avg));
        document.getElementById('totalReviews').textContent = reviews.length;
    }

    function getFilteredReviews() {
        let filtered = [...reviews];
        if (filterRating !== null) {
            filtered = filtered.filter(r => r.rating === filterRating);
        }
        
        filtered.sort((a, b) => {
            const dateA = new Date(a.date.split('/').reverse().join('-'));
            const dateB = new Date(b.date.split('/').reverse().join('-'));
            switch(sortBy) {
                case 'newest': return dateB - dateA;
                case 'oldest': return dateA - dateB;
                case 'highest': return b.rating - a.rating;
                case 'lowest': return a.rating - b.rating;
                default: return 0;
            }
        });
        
        return filtered;
    }

    function renderReviews() {
        const filtered = getFilteredReviews();
        document.getElementById('filteredCount').textContent = filtered.length;
        
        const totalPages = Math.ceil(filtered.length / reviewsPerPage);
        const start = (currentPage - 1) * reviewsPerPage;
        const current = filtered.slice(start, start + reviewsPerPage);
        
        let html = '';
        current.forEach(review => {
            const isVoted = helpfulVoted.includes(review.id);
            html += `
                <div class="review-card">
                    <div class="review-header">
                        <div>
                            <div class="review-author">${review.name}</div>
                            <div class="review-stars">${renderStars(review.rating)}</div>
                        </div>
                        <div class="review-date">${review.date}</div>
                    </div>
                    <p class="review-content">${review.comment}</p>
                    ${review.images.length > 0 ? `
                        <div class="review-images">
                            ${review.images.map(img => `<img src="${img}" alt="Review image">`).join('')}
                        </div>
                    ` : ''}
                    <div class="review-actions">
                        <button class="review-action-btn ${isVoted ? 'active' : ''}" onclick="toggleHelpful(${review.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="${isVoted ? '#059669' : 'none'}" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                            Hữu ích (${review.helpful})
                        </button>
                        <button class="review-action-btn" onclick="toggleReply(${review.id})">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg>
                            Phản hồi
                        </button>
                    </div>
                    ${review.replies.length > 0 ? review.replies.map(reply => `
                        <div class="reply-box">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div class="reply-author">${reply.name}</div>
                                <div class="reply-date">${reply.date}</div>
                            </div>
                            <p class="reply-content">${reply.comment}</p>
                        </div>
                    `).join('') : ''}
                </div>
            `;
        });
        
        document.getElementById('reviewsList').innerHTML = html || '<p style="text-align: center; color: #9ca3af; padding: 2rem;">Không có đánh giá nào.</p>';
        
        // Pagination
        if (totalPages > 1) {
            let paginationHtml = `
                <button class="pagination-btn" onclick="changePage(${currentPage - 1})" ${currentPage === 1 ? 'disabled' : ''}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
            `;
            for (let i = 1; i <= totalPages; i++) {
                paginationHtml += `<button class="pagination-page ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            }
            paginationHtml += `
                <button class="pagination-btn" onclick="changePage(${currentPage + 1})" ${currentPage === totalPages ? 'disabled' : ''}>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            `;
            document.getElementById('pagination').innerHTML = paginationHtml;
        } else {
            document.getElementById('pagination').innerHTML = '';
        }
    }

    window.changePage = function(page) {
        const filtered = getFilteredReviews();
        const totalPages = Math.ceil(filtered.length / reviewsPerPage);
        if (page >= 1 && page <= totalPages) {
            currentPage = page;
            renderReviews();
        }
    };

    window.toggleHelpful = function(reviewId) {
        const idx = helpfulVoted.indexOf(reviewId);
        if (idx > -1) {
            helpfulVoted.splice(idx, 1);
            const review = reviews.find(r => r.id === reviewId);
            if (review) review.helpful--;
        } else {
            helpfulVoted.push(reviewId);
            const review = reviews.find(r => r.id === reviewId);
            if (review) review.helpful++;
        }
        renderReviews();
    };

    window.toggleReply = function(reviewId) {
        // Could implement inline reply form here
        alert('Tính năng phản hồi sẽ sớm được triển khai!');
    };

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterRating = this.dataset.filter === 'all' ? null : parseInt(this.dataset.filter);
            currentPage = 1;
            renderReviews();
        });
    });

    // Sort select
    document.getElementById('sortSelect').addEventListener('change', function() {
        sortBy = this.value;
        currentPage = 1;
        renderReviews();
    });

    // Star rating input
    document.querySelectorAll('#starRatingInput button').forEach(btn => {
        btn.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.star);
            document.querySelectorAll('#starRatingInput svg').forEach((svg, idx) => {
                if (idx < selectedRating) {
                    svg.classList.add('filled');
                    svg.style.fill = '#fbbf24';
                    svg.style.color = '#fbbf24';
                } else {
                    svg.classList.remove('filled');
                    svg.style.fill = 'none';
                    svg.style.color = '#d1d5db';
                }
            });
            updateSubmitButton();
        });
        
        btn.addEventListener('mouseenter', function() {
            const star = parseInt(this.dataset.star);
            document.querySelectorAll('#starRatingInput svg').forEach((svg, idx) => {
                if (idx < star) {
                    svg.style.fill = '#fbbf24';
                    svg.style.color = '#fbbf24';
                }
            });
        });
        
        btn.addEventListener('mouseleave', function() {
            document.querySelectorAll('#starRatingInput svg').forEach((svg, idx) => {
                if (idx < selectedRating) {
                    svg.style.fill = '#fbbf24';
                    svg.style.color = '#fbbf24';
                } else {
                    svg.style.fill = 'none';
                    svg.style.color = '#d1d5db';
                }
            });
        });
    });

    // Image upload
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const files = e.target.files;
        if (files) {
            Array.from(files).forEach(file => {
                if (uploadedImages.length < 3) {
                    uploadedImages.push(URL.createObjectURL(file));
                }
            });
            renderUploadedImages();
        }
    });

    function renderUploadedImages() {
        const container = document.getElementById('uploadedImages');
        container.innerHTML = uploadedImages.map((img, idx) => `
            <div class="uploaded-image-wrapper">
                <img src="${img}" alt="Upload ${idx + 1}">
                <button type="button" class="remove-image-btn" onclick="removeImage(${idx})">×</button>
            </div>
        `).join('');
        
        document.getElementById('imageUploadArea').style.display = uploadedImages.length >= 3 ? 'none' : 'flex';
    }

    window.removeImage = function(idx) {
        uploadedImages.splice(idx, 1);
        renderUploadedImages();
    };

    // Form validation
    function updateSubmitButton() {
        const name = document.getElementById('reviewName').value.trim();
        const comment = document.getElementById('reviewComment').value.trim();
        document.getElementById('submitBtn').disabled = !(selectedRating > 0 && name && comment);
    }

    document.getElementById('reviewName').addEventListener('input', updateSubmitButton);
    document.getElementById('reviewComment').addEventListener('input', updateSubmitButton);

    // Form submit
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const name = document.getElementById('reviewName').value.trim();
        const comment = document.getElementById('reviewComment').value.trim();
        
        if (selectedRating > 0 && name && comment) {
            const newReview = {
                id: Date.now(),
                name: name,
                rating: selectedRating,
                date: new Date().toLocaleDateString('vi-VN'),
                comment: comment,
                helpful: 0,
                images: [...uploadedImages],
                replies: [],
                isOwner: true
            };
            
            reviews.unshift(newReview);
            
            // Reset form
            document.getElementById('reviewForm').style.display = 'none';
            document.getElementById('submitSuccess').style.display = 'block';
            
            setTimeout(() => {
                document.getElementById('reviewForm').style.display = 'block';
                document.getElementById('submitSuccess').style.display = 'none';
                document.getElementById('reviewName').value = '';
                document.getElementById('reviewComment').value = '';
                selectedRating = 0;
                uploadedImages = [];
                document.querySelectorAll('#starRatingInput svg').forEach(svg => {
                    svg.style.fill = 'none';
                    svg.style.color = '#d1d5db';
                });
                renderUploadedImages();
                updateSubmitButton();
            }, 3000);
            
            updateStats();
            renderReviews();
        }
    });

    // Initial render
    updateStats();
    renderReviews();
});
</script>
