@extends('layouts.app')

@section('content')

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Account Page</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<style>
  /* --- Color & Theme Variables --- */
  :root {
    --bg-dark: rgb(10, 10, 10);
    --card-bg: rgb(10, 10, 10);
    --border-color: rgb(18, 18, 18);
    
    /* Your Custom Color Palette */
    --text-base: rgb(245, 245, 245);          /* Base text color */
    --text-important: rgb(254, 198, 228);   /* Important/accent text color (Pastel Pink) */
    --text-secondary: #b0b0b0;               /* Secondary, less prominent text */
    --text-white: #ffffff;
  }

  /* --- General Resets & Dark Theme Foundation --- */
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  body {
    font-family: 'Inter', sans-serif;
    background-color: var(--bg-dark);
    color: var(--text-base); /* USE: Base text color */
    padding-top: 2rem;
  }
  
  /* --- Main Layout Container --- */
  .container {

    margin: 2rem auto;
    padding: 0 20px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
    align-items: stretch; /* Ensures columns stretch to equal height */
  }
  
  /* --- Sidebar Styling --- */
  .sidebar {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 40px;
    flex: 1 1 340px; /* ADJUSTED: Slightly wider base for balance */
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    /* REMOVED: height: fit-content; to allow stretching */
  }

  .sidebar-top p {
    margin-bottom: 1rem;
    font-weight: 500;
    font-size: 16px;
    color: var(--text-secondary); /* USE: Secondary text */
  }
  .sidebar-top h1 {
    margin-bottom: 2rem;
    font-weight: 700;
    font-size: 32px;
    line-height: 1.2;
    color: var(--text-important); /* USE: Important text for user's name */
  }
  
  /* --- Navigation Links --- */
  .sidebar-nav {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    font-weight: 500;
    font-size: 18px;
  }
  .sidebar-nav a {
    color: var(--text-base); /* USE: Base text */
    text-decoration: none;
    transition: color 0.3s ease, padding-left 0.3s ease, border-color 0.3s ease;
    padding-left: 0;
    border-left: 3px solid transparent;
  }
  .sidebar-nav a:hover {
    color: var(--text-white);
  }
  .sidebar-nav a.active {
    color: var(--text-important); /* USE: Important text for active link */
    font-weight: 700;
    padding-left: 15px; /* Indent on active */
    border-left: 3px solid var(--text-important); /* Visual indicator for active link */
  }
  
  /* --- Sidebar Footer --- */
  .sidebar-bottom {
    margin-top: 40px;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    font-size: 14px;
    font-weight: 500;
  }
  .sidebar-bottom span, .sidebar-bottom button {
    cursor: pointer;
    color: var(--text-secondary); /* USE: Secondary text */
    transition: color 0.3s ease;
  }
  .sidebar-bottom span:hover, .sidebar-bottom button:hover {
    color: var(--text-white);
  }
  #logout-form button {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 500;
    text-align: left;
  }

  /* --- Main Content Area --- */
  .main-content {
    flex: 1.5 1 500px; /* ADJUSTED: Reduced grow factor and basis width */
    display: flex;
    flex-direction: column;
    gap: 30px;
  }
  
  /* --- Card Styling (for Profile, Orders, etc.) --- */
  .card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 30px 35px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
  }
  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #444;
    padding-bottom: 15px;
    margin-bottom: 25px;
    text-transform: uppercase;
    color: var(--text-secondary); /* USE: Secondary text */
  }
  .card-header .edit {
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    color: var(--text-base); /* USE: Base text */
    text-decoration: none;
    transition: color 0.3s ease;
  }
  .card-header .edit:hover {
    color: var(--text-white);
  }
  
  /* --- Profile Info Section --- */
  .profile-info .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    font-size: 16px;
  }
  .profile-info .row .label {
    font-weight: 500;
    color: var(--text-important); /* USE: Important text for labels */
  }
  .profile-info .row .value {
    font-weight: 400;
    color: var(--text-base); /* USE: Base text */
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .profile-info .row .value svg {
    width: 14px;
    height: 14px;
    stroke: var(--text-secondary); /* USE: Secondary text */
    stroke-width: 1.5;
  }
  
  .recent-orders .no-orders {
    color: var(--text-secondary); /* USE: Secondary text */
    font-size: 16px;
    text-align: center;
    padding: 20px 0;
  }

  /* --- Profile Image Styling --- */
  .profile-image-container {
    position: relative;
    width: 120px;
    margin: -100px auto 25px auto;
  }
  .profile-image {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #444;
    background: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .profile-image:hover {
    border-color: var(--text-important); /* USE: Important color on hover */
    transform: scale(1.05);
  }
  .profile-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .placeholder-icon {
    font-size: 48px;
    font-weight: 300;
    color: var(--text-secondary); /* USE: Secondary text */
  }
  .edit-profile-btn {
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #2a2a2a;
    color: var(--text-white);
    border: 1px solid #444;
    border-radius: 15px;
    padding: 4px 12px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
  }
  .edit-profile-btn:hover {
    background-color: var(--text-important) !important;
    color: var(--bg-dark) !important;
    transform: translateX(-50%) translateY(-2px) !important;
  }

  /* --- Responsive Adjustments --- */
  @media (max-width: 900px) {
    .container {
      flex-direction: column;
      margin: 1rem auto;
      gap: 30px;
    }
  }

  /* --- Modal Styling --- */
  #cropModal .modal-content {
      background-color: #2a2a2a;
      border: 1px solid #444;
      border-radius: 10px;
      color: var(--text-base);
  }
  #cropModal h2 {
      color: var(--text-white);
  }
  #cropModal #cancelCropBtn {
      background-color: transparent;
      border: 1px solid #555;
      color: var(--text-base);
  }
  #cropModal #cropBtn {
      background-color: var(--text-important);
      color: var(--bg-dark);
      font-weight: 700;
      border: none;
  }

