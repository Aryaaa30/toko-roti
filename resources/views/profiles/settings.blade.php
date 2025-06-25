@extends('layouts.app')

@section('content')

<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Account Settings</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
<style>
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background-color: #f7f1ea;
    color: #222222;
  }
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px 60px 20px;
    display: flex;
    gap: 40px;
  }
  .sidebar {
    background: #fff;
    border-radius: 10px;
    padding: 30px 30px 40px 30px;
    width: 320px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .sidebar-top {
    user-select: none;
  }
  .sidebar-top p {
    margin: 0 0 10px 0;
    font-weight: 400;
    font-size: 16px;
  }
  .sidebar-top h1 {
    margin: 0 0 30px 0;
    font-weight: 900;
    font-size: 40px;
    letter-spacing: 0.02em;
  }
  .sidebar-top nav a {
    display: block;
    font-weight: 400;
    font-size: 18px;
    color: #222222;
    text-decoration: none;
    margin-bottom: 30px;
    line-height: 1.3;
  }
  .sidebar-top nav a:last-child {
    margin-bottom: 0;
  }
  .sidebar-top nav a.active,
  .sidebar-top nav a:hover {
    text-decoration: underline;
  }
  .sidebar-bottom {
    font-weight: 700;
    font-size: 16px;
    display: flex;
    gap: 30px;
    user-select: none;
  }
  .sidebar-bottom strong {
    cursor: default;
  }
  .sidebar-bottom a {
    color: #222222;
    text-decoration: none;
    font-weight: 700;
  }
  .sidebar-bottom a:hover {
    text-decoration: underline;
  }
  .main-content {
    flex: 1;
  }
  .main-content h2 {
    font-weight: 900;
    font-size: 24px;
    margin: 0 0 30px 0;
    user-select: none;
  }
  .cards {
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap: 30px;
  }
  .card {
    background: #fff;
    border-radius: 10px;
    padding: 25px 30px 30px 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #222222;
    padding-bottom: 8px;
    font-weight: 400;
    font-size: 16px;
    user-select: none;
  }
  .card-header .edit {
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    user-select: none;
  }
  .card-header .edit:hover {
    text-decoration: underline;
  }
  .profile-info,
  .password-info,
  .saved-address,
  .communication-info {
    font-weight: 400;
    font-size: 16px;
    line-height: 1.5;
  }
  .profile-info .row,
  .communication-info .row {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
  }
  .profile-info .row label,
  .communication-info .row label {
    user-select: none;
  }
  .saved-address .address-row {
    background: #fef9f5;
    border-radius: 10px;
    padding: 12px 20px;
    font-weight: 400;
    font-size: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .saved-address .address-row .edit {
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    user-select: none;
  }
  .saved-address .address-row .edit:hover {
    text-decoration: underline;
  }
  @media (max-width: 768px) {
    .container {
      flex-direction: column;
      padding: 20px 15px 40px 15px;
    }
    .sidebar {
      width: 100%;
      margin-bottom: 30px;
      padding: 25px 20px 30px 20px;
    }
    .cards {
      grid-template-columns: 1fr;
      gap: 20px;
    }
  }

  .modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none; /* awalnya disembunyikan */
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
}

.modal {
  background: #fff;
  border-radius: 10px;
  padding: 30px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 0 10px rgba(0,0,0,0.25);
  position: relative;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h1 {
  margin: 0;
  font-size: 20px;
}

.close-btn {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
}

form {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

form label {
  font-weight: 600;
  margin-top: 10px;
}

form input,
form select {
  padding: 8px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form .email-container {
 position: relative;
  width: 100%;
}

.email-container input {
  width: 100%;
  padding-right: 35px; /* Space for the lock icon */
}

form .email-lock-icon {
   position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
  pointer-events: none;
}

form .info-text {
  font-size: 12px;
  color: #888;
}

.save-btn {
  margin-top: 20px;
  padding: 10px;
  font-size: 16px;
  background: #222;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.save-btn:hover {
  background: #444;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none; /* default hidden */
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 9999;
}

.modal {
  background: #fff;
  border-radius: 8px;
  width: 90%;
  max-width: 480px;
  padding: 32px 32px 40px 32px;
  box-shadow: 0 4px 12px rgb(0 0 0 / 0.15);
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
  color: #222;
  margin: 0;
}

.close-btn {
  font-size: 28px;
  font-weight: 700;
  color: #222;
  background: transparent;
  border: none;
  cursor: pointer;
}

form label {
  display: block;
  font-weight: 400;
  font-size: 14px;
  margin-bottom: 8px;
}

form input[type="password"] {
  width: 100%;
  height: 48px;
  padding: 12px 16px;
  font-size: 16px;
  border: 1.5px solid #000;
  border-radius: 8px;
  margin-bottom: 24px;
}

form input::placeholder {
  color: #222;
}

button.save-btn {
  width: 100%;
  height: 48px;
  background: #1a1717;
  color: #f7e6d6;
  border-radius: 6px;
  border: none;
  font-weight: 700;
  cursor: pointer;
}

.cancel-text {
  text-align: center;
  font-size: 14px;
  color: #222;
  cursor: pointer;
  user-select: none;
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
    <aside class="sidebar">
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
        <h1>HI!</h1>
        <nav>
          <a href="{{ route('account.page')  }}">Dashboard</a>
          <a href="#">Order History</a>
          <a href="#">Account Settings</a>
        </nav>
      </div>
      <div class="sidebar-bottom">
        <strong>Need help?</strong>
        <a href="#">Contact Us</a>
        <a href="#">FAQ's</a>
        <a href="#">Log Out</a>
      </div>
    </aside>
    <main class="main-content">
      <h2>ACCOUNT SETTINGS</h2>
      <div class="cards">
        <section class="card profile-card">
          <div class="card-header">
            <span>PROFILE</span>
            <span class="edit" id="openModal">EDIT</span>
          </div>
          <div class="profile-info">
            <div class="row">
            <label>Name:</label>
            <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
            </div>
            <div class="row">
            <label>Email:</label>
            <span>🔒 {{ Auth::user()->email }}</span>
            </div>
            <div class="row">
            <label>Phone Number:</label>
            <span>{{ Auth::user()->phone_number }}</span>
            </div>
            <div class="row">
            <label>Birthday:</label>
            <span>{{ Auth::user()->birthday }}</span>
            </div>
          </div>
        </section>
        <section class="card password-card">
          <div class="card-header">
            <span>PASSWORD</span>
            <span class="edit">EDIT</span>
          </div>
          <div class="password-info" style="margin-top: 20px; user-select:none;">
            <span style="float:right;">****************</span>
          </div>
        </section>
        <section class="card saved-address-card">
          <div class="card-header">
            <span>SAVED ADDRESSES &amp; CONTACTS</span>
            <span class="edit" style="font-weight: 400; font-size: 14px; cursor: default;">ADD NEW+</span>
          </div>
          <div class="saved-address" style="margin-top: 20px;">
            <div class="address-row">
              <span>United States</span>
              <span class="edit">EDIT</span>
            </div>
          </div>
        </section>
        <section class="card communication-card">
          <div class="card-header">
            <span>COMMUNICATION SETTINGS</span>
          </div>
          <div class="communication-info">
            <div class="row"><label>Marketing Emails</label><span>Unsubscribed</span></div>
          </div>
        </section>
      </div>
    </main>
  </div>

  <!-- MODAL -->
  <div class="modal-overlay" id="editModal">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="editProfileTitle">
      <div class="modal-header">
        <h1 id="editProfileTitle">EDIT PROFILE</h1>
        <button class="close-btn" id="closeModal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <form method="POST" action="{{ route('user.updateProfile') }}">
        @csrf
        <label for="firstName">First Name</label>
        <input type="text" name="firstName" value="{{ old('firstName', Auth::user()->first_name) }}" />

        <label for="lastName">Last Name</label>
        <input type="text" name="lastName" value="{{ old('lastName', Auth::user()->last_name) }}" />

        <label for="phoneNumber">Phone Number</label>
        <input type="text" name="phoneNumber" value="{{ old('phoneNumber', Auth::user()->phone_number) }}" />

        <label for="email">Email</label>
        <div class="email-container">
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly />
        <i class="fas fa-lock email-lock-icon"></i>
        </div>
        <p class="info-text">This information can not be edited.</p>
        <input type="date" name="birthday" value="{{ old('birthday', Auth::user()->birthday) }}" />

        <button type="submit" class="save-btn">SAVE</button>
        <div class="cancel-text" id="cancelChangePassword">Cancel</div>
      </form>
    </div>
  </div>

 <!-- MODAL CHANGE PASSWORD -->
<div class="modal-overlay" id="changePasswordModal">
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-header">
      <h2 id="modalTitle">CHANGE PASSWORD</h2>
      <button class="close-btn" id="closeChangePasswordModal" aria-label="Close modal">&times;</button>
    </div>
    <form method="POST" action="{{ route('user.changePassword') }}">
      @csrf
      <label for="password">New Password</label>
      <input id="password" name="password" type="password" autocomplete="new-password" required />
      
      <label for="password_confirmation">Confirm New Password</label>
      <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required />
      
      <button type="submit" class="save-btn">SAVE</button>
    </form>
    <div class="cancel-text" id="cancelChangePassword">Cancel</div>
  </div>
</div>

<div id="toast" style="
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 4px;
  padding: 16px;
  position: fixed;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
  z-index: 9999;
  opacity: 0;
  transition: opacity 0.5s, visibility 0.5s;">
</div>

  <script>
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const modalOverlay = document.getElementById('editModal');
    const openProfileModal = document.getElementById('openModal');
    const closeProfileModal = document.getElementById('closeModal');
    const profileModalOverlay = document.getElementById('editModal');

    openModal.addEventListener('click', () => {
      modalOverlay.style.display = 'flex';
    });

    closeModal.addEventListener('click', () => {
      modalOverlay.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
      if (e.target === modalOverlay) {
        modalOverlay.style.display = 'none';
      }
    });

    openProfileModal.addEventListener('click', () => {
    profileModalOverlay.style.display = 'flex';
  });

  closeProfileModal.addEventListener('click', () => {
    profileModalOverlay.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === profileModalOverlay) {
      profileModalOverlay.style.display = 'none';
    }
  });

  // NEW: Change Password Modal
  const openChangePassword = document.querySelector('.password-card .edit');
  const changePasswordModalOverlay = document.getElementById('changePasswordModal');
  const closeChangePasswordModal = document.getElementById('closeChangePasswordModal');
  const cancelChangePassword = document.getElementById('cancelChangePassword');

  openChangePassword.addEventListener('click', () => {
    changePasswordModalOverlay.style.display = 'flex';
  });

  closeChangePasswordModal.addEventListener('click', () => {
    changePasswordModalOverlay.style.display = 'none';
  });

  cancelChangePassword.addEventListener('click', () => {
    changePasswordModalOverlay.style.display = 'none';
  });

  window.addEventListener('click', (e) => {
    if (e.target === changePasswordModalOverlay) {
      changePasswordModalOverlay.style.display = 'none';
    }
  });


  function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.style.visibility = 'visible';
  toast.style.opacity = '1';

  // hilangkan toast setelah 3 detik
  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.visibility = 'hidden';
  }, 3000);
}

 changePasswordForm.addEventListener('submit', async function(e) {
  e.preventDefault();

  const formData = new FormData(changePasswordForm);

  try {
    const response = await fetch("{{ route('user.changePassword') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
      body: formData,
    });

    if (!response.ok) {
      const errorData = await response.json();
      const errorMessage = errorData.errors?.password?.[0] || errorData.message || 'Error mengubah password';
      throw new Error(errorMessage);
    }

    const data = await response.json();

    // tutup modal
    changePasswordModalOverlay.style.display = 'none';

    // reset form
    changePasswordForm.reset();

    // tampilkan toast pesan sukses
    showToast(data.message || 'Password berhasil diubah!');
  } catch (error) {
    // tampilkan toast pesan error
    showToast(error.message);
  }
});

