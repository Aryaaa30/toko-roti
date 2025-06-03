@extends('layouts.app')

@section('content')

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Account Page</title>
<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
<style>
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background-color: #f8f3ec;
    color: #1a1a1a;
  }
  .container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }
  .sidebar {
    background: #fff;
    border-radius: 10px;
    padding: 40px 30px 30px 30px;
    flex: 1 1 280px;
    min-width: 280px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: fit-content;
  }
  .sidebar-top {
    margin-bottom: 20px;
  }
  .sidebar-top p {
    margin: 0 0 20px 0;
    font-weight: 400;
    font-size: 16px;
  }
  .sidebar-top h1 {
    margin: 0 0 30px 0;
    font-weight: 700;
    font-size: 36px;
    line-height: 1.1;
  }
  .sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 24px;
    font-weight: 400;
    font-size: 18px;
  }
  .sidebar-nav a {
    color: #1a1a1a;
    text-decoration: none;
    border-bottom: 1px solid transparent;
    padding-bottom: 2px;
    width: fit-content;
  }
  .sidebar-nav a.active,
  .sidebar-nav a:hover {
    border-color: #1a1a1a;
  }
  .sidebar-bottom {
    margin-top: 40px;
    font-weight: 700;
    font-size: 16px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
  }
  .sidebar-bottom span {
    cursor: pointer;
  }

  .main-content {
    flex: 3 1 600px;
    display: flex;
    flex-direction: column;
    gap: 30px;
  }
  .card {
    background: #fff;
    border-radius: 10px;
    padding: 25px 30px 30px 30px;
  }
  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 400;
    font-size: 16px;
    border-bottom: 1px solid #1a1a1a;
    padding-bottom: 10px;
    margin-bottom: 20px;
    text-transform: uppercase;
  }
  .card-header .edit {
    cursor: pointer;
    font-weight: 400;
    font-size: 14px;
  }
  .profile-info {
    font-weight: 700;
    font-size: 16px;
    line-height: 1.3;
  }
  .profile-info .row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 14px;
    font-weight: 700;
  }
  .profile-info .row .label {
    font-weight: 700;
  }
  .profile-info .row .value {
    font-weight: 400;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .profile-info .row .value svg {
    width: 14px;
    height: 14px;
    fill: none;
    stroke: #1a1a1a;
    stroke-width: 1.5;
  }
  .recent-orders {
    font-weight: 400;
    font-size: 16px;
  }
  .recent-orders .no-orders {
    font-weight: 400;
    font-size: 16px;
  }

  @media (max-width: 900px) {
    .container {
      flex-direction: column;
      margin: 20px auto;
    }
    .sidebar {
      width: 100%;
      min-width: auto;
      height: auto;
      padding: 30px 20px 20px 20px;
    }
    .main-content {
      width: 100%;
    }
  }
  .profile-image {
  width: 120px;
  height: 120px;
  margin: -130px auto 15px auto;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #1a1a1a;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #ddd;
  font-size: 48px;
  color: #1a1a1a;
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.placeholder-icon {
  font-size: 48px;
  font-weight: bold;
  color: #1a1a1a;
}

</style>
</head>
<body>
  <div class="container">
    <aside class="sidebar" role="complementary" aria-label="User account navigation">
      <div class="sidebar-top">
        <form id="uploadForm" action="{{ route('account.uploadProfilePicture') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input
            type="file"
            id="profilePictureInput"
            name="profile_picture"
            accept="image/*"
            capture="environment"
            onchange="document.getElementById('uploadForm').submit()"
        >
        </form>

        <div class="profile-image" onclick="document.getElementById('profilePictureInput').click()">
        @if(Auth::user()->profile_picture_url)
            <img src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
        @else
            <div class="placeholder-icon">+</div>
        @endif
        </div>
        <p>My Account</p>
        <h1>HI {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h1>
        <nav class="sidebar-nav" aria-label="Account navigation">
          <a href="{{ route('account.page')  }}">Dashboard</a>
          <a href="#">Order History</a>
          <a href="{{ route('account.settings') }}">Account Settings</a>
        </nav>
      </div>
      <div class="sidebar-bottom">
        <span><strong>Need help?</strong></span>
        <span><strong>Contact Us</strong></span>
        <span><strong>FAQ's</strong></span>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" style="border: none; background: none; font-weight: bold; cursor: pointer;">Log Out</button>
        </form>
      </div>
    </aside>
    <main class="main-content" role="main">
      <section class="card profile" aria-labelledby="profile-title">
        <div class="card-header">
          <h2 id="profile-title">PROFILE</h2>
            <a href="{{ route('account.settings') }}" class="edit" aria-label="Edit profile">EDIT</a>
        </div>
        <div class="profile-info">
           <div class="row">
            <label>Name:</label>
            <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </div>
         <div class="row">
            <div class="label">Email:</div>
            <div class="value" aria-label="Email address">
              🔒 {{ Auth::user()->email }}
            </div>
          </div>
          <div class="row">
            <label>Birthday:</label>
            <span>{{ Auth::user()->birthday }}</span>
            </div>
        </div>
      </section>
      <section class="card recent-orders" aria-labelledby="recent-orders-title">
        <div class="card-header">
          <h2 id="recent-orders-title">RECENT ORDERS</h2>
          <button class="edit" aria-label="See all recent orders">SEE ALL</button>
        </div>
        <p class="no-orders">No order history</p>
      </section>
    </main>
  </div>
</body>
</html>
@endsection