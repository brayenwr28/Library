<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profil - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BkyQi+0lKQ8Zq+6N0hZl5uN5l5Z4O3BO6cK7VQ0YzJis+qJfFZ0CPt2jT9sSk6U2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .edit-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .edit-header {
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
            color: white;
            padding: 30px;
        }

        .edit-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.8em;
        }

        .edit-header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 0.95em;
        }

        .edit-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 0.95em;
            display: block;
        }

        .form-control {
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 0.95em;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #003d7a;
            box-shadow: 0 0 0 3px rgba(0, 61, 122, 0.1);
            outline: none;
        }

        .form-help {
            font-size: 0.8em;
            color: #888;
            margin-top: 5px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.8em;
            margin-top: 5px;
            display: block;
        }

        .photo-preview {
            width: 150px;
            height: 180px;
            border-radius: 8px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #e0e0e0;
            margin-bottom: 15px;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: #999;
            font-size: 3em;
            text-align: center;
        }

        .btn-submit {
            background: linear-gradient(to right, #003d7a 0%, #0052a3 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            cursor: pointer;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(0, 61, 122, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-cancel {
            background: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
            color: #333;
            text-decoration: none;
        }

        .row-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        @media (max-width: 768px) {
            .row-2col {
                grid-template-columns: 1fr;
            }

            .edit-body {
                padding: 25px;
            }

            .edit-header {
                padding: 20px;
            }
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Message -->
                @if (session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Terjadi Kesalahan!</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Edit Card -->
                <div class="edit-card">
                    <!-- Header -->
                    <div class="edit-header">
                        <h2>
                            <i class="fas fa-user-edit me-2"></i>Edit Profil
                        </h2>
                        <p>Perbarui informasi pribadi dan data akademik Anda</p>
                    </div>

                    <!-- Body -->
                    <div class="edit-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Username -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-user me-2" style="color: #003d7a;"></i>Username
                                </label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username', $member->username) }}" readonly>
                                <p class="form-help">Username tidak dapat diubah</p>
                                @error('username')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Nama Lengkap -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-signature me-2" style="color: #003d7a;"></i>Nama Lengkap
                                </label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $member->name) }}" required>
                                @error('name')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Two Column Section -->
                            <div class="row-2col">
                                <!-- Email -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-envelope me-2" style="color: #003d7a;"></i>Email
                                    </label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $member->email) }}" required>
                                    @error('email')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- NIM (Nomor Induk Mahasiswa) -->
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-id-card me-2" style="color: #003d7a;"></i>Nomor Induk Mahasiswa (NIM)
                                    </label>
                                    <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                        value="{{ old('nim', $member->nim) }}" required>
                                    @error('nim')
                                        <span class="error-message">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Program Studi -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-graduation-cap me-2" style="color: #003d7a;"></i>Program Studi
                                </label>
                                <input type="text" name="prodi" class="form-control @error('prodi') is-invalid @enderror"
                                    value="{{ old('prodi', $member->prodi) }}" placeholder="Contoh: Teknik Informatika" required>
                                @error('prodi')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Foto Profil -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-image me-2" style="color: #003d7a;"></i>Foto Profil (Opsional)
                                </label>
                                <p class="form-help">Format: JPG, PNG. Ukuran maksimal: 2MB</p>

                                <!-- Photo Preview -->
                                <div class="photo-preview">
                                    @if ($member->photo && file_exists(public_path('storage/' . $member->photo)))
                                        <img id="photoPreview" src="{{ asset('storage/' . $member->photo) }}" alt="Foto Profil">
                                    @else
                                        <div class="photo-placeholder" id="photoPlaceholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- File Input -->
                                <input type="file" name="photo" id="photoInput" accept="image/jpeg,image/png"
                                    class="form-control @error('photo') is-invalid @enderror"
                                    onchange="previewPhoto(event)">
                                @error('photo')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Tanggal Daftar (Read Only) -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-calendar me-2" style="color: #003d7a;"></i>Tanggal Daftar
                                </label>
                                <input type="text" class="form-control" 
                                    value="{{ $member->tgl_daftar ? $member->tgl_daftar->format('d-m-Y') : '-' }}" readonly>
                                <p class="form-help">Tanggal daftar tidak dapat diubah</p>
                            </div>

                            <!-- Nomor Member (Read Only) -->
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-hashtag me-2" style="color: #003d7a;"></i>Nomor Member
                                </label>
                                <input type="text" class="form-control" value="{{ $member->member_id }}" readonly>
                                <p class="form-help">Nomor member tidak dapat diubah</p>
                            </div>

                            <!-- Form Buttons -->
                            <div class="row-2col mt-5">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn-cancel">
                                    <i class="fas fa-arrow-left me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Photo Preview -->
    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const photoPreview = document.querySelector('.photo-preview');
            const photoPlaceholder = document.getElementById('photoPlaceholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    let img = photoPreview.querySelector('img');
                    if (!img) {
                        img = document.createElement('img');
                        img.id = 'photoPreview';
                        photoPreview.innerHTML = '';
                        photoPreview.appendChild(img);
                    }
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>