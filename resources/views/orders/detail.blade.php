@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Detail Pesanan</title>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<style>
body {
    background-color: #ffffff;
    font-family: 'Segoe UI', sans-serif;
}
.header-area {
    text-align: center;
    padding: 40px 20px 20px;
}
.header-area h1 {
    font-size: 32px;
    font-weight: 700;
    color: #2c3e50;
}
.card {
    background-color: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 24px;
    max-width: 900px;
    margin: 30px auto;
}
.card-section {
    margin-bottom: 20px;
}
.card-section h3 {
    font-weight: 700;
    font-size: 24px;
    color: #2c3e50;
    margin-bottom: 16px;
    border-bottom: 2px solid #e67e22;
    padding-bottom: 8px;
}
.info-item {
    font-size: 16px;
    color: #34495e;
    margin-bottom: 8px;
}
.address-input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #ccc;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
}
table thead tr {
    background-color: #f1c40f;
    color: #2c3e50;
    font-weight: 600;
}
table th, table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
    font-size: 14px;
}
table tbody tr:hover {
    background-color: #f9f9f9;
}
.btn-primary, .btn-pay {
    background-color: #e67e22;
    border: none;
    padding: 12px 30px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    display: inline-block;
    margin-top: 20px;
    text-decoration: none;
    text-align: center;
}
.btn-primary:hover, .btn-pay:hover {
    background-color: #d35400;
    text-decoration: none;
    color: white;
}
.btn-pay:disabled {
    background-color: #95a5a6;
    cursor: not-allowed;
}
.loading {
    position: relative;
}
.loading:after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-top: -10px;
    margin-left: -10px;
    border: 3px solid rgba(255,255,255,0.3);
    border-radius: 50%;
    border-top: 3px solid #fff;
    animation: spin 1s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.step-indicator {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
  position: relative;
  max-width: 560px;
  margin-left: auto;
  margin-right: auto;
  font-family: 'Segoe UI', sans-serif;
}

.step {
  text-align: center;
  position: relative;
  flex: 1;
  z-index: 1;
}

.step .circle {
  width: 36px;
  height: 36px;
  margin: 0 auto 8px auto;
  border-radius: 50%;
  background-color: #ccc;
  color: white;
  font-weight: 700;
  line-height: 36px;
  font-size: 18px;
  user-select: none;
  transition: background-color 0.3s ease;
}

.step.active .circle {
  background-color: #e67e22;
}

.step .label {
  font-size: 14px;
  color: #34495e;
  user-select: none;
}

/* Garis penghubung */
.step-indicator::before {
  content: '';
  position: absolute;
  top: 18px; /* Vertikal center garis sesuai lingkaran */
  left: 18px;
  right: 18px;
  height: 4px;
  background-color: #ccc;
  z-index: 0;
  border-radius: 2px;
}

/* Warna garis sampai step aktif */
.step.active ~ .step .circle {
  background-color: #ccc;
}

.step.active::before {
  content: none;
}

.step-indicator .step.active ~ .step::before {
  content: none;
}

/* Garis aktif sampai step aktif */
.step-indicator .step.active ~ .step .circle {
  background-color: #ccc;
}

.step-indicator .step.active {
  /* Garis di kiri lingkaran aktif warna oranye */
  position: relative;
}

.step-indicator .step.active::before {
  content: '';
  position: absolute;
  top: 18px;
  left: -50%;
  width: 50%;
  height: 4px;
  background-color: #e67e22;
  z-index: -1;
  border-radius: 2px;
}

/* Garis kiri untuk step pertama tidak ada */
.step-indicator .step:first-child::before {
  content: none;
}

#add-address-modal > div {
  max-height: 80vh;      /* batasi tinggi maksimum modal supaya tidak melebihi viewport */
  overflow-y: auto;      /* aktifkan scroll vertikal jika konten melebihi max-height */
}

#address-modal > div {
  max-height: 80vh;      /* Maksimal tinggi modal 80% viewport */
  overflow-y: auto;      /* Aktifkan scroll vertikal jika konten melebihi max-height */
  /* jaga supaya modal tetap punya padding dan lebar */
  padding: 30px;
  box-sizing: border-box;
}

