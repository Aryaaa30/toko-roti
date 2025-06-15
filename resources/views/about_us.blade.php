@extends('layouts.app')

@section('content')
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background-color: #000;
    color: #f5f5f5;
  }
  
  .hero-section {
    background-image: url('https://images.unsplash.com/photo-1517433367423-c7e5b0f35086?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
    background-size: cover;
    background-position: center;
    height: 60vh;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
  }
  
  .hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 1;
  }
  
  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    padding: 0 20px;
  }
  
  .section {
    padding: 80px 0;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
  }
  
  .section-title {
    font-size: 2.5rem;
    font-weight: 500;
    margin-bottom: 20px;
    color: #fec6e4;
  }
  
  .section-subtitle {
    font-size: 1.1rem;
    font-weight: 300;
    margin-bottom: 40px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding: 40px 0;
  }
  
  .timeline::after {
    content: '';
    position: absolute;
    width: 4px;
    background-color: #fec6e4;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -2px;
  }
  
  .timeline-item {
    position: relative;
    width: 50%;
    padding: 20px 40px;
    box-sizing: border-box;
  }
  
  .timeline-item::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    background-color: #fec6e4;
    border-radius: 50%;
    top: 30px;
    z-index: 1;
  }
  
  .timeline-item:nth-child(odd) {
    left: 0;
    text-align: right;
  }
  
  .timeline-item:nth-child(even) {
    left: 50%;
    text-align: left;
  }
  
  .timeline-item:nth-child(odd)::after {
    right: -10px;
  }
  
  .timeline-item:nth-child(even)::after {
    left: -10px;
  }
  
  .timeline-year {
    font-size: 1.5rem;
    font-weight: 600;
    color: #fec6e4;
    margin-bottom: 10px;
  }
  
  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }
  
  .team-member {
    background-color: #111;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
  }
  
  .team-member:hover {
    transform: translateY(-10px);
  }
  
  .team-photo {
    width: 100%;
    height: 300px;
    object-fit: cover;
  }
  
  .team-info {
    padding: 20px;
  }
  
  .team-name {
    font-size: 1.2rem;
    font-weight: 500;
    margin-bottom: 5px;
    color: #fec6e4;
  }
  
  .team-role {
    font-size: 0.9rem;
    color: #ccc;
    margin-bottom: 15px;
  }
  
  .team-bio {
    font-size: 0.9rem;
    line-height: 1.5;
  }
  
  .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    margin-top: 40px;
  }
  
  .value-card {
    background-color: #111;
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    transition: transform 0.3s ease;
  }
  
  .value-card:hover {
    transform: translateY(-10px);
  }
  
  .value-icon {
    font-size: 3rem;
    margin-bottom: 20px;
    color: #fec6e4;
  }
  
  .value-title {
    font-size: 1.5rem;
    font-weight: 500;
    margin-bottom: 15px;
    color: #fec6e4;
  }
  
  .value-desc {
    font-size: 0.9rem;
    line-height: 1.5;
  }
  
  @media (max-width: 768px) {
    .timeline::after {
      left: 40px;
    }
    
    .timeline-item {
      width: 100%;
      padding-left: 80px;
      padding-right: 20px;
      text-align: left;
    }
    
    .timeline-item:nth-child(odd) {
      left: 0;
      text-align: left;
    }
    
    .timeline-item:nth-child(even) {
      left: 0;
    }
    
    .timeline-item:nth-child(odd)::after {
      left: 30px;
      right: auto;
    }
    
    .timeline-item:nth-child(even)::after {
      left: 30px;
    }
  }
</style>

<!-- Hero Section -->
<section class="hero-section">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1 class="section-title" style="font-size: 3rem; margin-bottom: 20px;">About Bake My Day</h1>
    <p class="section-subtitle" style="font-size: 1.2rem;">Crafting delicious moments with passion and quality since 2009</p>
  </div>
</section>

<!-- Our Story Section -->
<section class="section">
  <div class="container">
    <h2 class="section-title text-center">Our Story</h2>
    <p class="section-subtitle text-center">The journey of Bake My Day from a small home kitchen to becoming one of the most beloved bakeries in the city.</p>
    
    <div class="timeline">
      <div class="timeline-item">
        <div class="timeline-year">2009</div>
        <p>Bake My Day was founded by Maria Wijaya in her small home kitchen, selling homemade bread to neighbors and friends.</p>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2011</div>
        <p>Opened our first small bakery shop in Yogyakarta with just 3 employees and 15 different bread varieties.</p>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2014</div>
        <p>Expanded our menu to include cakes, pastries, and donuts. Introduced our signature "Rainbow Bread" that became an instant hit.</p>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2016</div>
        <p>Opened our second branch and established our central kitchen to maintain consistent quality across locations.</p>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2019</div>
        <p>Celebrated our 10th anniversary with the launch of our online ordering system and home delivery service.</p>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2023</div>
        <p>Expanded to 5 branches across the city and introduced our sustainable packaging initiative to reduce environmental impact.</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Values Section -->
