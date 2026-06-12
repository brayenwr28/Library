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
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* Warna background abu-abu ultra-light modern */
        }

        .edit-card {
            background: white;
            border-radius: 16px; /* Sudut sedikit lebih melengkung agar modern */
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 20px 40px rgba(15, 23, 42, 0.08); /* Soft layered shadow */
        }

        .edit-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); /* Gradasi biru safir kontemporer */
            color: white;
            padding: 35px 40px;
        }

        .edit-header h2 {
            margin: 0;
            font-weight: 700;
            font-size: 1.65em;
            letter-spacing: -0.025em;
        }

        .edit-header p {
            margin: 6px 0 0 0;
            opacity: 0.85;
            font-size: 0.92em;
            font-weight: 400;
        }

        .edit-body {
            padding: 40px;
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b; /* Warna abu-abu gelap slate, lebih ramah di mata */
            margin-bottom: 8px;
            font-size: 0.88em;
            display: block;
            letter-spacing: 0.01em;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 0.95em;
            color: #334155;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
            outline: none;
            color: #0f172a;
        }

        .form-control::placeholder {
            color: #cbd5e1;
        }

        .form-help {
            font-size: 0.8em;
            color: #64748b;
            margin-top: 6px;
            font-weight: 400;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8em;
            margin-top: 6px;
            font-weight: 500;
            display: block;
        }

        .photo-preview {
            width: 140px;
            height: 175px;
            border-radius: 12px;
            overflow: hidden;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #cbd5e1; /* Gaya border dashed agar khas upload area */
            margin-bottom: 15px;
            transition: all 0.2s ease;
        }

        .photo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-placeholder {
            color: #94a3b8;
            font-size: 2.5em;
            text-align: center;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 13px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95em;
            transition: all 0.25s ease;
            width: 100%;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.35);
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            color: white;
            text-decoration: none;
        }

        .btn-submit:active {
            transform: translateY(1px);
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 13px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.95em;
            transition: all 0.2s ease;
            width: 100%;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
            color: #334155;
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
                gap: 15px;
            }

            .edit-body {
                padding: 28px 20px;
            }

            .edit-header {
                padding: 25px 20px;
            }
        }

        .success-message {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 0.9em;
            font-weight: 500;
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