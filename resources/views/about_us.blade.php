@extends('layouts.app')

@section('title', 'About Us - Our Bakery')

@section('content')
    <style>
        section {
            color: rgb(245, 245, 245);/* latar gelap agar teks terlihat jelas */
        }
        .section-title {
            color: rgb(254, 198, 228);
            margin-bottom: 1rem;
        }
        ul.custom-list {
            list-style: none;
            padding-left: 0;
        }
        ul.custom-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 8px;
        }
        ul.custom-list li::before {
            content: ">";
            color: rgb(245, 245, 245);
            position: absolute;
            left: 0;
            top: 0;
        }
        a, h5 {
            color: rgb(254, 198, 228);
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section text-center py-5">
        <div class="container">
            <h1 class="display-4 section-title">Welcome to Our Bakery</h1>
            <p>Freshly baked goodness every day, made with love and passion.</p>
        </div>
    </section>

    <!-- Our Story / History -->
    <section class="history-section py-5">
        <div class="container">
            <h2 class="section-title">Our Story</h2>
            <p>
                Founded in 1995, Our Bakery began as a small family business dedicated to crafting delicious breads and pastries using traditional recipes. Over the years, we have grown while maintaining our commitment to quality and freshness, becoming a beloved part of the community.
            </p>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission-vision-section py-5">
        <div class="container">
            <h2 class="section-title">Our Mission & Vision</h2>
            <p>
                Our mission is to bring joy and comfort to every table through freshly baked goods made from the finest ingredients. We envision becoming the community’s favorite bakery, known for quality, care, and consistency.
            </p>
        </div>
    </section>

    <!-- Our Values -->
    <section class="values-section py-5">
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <ul class="custom-list">
                <li>Quality Ingredients: We use only the finest, natural ingredients.</li>
                <li>Freshness: All products are baked daily to ensure the best taste.</li>
                <li>Customer Happiness: Your satisfaction is our top priority.</li>
                <li>Integrity: Honest and transparent in every process.</li>
            </ul>
        </div>
    </section>

    <!-- Meet The Team -->
    <section class="team-section py-5">
        <div class="container">
            <h2 class="section-title">Meet The Team</h2>
            <div class="row">
                <div class="col-md-4">
                    <h5>John Doe - Head Baker</h5>
                    <p>With over 20 years of experience, John crafts every loaf with passion and precision.</p>
                </div>
                <div class="col-md-4">
                    <h5>Jane Smith - Pastry Chef</h5>
                    <p>Jane blends creativity and tradition to produce delightful pastries.</p>
                </div>
                <div class="col-md-4">
                    <h5>Emily Johnson - Customer Service</h5>
                    <p>Emily ensures every customer feels welcomed and valued.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us-section py-5">
        <div class="container">
            <h2 class="section-title">Why Choose Us</h2>
            <ul class="custom-list">
                <li>Authentic recipes passed down through generations.</li>
                <li>Commitment to quality and freshness in every product.</li>
                <li>Friendly and personalized customer service.</li>
                <li>Community-focused bakery with heart.</li>
            </ul>
        </div>
    </section>

    <!-- Customer Testimonials -->
    <section class="testimonials-section py-5">
        <div class="container">
            <h2 class="section-title">Customer Testimonials</h2>
            <p>
                "The best bakery in town! Their bread is always fresh and delicious." – Sarah L.<br>
                "Friendly staff and amazing pastries. Highly recommend!" – Michael T.
            </p>
        </div>
    </section>

    <!-- Contact Information -->
    <section class="contact-section py-5">
        <div class="container">
            <h2 class="section-title">Contact Us</h2>
            <p>Have questions or want to place an order? Reach out to us!</p>
            <ul class="custom-list">
                <li>Email: info@ourbakery.com</li>
                <li>Phone: +62 812 3456 7890</li>
                <li>Address: Jl. Bakery No. 123, Jakarta</li>
            </ul>
        </div>
    </section>
@endsection
