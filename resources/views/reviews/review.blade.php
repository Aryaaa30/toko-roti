@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews - Black & Pink Theme</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #0a0a0a;
            color: #ffffff;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #1a1a1a;
            border-radius: 20px;
            padding: 40px;
            border: 1px solid #333;
        }

        .main-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* Left Section - Rating Overview */
        .rating-section {
            display: flex;
            flex-direction: column;
            gap: 40px;
        }

        .overall-rating {
            text-align: center;
            margin-bottom: 30px;
        }

        .rating-score {
            font-size: 4rem;
            font-weight: 700;
            color: #fbbf24;
            margin-bottom: 10px;
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .star {
            font-size: 24px;
            color: #fbbf24;
        }

        .rating-count {
            color: #888;
            font-size: 16px;
        }

        .rating-breakdown {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .rating-row {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .rating-label {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 80px;
            font-weight: 600;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 14px;
        }

        .rating-label .star {
            font-size: 16px;
            color: #fbbf24;
        }

        .progress-bar {
            flex: 1;
            height: 8px;
            background-color: #333;
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background-color: #fbbf24;
            border-radius: 4px;
            transition: width 0.8s ease;
        }



        .rating-count-number {
            min-width: 50px;
            text-align: right;
            color: #888;
            font-weight: 600;
        }

        /* Recent Feedbacks */
        .recent-feedbacks {
            margin-top: 40px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 25px;
        }

        .feedback-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feedback-item {
            display: flex;
            gap: 15px;
            padding: 20px;
            background-color: #262626;
            border-radius: 12px;
            border: 1px solid #333;
            transition: all 0.3s ease;
        }

        .feedback-item:hover {
            border-color: rgb(254, 198, 228);
            transform: translateY(-2px);
        }

        .feedback-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #333;
        }

        .feedback-content {
            flex: 1;
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .feedback-name {
            font-weight: 600;
            color: #ffffff;
            font-size: 16px;
        }

        .feedback-rating {
            display: flex;
            gap: 2px;
        }

        .feedback-rating .star {
            font-size: 14px;
            color: #fbbf24;
        }

        .feedback-rating .star.empty {
            color: #444;
        }

        .feedback-text {
            color: #cccccc;
            line-height: 1.5;
            font-size: 14px;
        }

        /* Right Section - Add Review Form */
        .add-review-section {
            background-color: #262626;
            border-radius: 16px;
            padding: 30px;
            border: 1px solid #333;
            height: fit-content;
        }

        .form-title {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 10px;
            text-align: center;
        }

        .product-name {
            font-size: 18px;
            font-weight: 500;
            color: #fbbf24;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #cccccc;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .required {
            color: #ef4444;
        }

        .star-rating {
            display: flex;
            gap: 5px;
            margin-bottom: 5px;
        }

        .star-rating .star {
            font-size: 24px;
            color: #444;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .star-rating .star:hover,
        .star-rating .star.active {
            color: #fbbf24;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background-color: #1a1a1a;
            border: 1px solid #444;
            border-radius: 8px;
            color: #ffffff;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: rgb(254, 198, 228);
        }

        .form-input::placeholder {
            color: #666;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
            font-family: inherit;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #fbbf24;
            color: #000;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .submit-btn:hover {
            background-color: #f59e0b;
            transform: translateY(-2px);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Bottom Link */
        .bottom-link {
            position: fixed;
            bottom: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .bottom-link:hover {
            color: rgb(254, 198, 228);
        }

        .jelajahi-link {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #888;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .jelajahi-link:hover {
            color: rgb(254, 198, 228);
        }

        /* Alert Styles */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border-color: rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            .main-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            
            .rating-score {
                font-size: 3rem;
            }
        }

        /* Loading Animation for Progress Bars */
        @keyframes progressLoad {
            from {
                width: 0;
            }
            to {
                width: var(--target-width);
            }
        }

        .no-reviews {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }

        .no-reviews h3 {
            margin-bottom: 15px;
            color: #ffffff;
            font-size: 24px;
        }

        .btn-primary {
            background-color: rgb(254, 198, 228);
            color: #000;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: rgba(254, 198, 228, 0.8);
            transform: translateY(-2px);
        }
        
        /* Review Images */
        .feedback-images {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .feedback-images img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #333;
            transition: all 0.3s ease;
        }
        
        .feedback-images img:hover {
            transform: scale(1.05);
            border-color: rgb(254, 198, 228);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .feedback-images a {
            display: block;
            position: relative;
        }
        
        .feedback-images a::after {
            content: '🔍';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            font-size: 20px;
        }
        
        .feedback-images a:hover::after {
            opacity: 1;
        }

        /* Back Button */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #fbbf24;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            padding: 10px 16px;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            background-color: transparent;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: #fbbf24;
            color: #000;
            transform: translateX(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back Button -->
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('orders.index') }}" class="back-btn">
                <span>←</span> Kembali
            </a>
            <div style="color: #fbbf24; font-size: 18px; font-weight: bold;">
                Review untuk: {{ $menu->name ?? 'Menu tidak tersedia' }}
            </div>
        </div>
        
        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        
        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
        @endif

        <!-- Main Content -->
        <div class="main-content">
            <!-- Left Section - Rating Overview -->
            <div class="rating-section">
                <!-- Overall Rating -->
                @php
                    // Reviews sudah difilter di controller, jadi tidak perlu filter lagi
                    $totalReviews = $reviews->count();
                    $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;
                    $ratingCounts = [
                        5 => $reviews->where('rating', 5)->count(),
                        4 => $reviews->where('rating', 4)->count(),
                        3 => $reviews->where('rating', 3)->count(),
                        2 => $reviews->where('rating', 2)->count(),
                        1 => $reviews->where('rating', 1)->count(),
                    ];
                @endphp
                
                <div class="overall-rating">
                    <div class="rating-score">{{ $totalReviews > 0 ? number_format($averageRating, 1) : '0.0' }}</div>
                    <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star {{ $i <= round($averageRating) ? '' : 'empty' }}">★</span>
                        @endfor
                    </div>
                    <div class="rating-count">{{ $totalReviews }} {{ $totalReviews == 1 ? 'Rating' : 'Ratings' }}</div>
                </div>

                <!-- Rating Breakdown -->
                <div class="rating-breakdown">
                    @foreach([5, 4, 3, 2, 1] as $rating)
                    @php
                        $count = $ratingCounts[$rating];
                        $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                        $ratingText = ['ONE', 'TWO', 'THREE', 'FOUR', 'FIVE'][$rating - 1];
                    @endphp
                    <div class="rating-row">
                        <div class="rating-label">
                            <span>{{ $ratingText }}</span>
                            <span class="star">★</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                        </div>
                        <div class="rating-count-number">{{ $count }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Recent Feedbacks -->
                <div class="recent-feedbacks">
                    <h2 class="section-title">Recent Feedbacks</h2>
                    <div class="feedback-list">
                        @php
                            // Gunakan $reviews yang sudah difilter di controller
                            $allRecentReviews = $reviews->take(5);
                        @endphp
                        
                        @forelse($allRecentReviews as $review)
                        <div class="feedback-item">
                            <img src="{{ $review->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=333&color=fff' }}" 
                                 alt="{{ $review->user->name }}" class="feedback-avatar">
                            <div class="feedback-content">
                                <div class="feedback-header">
                                    <div class="feedback-name">{{ $review->user->name }}</div>
                                    <div class="feedback-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="star {{ $i <= $review->rating ? '' : 'empty' }}">★</span>
                                        @endfor
                                    </div>
                                </div>
                                <div style="margin-bottom: 5px; font-size: 12px; color: rgb(254, 198, 228);">
                                    <a href="{{ route('menus.show', $review->menu_id) }}" style="color: rgb(254, 198, 228); text-decoration: none;">
                                        {{ $review->menu->name ?? 'Menu tidak tersedia' }}
                                    </a>
                                    <span style="color: #888; margin-left: 10px;">{{ $review->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="feedback-text">
                                    {{ $review->comment }}
                                </div>
                                
                                @if(!empty($review->images))
                                <div class="feedback-images" style="margin-top: 15px; display: flex; flex-wrap: wrap; gap: 10px;">
                                    @foreach($review->images as $image)
                                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="review-image-link" onclick="event.preventDefault(); openImageModal('{{ asset('storage/' . $image) }}')">
                                        <img src="{{ asset('storage/' . $image) }}" alt="Review Image" class="review-image" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #333; transition: all 0.3s ease;">
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="feedback-item">
                            <div class="feedback-content" style="text-align: center; color: #888;">
                                <p>Belum ada review yang tersedia.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Section - Add Review Form -->
            <div class="add-review-section">
                <h2 class="form-title">Add a Review</h2>
                <p style="text-align: center; color: #888; margin-bottom: 15px; font-size: 14px;">
                    Anda hanya dapat memberikan review untuk produk yang sudah dikonfirmasi dan pembayaran berhasil.
                </p>
                
                @php
                    // Cek apakah user sudah beli menu ini dan pembayaran berhasil
                    // Dapatkan order yang valid untuk review
                    $validOrder = \App\Models\Order::where('user_id', auth()->id())
                        ->where('payment_status', 'success')
                        ->whereHas('items', function ($query) use ($menu) {
                            $query->where('menu_id', $menu->id ?? 1);
                        })
                        ->orderBy('created_at', 'desc')
                        ->first();
                    
                    $canReview = $validOrder !== null;
                @endphp
                
                @if($canReview)
                <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id ?? 1 }}">
                    <input type="hidden" name="rating" id="ratingInput" value="">
                    <input type="hidden" name="redirect_to_review" value="1">
                    <input type="hidden" name="order_id" value="{{ $validOrder->id }}">
                    
                    <div class="form-group">
                        <label class="form-label">Add Your Rating <span class="required">*</span></label>
                        <div class="star-rating" id="starRating">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                        </div>
                    </div>

                    <!-- User info (read-only) -->
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-input" value="{{ auth()->user()->name }}" readonly style="background-color: #333; cursor: not-allowed; opacity: 0.7;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-input" value="{{ auth()->user()->email }}" readonly style="background-color: #333; cursor: not-allowed; opacity: 0.7;">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Upload Images (Optional)</label>
                        <input type="file" name="images[]" class="form-input" accept="image/*" style="padding: 8px;" multiple>
                        <small style="color: #888; font-size: 12px; margin-top: 5px; display: block;">Upload foto produk (opsional, bisa lebih dari satu)</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Write Your Review <span class="required">*</span></label>
                        <textarea name="comment" class="form-input form-textarea" placeholder="Write here..." required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Submit</button>
                </form>
                @else
                <div style="text-align: center; padding: 20px; background-color: #333; border-radius: 8px; margin-top: 20px;">
                    <p style="color: #fbbf24; font-weight: 600; margin-bottom: 10px;">Anda belum dapat memberikan review</p>
                    <p style="color: #888; font-size: 14px;">
                        Untuk memberikan review, Anda harus terlebih dahulu membeli produk ini dan menyelesaikan pembayaran.
                    </p>
                    <a href="{{ route('menus.show', $menu->id ?? 1) }}" class="btn-primary" style="margin-top: 15px; display: inline-block;">
                        Lihat Produk
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- No Reviews State (hidden by default) -->
        <div class="no-reviews" style="display: none;">
            <h3>Belum ada review.</h3>
            <p>Belum ada review yang tersedia saat ini.</p>
            <a href="#" class="btn-primary" style="margin-top: 20px;">Lihat Produk</a>
        </div>
    </div>

    <!-- Bottom Links -->
    <a href="#" class="bottom-link">
        <span>↗</span>
        <span>Buka situs</span>
    </a>

    <a href="#" class="jelajahi-link">
        <span>Jelajahi</span>
        <span>⟲</span>
    </a>

    <script>
        // Star Rating Functionality
        const starRating = document.getElementById('starRating');
        const stars = starRating.querySelectorAll('.star');
        let selectedRating = 0;

        stars.forEach((star, index) => {
            star.addEventListener('mouseover', () => {
                highlightStars(index + 1);
            });

            star.addEventListener('mouseout', () => {
                highlightStars(selectedRating);
            });

            star.addEventListener('click', () => {
                selectedRating = index + 1;
                highlightStars(selectedRating);
                document.getElementById('ratingInput').value = selectedRating;
            });
        });

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        // Form Submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            if (selectedRating === 0) {
                e.preventDefault();
                alert('Silakan pilih rating terlebih dahulu!');
                return;
            }
            
            const commentField = document.querySelector('textarea[name="comment"]');
            if (!commentField.value.trim()) {
                e.preventDefault();
                alert('Silakan tulis review Anda!');
                return;
            }
            
            // Set rating value before submit
            document.getElementById('ratingInput').value = selectedRating;
        });

        // Animate progress bars on load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            
            progressBars.forEach((bar, index) => {
                setTimeout(() => {
                    bar.style.transform = 'scaleX(0)';
                    bar.style.transformOrigin = 'left';
                    bar.style.transition = 'transform 0.8s ease';
                    
                    setTimeout(() => {
                        bar.style.transform = 'scaleX(1)';
                    }, 100);
                }, index * 150);
            });
        });

        // Smooth scroll and hover effects
        document.querySelectorAll('.feedback-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 8px 25px rgba(254, 198, 228, 0.1)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
            });
        });

        // Input focus effects
        document.querySelectorAll('.form-input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
        
        // Image preview functionality
        const imageInput = document.querySelector('input[name="images[]"]');
        const previewContainer = document.createElement('div');
        previewContainer.className = 'image-preview-container';
        previewContainer.style.display = 'flex';
        previewContainer.style.flexWrap = 'wrap';
        previewContainer.style.gap = '10px';
        previewContainer.style.marginTop = '10px';
        
        if (imageInput) {
            imageInput.parentNode.insertBefore(previewContainer, imageInput.nextSibling);
            
            imageInput.addEventListener('change', function() {
                // Clear previous previews
                previewContainer.innerHTML = '';
                
                if (this.files) {
                    Array.from(this.files).forEach(file => {
                        if (!file.type.match('image.*')) {
                            return;
                        }
                        
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const previewItem = document.createElement('div');
                            previewItem.style.position = 'relative';
                            previewItem.style.width = '80px';
                            previewItem.style.height = '80px';
                            previewItem.style.marginBottom = '10px';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.width = '100%';
                            img.style.height = '100%';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '8px';
                            img.style.border = '1px solid #333';
                            
                            previewItem.appendChild(img);
                            previewContainer.appendChild(previewItem);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                }
            });
        }
        
        // Auto-scroll to success message if present and reset form
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                // Scroll to success message
                successAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Reset form
                const reviewForm = document.getElementById('reviewForm');
                if (reviewForm) {
                    // Reset text fields
                    reviewForm.querySelector('textarea[name="comment"]').value = '';
                    
                    // Reset star rating
                    selectedRating = 0;
                    highlightStars(0);
                    document.getElementById('ratingInput').value = '';
                    
                    // Reset file input if exists
                    const fileInput = reviewForm.querySelector('input[type="file"]');
                    if (fileInput) {
                        fileInput.value = '';
                        // Clear image previews
                        const previewContainer = document.querySelector('.image-preview-container');
                        if (previewContainer) {
                            previewContainer.innerHTML = '';
                        }
                    }
                }
                
                // Auto-hide success message after 5 seconds
                setTimeout(function() {
                    successAlert.style.transition = 'opacity 1s ease';
                    successAlert.style.opacity = '0';
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 1000);
                }, 5000);
            }
        });
        
        // Image Modal Functions
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            
            modal.style.display = "block";
            modalImg.src = imageSrc;
            
            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }
    </script>
    
    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
        <span class="close-modal" style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
        <img id="modalImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
    </div>
    
    <script>
        // Close modal when clicking the X
        document.querySelector('.close-modal').addEventListener('click', function() {
            document.getElementById('imageModal').style.display = "none";
            document.body.style.overflow = 'auto';
        });
        
        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(event) {
            if (event.target === this) {
                this.style.display = "none";
                document.body.style.overflow = 'auto';
            }
        });
    </script>
</body>
</html>
@endsection