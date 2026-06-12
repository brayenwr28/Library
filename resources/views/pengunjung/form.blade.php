@extends('layouts.app')
@section('title', 'Isi Data Pengunjung')

@section('content')
<section class="bg-gradient-to-br from-slate-50 via-emerald-50 to-teal-50 min-h-screen py-16 px-4">
    <div class="mx-auto max-w-2xl">

        <div class="mb-10 text-center animate-fade-in-down">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white mb-6 shadow-2xl shadow-emerald-200 ring-4 ring-white">
                <i class="fas fa-user-check text-3xl"></i>
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-3">Presensi Pengunjung</h1>
            <p class="text-slate-600 text-lg max-w-md mx-auto leading-relaxed">
                Selamat datang! Silakan lengkapi data diri Anda untuk layanan perpustakaan.
            </p>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-[2rem] shadow-2xl border border-white overflow-hidden transition-all hover:shadow-emerald-100/50">
            
            <div class="bg-gradient-to-r from-emerald-600 to-teal-500 px-8 py-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fas fa-edit opacity-80"></i> Formulir Digital
                    </h2>
                    <span class="text-emerald-100 text-xs font-medium bg-white/20 px-3 py-1 rounded-full backdrop-blur-md">
                        {{ date('d M Y') }}
                    </span>
                </div>
            </div>

            <form id="pengunjungForm" class="p-8 md:p-10 space-y-8">
                @csrf

                <div class="group">
                    <label class="block text-sm font-bold text-slate-700 mb-2 transition-colors group-focus-within:text-emerald-600">
                        Nama Lengkap <span class="text-rose-500">+</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <i class="fas fa-user"></i>
                        </span>
                        <input 
                            type="text" 
                            name="nama"
                            value="{{ old('nama') }}"
                            class="w-full pl-11 pr-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 outline-none transition-all"
                            required>
                    </div>
                    <p class="errorNama mt-2 text-sm text-rose-500 font-medium hidden"></p>
                </div>

                <div class="bg-blue-50/50 border-l-4 border-blue-400 rounded-r-2xl p-5 flex gap-4">
                    <div class="text-blue-500 mt-1">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <div class="text-sm text-slate-600 leading-relaxed">
                        <p class="font-bold text-blue-800 mb-1">Panduan Pengisian:</p>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Mahasiswa: Gunakan NIM
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Dosen: Gunakan NIDN
                            </li>
                            <li class="flex items-center gap-2 mt-1">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full"></span> Umum: Kosongkan jika tidak ada
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="group">
                    <label class="block text-sm font-bold text-slate-700 mb-2 transition-colors group-focus-within:text-blue-600">
                        NIM / NIDN <span class="text-slate-400 font-normal text-xs ml-1">(Khusus Civitas Akademika)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-id-card"></i>
                        </span>
                        <input 
                            type="text" 
                            name="nim"
                            value="{{ old('nim') }}"
                            class="w-full pl-11 pr-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6">
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="flex-[2] py-4 bg-gradient-to-r from-emerald-600 to-teal-500 text-white font-bold rounded-2xl shadow-lg shadow-emerald-200 hover:shadow-emerald-300 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 group">
                        <span>Simpan Kehadiran</span>
                        <i class="fas fa-paper-plane text-sm opacity-70 group-hover:translate-x-1 transition-transform"></i>
                    </button>

                    <a href="/" 
                       class="flex-1 py-4 text-center border-2 border-slate-100 text-slate-500 font-semibold rounded-2xl hover:bg-slate-50 hover:text-slate-700 transition-all">
                        Kembali
                    </a>
                </div>

                <div class="flex items-center justify-center gap-2 text-xs text-slate-400 font-medium">
                    <i class="fas fa-shield-alt"></i>
                    <span>Sistem Enkripsi Data Keamanan Terjamin</span>
                </div>
            </form>
        </div>

        <div class="text-center mt-10">
            <p class="text-slate-400 text-sm">
                &copy; {{ date('Y') }} <span class="font-semibold text-slate-500 text-emerald-600">Perpustakaan Universitas Metamedia</span>.
            </p>
        </div>

    </div>
</section>

<style>
    @keyframes fade-in-down {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out;
    }

    /* Toast Notification Styles */
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes slideOutUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }

    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        min-width: 300px;
        padding: 16px 20px;
        background: linear-gradient(135deg, #10b981 0%, #0d9488 100%);
        color: white;
        border-radius: 12px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        animation: slideInDown 0.3s ease-out;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9999;
    }

    .toast-notification.hiding {
        animation: slideOutUp 0.3s ease-out;
    }

    .toast-notification i {
        font-size: 20px;
        flex-shrink: 0;
    }

    .toast-notification-content {
        flex: 1;
    }

    .toast-notification-title {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    }

    .toast-notification-message {
        font-size: 13px;
        opacity: 0.95;
    }

    /* Error toast */
    .toast-notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* Loading state for button */
    .btn-loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .btn-loading span::after {
        content: '';
        animation: dots 1.4s infinite;
    }

    @keyframes dots {
        0%, 20% { content: ''; }
        40% { content: '.'; }
        60% { content: '..'; }
        80%, 100% { content: '...'; }
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
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Memproses</span>';

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
                    // Show success notification
                    showToast('Sukses!', 'Selamat Kamu sudah jadi pengunjung Metamedia Digital', 'success');
                    
                    // Reset form
                    form.reset();
                    
                    // Clear any error messages
                    document.querySelectorAll('[class^="error"]').forEach(el => {
                        el.classList.add('hidden');
                        el.textContent = '';
                    });

                    // Reset button state after a short delay
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('btn-loading');
                        submitBtn.innerHTML = submitBtnText;
                    }, 1000);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.querySelector(`.error${field.charAt(0).toUpperCase() + field.slice(1)}`);
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                errorElement.classList.remove('hidden');
                            }
                        });
                    }
                    
                    showToast('Error!', data.message || 'Terjadi kesalahan saat menyimpan data', 'error');
                    
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('btn-loading');
                    submitBtn.innerHTML = submitBtnText;
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Error!', 'Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
                
                // Reset button state
                submitBtn.disabled = false;
                submitBtn.classList.remove('btn-loading');
                submitBtn.innerHTML = submitBtnText;
            }
        });

        // Toast notification function
        function showToast(title, message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast-notification ${type}`;
            
            const icon = type === 'success' 
                ? '<i class="fas fa-check-circle"></i>' 
                : '<i class="fas fa-exclamation-circle"></i>';
            
            toast.innerHTML = `
                ${icon}
                <div class="toast-notification-content">
                    <div class="toast-notification-title">${title}</div>
                    <div class="toast-notification-message">${message}</div>
                </div>
            `;

            document.body.appendChild(toast);

            // Auto remove after 4 seconds
            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 4000);
        }
    });
</script>
@endsection