</style>
</head>
<body>
<div class="header-area">
    <h1>Detail Pesanan {{ $order->order_code }}</h1>
</div>

<div class="card">
    <div class="card-section">
        <p class="info-item"><strong>Status Pesanan:</strong> {{ ucfirst($order->status) }}</p>
        <p class="info-item"><strong>Status Pembayaran:</strong> {{ ucfirst($order->payment_status) }}</p>
        <p class="info-item"><strong>Total Harga:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        <p class="info-item"><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

        <div id="address-display">
            <p class="info-item">
                <strong>Alamat Pengiriman:</strong>
                <span id="address-text">{{ $order->shipping_address }}</span>
                <button type="button" id="edit-address-button" class="btn-primary" style="padding: 4px 12px; font-size: 14px; margin-left: 10px;">Ganti</button>
            </p>
        </div>
    </div>

    <div class="card-section">
        <h3>Detail Item Pesanan</h3>
        <table>
            <thead>
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->menu->name ?? 'Produk tidak ditemukan' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('orders.index') }}" class="btn-primary">Kembali ke Daftar Pesanan</a>
     <button class="btn-pay" id="pay-button" {{ $order->payment_status === 'paid' ? 'disabled' : '' }}>
        {{ $order->payment_status === 'paid' ? 'Sudah Dibayar' : 'Bayar Sekarang' }}
    </button>
    
    @if($order->payment_status === 'paid')
    <div style="margin-top: 15px; color: #27ae60; font-weight: bold;">
        ✓ Pembayaran telah berhasil dilakukan
    </div>
    @endif
</div>

<!-- Modal Alamat Lama -->
<div id="address-modal" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 999;">
    <div style="background: #fff; width: 600px; margin: 60px auto; padding: 30px; border-radius: 16px; position: relative;">
        <button onclick="closeModal()" style="position: absolute; top: 12px; right: 20px; background: none; border: none; font-size: 20px;">×</button>
        <h2 style="color: #2c3e50; font-size: 20px; font-weight: 700; margin-bottom: 20px;">Daftar Alamat</h2>

        <input type="text" id="search-address" class="address-input" placeholder="Cari atau masukkan alamat baru..." oninput="filterAddresses()">
        <button onclick="openAddAddressSteps()" class="btn-primary" style="margin-top: 20px;">Tambah Alamat Baru</button>

        <hr style="margin: 30px 0; border-color: #eee;">

        <div id="saved-addresses">
            <div class="saved-address" style="border: 1px solid #ccc; padding: 15px; border-radius: 10px; margin-bottom: 12px;">
                <p><strong>Kos</strong> - Arya Anugrah</p>
                <p class="address-text" style="font-size: 14px;">Kembaran rt 07 tamantirto kasihan bantul</p>
                <button onclick="selectAddress('Kembaran rt 07 tamantirto kasihan bantul')" class="btn-primary" style="margin-top: 8px;">Pilih</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat 3 Langkah -->
<div id="add-address-modal" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.5); z-index: 1000;">
    <div style="background: #fff; width: 600px; margin: 60px auto; padding: 30px; border-radius: 16px; position: relative;">

    <!-- Tombol Back di kiri atas -->
    <button id="back-button" style="
      position: absolute;
      top: 12px;
      left: 20px;
      background: none;
      border: none;
      font-size: 24px;
      font-weight: 700;
      cursor: pointer;
      user-select: none;">&#8592;</button>

        <button onclick="closeAddAddressModal()" style="position: absolute; top: 12px; right: 20px; background: none; border: none; font-size: 20px;">×</button>
        <h2 style="margin-bottom: 20px; color: #2c3e50;">Tambah Alamat</h2>

         <!-- Step Indicator -->
<div class="step-indicator">
  <div class="step active">
    <div class="circle">1</div>
    <div class="label">Cari Lokasi</div>
  </div>
  <div class="step">
    <div class="circle">2</div>
    <div class="label">Tentukan Pinpoint</div>
  </div>
  <div class="step">
    <div class="circle">3</div>
    <div class="label">Detail Alamat</div>
  </div>