<section class="section" style="background-color: #0a0a0a;">
  <div class="container">
    <h2 class="section-title text-center">Our Values</h2>
    <p class="section-subtitle text-center">The principles that guide everything we do at Bake My Day.</p>
    
    <div class="values-grid">
      <div class="value-card">
        <div class="value-icon">🌟</div>
        <h3 class="value-title">Quality</h3>
        <p class="value-desc">We never compromise on ingredients. Every product is made with premium quality ingredients sourced from trusted suppliers.</p>
      </div>
      
      <div class="value-card">
        <div class="value-icon">❤️</div>
        <h3 class="value-title">Passion</h3>
        <p class="value-desc">Baking is our passion. We put our heart into every loaf, every pastry, and every cake we create.</p>
      </div>
      
      <div class="value-card">
        <div class="value-icon">🌱</div>
        <h3 class="value-title">Sustainability</h3>
        <p class="value-desc">We're committed to reducing our environmental footprint through sustainable practices and eco-friendly packaging.</p>
      </div>
      
      <div class="value-card">
        <div class="value-icon">🤝</div>
        <h3 class="value-title">Community</h3>
        <p class="value-desc">We believe in giving back to the community that has supported us through various charitable initiatives.</p>
      </div>
      
      <div class="value-card">
        <div class="value-icon">🔄</div>
        <h3 class="value-title">Innovation</h3>
        <p class="value-desc">We continuously innovate our recipes and processes to bring you new and exciting flavors while maintaining traditional quality.</p>
      </div>
      
      <div class="value-card">
        <div class="value-icon">😊</div>
        <h3 class="value-title">Customer Happiness</h3>
        <p class="value-desc">Your satisfaction is our priority. We strive to create not just products, but joyful experiences for our customers.</p>
      </div>
    </div>
  </div>
</section>

<!-- Our Team Section -->
<section class="section">
  <div class="container">
    <h2 class="section-title text-center">Meet Our Team</h2>
    <p class="section-subtitle text-center">The talented individuals behind your favorite breads and pastries.</p>
    
    <div class="team-grid">
      <div class="team-member">
        <img src="https://images.unsplash.com/photo-1556911073-a517e752729c?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Maria Wijaya" class="team-photo">
        <div class="team-info">
          <h3 class="team-name">Maria Wijaya</h3>
          <p class="team-role">Founder & Head Baker</p>
          <p class="team-bio">With over 20 years of baking experience, Maria's passion for bread making started in her grandmother's kitchen. She founded Bake My Day with a vision to share authentic, quality bread with the community.</p>
        </div>
      </div>
      
      <div class="team-member">
        <img src="https://images.unsplash.com/photo-1583394293214-28ded15ee548?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Budi Santoso" class="team-photo">
        <div class="team-info">
          <h3 class="team-name">Budi Santoso</h3>
          <p class="team-role">Executive Chef</p>
          <p class="team-bio">A graduate of Le Cordon Bleu, Budi brings international expertise to our kitchen. He specializes in French pastries and is the creative mind behind our seasonal menu items.</p>
        </div>
      </div>
      
      <div class="team-member">
        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Siti Rahma" class="team-photo">
        <div class="team-info">
          <h3 class="team-name">Siti Rahma</h3>
          <p class="team-role">Cake Specialist</p>
          <p class="team-bio">With an artistic background, Siti creates stunning cake designs that taste as good as they look. Her custom birthday and wedding cakes have become legendary in the city.</p>
        </div>
      </div>
      
      <div class="team-member">
        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Agus Purnomo" class="team-photo">
        <div class="team-info">
          <h3 class="team-name">Agus Purnomo</h3>
          <p class="team-role">Operations Manager</p>
          <p class="team-bio">Agus ensures that everything runs smoothly behind the scenes. From supply chain management to quality control, he makes sure that we maintain our high standards across all branches.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Section -->
<section class="section" style="background-color: #0a0a0a;">
  <div class="container">
    <h2 class="section-title text-center">Visit Us</h2>
    <p class="section-subtitle text-center">We'd love to see you at one of our locations. Come experience the aroma of freshly baked goods and the warm atmosphere of our bakeries.</p>
    
    <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; margin-top: 40px;">
      <div style="flex: 1; min-width: 300px; background-color: #111; border-radius: 10px; padding: 30px;">
        <h3 style="font-size: 1.5rem; font-weight: 500; margin-bottom: 15px; color: #fec6e4;">Main Branch</h3>
        <p style="margin-bottom: 10px;"><strong>Address:</strong> Jl. Raya Yogyakarta No. 123, Melati, Yogyakarta</p>
        <p style="margin-bottom: 10px;"><strong>Phone:</strong> +62 274 123 4567</p>
        <p style="margin-bottom: 10px;"><strong>Hours:</strong> Monday - Sunday, 06:00 - 21:00</p>
        <p><strong>Email:</strong> info@bakemyday.com</p>
      </div>
      
      <div style="flex: 1; min-width: 300px; background-color: #111; border-radius: 10px; padding: 30px;">
        <h3 style="font-size: 1.5rem; font-weight: 500; margin-bottom: 15px; color: #fec6e4;">Get In Touch</h3>
        <p style="margin-bottom: 20px;">Have questions, feedback, or special orders? We're here to help!</p>
        <a href="/contact" style="display: inline-block; background-color: #fec6e4; color: #000; padding: 12px 25px; border-radius: 5px; text-decoration: none; font-weight: 600; transition: background-color 0.3s ease;">Contact Us</a>
      </div>
    </div>
  </div>
</section>
@endsection