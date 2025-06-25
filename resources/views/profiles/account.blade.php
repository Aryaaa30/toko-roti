@extends('layouts.app')

@section('content')

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Account Page</title>
<link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet" />
<!-- Cropper.js CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" />
<!-- Cropper.js JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
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
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #1a1a1a;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #ddd;
  font-size: 48px;
  color: #1a1a1a;
  cursor: pointer;
  transition: all 0.3s ease;
}

.profile-image:hover {
  border-color: #555;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  transform: scale(1.02);
}

.profile-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  transition: all 0.3s ease;
}

.profile-image:hover img {
  transform: scale(1.05);
}

.placeholder-icon {
  font-size: 48px;
  font-weight: bold;
  color: #1a1a1a;
}

.edit-profile-btn:hover {
  background-color: #333 !important;
  transform: translateX(-50%) translateY(-2px) !important;
  box-shadow: 0 4px 8px rgba(0,0,0,0.3) !important;
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
            onchange="openCropModal(event)"
        >
        <input type="hidden" id="croppedImageData" name="cropped_image">
        </form>

        <div class="profile-image-container" style="position: relative; width: 120px; margin: -130px auto 15px auto;">
            <div class="profile-image" onclick="openProfileImageModal()">
            @if(Auth::user()->profile_picture_url)
                <img src="{{ Auth::user()->profile_picture_url }}" alt="Profile Picture">
            @else
                <div class="placeholder-icon">+</div>
            @endif
            </div>
            <button type="button" 
                    onclick="document.getElementById('profilePictureInput').click()" 
                    class="edit-profile-btn"
                    style="position: absolute; bottom: -10px; left: 50%; transform: translateX(-50%); 
                           background-color: #1a1a1a; color: white; border: none; 
                           border-radius: 12px; padding: 2px 10px; font-size: 12px; 
                           cursor: pointer; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                           transition: all 0.3s ease;">
                Edit
            </button>
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

  <!-- Profile Image Modal -->
  <div id="profileImageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
    <span class="close-modal" style="position: absolute; top: 15px; right: 35px; color: #f1f1f1; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
    <img id="modalProfileImage" style="margin: auto; display: block; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
  </div>

  <!-- Image Crop Modal -->
  <div id="cropModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px);">
    <div style="position: relative; width: 90%; max-width: 600px; margin: 30px auto; background-color: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
      <span class="close-crop-modal" style="position: absolute; top: 10px; right: 20px; color: #333; font-size: 30px; font-weight: bold; cursor: pointer; z-index: 1001;">&times;</span>
      
      <h2 style="text-align: center; margin-bottom: 20px; color: #333; font-size: 24px;">Crop Your Profile Picture</h2>
      
      <div style="max-height: 400px; margin-bottom: 20px;">
        <img id="cropImage" style="display: block; max-width: 100%; max-height: 400px;">
      </div>
      
      <div style="display: flex; justify-content: center; gap: 15px; margin-top: 20px;">
        <button id="cancelCropBtn" style="padding: 10px 20px; background-color: #ccc; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#b3b3b3'" onmouseout="this.style.backgroundColor='#ccc'">Cancel</button>
        <button id="cropBtn" style="padding: 10px 20px; background-color: #1a1a1a; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#333'" onmouseout="this.style.backgroundColor='#1a1a1a'">Save</button>
      </div>
      
      <div style="text-align: center; margin-top: 15px; color: #666; font-size: 13px;">
        <p>Drag to reposition • Use mouse wheel to zoom • Drag corners to resize</p>
      </div>
    </div>
  </div>

  <script>
    // Profile Image Modal Functions
    function openProfileImageModal() {
      @if(Auth::user()->profile_picture_url)
        const modal = document.getElementById('profileImageModal');
        const modalImg = document.getElementById('modalProfileImage');
        
        modal.style.display = "block";
        modalImg.src = "{{ Auth::user()->profile_picture_url }}";
        
        // Prevent body scrolling when modal is open
        document.body.style.overflow = 'hidden';
      @endif
    }
    
    // Close modal when clicking the X
    document.querySelector('.close-modal').addEventListener('click', function() {
      document.getElementById('profileImageModal').style.display = "none";
      document.body.style.overflow = 'auto';
    });
    
    // Close modal when clicking outside the image
    document.getElementById('profileImageModal').addEventListener('click', function(event) {
      if (event.target === this) {
        this.style.display = "none";
        document.body.style.overflow = 'auto';
      }
    });

    // Image Cropping Functions
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
        
        // Initialize cropper
        if (cropper) {
          cropper.destroy();
        }
        
        // Wait for the image to load before initializing cropper
        cropImage.onload = function() {
          cropper = new Cropper(cropImage, {
            aspectRatio: 1, // Square aspect ratio for profile picture
            viewMode: 1,    // Restrict the crop box to not exceed the size of the canvas
            guides: true,   // Show the dashed lines for guiding
            center: true,   // Show the center indicator for guiding
            dragMode: 'move',
            minContainerWidth: 250,
            minContainerHeight: 250,
            responsive: true
          });
        };
        
        // Prevent body scrolling when modal is open
        document.body.style.overflow = 'hidden';
      };
      
      reader.readAsDataURL(file);
    }
    
    // Crop and save image
    document.getElementById('cropBtn').addEventListener('click', function() {
      if (!cropper) return;
      
      // Get the cropped canvas
      const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
        fillColor: '#fff',
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
      });
      
      if (canvas) {
        // Convert canvas to blob
        canvas.toBlob(function(blob) {
          // Create a new File object
          const file = new File([blob], 'cropped-profile-picture.png', { type: 'image/png' });
          
          // Create a FormData object
          const formData = new FormData(document.getElementById('uploadForm'));
          formData.delete('profile_picture'); // Remove the original file
          formData.append('profile_picture', file); // Add the cropped file
          
          // Create and send the request
          const xhr = new XMLHttpRequest();
          xhr.open('POST', document.getElementById('uploadForm').action, true);
          xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
          
          // Handle the response
          xhr.onload = function() {
            if (xhr.status === 200) {
              // Reload the page to show the new profile picture
              window.location.reload();
            } else {
              alert('There was an error uploading your profile picture.');
            }
          };
          
          xhr.send(formData);
          
          // Close the modal
          document.getElementById('cropModal').style.display = "none";
          document.body.style.overflow = 'auto';
        }, 'image/png');
      }
    });
    
    // Cancel crop
    document.getElementById('cancelCropBtn').addEventListener('click', function() {
      document.getElementById('cropModal').style.display = "none";
      document.body.style.overflow = 'auto';
      
      // Reset the file input
      document.getElementById('profilePictureInput').value = '';
    });
    
    // Close crop modal when clicking the X
    document.querySelector('.close-crop-modal').addEventListener('click', function() {
      document.getElementById('cropModal').style.display = "none";
      document.body.style.overflow = 'auto';
      
      // Reset the file input
      document.getElementById('profilePictureInput').value = '';
    });
  </script>
</body>
</html>
@endsection