</div>

        <div id="step-1" class="address-step">
            <h3>Dimana lokasi tujuan pengirimanmu?</h3>
            <input type="text" id="step1-input" placeholder="Tulis nama jalan / gedung / perumahan" class="address-input">
            <button onclick="useCurrentLocation()" class="btn-primary" style="margin-top: 10px;">Gunakan Lokasi Saat Ini</button>
        </div>

        <div id="step-2" class="address-step" style="display: none;">
            <h3>2. Tentukan pinpoint lokasi</h3>
            <div id="map" style="width: 100%; height: 400px; border-radius: 10px; margin-bottom: 10px;"></div>
            <p id="selected-address" style="font-size: 14px; color: #555;"></p>
            <button onclick="goToStep(3)" class="btn-primary" style="margin-top: 10px;">Pilih Lokasi & Lanjut Isi Alamat</button>
        </div>

        <div id="step-3" class="address-step" style="display: none;">
    <h3>3. Lengkapi detail alamat</h3>

    <p><strong>Pinpoint:</strong> <span id="pinpoint-coordinates">-</span></p>
    <p><strong>Label Alamat:</strong> <span id="label-address">-</span></p>

    <label for="step3-address" style="font-weight: 600; margin-top: 12px; display: block;">Alamat Lengkap:</label>
    <textarea id="step3-address" placeholder="Detail alamat lengkap..." class="address-input" rows="3"></textarea>

    <label for="step3-note" style="font-weight: 600; margin-top: 12px; display: block;">Catatan Tambahan:</label>
    <textarea id="step3-note" placeholder="Catatan tambahan (opsional)..." class="address-input" rows="2"></textarea>

    <label for="step3-recipient" style="font-weight: 600; margin-top: 12px; display: block;">Nama Penerima:</label>
    <input type="text" id="step3-recipient" class="address-input" placeholder="Nama penerima">

    <label for="step3-phone" style="font-weight: 600; margin-top: 12px; display: block;">Nomor HP:</label>
    <input type="text" id="step3-phone" class="address-input" placeholder="08123456789">

    <div style="margin-top: 12px;">
        <input type="checkbox" id="step3-main-address">
        <label for="step3-main-address">Jadikan alamat utama</label>
    </div>

    <div style="margin-top: 8px;">
        <input type="checkbox" id="step3-agree-terms">
        <label for="step3-agree-terms">Saya menyetujui <a href="#" target="_blank">syarat dan ketentuan</a><label for="step3-agree-terms">serta<a href="#" target="_blank">Kebijakan Privasi</a>
    <label for="step3-agree-terms">pengaturan alamat di TokoRoti.</label>
    </div>

    <button onclick="saveNewAddress()" class="btn-primary" style="margin-top: 20px;">Simpan Alamat</button>
</div>

    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://app.{{ config('midtrans.is_production') ? 'midtrans' : 'sandbox.midtrans' }}.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
let currentStep = 1;
let map;
let marker;
let selectedAddress = '';
const backButton = document.getElementById('back-button');
const csrfToken = '{{ csrf_token() }}';

// Fungsi untuk setup CSRF token untuk fetch
function setupAjaxCsrf() {
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        if (!options.headers) {
            options.headers = {};
        }
        if (!options.method || options.method !== 'GET') {
            options.headers['X-CSRF-TOKEN'] = csrfToken;
        }
        return originalFetch(url, options);
    };
}