document.getElementById('saveProfile').addEventListener('click', function () {
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const phone = document.getElementById('phoneNumber').value.trim();
    const birthday = document.getElementById('birthday').value.trim();

    // Kirim data ke server via AJAX (opsional, jika backend disiapkan)
    fetch('/update-profile', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({
        first_name: firstName,
        last_name: lastName,
        phone: phone,
        birthday: birthday,
      })
    }).then(response => response.json())
      .then(data => {
        if (data.success) {
          // Update tampilan profile card
          document.getElementById('profileName').textContent = `${firstName} ${lastName}`;
          document.getElementById('profilePhone').textContent = phone;
          document.getElementById('profileBirthday').textContent = birthday;

          // Tutup modal
          document.getElementById('editModal').style.display = 'none';
        } else {
          alert('Failed to update profile.');
        }
      }).catch(() => alert('Error updating profile.'));
  });

  // Modal open/close
  document.getElementById('openModal').onclick = () => {
    document.getElementById('editModal').style.display = 'block';
  };
  document.getElementById('closeModal').onclick = () => {
    document.getElementById('editModal').style.display = 'none';
  };

  document.getElementById('openModal').addEventListener('click', () => {
  document.getElementById('firstName').value = document.getElementById('profileName').textContent.split(' ')[0] || '';
  document.getElementById('lastName').value = document.getElementById('profileName').textContent.split(' ')[1] || '';
  document.getElementById('phoneNumber').value = document.getElementById('profilePhone').textContent || '';
  document.getElementById('birthday').value = document.getElementById('profileBirthday').textContent || '';
});

  </script>
</body>
</html>
@endsection