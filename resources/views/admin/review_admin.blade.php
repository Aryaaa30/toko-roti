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
            background-color:rgb(0, 0, 0);
            color: #ffffff;
            line-height: 1.6;
        }

        .container {
            max-width: 1250px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #333;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
        }

        .date-range {
            color: #888;
            font-size: 14px;
        }

        .stats-section {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
            padding: 30px;
            background-color: rgb(18,18,18);
            border-radius: 12px;
            border: 1px solid #333;
        }

        .stat-item {
            flex: 1;
        }

        .stat-label {
            color: #888;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .stat-subtext {
            color: #666;
            font-size: 12px;
        }

        .rating-display {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .stars {
            color: rgb(254, 198, 228);
            font-size: 20px;
        }

        .rating-breakdown {
            margin-top: 15px;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
        }

        .rating-number {
            width: 20px;
            color: #888;
            font-size: 14px;
        }

        .bar-container {
            flex: 1;
            height: 8px;
            background-color: #333;
            border-radius: 4px;
            overflow: hidden;
        }

        .bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .bar-fill.rating-5 {
            background-color: rgb(254, 198, 228);
        }

        .bar-fill.rating-4 {
            background-color: rgb(254, 198, 228);
        }

        .bar-fill.rating-3 {
            background-color: #666;
        }

        .bar-fill.rating-2 {
            background-color: #666;
        }

        .bar-fill.rating-1 {
            background-color: #666;
        }

        .bar-count {
            color: #888;
            font-size: 12px;
            min-width: 30px;
        }

        .reviews-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .review-card {
                  background-color: rgb(18,18,18);
            border: 1px solid #333;
            border-radius: 12px;
            padding: 25px;
            transition: border-color 0.3s ease;
        }

        .review-card:hover {
            border-color: rgb(254, 198, 228);
        }

        .review-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 15px;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #333;
        }

        .reviewer-info {
            flex: 1;
        }

        .reviewer-name {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 3px;
        }

        .reviewer-stats {
            color: #888;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .review-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .review-stars {
            color: rgb(254, 198, 228);
            font-size: 16px;
        }

        .review-date {
            color: #666;
            font-size: 12px;
        }

        .review-content {
            color: #cccccc;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .review-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .action-btn {
            background: none;
            border: none;
            color: #888;
            font-size: 13px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .action-btn:hover {
            color: rgb(254, 198, 228);
        }

        .like-btn {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .view-shop-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: rgb(254, 198, 228);
            color: #000;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .view-shop-btn:hover {
            background-color: rgba(254, 198, 228, 0.8);
            transform: translateY(-2px);
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: rgb(254, 198, 228);
            color: #000;
        }

        .btn-primary:hover {
            background-color: rgba(254, 198, 228, 0.8);
        }

        .btn-warning {
            background-color: #f59e0b;
            color: #fff;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        .btn-danger {
            background-color: #ef4444;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #dc2626;
        }

        .no-reviews {
            text-align: center;
            padding: 60px 20px;
            color: #888;
        }

        .no-reviews h3 {
            margin-bottom: 15px;
            color: #ffffff;
        }
        
        /* Review Images Styling */
        .feedback-images {
            margin-top: 15px;
            margin-bottom: 15px;
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
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .feedback-images a:hover::after {
            opacity: 1;
        }
        
        .review-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #333;
            transition: all 0.3s ease;
        }
        
        .review-image:hover {
            transform: scale(1.05);
            border-color: rgb(254, 198, 228);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        
        .review-image-link {
            display: block;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        
        .product-rating-card {
            background-color: #262626;
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #333;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            transition: border-color 0.3s ease;
        }
        
        .product-rating-card:hover {
            border-color: rgb(254, 198, 228);
        }
        
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid #333;
        }
        
        .product-info {
            flex: 1;
        }
        
        .product-name {
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
        }
        
        .product-rating {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .rating-value {
            color: rgb(254, 198, 228);
            font-size: 16px;
            font-weight: 600;
        }
        
        .rating-stars {
            color: rgb(254, 198, 228);
            font-size: 14px;
        }
        
        .rating-count {
            color: #888;
            font-size: 14px;
        }
        
        .view-reviews-btn {
            background-color: rgb(254, 198, 228);
            color: #000;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        
        .view-reviews-btn:hover {
            background-color: rgba(254, 198, 228, 0.8);
        }

        @media (max-width: 768px) {
            .stats-section {
                flex-direction: column;
                gap: 20px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            /* Review images responsive */
            .feedback-images {
                gap: 8px;
            }
            
            .review-image {
                width: 70px;
                height: 70px;
            }
        }
    </style>
</head>
<body>
    <a href="#" class="view-shop-btn">View Shop</a>
    
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Reviews</h1>
            <div class="date-range">
                {{ now()->startOfMonth()->format('F Y') }} - {{ now()->endOfMonth()->format('F Y') }} 
                <span style="margin-left: 10px; font-size: 12px; opacity: 0.7;">({{ $totalReviews }} reviews)</span>
            </div>
        </div>

        <!-- Alerts (conditional) -->
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

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stat-item">
                <div class="stat-label">Total Reviews</div>
                <div class="stat-value">{{ number_format($totalReviews) }}</div>
                <div class="stat-subtext">{{ $totalReviews > 0 ? 'Total reviews dari pelanggan' : 'Belum ada review' }}</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-label">Average Rating</div>
                <div class="rating-display">
                    <div class="stat-value">{{ $averageRating }}</div>
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($averageRating))
                                ★
                            @elseif($i == ceil($averageRating) && $averageRating - floor($averageRating) >= 0.5)
                                ★
                            @else
                                ☆
                            @endif
                        @endfor
                    </div>
                </div>
                <div class="stat-subtext">{{ $totalReviews > 0 ? 'Rating rata-rata dari semua review' : 'Belum ada rating' }}</div>
            </div>
            
            <div class="stat-item">
                <div class="stat-label">Rating Breakdown</div>
                <div class="rating-breakdown">
                    @foreach([5, 4, 3, 2, 1] as $rating)
                    <div class="rating-bar">
                        <div class="rating-number">{{ $rating }}</div>
                        <div class="bar-container">
                            <div class="bar-fill rating-{{ $rating }}" style="width: {{ $ratingPercentages[$rating] }}%;"></div>
                        </div>
                        <div class="bar-count">{{ $ratingCounts[$rating] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Reviews List Section -->

        <!-- Reviews List -->
        <div class="reviews-list">
            @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <img src="{{ $review->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=333&color=fff' }}" alt="{{ $review->user->name }}" class="reviewer-avatar">
                    <div class="reviewer-info">
                        <div class="reviewer-name">{{ $review->user->name }}</div>
                        <div class="reviewer-stats">Customer ID: {{ $review->user->id }}</div>
                        <div class="review-rating">
                            <div class="review-date">{{ $review->created_at->format('d-m-Y') }}</div>
                        </div>
                    </div>
                    
                    @if($review->menu)
                    <div style="display: flex; align-items: center; gap: 10px; margin-left: auto;">
                        <div style="width: 60px; height: 60px; border-radius: 10px; overflow: hidden; border: 1px solid #333;">
                            @if($review->menu->images)
                                @php
                                    $images = json_decode($review->menu->images);
                                    $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                @endphp
                                @if($firstImage)
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $review->menu->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="width: 100%; height: 100%; background-color: #333; display: flex; align-items: center; justify-content: center; color: #888; font-size: 10px;">No Image</div>
                                @endif
                            @else
                                <div style="width: 100%; height: 100%; background-color: #333; display: flex; align-items: center; justify-content: center; color: #888; font-size: 10px;">No Image</div>
                            @endif
                        </div>
                        
                        <div>
                            <div style="font-weight: 600; color: #fff; margin-bottom: 5px;">
                                <a href="{{ route('menus.show', $review->menu->id) }}" style="color: #fff; text-decoration: none;">
                                    {{ $review->menu->name }}
                                </a>
                            </div>
                            
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <div style="color: rgb(254, 198, 228); font-size: 16px; font-weight: 600;">
                                    {{ number_format($review->rating, 1) }}
                                </div>
                                <div style="color: rgb(254, 198, 228); font-size: 14px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '★' : '☆' }}
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="review-content">
                    {{ $review->comment ?? 'Tidak ada komentar' }}
                </div>
                
                <!-- Review Images -->
                @if($review->images && count($review->images) > 0)
                <div class="feedback-images">
                    @foreach($review->images as $image)
                    <a href="{{ asset('storage/' . $image) }}" target="_blank" class="review-image-link" onclick="event.preventDefault(); openImageModal('{{ asset('storage/' . $image) }}')">
                        <img src="{{ asset('storage/' . $image) }}" alt="Review Image" class="review-image">
                    </a>
                    @endforeach
                </div>
                @endif
                
                <div class="review-actions">
                    <div style="margin-left: auto; display: flex; gap: 15px;">
                        <button class="action-btn">Public Comment</button>
                        <button class="action-btn">Direct Message</button>
                        <button class="action-btn like-btn">
                            <span>♡</span>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="no-reviews">
                <h3>Belum ada review.</h3>
                <p>Belum ada review yang tersedia saat ini.</p>
            </div>
            @endforelse
        </div>


    </div>

    <script>
        // Toggle like button
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const heart = this.querySelector('span');
                heart.textContent = heart.textContent === '♡' ? '♥' : '♡';
                heart.style.color = heart.textContent === '♥' ? 'rgb(254, 198, 228)' : '#888';
            });
        });

        // Smooth hover effects
        document.querySelectorAll('.review-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 8px 25px rgba(254, 198, 228, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });

        // Animate rating bars on load
        window.addEventListener('load', function() {
            const bars = document.querySelectorAll('.bar-fill');
            bars.forEach((bar, index) => {
                const originalWidth = bar.style.width;
                setTimeout(() => {
                    bar.style.opacity = '0';
                    bar.style.width = '0';
                    setTimeout(() => {
                        bar.style.transition = 'all 0.8s ease';
                        bar.style.opacity = '1';
                        bar.style.width = originalWidth;
                    }, 100);
                }, index * 100);
            });
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