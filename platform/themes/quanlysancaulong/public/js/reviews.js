/******/ (() => { // webpackBootstrap
/*!***************************************************************!*\
  !*** ./platform/themes/quanlysancaulong/assets/js/reviews.js ***!
  \***************************************************************/
(function () {
  'use strict';

  var page = document.querySelector('.reviews-page');
  if (!page) return;
  var API_URL = page.dataset.apiReviews;
  var API_SUBMIT = page.dataset.apiSubmit;
  var CSRF = page.dataset.csrfToken;
  var MEMBER_NAME = page.dataset.memberName || '';
  var MEMBER_ID = page.dataset.memberId || null;
  var currentFilter = 'all';
  var currentSort = 'newest';
  var currentPage = 1;
  var uploadedImages = [];

  // ── Init ──
  document.addEventListener('DOMContentLoaded', function () {
    loadReviews();
    initStarRating();
    initFilters();
    initSort();
    initImageUpload();
    initForm();
  });

  // ── Load reviews from API ──
  function loadReviews() {
    var url = API_URL + '?page=' + currentPage + '&sort=' + currentSort;
    if (currentFilter !== 'all') url += '&rating=' + currentFilter;
    fetch(url, {
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (r) {
      return r.json();
    }).then(function (data) {
      renderStats(data.stats);
      renderReviews(data.reviews);
      renderPagination(data.pagination);
      var el = document.getElementById('filteredCount');
      if (el) el.textContent = data.pagination.total;
    })["catch"](function (err) {
      console.error('Error loading reviews:', err);
    });
  }

  // ── Render Stats ──
  function renderStats(stats) {
    var avg = document.getElementById('averageRating');
    if (avg) avg.textContent = stats.average_rating;
    var total = document.getElementById('totalReviews');
    if (total) total.textContent = stats.total_reviews;

    // Stars
    var starsEl = document.getElementById('averageStars');
    if (starsEl) {
      starsEl.innerHTML = '';
      var full = Math.round(stats.average_rating);
      for (var i = 1; i <= 5; i++) {
        var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('width', '24');
        svg.setAttribute('height', '24');
        svg.setAttribute('viewBox', '0 0 24 24');
        svg.setAttribute('stroke', 'currentColor');
        svg.setAttribute('stroke-width', '2');
        var poly = document.createElementNS('http://www.w3.org/2000/svg', 'polygon');
        poly.setAttribute('points', '12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2');
        if (i <= full) {
          svg.setAttribute('fill', '#fbbf24');
          svg.style.color = '#fbbf24';
        } else {
          svg.setAttribute('fill', 'none');
          svg.style.color = '#d1d5db';
        }
        svg.appendChild(poly);
        starsEl.appendChild(svg);
      }
    }

    // Rating bars
    var bars = document.querySelectorAll('.rating-bar');
    bars.forEach(function (bar, idx) {
      var star = 5 - idx;
      var count = stats.rating_counts[star] || 0;
      var pct = stats.total_reviews > 0 ? Math.round(count / stats.total_reviews * 100) : 0;
      var fill = bar.querySelector('.rating-bar-fill');
      var label = bar.querySelector('.rating-bar-percent');
      if (fill) fill.style.width = pct + '%';
      if (label) label.textContent = pct + '%';
    });
  }

  // ── Render Reviews ──
  function renderReviews(reviews) {
    var list = document.getElementById('reviewsList');
    if (!list) return;
    if (!reviews || reviews.length === 0) {
      list.innerHTML = '<div style="text-align:center;padding:3rem;color:#9ca3af;">' + '<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 1rem;display:block;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>' + '<p style="font-weight:600;">Chưa có đánh giá nào</p>' + '<p>Hãy là người đầu tiên chia sẻ trải nghiệm!</p></div>';
      return;
    }
    var html = '';
    reviews.forEach(function (review) {
      html += renderReviewCard(review);
    });
    list.innerHTML = html;

    // Attach event listeners
    list.querySelectorAll('.btn-helpful').forEach(function (btn) {
      btn.addEventListener('click', function () {
        handleHelpful(this.dataset.id, this);
      });
    });
    list.querySelectorAll('.btn-reply-toggle').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var box = document.getElementById('replyBox-' + this.dataset.id);
        if (box) box.style.display = box.style.display === 'none' ? 'block' : 'none';
      });
    });
    list.querySelectorAll('.reply-form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        handleReply(this);
      });
    });
    list.querySelectorAll('.btn-delete-review').forEach(function (btn) {
      btn.addEventListener('click', function () {
        handleDeleteReview(this.dataset.id);
      });
    });
    list.querySelectorAll('.btn-delete-reply').forEach(function (btn) {
      btn.addEventListener('click', function () {
        handleDeleteReply(this.dataset.id);
      });
    });
  }
  function renderReviewCard(review) {
    var stars = '';
    for (var i = 1; i <= 5; i++) {
      var fill = i <= review.rating ? '#fbbf24' : 'none';
      var color = i <= review.rating ? '#fbbf24' : '#d1d5db';
      stars += '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="' + fill + '" stroke="' + color + '" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
    }
    var images = '';
    if (review.images && review.images.length > 0) {
      images = '<div class="review-images">';
      review.images.forEach(function (img) {
        if (img && !img.startsWith('blob:')) {
          images += '<img src="' + img + '" alt="Review image" loading="lazy">';
        }
      });
      images += '</div>';
    }
    var replies = '';
    if (review.replies && review.replies.length > 0) {
      review.replies.forEach(function (reply) {
        var deleteReplyBtn = '';
        if (MEMBER_ID && reply.member_id == MEMBER_ID) {
          deleteReplyBtn = '<button class="btn-delete-reply review-action-btn" data-id="' + reply.id + '" style="color:#ef4444;margin-left:auto;font-size:0.75rem;">Xóa</button>';
        }
        var isAdmin = !reply.member_id;
        var adminBadge = isAdmin ? ' <span style="background:#059669;color:white;font-size:0.7rem;padding:0.1rem 0.4rem;border-radius:4px;font-weight:600;">Quản trị viên</span>' : '';
        var replyBg = isAdmin ? 'background:#ecfdf5;border-left:3px solid #059669;' : '';
        replies += '<div class="reply-box" style="' + replyBg + '">' + '<div style="display:flex;align-items:center;gap:0.5rem;">' + '<span class="reply-author">' + escapeHtml(reply.name) + '</span>' + adminBadge + '<span class="reply-date">' + reply.date + '</span>' + deleteReplyBtn + '</div>' + '<p class="reply-content" style="white-space:pre-wrap;">' + escapeHtml(reply.comment) + '</p>' + '</div>';
      });
    }
    var replyForm = '';
    if (MEMBER_ID) {
      replyForm = '<div id="replyBox-' + review.id + '" style="display:none;margin-top:0.75rem;">' + '<form class="reply-form" data-review-id="' + review.id + '">' + '<div style="display:flex;gap:0.5rem;">' + '<input type="text" class="form-input reply-input" placeholder="Viết phản hồi..." required style="flex:1;">' + '<button type="submit" style="padding:0.5rem 1rem;background:#065f46;color:white;border:none;border-radius:0.5rem;cursor:pointer;white-space:nowrap;">Gửi</button>' + '</div></form></div>';
    }
    var deleteBtn = '';
    if (MEMBER_ID && review.member_id == MEMBER_ID) {
      deleteBtn = '<button class="btn-delete-review review-action-btn" data-id="' + review.id + '" style="position:absolute;top:1rem;right:1rem;color:#ef4444;">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>' + 'Xóa</button>';
    }
    return '<div class="review-card" style="position:relative;">' + deleteBtn + '<div class="review-header">' + '<div>' + '<div class="review-author">' + escapeHtml(review.name) + '</div>' + '<div class="review-date">' + review.date + '</div>' + '</div>' + '</div>' + '<div class="review-stars">' + stars + '</div>' + '<div class="review-content">' + escapeHtml(review.comment) + '</div>' + images + '<div class="review-actions">' + '<button class="review-action-btn btn-helpful ' + (review.is_voted ? 'active' : '') + '" data-id="' + review.id + '">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="' + (review.is_voted ? '#059669' : 'none') + '" stroke="currentColor" stroke-width="2"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>' + '<span>Hữu ích (' + (review.helpful || 0) + ')</span>' + '</button>' + (MEMBER_ID ? '<button class="review-action-btn btn-reply-toggle" data-id="' + review.id + '"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>Trả lời</button>' : '') + '</div>' + replies + replyForm + '</div>';
  }

  // ── Pagination ──
  function renderPagination(pag) {
    var el = document.getElementById('pagination');
    if (!el || pag.last_page <= 1) {
      if (el) el.innerHTML = '';
      return;
    }
    var html = '<button class="pagination-btn" ' + (pag.current_page <= 1 ? 'disabled' : '') + ' data-page="' + (pag.current_page - 1) + '">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>';
    for (var i = 1; i <= pag.last_page; i++) {
      html += '<button class="pagination-page ' + (i === pag.current_page ? 'active' : '') + '" data-page="' + i + '">' + i + '</button>';
    }
    html += '<button class="pagination-btn" ' + (pag.current_page >= pag.last_page ? 'disabled' : '') + ' data-page="' + (pag.current_page + 1) + '">' + '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>';
    el.innerHTML = html;
    el.querySelectorAll('[data-page]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (this.disabled) return;
        currentPage = parseInt(this.dataset.page);
        loadReviews();
        window.scrollTo({
          top: document.getElementById('reviewsList').offsetTop - 100,
          behavior: 'smooth'
        });
      });
    });
  }

  // ── Star Rating Input ──
  function initStarRating() {
    var container = document.getElementById('starRatingInput');
    if (!container) return;
    var selectedRating = 0;
    container.querySelectorAll('button').forEach(function (btn) {
      btn.addEventListener('click', function () {
        selectedRating = parseInt(this.dataset.star);
        container.dataset.rating = selectedRating;
        updateStarDisplay(container, selectedRating);
        checkFormValid();
      });
      btn.addEventListener('mouseenter', function () {
        updateStarDisplay(container, parseInt(this.dataset.star));
      });
      btn.addEventListener('mouseleave', function () {
        updateStarDisplay(container, parseInt(container.dataset.rating || 0));
      });
    });
  }
  function updateStarDisplay(container, rating) {
    container.querySelectorAll('svg').forEach(function (svg, idx) {
      if (idx < rating) {
        svg.classList.add('filled');
        svg.setAttribute('fill', '#fbbf24');
        svg.style.color = '#fbbf24';
      } else {
        svg.classList.remove('filled');
        svg.setAttribute('fill', 'none');
        svg.style.color = '#d1d5db';
      }
    });
  }

  // ── Filters ──
  function initFilters() {
    var container = document.getElementById('filterButtons');
    if (!container) return;
    container.querySelectorAll('.filter-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        container.querySelectorAll('.filter-btn').forEach(function (b) {
          b.classList.remove('active');
        });
        this.classList.add('active');
        currentFilter = this.dataset.filter;
        currentPage = 1;
        loadReviews();
      });
    });
  }

  // ── Sort ──
  function initSort() {
    var select = document.getElementById('sortSelect');
    if (!select) return;
    select.addEventListener('change', function () {
      currentSort = this.value;
      currentPage = 1;
      loadReviews();
    });
  }

  // ── Image Upload ──
  function initImageUpload() {
    var input = document.getElementById('imageInput');
    if (!input) return;
    input.addEventListener('change', function () {
      var files = Array.from(this.files);
      var remaining = 3 - uploadedImages.length;
      files.slice(0, remaining).forEach(function (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
          uploadedImages.push(e.target.result);
          renderUploadedImages();
        };
        reader.readAsDataURL(file);
      });
      input.value = '';
    });
  }
  function renderUploadedImages() {
    var container = document.getElementById('uploadedImages');
    var uploadArea = document.getElementById('imageUploadArea');
    if (!container) return;
    container.innerHTML = '';
    uploadedImages.forEach(function (src, idx) {
      var wrapper = document.createElement('div');
      wrapper.className = 'uploaded-image-wrapper';
      wrapper.innerHTML = '<img src="' + src + '" alt="Upload">' + '<button type="button" class="remove-image-btn" data-idx="' + idx + '">×</button>';
      container.appendChild(wrapper);
    });

    // Remove handlers
    container.querySelectorAll('.remove-image-btn').forEach(function (btn) {
      btn.addEventListener('click', function () {
        uploadedImages.splice(parseInt(this.dataset.idx), 1);
        renderUploadedImages();
      });
    });
    if (uploadArea) {
      uploadArea.style.display = uploadedImages.length >= 3 ? 'none' : '';
    }
  }

  // ── Form ──
  function initForm() {
    var form = document.getElementById('reviewForm');
    if (!form) return;
    var nameInput = document.getElementById('reviewName');
    var commentInput = document.getElementById('reviewComment');
    if (nameInput) nameInput.addEventListener('input', checkFormValid);
    if (commentInput) commentInput.addEventListener('input', checkFormValid);
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      submitReview();
    });
  }
  function checkFormValid() {
    var btn = document.getElementById('submitBtn');
    var name = document.getElementById('reviewName');
    var comment = document.getElementById('reviewComment');
    var stars = document.getElementById('starRatingInput');
    if (!btn) return;
    var rating = parseInt(stars ? stars.dataset.rating || 0 : 0);
    var valid = rating > 0 && name && name.value.trim() && comment && comment.value.trim();
    btn.disabled = !valid;
  }
  function submitReview() {
    var btn = document.getElementById('submitBtn');
    var name = document.getElementById('reviewName');
    var comment = document.getElementById('reviewComment');
    var stars = document.getElementById('starRatingInput');
    var rating = parseInt(stars ? stars.dataset.rating || 0 : 0);
    if (!rating || !name.value.trim() || !comment.value.trim()) return;
    btn.disabled = true;
    btn.textContent = 'Đang gửi...';
    var body = {
      name: name.value.trim(),
      rating: rating,
      comment: comment.value.trim(),
      images: uploadedImages.length > 0 ? uploadedImages : []
    };
    fetch(API_SUBMIT, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(body)
    }).then(function (r) {
      return r.json();
    }).then(function (data) {
      if (data.review_id || data.message) {
        // Success
        document.getElementById('reviewForm').style.display = 'none';
        document.getElementById('submitSuccess').style.display = 'block';
        uploadedImages = [];
        currentPage = 1;
        loadReviews();
        setTimeout(function () {
          document.getElementById('reviewForm').style.display = 'block';
          document.getElementById('submitSuccess').style.display = 'none';
          document.getElementById('reviewComment').value = '';
          updateStarDisplay(stars, 0);
          stars.dataset.rating = 0;
          renderUploadedImages();
          btn.textContent = 'Gửi Đánh Giá';
          btn.disabled = true;
        }, 3000);
      }
    })["catch"](function (err) {
      console.error('Submit error:', err);
      alert('Có lỗi xảy ra, vui lòng thử lại!');
      btn.disabled = false;
      btn.textContent = 'Gửi Đánh Giá';
    });
  }

  // ── Helpful ──
  function handleHelpful(id, btn) {
    fetch('/api/reviews/' + id + '/helpful', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (r) {
      return r.json();
    }).then(function (data) {
      var count = btn.querySelector('span');
      if (count) count.textContent = 'Hữu ích (' + data.helpful + ')';
      if (data.voted) {
        btn.classList.add('active');
        btn.querySelector('svg').setAttribute('fill', '#059669');
      } else {
        btn.classList.remove('active');
        btn.querySelector('svg').setAttribute('fill', 'none');
      }
    });
  }

  // ── Reply ──
  function handleReply(form) {
    var reviewId = form.dataset.reviewId;
    var input = form.querySelector('.reply-input');
    if (!input || !input.value.trim()) return;
    fetch(API_SUBMIT, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify({
        name: MEMBER_NAME || 'Ẩn danh',
        comment: input.value.trim(),
        parent_id: reviewId
      })
    }).then(function (r) {
      return r.json();
    }).then(function () {
      loadReviews();
    });
  }

  // ── Delete Review ──
  function handleDeleteReview(id) {
    if (!confirm('Bạn có chắc muốn xóa đánh giá này?')) return;
    fetch('/api/reviews/' + id, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (r) {
      return r.json();
    }).then(function () {
      loadReviews();
    });
  }

  // ── Delete Reply ──
  function handleDeleteReply(id) {
    if (!confirm('Bạn có chắc muốn xóa phản hồi này?')) return;
    fetch('/api/reviews/replies/' + id, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (r) {
      return r.json();
    }).then(function () {
      loadReviews();
    });
  }

  // ── Helpers ──
  function escapeHtml(str) {
    if (!str) return '';
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }
})();
/******/ })()
;