// Event tombol "Back"
backButton.addEventListener('click', () => {
    if(currentStep === 1) {
        closeAddAddressModal();
    } else {
        goToStep(currentStep - 1);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    setupAjaxCsrf();

    const payButton = document.getElementById('pay-button');
    if (!payButton) {
        console.error('Tombol bayar tidak ditemukan');
        return;
    }

    // Jika status pembayaran sudah "paid"
    if ('{{ $order->payment_status }}' === 'paid') {
        payButton.disabled = true;
        payButton.textContent = 'Sudah Dibayar';
        payButton.classList.add('disabled');
    }

    // Saat tombol bayar diklik
    payButton.addEventListener('click', function () {
        // Tampilkan status loading pada tombol
        payButton.disabled = true;
        payButton.textContent = 'Memproses...';
        payButton.classList.add('loading');

        // Ambil token Snap dari server
        fetch("{{ route('orders.getSnapToken', $order->id) }}")
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.error || 'Gagal mengambil token pembayaran');
                });
            }
            return response.json();
        })
        .then(data => {
            // Hapus status loading
            payButton.classList.remove('loading');

            if (!data.snap_token) {
                throw new Error('Token pembayaran tidak ditemukan');
            }

            console.log('Snap token diterima:', data.snap_token);

            // Reset tombol
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';

            // Jalankan Midtrans Snap dengan konfigurasi callback yang lengkap
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    // Pembayaran berhasil
                    console.log('✅ Pembayaran berhasil:', result);
                    alert("🟢 Pembayaran berhasil! Status: settlement");

                    // Update UI
                    document.getElementById('payment-status').innerText = 'paid';
                    payButton.disabled = true;
                    payButton.textContent = 'Sudah Dibayar';

                    // Refresh halaman untuk menampilkan status terbaru
                    window.location.reload();
                },
                onPending: function(result) {
                    // Pembayaran pending (menunggu transfer)
                    console.log('🟡 Pembayaran pending:', result);
                    alert("Transaksi dibuat. Silakan selesaikan pembayaran melalui " +
                          (result.payment_type || "metode yang dipilih") +
                          ". Status: pending");

                    // Refresh halaman untuk menampilkan status terbaru
                    window.location.reload();
                },
                onError: function(result) {
                    // Pembayaran gagal
                    console.error('❌ Pembayaran gagal:', result);
                    alert("🔴 Pembayaran gagal. Status: deny. Pesan: " +
                          (result.status_message || "Silakan coba lagi."));
                },
                onClose: function() {
                    // User menutup popup tanpa menyelesaikan pembayaran
                    console.log('⚫ User menutup popup tanpa menyelesaikan pembayaran');
                    alert("Anda menutup popup tanpa menyelesaikan pembayaran. Status: cancel / expire.");
                }
            });
        })
        .catch(error => {
            // Hapus status loading dan reset tombol
            payButton.classList.remove('loading');
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';

            // Tampilkan pesan error
            console.error('Payment error detail:', error);
            alert('Error pembayaran: ' + error.message);
        });
    });
});

document.getElementById('edit-address-button').addEventListener('click', function () {
    document.getElementById('address-modal').style.display = 'block';
});

function closeModal() {
    document.getElementById('address-modal').style.display = 'none';
}

function selectAddress(address) {
    // Tampilkan loading state
    const addressText = document.getElementById('address-text');
    const originalText = addressText.innerText;
    addressText.innerText = 'Menyimpan...';

    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ _method: 'PUT', shipping_address: address })
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('address-text').innerText = address;
            closeModal();
        } else {
            // Kembalikan text asli jika gagal
            addressText.innerText = originalText;
            alert("Gagal menyimpan alamat.");
        }
    })
    .catch(error => {
        // Kembalikan text asli jika error
        addressText.innerText = originalText;
        console.error('Error updating address:', error);
        alert("Terjadi kesalahan saat menyimpan alamat.");
    });
}

function filterAddresses() {
    const query = document.getElementById('search-address').value.toLowerCase();
    const addressBlocks = document.querySelectorAll('#saved-addresses .saved-address');
    addressBlocks.forEach(block => {
        const text = block.innerText.toLowerCase();
        block.style.display = text.includes(query) ? 'block' : 'none';
    });
}

function addNewAddress() {
    const newAddress = document.getElementById('search-address').value.trim();
    if (!newAddress) return alert("Silakan masukkan alamat terlebih dahulu.");
    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ _method: 'PUT', shipping_address: newAddress })
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('address-text').innerText = newAddress;
            closeModal();
        } else {
            alert("Gagal menambahkan alamat baru.");
        }
    })
    .catch(() => alert("Terjadi kesalahan."));
}

function openAddAddressSteps() {
    document.getElementById('add-address-modal').style.display = 'block';
    goToStep(1);
}

