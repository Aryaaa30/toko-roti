@extends('layouts.app')

@section('content')

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Account Settings</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<style>
  /* --- Color & Theme Variables --- */
  :root {
    --bg-dark: rgb(10, 10, 10);
    --card-bg: rgb(10, 10, 10);
    --border-color: rgb(40, 40, 40);
    
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
    color: var(--text-base);
    padding-top: 2rem;
  }
  
  /* --- Main Layout Container --- */
  .container {

    margin: 2rem auto;
    padding: 0 20px;
    display: flex;
    gap: 40px;
    align-items: flex-start;
  }
  
  /* --- Sidebar Styling --- */
  .sidebar {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 40px;
    flex: 0 0 340px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: sticky;
    top: 2rem;
  }

  .sidebar-top p {
    margin-bottom: 1rem;
    font-weight: 500;
    font-size: 16px;
    color: var(--text-secondary);
  }
  .sidebar-top h1 {
    margin-bottom: 2rem;
    font-weight: 700;
    font-size: 32px;
    line-height: 1.2;
    color: var(--text-important);
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
    color: var(--text-base);
    text-decoration: none;
    transition: color 0.3s ease, padding-left 0.3s ease, border-color 0.3s ease;
    padding-left: 0;
    border-left: 3px solid transparent;
  }
  .sidebar-nav a:hover {
    color: var(--text-white);
  }
  .sidebar-nav a.active {
    color: var(--text-important);
    font-weight: 700;
    padding-left: 15px;
    border-left: 3px solid var(--text-important);
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
  .sidebar-bottom a, .sidebar-bottom button {
    cursor: pointer;
    color: var(--text-secondary);
    transition: color 0.3s ease;
    text-decoration: none;
    text-align: left;
    background: none;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 500;
  }
  .sidebar-bottom a:hover, .sidebar-bottom button:hover {
    color: var(--text-white);
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
    border: 3px solid var(--border-color);
    background: #333;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  .profile-image:hover {
    border-color: var(--text-important);
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
    color: var(--text-secondary);
  }
  .edit-profile-btn {
    position: absolute;
    bottom: 0px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #2a2a2a;
    color: var(--text-white);
    border: 1px solid var(--border-color);
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

  /* --- Main Content Area --- */
  .main-content {
    flex: 1.5 1 500px;
    display: flex;
    flex-direction: column;
    gap: 30px;
  }
  
  /* --- Card Styling --- */
  .card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 30px 35px;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
  }
  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 15px;
    margin-bottom: 25px;
    text-transform: uppercase;
    color: var(--text-secondary);
  }
  .card-header .edit {
    cursor: pointer;
    font-weight: 500;
    font-size: 14px;
    color: var(--text-base);
    text-decoration: none;
    transition: color 0.3s ease;
  }
  .card-header .edit:hover {
    color: var(--text-white);
  }
  
  /* --- Info Styling (in cards) --- */
  .info-group .row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    font-size: 16px;
  }
  .info-group .row:last-child {
    margin-bottom: 0;
  }
  .info-group .row .label, .sub-header .label {
    font-weight: 500;
    color: var(--text-secondary);
  }
  .info-group .row .value {
    font-weight: 500;
    color: var(--text-base);
    display: flex;
    align-items: center;
    gap: 8px;
  }
   .info-group .row .value .fas.fa-lock {
    color: var(--text-secondary);
   }
   .sub-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-weight: 700;
    font-size: 16px;
    color: var(--text-base);
    padding-bottom: 15px;
    border-bottom: 1px solid var(--border-color);
    margin-bottom: 20px;
   }

  /* --- Modal Styling --- */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        background-color: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 9999;
    }
    .modal {
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        width: 90%;
        max-width: 480px;
        padding: 32px 32px 40px 32px;
        box-shadow: 0 4px 25px rgba(0, 0, 0, 0.4);
        position: relative;
    }
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .modal-header h2 {
        font-weight: 700;
        font-size: 22px;
        color: var(--text-base);
        margin: 0;
    }
    .close-btn {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-secondary);
        background: transparent;
        border: none;
        cursor: pointer;
        transition: color 0.3s;
    }
    .close-btn:hover {
        color: var(--text-white);
    }

    /* --- Form Styling --- */
    form label {
        display: block;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 8px;
        color: var(--text-secondary);
    }
    form input[type="text"],
    form input[type="email"],
    form input[type="date"],
    form input[type="password"] {
        width: 100%;
        height: 48px;
        padding: 12px 16px;
        font-size: 16px;
        border: 1.5px solid var(--border-color);
        background-color: var(--card-bg);
        border-radius: 8px;
        margin-bottom: 1rem;
        color: var(--text-base);
        font-family: 'Inter', sans-serif;
    }
    form input:focus {
        outline: none;
        border-color: var(--text-important);
    }
    form input[readonly] {
        background-color: #1a1a1a;
        cursor: not-allowed;
    }
    .email-container {
        position: relative;
        width: 100%;
    }
    .email-container .email-lock-icon {
        position: absolute;
        right: 16px;
        top: 15px;
        color: var(--text-secondary);
    }
    .info-text {
        font-size: 12px;
        color: var(--text-secondary);
        margin-top: -10px;
        margin-bottom: 1rem;
    }
    .save-btn {
        width: 100%;
        height: 48px;
        background: var(--text-important);
        color: var(--bg-dark);
        border-radius: 8px;
        border: none;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        margin-top: 1rem;
        transition: background-color 0.3s;
    }
    .save-btn:hover {
        background-color: rgb(255, 215, 235);
    }
    .cancel-text {
        text-align: center;
        font-size: 14px;
        color: var(--text-secondary);
        cursor: pointer;
        user-select: none;
        margin-top: 1rem;
    }

    /* --- Toast Notification --- */
    #toast {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #222;
        border: 1px solid var(--border-color);
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 16px;
        position: fixed;
        left: 50%;
        bottom: 30px;
        font-size: 16px;
        z-index: 10000;
        opacity: 0;
        transition: opacity 0.5s, visibility 0.5s, bottom 0.5s;
    }

  /* --- Responsive Adjustments --- */
  @media (max-width: 900px) {
    .container {
      flex-direction: column;
      margin: 1rem auto;
      gap: 30px;
    }
    .sidebar {
      position: static;
      width: 100%;
    }
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
            <div class="profile-image" onclick="document.getElementById('profilePictureInput').click()">
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
          <a href="{{ route('account.page') }}">Dashboard</a>
          <a href="#">Order History</a>
          <a href="{{ route('account.settings') }}" class="active">Account Settings</a>
        </nav>
      </div>
      
      <div class="sidebar-bottom">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit">Log Out</button>
        </form>
      </div>
    </aside>

    <main class="main-content" role="main">
      <section class="card" aria-labelledby="profile-settings-title">
        <div class="card-header">
          <h2 id="profile-settings-title">Profile Settings</h2>
          <a href="#" class="edit" id="openProfileModal" aria-label="Edit Profile">EDIT</a>
        </div>
        <div class="info-group">
            <div class="row">
                <span class="label">Name:</span>
                <span class="value">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </div>
            <div class="row">
                <span class="label">Email:</span>
                <span class="value"><i class="fas fa-lock"></i> {{ Auth::user()->email }}</span>
            </div>
            <div class="row">
                <span class="label">Phone:</span>
                <span class="value">{{ Auth::user()->phone_number ?? 'Not set' }}</span>
            </div>
            <div class="row">
                <span class="label">Birthday:</span>
                <span class="value">{{ Auth::user()->birthday ? \Carbon\Carbon::parse(Auth::user()->birthday)->format('F d, Y') : 'Not set' }}</span>
            </div>
        </div>
      </section>
      
      <section class="card" aria-labelledby="security-preferences-title">
        <div class="card-header">
          <h2 id="security-preferences-title">Security & Preferences</h2>
        </div>
        <div class="info-group">
            <div class="sub-header">
                <span class="label" style="text-transform: uppercase;">Password</span>
                <a href="#" class="edit" id="openChangePasswordModal" aria-label="Edit Password">EDIT</a>
            </div>
            <div class="row">
                <span class="label">Password:</span>
                <span class="value">************</span>
            </div>
        </div>
        <div class="info-group" style="margin-top: 25px;">
            <div class="sub-header">
                <span class="label" style="text-transform: uppercase;">Saved Addresses</span>
                <a href="#" class="edit" aria-label="Add New Address">ADD NEW+</a>
            </div>
            <div class="row">
                <span class="value">No saved addresses yet.</span>
            </div>
        </div>
        <div class="info-group" style="margin-top: 25px;">
             <div class="sub-header">
                <span class="label" style="text-transform: uppercase;">Communication</span>
            </div>
            <div class="row">
                <span class="label">Marketing Emails:</span>
                <span class="value">Subscribed</span>
            </div>
        </div>
      </section>
    </main>
  </div>

  <div class="modal-overlay" id="profileModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="profileModalTitle">
      <div class="modal-header">
        <h2 id="profileModalTitle">EDIT PROFILE</h2>
        <button class="close-btn" id="closeProfileModal" aria-label="Close">&times;</button>
      </div>
      <form method="POST" action="{{ route('user.updateProfile') }}">
        @csrf
        <label for="firstName">First Name</label>
        <input type="text" id="firstName" name="firstName" value="{{ old('firstName', Auth::user()->first_name) }}" />

        <label for="lastName">Last Name</label>
        <input type="text" id="lastName" name="lastName" value="{{ old('lastName', Auth::user()->last_name) }}" />

        <label for="phoneNumber">Phone Number</label>
        <input type="text" id="phoneNumber" name="phoneNumber" value="{{ old('phoneNumber', Auth::user()->phone_number) }}" />

        <label for="birthday">Birthday</label>
        <input type="date" id="birthday" name="birthday" value="{{ old('birthday', Auth::user()->birthday) }}" />
        
        <label for="email">Email</label>
        <div class="email-container">
            <input type="email" name="email" value="{{ Auth::user()->email }}" readonly />
            <i class="fas fa-lock email-lock-icon"></i>
        </div>
        <p class="info-text">Email address cannot be edited for security reasons.</p>

        <button type="submit" class="save-btn">SAVE CHANGES</button>
      </form>
    </div>
  </div>

  <div class="modal-overlay" id="changePasswordModal">
      <div class="modal" role="dialog" aria-modal="true" aria-labelledby="passwordModalTitle">
          <div class="modal-header">
              <h2 id="passwordModalTitle">CHANGE PASSWORD</h2>
              <button class="close-btn" id="closeChangePasswordModal" aria-label="Close">&times;</button>
          </div>
          <form id="changePasswordForm" method="POST" action="{{ route('user.changePassword') }}">
              @csrf
              <label for="password">New Password</label>
              <input id="password" name="password" type="password" autocomplete="new-password" required />
              
              <label for="password_confirmation">Confirm New Password</label>
              <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required />
              
              <button type="submit" class="save-btn">SAVE NEW PASSWORD</button>
              <div class="cancel-text" id="cancelPasswordModal">Cancel</div>
          </form>
      </div>
  </div>
  
  <div id="cropModal" class="modal-overlay">
    <div class="modal" style="background-color: #2a2a2a; border-radius: 10px; padding: 25px;">
      <span class="close-btn" onclick="closeCropModal()" style="position: absolute; top: 10px; right: 20px;">&times;</span>
      <h2 style="text-align: center; margin-bottom: 20px;">Crop Your Image</h2>
      <div style="max-height: 400px; margin-bottom: 20px; background: #121212; border-radius: 8px;">
        <img id="cropImage" style="display: block; max-width: 100%;">
      </div>
      <div style="display: flex; justify-content: flex-end; gap: 15px; margin-top: 20px;">
        <button id="cancelCropBtn" onclick="closeCropModal()" style="padding: 10px 20px; border-radius: 8px; cursor: pointer; background-color: transparent; border: 1px solid var(--border-color); color: var(--text-base);">Cancel</button>
        <button id="cropBtn" style="padding: 10px 20px; border-radius: 8px; cursor: pointer; background-color: var(--text-important); color: var(--bg-dark); font-weight: 700; border: none;">Save & Upload</button>
      </div>
    </div>
  </div>
  
  <div id="toast"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- LOGIC DARI SETTINGS.BLADE.PHP ---
    
    // Modal Handling
    function setupModal(openBtnId, closeBtnId, cancelBtnId, modalId) {
        const openBtn = document.getElementById(openBtnId);
        const closeBtn = document.getElementById(closeBtnId);
        const cancelBtn = document.getElementById(cancelBtnId);
        const modalOverlay = document.getElementById(modalId);

        if (!openBtn || !modalOverlay) return;

        const open = (e) => { e.preventDefault(); modalOverlay.style.display = 'flex'; };
        const close = () => modalOverlay.style.display = 'none';

        openBtn.addEventListener('click', open);
        if(closeBtn) closeBtn.addEventListener('click', close);
        if(cancelBtn) cancelBtn.addEventListener('click', close);
        
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) close();
        });
    }

    setupModal('openProfileModal', 'closeProfileModal', null, 'profileModal');
    setupModal('openChangePasswordModal', 'closeChangePasswordModal', 'cancelPasswordModal', 'changePasswordModal');

    // Toast Notification
    function showToast(message, isError = false) {
        const toast = document.getElementById('toast');
        toast.textContent = message;
        toast.style.backgroundColor = isError ? '#D32F2F' : '#333';
        toast.style.visibility = 'visible';
        toast.style.opacity = '1';
        toast.style.bottom = '30px';

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.bottom = '0px';
            setTimeout(() => { toast.style.visibility = 'hidden'; }, 500);
        }, 3000);
    }

    // AJAX Password Change
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(changePasswordForm);
            try {
                const response = await fetch("{{ route('user.changePassword') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: formData,
                });
                const data = await response.json();
                if (!response.ok) {
                    const errorMessage = data.errors?.password?.[0] || data.message || 'Error changing password.';
                    throw new Error(errorMessage);
                }
                document.getElementById('changePasswordModal').style.display = 'none';
                changePasswordForm.reset();
                showToast(data.message || 'Password changed successfully!');
            } catch (error) {
                showToast(error.message, true);
            }
        });
    }

    // Handle Session Messages for Toast
    @if(session('success'))
        showToast("{{ session('success') }}");
    @endif
    @if($errors->any())
        showToast("{{ $errors->first() }}", true);
    @endif

    // --- LOGIC DARI ACCOUNT.BLADE.PHP (CROPPER) ---
    
    let cropper;
    
    window.openCropModal = function(event) {
      const file = event.target.files[0];
      if (!file) return;
      
      const reader = new FileReader();
      reader.onload = function(e) {
        const cropModal = document.getElementById('cropModal');
        const cropImage = document.getElementById('cropImage');
        cropModal.style.display = "flex";
        cropImage.src = e.target.result;
        if (cropper) cropper.destroy();
        
        cropper = new Cropper(cropImage, {
            aspectRatio: 1, viewMode: 1, dragMode: 'move', responsive: true, background: false, autoCropArea: 0.8
        });
        document.body.style.overflow = 'hidden';
      };
      reader.readAsDataURL(file);
    }
    
    document.getElementById('cropBtn').addEventListener('click', function() {
      if (!cropper) return;
      
      const canvas = cropper.getCroppedCanvas({ width: 400, height: 400, fillColor: '#fff' });
      
      if (canvas) {
        canvas.toBlob(function(blob) {
          const formData = new FormData(document.getElementById('uploadForm'));
          formData.delete('profile_picture');
          formData.append('profile_picture', blob, 'profile.png');
          
          fetch(document.getElementById('uploadForm').action, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
          }).then(response => {
            if (response.ok) window.location.reload();
            else alert('Upload failed.');
          }).catch(error => console.error('Error:', error));
          
          closeCropModal();
        }, 'image/png');
      }
    });
    
    window.closeCropModal = function() {
        if(cropper) cropper.destroy();
        document.getElementById('cropModal').style.display = "none";
        document.body.style.overflow = 'auto';
        document.getElementById('profilePictureInput').value = '';
    }
});
</script>
</body>
</html>
@endsection