</style>
</head>
<body>
  <div class="container">
    <aside class="sidebar" role="complementary" aria-label="User account navigation">
      <div class="sidebar-top">
        <form id="uploadForm" action="{{ route('account.uploadProfilePicture') }}" method="POST" enctype="multipart/form-data" style="display: none;">
          @csrf
          <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*" onchange="openCropModal(event)">
          <input type="hidden" id="croppedImageData" name="cropped_image">
        </form>

        <div class="profile-image-container">
            <div class="profile-image" onclick="openProfileImageModal()">
            @if(Auth::user()->profile_picture_url)
                <img src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
            @else
                <div class="placeholder-icon">+</div>
            @endif
            </div>
            <button type="button" onclick="document.getElementById('profilePictureInput').click()" class="edit-profile-btn">
                Edit
            </button>
        </div>
        
        <p>Welcome back,</p>
        <h1>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
        
        <nav class="sidebar-nav" aria-label="Account navigation">
          <a href="{{ route('account.page')  }}" class="active">Dashboard</a>
          <a href="{{ route('account.settings') }}">Account Settings</a>
        </nav>
      </div>
      
      <div class="sidebar-bottom">

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" style="border: none; background: none; cursor: pointer;">Log Out</button>
        </form>
      </div>
    </aside>

    <main class="main-content" role="main">
      <section class="card profile" aria-labelledby="profile-title">
        <div class="card-header">
          <h2 id="profile-title">Profile Overview</h2>
            <a href="{{ route('account.settings') }}" class="edit" aria-label="Edit profile">EDIT</a>
        </div>
        <div class="profile-info">
           <div class="row">
            <span class="label">Name:</span>
            <span class="value">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </div>
         <div class="row">
            <div class="label">Email:</div>
            <div class="value" aria-label="Email address">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
              {{ Auth::user()->email }}
            </div>
          </div>
          <div class="row">
            <span class="label">Birthday:</span>
            <span class="value">{{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('F d, Y') : 'Not set' }}</span>
            </div>
        </div>
      </section>
      
      <section class="card recent-orders" aria-labelledby="recent-orders-title">
        <div class="card-header">
          <h2 id="recent-orders-title">Recent Orders</h2>
          <a href="#" class="edit" aria-label="See all recent orders">SEE ALL</a>
        </div>
        <p class="no-orders">You have no recent orders.</p>
      </section>
    </main>
  </div>

  <div id="profileImageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
    <span class="close-modal" style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
    <img id="modalProfileImage" style="margin: auto; display: block; max-width: 85%; max-height: 85%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 8px;">
  </div>

  <div id="cropModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
    <div class="modal-content" style="position: relative; width: 90%; max-width: 500px; margin: 30px auto; background-color: #2a2a2a; border: 1px solid #444; border-radius: 10px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
      <span class="close-crop-modal" style="position: absolute; top: 10px; right: 20px; color: #aaa; font-size: 30px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
      
      <h2 style="text-align: center; margin-bottom: 20px; font-size: 22px;">Crop Your Image</h2>
      
      <div style="max-height: 400px; margin-bottom: 20px; background: #121212; border-radius: 8px;">
        <img id="cropImage" style="display: block; max-width: 100%;">
      </div>
      
      <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px;">
        <button id="cancelCropBtn" style="padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;">Cancel</button>
        <button id="cropBtn" style="padding: 10px 20px; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">Save & Upload</button>
      </div>
    </div>
  </div>

  <script>
    // --- Unchanged JavaScript Logic ---
    function openProfileImageModal() {
      @if(Auth::user()->profile_picture_url)
        const modal = document.getElementById('profileImageModal');
        const modalImg = document.getElementById('modalProfileImage');
        modal.style.display = "block";
        modalImg.src = "{{ Auth::user()->profile_picture_url }}";
        document.body.style.overflow = 'hidden';
      @endif
    }
    
    document.querySelector('.close-modal').addEventListener('click', function() {
      document.getElementById('profileImageModal').style.display = "none";
      document.body.style.overflow = 'auto';
    });
    
    document.getElementById('profileImageModal').addEventListener('click', function(event) {
      if (event.target === this) {
        this.style.display = "none";
        document.body.style.overflow = 'auto';
      }
    });

    let cropper;
    
    function openCropModal(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = function(e) {
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        cropModal.style.display = "block";
        cropImage.src = e.target.result;
        if (cropper) {
          cropper.destroy();
        }
        cropImage.onload = function() {
          cropper = new Cropper(cropImage, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            responsive: true,
            background: false,
            autoCropArea: 0.8
          });
        };
        document.body.style.overflow = 'hidden';
      };
      
      reader.readAsDataURL(file);
    }
    
    document.getElementById('cropBtn').addEventListener('click', function() {
      if (!cropper) return;
      
      const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
      });
      
      if (canvas) {
        canvas.toBlob(function(blob) {
          const formData = new FormData(document.getElementById('uploadForm'));
          formData.delete('profile_picture');
          formData.append('profile_picture', blob, 'profile.png');
          
          const xhr = new XMLHttpRequest();
          xhr.open('POST', document.getElementById('uploadForm').action, true);
          xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          
          xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
              window.location.reload();
            } else {
              console.error('Upload failed: ', xhr.responseText);
              alert('There was an error uploading your profile picture.');
            }
          };
          
          xhr.send(formData);
          closeCropModal();
        }, 'image/png');
      }
    });
    
    function closeCropModal() {
        if(cropper) cropper.destroy();
        document.getElementById('cropModal').style.display = "none";
        document.body.style.overflow = 'auto';
        document.getElementById('profilePictureInput').value = '';
    }

    document.getElementById('cancelCropBtn').addEventListener('click', closeCropModal);
    document.querySelector('.close-crop-modal').addEventListener('click', closeCropModal);
  </script>
</body>
</html>
@endsection