function closeAddAddressModal() {
    document.getElementById('add-address-modal').style.display = 'none';
    // Reset step ke 1 jika perlu
    goToStep(1);
  }

  function submitAddress() {
    alert('Alamat disimpan!');
    closeAddAddressModal();
  }

function goToStep(step) {
    currentStep = step;
    for(let i=1; i<=3; i++) {
        document.getElementById(`step-${i}`).style.display = (i === step) ? 'block' : 'none';
    }
    updateStepIndicator(step);  // Panggil update step indicator

    if(step === 2) {
        initMap(); // Panggil fungsi peta kalau perlu
    }
}

function updateStepIndicator(activeStep) {
    const steps = document.querySelectorAll('.step-indicator .step');
    steps.forEach((el, index) => {
        if (index + 1 === activeStep) {
            el.classList.add('active');
        } else {
            el.classList.remove('active');
        }
    });
}

function useCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            goToStep(2);
            setMap(lat, lng);
            reverseGeocode(lat, lng);
        }, () => alert("Gagal mendapatkan lokasi."));
    } else {
        alert("Browser tidak mendukung Geolocation.");
    }
}

function initMap() {
    if (map) {
        // Map sudah diinisialisasi
        return;
    }
    const defaultLatLng = [-7.801194, 110.364917];
    map = L.map('map').setView(defaultLatLng, 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    map.on('click', function(e) {
        const latlng = e.latlng;
        setMarker(latlng.lat, latlng.lng);
        reverseGeocode(latlng.lat, latlng.lng);
    });
}

function setMap(lat, lng) {
    if (!map) {
        initMap();
    }
    setMarker(lat, lng);
    map.setView([lat, lng], 15);
}

function setMarker(lat, lng) {
    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
    .then(response => response.json())
    .then(data => {
        if (data && data.display_name) {
            selectedAddress = data.display_name;
            document.getElementById('selected-address').innerText = selectedAddress;

            // Update label alamat dan koordinat di step 3
            document.getElementById('label-address').innerText = selectedAddress;
            document.getElementById('pinpoint-coordinates').innerText = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        } else {
            document.getElementById('selected-address').innerText = "Alamat tidak ditemukan";
            document.getElementById('label-address').innerText = "-";
            document.getElementById('pinpoint-coordinates').innerText = "-";
        }
    })
    .catch(() => {
        document.getElementById('selected-address').innerText = "Alamat tidak ditemukan";
        document.getElementById('label-address').innerText = "-";
        document.getElementById('pinpoint-coordinates').innerText = "-";
    });
}


function saveNewAddress() {
    const detail = document.getElementById('step3-address').value.trim();
    const note = document.getElementById('step3-note').value.trim();
    const recipient = document.getElementById('step3-recipient').value.trim();
    const phone = document.getElementById('step3-phone').value.trim();
    const mainAddress = document.getElementById('step3-main-address').checked;
    const agreeTerms = document.getElementById('step3-agree-terms').checked;

    if (!selectedAddress) {
        return alert("Harap tentukan lokasi pinpoint terlebih dahulu.");
    }
    if (!detail) {
        return alert("Harap isi alamat lengkap.");
    }
    if (!recipient) {
        return alert("Harap isi nama penerima.");
    }
    if (!phone) {
        return alert("Harap isi nomor HP.");
    }
    if (!agreeTerms) {
        return alert("Anda harus menyetujui syarat dan ketentuan.");
    }

    // Gabungkan alamat utama dengan detail tambahan dan catatan
    let fullAddress = selectedAddress + ", " + detail;
    if(note) fullAddress += " (Catatan: " + note + ")";

    // Tampilkan loading state
    const saveButton = document.querySelector('#step-3 .btn-primary');
    const originalText = saveButton.textContent;
    saveButton.textContent = 'Menyimpan...';
    saveButton.disabled = true;

    // Kirim data ke server
    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            _method: 'PUT',
            shipping_address: fullAddress,
            recipient: recipient,
            phone: phone,
            main_address: mainAddress
        })
    })
    .then(response => {
        // Reset button state
        saveButton.textContent = originalText;
        saveButton.disabled = false;

        if(response.ok) {
            document.getElementById('address-text').innerText = fullAddress;
            closeAddAddressModal();

            if(mainAddress) {
                addAddressToList(fullAddress, recipient);
            }

            alert("Alamat berhasil disimpan.");
        } else {
            alert("Gagal menyimpan alamat.");
        }
    })
    .catch(error => {
        // Reset button state
        saveButton.textContent = originalText;
        saveButton.disabled = false;

        console.error('Error saving address:', error);
        alert("Terjadi kesalahan saat menyimpan alamat.");
    });
}

