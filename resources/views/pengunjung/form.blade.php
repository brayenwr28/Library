@extends('layouts.app')
@section('title', 'Isi Data Pengunjung')

@section('content')
<section class="bg-gradient-to-br from-slate-100 via-sky-50 to-blue-100/50 min-h-screen py-16 px-4 font-sans">
    <div class="mx-auto max-w-xl">

        <!-- Header Section -->
        <div class="mb-8 text-center animate-fade-in-down">
            <!-- Logo Universitas Metamedia -->
            <div class="flex justify-center mb-5">
                <img src="{{ asset('logo/logo-univ.png') }}" alt="Logo Universitas Metamedia" class="h-16 w-auto object-contain drop-shadow-md transition-transform duration-300 hover:scale-105">
            </div>
            
            <h1 class="text-3xl font-black text-slate-800 tracking-tight mb-2">Presensi Pengunjung</h1>
            <p class="text-slate-500 text-base max-w-sm mx-auto leading-relaxed">
                Selamat datang! Silakan lengkapi data diri Anda untuk layanan perpustakaan.
            </p>
        </div>

        <!-- Form Card (Dibuat kontras tinggi dengan border kelabu tipis dan bayangan tajam) -->
        <div class="bg-white rounded-3xl shadow-2xl shadow-blue-900/10 border border-slate-200/80 overflow-hidden transition-all duration-300 hover:shadow-blue-600/15">
            
            <!-- Mini Header Form (Menggunakan aksen biru logo) -->
            <div class="bg-slate-50 border-b border-slate-100 px-8 py-4 flex items-center justify-between">
                <h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <i class="fas fa-edit text-blue-600"></i> Formulir Digital
                </h2>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full shadow-sm">
                    {{ date('d M Y') }}
                </span>
            </div>

            <form id="pengunjungForm" class="p-8 space-y-6">
                @csrf

                <!-- Input Nama -->
                <div class="group flex flex-col gap-1.5">
                    <label class="text-xs font-bold uppercase tracking-wide text-slate-600 group-focus-within:text-blue-600 transition-colors">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input 
                            type="text" 
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            class="w-full pl-11 pr-5 py-3.5 bg-slate-50 border-2 border-slate-200/70 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 text-slate-700 font-medium"
                            required>
                    </div>
                    <p class="errorNama mt-1 text-xs text-rose-500 font-medium hidden"></p>
                </div>

                <!-- Info Panduan Minimalis (Diubah ke tema biru) -->
                <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 flex gap-3.5">
                    <div class="text-blue-600 mt-0.5">
                        <i class="fas fa-info-circle text-base"></i>
                    </div>
                    <div class="text-xs text-slate-600 leading-relaxed">
                        <span class="font-bold text-blue-900 block mb-1">Panduan Pengisian:</span>
                        <ul class="space-y-1 text-slate-500">
                            <li><b class="text-slate-700">Mahasiswa:</b> Gunakan NIM</li>
                            <li><b class="text-slate-700">Dosen:</b> Gunakan NIDN</li>
                            <li><b class="text-slate-700">Umum:</b> Kosongkan jika tidak ada</li>
                        </ul>
                    </div>
                </div>

                <!-- Input NIM / NIDN -->
                <div class="group flex flex-col gap-1.5">
                    <label class="text-xs font-bold uppercase tracking-wide text-slate-600 group-focus-within:text-blue-600 transition-colors">
                        NIM / NIDN <span class="text-slate-400 font-normal normal-case italic">(Wajib Diisi)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-id-card text-sm"></i>
                        </span>
                        <input 
                            type="text" 
                            name="nim"
                            value="{{ old('nim') }}"
                            class="w-full pl-11 pr-5 py-3.5 bg-slate-50 border-2 border-slate-200/70 rounded-xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all placeholder:text-slate-400 text-slate-700 font-medium">
                    </div>
                </div>

                <!-- Tombol Aksi (Tombol utama menggunakan warna biru solid logo yang kuat) -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="flex-[2] py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 flex items-center justify-center gap-2 group">
                        <span>Simpan Kehadiran</span>
                        <i class="fas fa-arrow-right text-xs opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <a href="/" 
                       class="flex-1 py-3.5 text-center border-2 border-slate-200 text-slate-500 font-semibold rounded-xl hover:bg-slate-50 hover:text-slate-700 transition-all duration-200 flex items-center justify-center text-sm">
                        Kembali
                    </a>
                </div>

                <!-- Keamanan -->
                <div class="flex items-center justify-center gap-1.5 text-[11px] text-slate-400 font-medium pt-2">
                    <i class="fas fa-lock text-[10px]"></i>
                    <span>Sistem Enkripsi Data Keamanan Terjamin</span>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12">
            <p class="text-slate-400 text-xs tracking-wide">
                &copy; {{ date('Y') }} <span class="font-semibold text-slate-600">Perpustakaan Universitas Metamedia</span>.
            </p>
        </div>

    </div>
</section>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-8px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Toast Notification Styles (Mengikuti Aksen Putih-Biru Premium) */
    @keyframes slideInDown {
        from { transform: translateY(-100%) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    @keyframes slideOutUp {
        from { transform: translateY(0) scale(1); opacity: 1; }
        to { transform: translateY(-100%) scale(0.95); opacity: 0; }
    }

    .toast-notification {
        position: fixed;
        top: 24px;
        right: 24px;
        min-width: 320px;
        padding: 16px;
        background: #ffffff;
        color: #1e293b;
        border-radius: 16px;
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 10px 10px -5px rgba(15, 23, 42, 0.05);
        border: 1px solid #e2e8f0;
        animation: slideInDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        align-items: center;
        gap: 14px;
        z-index: 9999;
    }

    .toast-notification.hiding {
        animation: slideOutUp 0.3s ease-in forwards;
    }

    .toast-notification i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .toast-notification.success i { color: #2563eb; }
    .toast-notification.error i { color: #f43f5e; }

    .toast-notification-content { flex: 1; }
    .toast-notification-title { font-weight: 700; font-size: 14px; color: #0f172a; }
    .toast-notification-message { font-size: 13px; color: #64748b; margin-top: 1px; }

    /* Loading state untuk button */
    .btn-loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('pengunjungForm');
        const submitBtn = document.getElementById('submitBtn');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const submitBtnText = submitBtn.innerHTML;

            // Set loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('btn-loading');
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm"></i> <span>Memproses...</span>';

            try {
                const response = await fetch('{{ route("pengunjung.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    showToast('Sukses!', 'Selamat Kamu sudah jadi pengunjung Metamedia Digital', 'success');
                    form.reset();
                    
                    document.querySelectorAll('[class^="error"]').forEach(el => {
                        el.classList.add('hidden');
                        el.textContent = '';
                    });

                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.innerHTML = submitBtnText;
                    }, 1000);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.querySelector(`.error${field.charAt(0).toUpperCase() + field.slice(1)}`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    }
                    
                    showToast('Gagal!', data.message || 'Terjadi kesalahan saat menyimpan data', 'error');
                    
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.innerHTML = submitBtnText;
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error!', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = submitBtnText;
            }
        });

        function showToast(title, message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            
            const icon = type === 'success' 
                ? '<i class="fas fa-check-circle"></i>' 
                : '<i class="fas fa-times-circle"></i>';
            
            toast.innerHTML = `
                ${icon}
                <div class="toast-notification-content">
                    <div class="toast-notification-title">${title}</div>
                    <div class="toast-notification-message">${message}</div>
                </div>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => { toast.remove(); }, 300);
            }, 4000);
        }
    });
</script>
@endsection