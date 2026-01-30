(function () {
    'use strict';

    // Execute immediately if DOM is already ready, otherwise wait
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        const pageEl = document.querySelector('.reviews-page');
        if (!pageEl) return;

        // Get configuration from data attributes
        const memberName = pageEl.dataset.memberName || '';
        const memberId = pageEl.dataset.memberId || null;
        const csrfToken = pageEl.dataset.csrfToken || '';
        const apiReviewsUrl = pageEl.dataset.apiReviews || '/api/reviews';
        const apiSubmitUrl = pageEl.dataset.apiSubmit || '/api/reviews';

        // State variables
        let reviews = [];
        let reviewStats = {
            averageRating: 0,
            totalReviews: 0,
            ratingCounts: { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 }
        };
        let filterRating = null;
        let sortBy = 'newest';
        let currentPage = 1;
        const reviewsPerPage = 5;
        let selectedRating = 0;
        let uploadedImages = [];
        let helpfulVoted = [];

        // Expose global functions for onclick handlers
        window.changePage = function (page) {
            currentPage = page;
            fetchReviews();
        };

        window.toggleHelpful = async function (reviewId) {
            try {
                const response = await fetch(`/api/reviews/${reviewId}/helpful`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                const data = await response.json();

                // Update local state
                const review = reviews.find(r => r.id === reviewId);
                if (review && data.helpful !== undefined) {
                    review.helpful = data.helpful;
                    review.is_voted = data.voted; // Update review state directly

                    // Sync helpfulVoted array (optional but keeps consistency)
                    if (data.voted) {
                        if (!helpfulVoted.includes(reviewId)) helpfulVoted.push(reviewId);
                    } else {
                        const idx = helpfulVoted.indexOf(reviewId);
                        if (idx > -1) helpfulVoted.splice(idx, 1);
                    }
                    renderReviews(); // Re-render to update UI
                }
            } catch (error) {
                console.error('Failed to toggle helpful:', error);
            }
        };

        window.toggleReply = function (reviewId) {
            const replyBox = document.getElementById(`reply-input-box-${reviewId}`);
            if (replyBox) {
                replyBox.style.display = replyBox.style.display === 'none' ? 'block' : 'none';
            }
        };

        window.submitReply = async function (reviewId) {
            const inputEl = document.getElementById(`reply-input-${reviewId}`);
            if (!inputEl) return;

            const content = inputEl.value.trim();
            if (!content) {
                alert('Vui lòng nhập nội dung phản hồi.');
                return;
            }

            try {
                const response = await fetch(apiSubmitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        name: memberName || 'Khách',
                        comment: content,
                        parent_id: reviewId
                        // rating: 0 // Should not send rating for replies to avoid validation error
                    })
                });

                if (response.ok) {
                    inputEl.value = '';
                    window.toggleReply(reviewId); // Hide input
                    fetchReviews(); // Refresh list to show new reply
                } else {
                    const errorData = await response.json();
                    console.error('Reply submission error:', errorData);
                    let msg = 'Có lỗi xảy ra khi gửi phản hồi. Vui lòng thử lại!';
                    if (errorData.message) msg += '\n' + errorData.message;
                    if (errorData.errors) {
                        msg += '\n' + JSON.stringify(errorData.errors);
                    }
                    alert(msg);
                }
            } catch (error) {
                console.error('Failed to submit reply:', error);
                alert('Có lỗi xảy ra khi gửi phản hồi. Vui lòng thử lại!');
            }
        };

        // Custom Confirmation Modal
        function showConfirm(message, onConfirm) {
            // Remove existing modal if any
            const existingModal = document.getElementById('custom-confirm-modal');
            if (existingModal) existingModal.remove();

            const modalHtml = `
                <div id="custom-confirm-modal" style="position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); display:flex; align-items:center; justify-content:center; z-index:9999; animation: fadeIn 0.2s;">
                    <div style="background:white; padding:25px; border-radius:12px; width:90%; max-width:400px; text-align:center; box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: scaleIn 0.2s;">
                        <div style="margin-bottom:15px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                        <h3 style="margin:0 0 10px; font-size:1.25rem; font-weight:600; color:#111;">Xác nhận xóa</h3>
                        <p style="margin:0 0 25px; color:#666; font-size:1rem; line-height:1.5;">${message}</p>
                        <div style="display:flex; justify-content:center; gap:12px;">
                            <button id="modal-cancel-btn" style="padding:10px 20px; border:1px solid #d1d5db; background:white; color:#374151; border-radius:6px; font-weight:500; cursor:pointer; min-width:100px; transition:all 0.2s;">Hủy bỏ</button>
                            <button id="modal-confirm-btn" style="padding:10px 20px; border:none; background:#ef4444; color:white; border-radius:6px; font-weight:500; cursor:pointer; min-width:100px; box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.5); transition:all 0.2s;">Xóa ngay</button>
                        </div>
                    </div>
                </div>
            `;

            // Add keyframes if not exists
            if (!document.getElementById('modal-styles')) {
                const style = document.createElement('style');
                style.id = 'modal-styles';
                style.textContent = `
                    @keyframes fadeIn { from { opacity:0; } to { opacity:1; } }
                    @keyframes scaleIn { from { transform:scale(0.95); opacity:0; } to { transform:scale(1); opacity:1; } }
                    #modal-confirm-btn:hover { background:#dc2626; transform:translateY(-1px); }
                    #modal-cancel-btn:hover { background:#f3f4f6; border-color:#9ca3af; }
                `;
                document.head.appendChild(style);
            }

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            document.getElementById('modal-cancel-btn').onclick = function () {
                document.getElementById('custom-confirm-modal').remove();
            };

            document.getElementById('modal-confirm-btn').onclick = function () {
                document.getElementById('custom-confirm-modal').remove();
                onConfirm();
            };

            // Close on click outside
            document.getElementById('custom-confirm-modal').onclick = function (e) {
                if (e.target === this) this.remove();
            };
        }

        window.deleteReply = function (replyId) {
            showConfirm('Bạn có chắc chắn muốn xóa phản hồi này không? Hành động này không thể hoàn tác.', async function () {
                try {
                    const response = await fetch(`/api/reviews/replies/${replyId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        fetchReviews();
                    } else {
                        alert('Không thể xóa phản hồi này.');
                    }
                } catch (error) {
                    console.error('Failed to delete reply:', error);
                }
            });
        };

        window.deleteReview = function (reviewId) {
            showConfirm('Bạn có chắc chắn muốn xóa đánh giá này không? Hành động này không thể hoàn tác.', async function () {
                try {
                    const response = await fetch(`/api/reviews/${reviewId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    });

                    if (response.ok) {
                        fetchReviews();
                    } else {
                        alert('Không thể xóa đánh giá này.');
                    }
                } catch (error) {
                    console.error('Failed to delete review:', error);
                }
            });
        };

        window.removeImage = function (idx) {
            uploadedImages.splice(idx, 1);
            renderUploadedImages();
        };

        // API Functions
        async function fetchReviews() {
            try {
                const params = new URLSearchParams();
                if (filterRating !== null) {
                    params.append('rating', filterRating);
                }
                params.append('sort', sortBy);
                params.append('page', currentPage);

                const response = await fetch(`${apiReviewsUrl}?${params.toString()}`);
                const data = await response.json();

                reviews = data.reviews || [];

                // Map API snake_case to JS camelCase
                const stats = data.stats || {};
                reviewStats = {
                    averageRating: stats.average_rating || 0,
                    totalReviews: stats.total_reviews || 0,
                    ratingCounts: stats.rating_counts || { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0 }
                };

                // Update UI with stats
                updateStats();
                renderReviews();
            } catch (error) {
                console.error('Failed to fetch reviews:', error);
            }
        }

        function updateStats() {
            const avgRatingEl = document.getElementById('averageRating');
            const avgStarsEl = document.getElementById('averageStars');
            const totalReviewsEl = document.getElementById('totalReviews');

            if (avgRatingEl) avgRatingEl.textContent = reviewStats.averageRating || '0';
            if (avgStarsEl) avgStarsEl.innerHTML = renderStars(Math.round(reviewStats.averageRating || 0));
            if (totalReviewsEl) totalReviewsEl.textContent = reviewStats.totalReviews || 0;

            // Update rating bars
            const total = reviewStats.totalReviews || 1;
            for (let i = 1; i <= 5; i++) {
                const count = reviewStats.ratingCounts?.[i] || 0;
                const percent = Math.round((count / total) * 100);
                const barIndex = 6 - i; // Reverse order (5 stars first)
                const bars = document.querySelectorAll('.rating-bar');
                if (bars[barIndex - 1]) {
                    const fill = bars[barIndex - 1].querySelector('.rating-bar-fill');
                    const percentEl = bars[barIndex - 1].querySelector('.rating-bar-percent');
                    if (fill) fill.style.width = `${percent}%`;
                    if (percentEl) percentEl.textContent = `${percent}%`;
                }
            }
        }

        // Utility: Escape HTML to prevent XSS and syntax errors
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Render functions
        function renderStars(rating, size = '1rem') {
            let html = '';
            for (let i = 1; i <= 5; i++) {
                html += `<svg xmlns="http://www.w3.org/2000/svg" width="${size}" height="${size}" viewBox="0 0 24 24" fill="${i <= rating ? '#fbbf24' : 'none'}" stroke="${i <= rating ? '#fbbf24' : '#d1d5db'}" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`;
            }
            return html;
        }

        function renderReviews() {
            const reviewsListEl = document.getElementById('reviewsList');
            const filteredCountEl = document.getElementById('filteredCount');

            if (filteredCountEl) filteredCountEl.textContent = reviews.length || 0;

            let html = '';
            reviews.forEach(review => {
                // Use is_voted directly as source of truth
                const isVoted = review.is_voted;
                const isOwner = memberId && (parseInt(review.member_id) === parseInt(memberId));

                html += `
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <div class="review-author">${escapeHtml(review.name)}</div>
                                <div class="review-stars">${renderStars(review.rating)}</div>
                            </div>
                            <div class="review-date">${review.date}
                            ${isOwner ? `<button class="text-danger ml-2" onclick="window.deleteReview(${review.id})" style="border:none; background:none; color:red; cursor:pointer;" title="Xóa đánh giá"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>` : ''}
                            </div>
                        </div>
                        <p class="review-content">${escapeHtml(review.comment)}</p>
                        ${review.images && review.images.length > 0 ? `
                            <div class="review-images">
                                ${review.images.map(img => `<img src="${img}" alt="Review image">`).join('')}
                            </div>
                        ` : ''}
                        <div class="review-actions">
                            <button class="review-action-btn ${isVoted ? 'active' : ''}" onclick="window.toggleHelpful(${review.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="${isVoted ? '#059669' : 'none'}" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                                Hữu ích (${review.helpful})
                            </button>
                            ${memberId ? `
                            <button class="review-action-btn" onclick="window.toggleReply(${review.id})">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 17 4 12 9 7"></polyline><path d="M20 18v-2a4 4 0 0 0-4-4H4"></path></svg>
                                Phản hồi
                            </button>` : ''}
                        </div>
                        
                        <!-- Reply Input Box (Hidden by default) -->
                        <div id="reply-input-box-${review.id}" style="display: none; margin-top: 10px; margin-left: 20px;">
                            <textarea id="reply-input-${review.id}" class="form-control" rows="2" placeholder="Viết phản hồi của bạn..." style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;"></textarea>
                            <button class="btn btn-sm btn-primary mt-2" onclick="window.submitReply(${review.id})" style="margin-top: 5px; padding: 5px 10px; background: #059669; color: white; border: none; border-radius: 4px; cursor: pointer;">Gửi trả lời</button>
                        </div>

                        ${review.replies && review.replies.length > 0 ? review.replies.map(reply => {
                    const isReplyOwner = memberId && (parseInt(reply.member_id) === parseInt(memberId));
                    return `
                            <div class="reply-box" style="margin-left: 20px; border-left: 2px solid #ddd; padding-left: 10px; margin-top: 10px; background: #f9fafb; padding: 10px; border-radius: 4px;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                                    <div>
                                        <div class="reply-author" style="font-weight: 600; font-size: 0.9rem;">${escapeHtml(reply.name)}</div>
                                        <div class="reply-date" style="font-size: 0.8rem; color: #6b7280;">${reply.date}</div>
                                    </div>
                                    ${isReplyOwner ? `<button onclick="window.deleteReply(${reply.id})" style="border:none; background:none; color:red; cursor:pointer;" title="Xóa phản hồi"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg></button>` : ''}
                                </div>
                                <p class="reply-content" style="margin-top: 5px; font-size: 0.95rem; color: #374151;">${escapeHtml(reply.comment)}</p>
                            </div>
                        `}).join('') : ''}
                    </div>
                `;
            });

            if (reviewsListEl) {
                reviewsListEl.innerHTML = html || '<p style="text-align: center; color: #9ca3af; padding: 2rem;">Chưa có đánh giá nào.</p>';
            }

            // Pagination - placeholder for now (hidden in original too)
            const paginationEl = document.getElementById('pagination');
            if (paginationEl) paginationEl.innerHTML = '';
        }

        // Filter buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                filterRating = this.dataset.filter === 'all' ? null : parseInt(this.dataset.filter);
                currentPage = 1;
                fetchReviews();
            });
        });

        // Sort select
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                sortBy = this.value;
                currentPage = 1;
                fetchReviews();
            });
        }

        // Star rating input
        const starBtns = document.querySelectorAll('#starRatingInput button');
        const starSvgs = document.querySelectorAll('#starRatingInput svg');

        if (starBtns.length > 0) {
            starBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    selectedRating = parseInt(this.dataset.star);
                    starSvgs.forEach((svg, idx) => {
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

                btn.addEventListener('mouseenter', function () {
                    const star = parseInt(this.dataset.star);
                    starSvgs.forEach((svg, idx) => {
                        if (idx < star) {
                            svg.style.fill = '#fbbf24';
                            svg.style.color = '#fbbf24';
                        }
                    });
                });

                btn.addEventListener('mouseleave', function () {
                    starSvgs.forEach((svg, idx) => {
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
        }

        // Image upload
        const imageInput = document.getElementById('imageInput');
        if (imageInput) {
            imageInput.addEventListener('change', function (e) {
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
        }

        function renderUploadedImages() {
            const container = document.getElementById('uploadedImages');
            const uploadArea = document.getElementById('imageUploadArea');
            if (!container) return;

            container.innerHTML = uploadedImages.map((img, idx) => `
                <div class="uploaded-image-wrapper">
                    <img src="${img}" alt="Upload ${idx + 1}">
                    <button type="button" class="remove-image-btn" onclick="window.removeImage(${idx})">×</button>
                </div>
            `).join('');

            if (uploadArea) {
                uploadArea.style.display = uploadedImages.length >= 3 ? 'none' : 'flex';
            }
        }

        // Form validation
        function updateSubmitButton() {
            const nameEl = document.getElementById('reviewName');
            const commentEl = document.getElementById('reviewComment');
            const submitBtn = document.getElementById('submitBtn');

            if (!nameEl || !commentEl || !submitBtn) return;

            const name = nameEl.value.trim();
            const comment = commentEl.value.trim();
            submitBtn.disabled = !(selectedRating > 0 && name && comment);
        }

        const reviewNameInput = document.getElementById('reviewName');
        const reviewCommentInput = document.getElementById('reviewComment');

        if (reviewNameInput) reviewNameInput.addEventListener('input', updateSubmitButton);
        if (reviewCommentInput) reviewCommentInput.addEventListener('input', updateSubmitButton);

        // Form submit
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const nameEl = document.getElementById('reviewName');
                const commentEl = document.getElementById('reviewComment');

                if (!nameEl || !commentEl) return;

                const name = nameEl.value.trim();
                const comment = commentEl.value.trim();

                if (selectedRating > 0 && name && comment) {
                    try {
                        const response = await fetch(apiSubmitUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                name: name,
                                rating: selectedRating,
                                comment: comment,
                                images: uploadedImages
                            })
                        });

                        // const data = await response.json(); // Unused for now

                        if (response.ok) {
                            // Show success state
                            reviewForm.style.display = 'none';
                            const successEl = document.getElementById('submitSuccess');
                            if (successEl) successEl.style.display = 'block';

                            // Reset form after 3 seconds
                            setTimeout(() => {
                                reviewForm.style.display = 'block';
                                if (successEl) successEl.style.display = 'none';

                                // Re-fill if logged in
                                nameEl.value = memberName;
                                commentEl.value = '';
                                selectedRating = 0;
                                uploadedImages = [];

                                const starSvgs = document.querySelectorAll('#starRatingInput svg');
                                starSvgs.forEach(svg => {
                                    svg.style.fill = 'none';
                                    svg.style.color = '#d1d5db';
                                });
                                renderUploadedImages();
                                updateSubmitButton();
                            }, 3000);

                            // Refresh reviews list
                            fetchReviews();
                        } else {
                            const errorData = await response.json();
                            console.error('Submission error:', errorData);
                            let msg = 'Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại!';
                            if (errorData.message) msg += '\n' + errorData.message;
                            if (errorData.errors) {
                                msg += '\n' + JSON.stringify(errorData.errors);
                            }
                            alert(msg);
                        }
                    } catch (error) {
                        console.error('Failed to submit review:', error);
                        alert('Có lỗi xảy ra khi gửi đánh giá. Vui lòng thử lại!');
                    }
                }
            });
        }

        // Initialize: Auto-fill member name if logged in
        if (memberName) {
            const nameField = document.getElementById('reviewName');
            if (nameField) {
                nameField.value = memberName;
            }
            updateSubmitButton();
        }

        // Initial fetch from API
        fetchReviews();
    }
})();