// Fungsi untuk menambahkan alamat baru ke daftar alamat di modal
function addAddressToList(address, recipient) {
    const container = document.getElementById('saved-addresses');

    // Buat elemen baru sesuai format alamat tersimpan
    const newAddressDiv = document.createElement('div');
    newAddressDiv.classList.add('saved-address');
    newAddressDiv.style.border = "1px solid #ccc";
    newAddressDiv.style.padding = "15px";
    newAddressDiv.style.borderRadius = "10px";
    newAddressDiv.style.marginBottom = "12px";

    // Konten alamat
    newAddressDiv.innerHTML = `
        <p><strong>Alamat Baru</strong> - ${recipient}</p>
        <p class="address-text" style="font-size: 14px;">${address}</p>
        <button class="btn-primary" style="margin-top: 8px;">Pilih</button>
    `;

    // Tambahkan event listener untuk tombol Pilih
    const selectBtn = newAddressDiv.querySelector('button');
    selectBtn.addEventListener('click', () => {
        selectAddress(address);
    });

    // Masukkan alamat baru ke dalam container
    container.prepend(newAddressDiv);
}

</script>
<script>
let currentStep = 1;
let map;
let marker;
let selectedAddress = '';
const backButton = document.getElementById('back-button');
const csrfToken = '{{ csrf_token() }}';

// Fungsi untuk setup CSRF token untuk fetch
function setupAjaxCsrf() {
    const originalFetch = window.fetch;
    window.fetch = function(url, options = {}) {
        if (!options.headers) {
            options.headers = {};
        }
        if (!options.method || options.method !== 'GET') {
            options.headers['X-CSRF-TOKEN'] = csrfToken;
        }
        return originalFetch(url, options);
    };
}

// Event tombol "Back"
backButton.addEventListener('click', () => {
    if(currentStep === 1) {
        closeAddAddressModal();
    } else {
        goToStep(currentStep - 1);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    setupAjaxCsrf();

    const payButton = document.getElementById('pay-button');
    if (!payButton) {
        console.error('Tombol bayar tidak ditemukan');
        return;
    }

    // Jika status pembayaran sudah "paid"
    if ('{{ $order->payment_status }}' === 'paid') {
        payButton.disabled = true;
        payButton.textContent = 'Sudah Dibayar';
        payButton.classList.add('disabled');
    }

    // Saat tombol bayar diklik
    payButton.addEventListener('click', function () {
        payButton.disabled = true;
        payButton.textContent = 'Memproses...';

        fetch("{{ route('orders.getSnapToken', $order->id) }}")
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.error || 'Gagal mengambil token pembayaran');
                });
            }
            return response.json();
        })
        .then(data => {
            if (!data.snap_token) {
                throw new Error('Token pembayaran tidak ditemukan');
            }

            console.log('Snap token diterima:', data.snap_token);
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';

            // Jalankan Midtrans Snap
            window.snap.pay(data.snap_token, {
                onSuccess: function(result) {
                    console.log('✅ Pembayaran berhasil:', result);
                    alert("🟢 Pembayaran berhasil! Status: settlement");
                    window.location.reload();
                },
                onPending: function(result) {
                    console.log('🟡 Pembayaran pending (menunggu transfer):', result);
                    alert("Transaksi dibuat. Silakan selesaikan pembayaran melalui Virtual Account. Status: pending");
                    window.location.reload();
                },
                onError: function(result) {
                    console.error('❌ Pembayaran gagal (denied):', result);
                    alert("🔴 Pembayaran gagal. Status: deny. Pesan: " + (result.status_message || "Silakan coba lagi."));
                },
                onClose: function() {
                    console.log('⚫ User menutup popup tanpa menyelesaikan pembayaran');
                    alert("Anda menutup popup tanpa menyelesaikan pembayaran. Status: cancel / expire.");
                }
            });
        })
        .catch(error => {
            payButton.disabled = false;
            payButton.textContent = 'Bayar Sekarang';
            console.error('Payment error detail:', error);
            alert('Error pembayaran: ' + error.message);
        });
    });
});

document.getElementById('edit-address-button').addEventListener('click', function () {
    document.getElementById('address-modal').style.display = 'block';
});

function closeModal() {
    document.getElementById('address-modal').style.display = 'none';
}

function selectAddress(address) {
    // Tampilkan loading state
    const addressText = document.getElementById('address-text');
    const originalText = addressText.innerText;
    addressText.innerText = 'Menyimpan...';

    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ _method: 'PUT', shipping_address: address })
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('address-text').innerText = address;
            closeModal();
        } else {
            // Kembalikan text asli jika gagal
            addressText.innerText = originalText;
            alert("Gagal menyimpan alamat.");
        }
    })
    .catch(error => {
        // Kembalikan text asli jika error
        addressText.innerText = originalText;
        console.error('Error updating address:', error);
        alert("Terjadi kesalahan saat menyimpan alamat.");
    });
}

function filterAddresses() {
    const query = document.getElementById('search-address').value.toLowerCase();
    const addressBlocks = document.querySelectorAll('#saved-addresses .saved-address');
    addressBlocks.forEach(block => {
        const text = block.innerText.toLowerCase();
        block.style.display = text.includes(query) ? 'block' : 'none';
    });
}

function addNewAddress() {
    const newAddress = document.getElementById('search-address').value.trim();
    if (!newAddress) return alert("Silakan masukkan alamat terlebih dahulu.");
    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ _method: 'PUT', shipping_address: newAddress })
    })
    .then(response => {
        if (response.ok) {
            document.getElementById('address-text').innerText = newAddress;
            closeModal();
        } else {
            alert("Gagal menambahkan alamat baru.");
        }
    })
    .catch(() => alert("Terjadi kesalahan."));
}

function openAddAddressSteps() {
    document.getElementById('add-address-modal').style.display = 'block';
    goToStep(1);
}

function closeAddAddressModal() {
    document.getElementById('add-address-modal').style.display = 'none';
    // Reset step ke 1 jika perlu
    goToStep(1);
  }

  function submitAddress() {
    alert('Alamat disimpan!');
    closeAddAddressModal();
  }

function goToStep(step) {
    currentStep = step;
    for(let i=1; i<=3; i++) {
        document.getElementById(`step-${i}`).style.display = (i === step) ? 'block' : 'none';
    }
    updateStepIndicator(step);  // Panggil update step indicator

    if(step === 2) {
        initMap(); // Panggil fungsi peta kalau perlu
    }
}

function updateStepIndicator(activeStep) {
    const steps = document.querySelectorAll('.step-indicator .step');
    steps.forEach((el, index) => {
        if (index + 1 === activeStep) {
            el.classList.add('active');
        } else {
            el.classList.remove('active');
        }
    });
}

function useCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            goToStep(2);
            setMap(lat, lng);
            reverseGeocode(lat, lng);
        }, () => alert("Gagal mendapatkan lokasi."));
    } else {
        alert("Browser tidak mendukung Geolocation.");
    }
}

function initMap() {
    if (map) {
        // Map sudah diinisialisasi
        return;
    }
    const defaultLatLng = [-7.801194, 110.364917];
    map = L.map('map').setView(defaultLatLng, 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    map.on('click', function(e) {
        const latlng = e.latlng;
        setMarker(latlng.lat, latlng.lng);
        reverseGeocode(latlng.lat, latlng.lng);
    });
}

function setMap(lat, lng) {
    if (!map) {
        initMap();
    }
    setMarker(lat, lng);
    map.setView([lat, lng], 15);
}

function setMarker(lat, lng) {
    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
}

function reverseGeocode(lat, lng) {
    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
    .then(response => response.json())
    .then(data => {
        if (data && data.display_name) {
            selectedAddress = data.display_name;
            document.getElementById('selected-address').innerText = selectedAddress;

            // Update label alamat dan koordinat di step 3
            document.getElementById('label-address').innerText = selectedAddress;
            document.getElementById('pinpoint-coordinates').innerText = `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        } else {
            document.getElementById('selected-address').innerText = "Alamat tidak ditemukan";
            document.getElementById('label-address').innerText = "-";
            document.getElementById('pinpoint-coordinates').innerText = "-";
        }
    })
    .catch(() => {
        document.getElementById('selected-address').innerText = "Alamat tidak ditemukan";
        document.getElementById('label-address').innerText = "-";
        document.getElementById('pinpoint-coordinates').innerText = "-";
    });
}


function saveNewAddress() {
    const detail = document.getElementById('step3-address').value.trim();
    const note = document.getElementById('step3-note').value.trim();
    const recipient = document.getElementById('step3-recipient').value.trim();
    const phone = document.getElementById('step3-phone').value.trim();
    const mainAddress = document.getElementById('step3-main-address').checked;
    const agreeTerms = document.getElementById('step3-agree-terms').checked;

    if (!selectedAddress) {
        return alert("Harap tentukan lokasi pinpoint terlebih dahulu.");
    }
    if (!detail) {
        return alert("Harap isi alamat lengkap.");
    }
    if (!recipient) {
        return alert("Harap isi nama penerima.");
    }
    if (!phone) {
        return alert("Harap isi nomor HP.");
    }
    if (!agreeTerms) {
        return alert("Anda harus menyetujui syarat dan ketentuan.");
    }

    // Gabungkan alamat utama dengan detail tambahan dan catatan
    let fullAddress = selectedAddress + ", " + detail;
    if(note) fullAddress += " (Catatan: " + note + ")";

    // Tampilkan loading state
    const saveButton = document.querySelector('#step-3 .btn-primary');
    const originalText = saveButton.textContent;
    saveButton.textContent = 'Menyimpan...';
    saveButton.disabled = true;

    // Kirim data ke server
    fetch("{{ route('orders.update_address', $order->id) }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            _method: 'PUT',
            shipping_address: fullAddress,
            recipient: recipient,
            phone: phone,
            main_address: mainAddress
        })
    })
    .then(response => {
        // Reset button state
        saveButton.textContent = originalText;
        saveButton.disabled = false;

        if(response.ok) {
            document.getElementById('address-text').innerText = fullAddress;
            closeAddAddressModal();

            if(mainAddress) {
                addAddressToList(fullAddress, recipient);
            }

            alert("Alamat berhasil disimpan.");
        } else {
            alert("Gagal menyimpan alamat.");
        }
    })
    .catch(error => {
        // Reset button state
        saveButton.textContent = originalText;
        saveButton.disabled = false;

        console.error('Error saving address:', error);
        alert("Terjadi kesalahan saat menyimpan alamat.");
    });
}

// Fungsi untuk menambahkan alamat baru ke daftar alamat di modal
function addAddressToList(address, recipient) {
    const container = document.getElementById('saved-addresses');

    // Buat elemen baru sesuai format alamat tersimpan
    const newAddressDiv = document.createElement('div');
    newAddressDiv.classList.add('saved-address');
    newAddressDiv.style.border = "1px solid #ccc";
    newAddressDiv.style.padding = "15px";
    newAddressDiv.style.borderRadius = "10px";
    newAddressDiv.style.marginBottom = "12px";

    // Konten alamat
    newAddressDiv.innerHTML = `
        <p><strong>Alamat Baru</strong> - ${recipient}</p>
        <p class="address-text" style="font-size: 14px;">${address}</p>
        <button class="btn-primary" style="margin-top: 8px;">Pilih</button>
    `;

    // Tambahkan event listener untuk tombol Pilih
    const selectBtn = newAddressDiv.querySelector('button');
    selectBtn.addEventListener('click', () => {
        selectAddress(address);
    });

    // Masukkan alamat baru ke dalam container
    container.prepend(newAddressDiv);
}

</script>

</body>
</html>
@endsection