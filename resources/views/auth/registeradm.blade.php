<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<title>Registrasi Admin | Perpustakaan Digital</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		@keyframes fadeUp {
			from {
				opacity: 0;
				transform: translateY(20px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.animate-fadeUp {
			animation: fadeUp 0.7s ease-out forwards;
		}
	</style>
</head>

<body class="min-h-screen bg-slate-100 text-slate-800 flex items-center justify-center px-4 py-12">
	<div class="w-full max-w-4xl rounded-3xl border border-slate-200 bg-white shadow-xl animate-fadeUp">
		<div class="grid grid-cols-1 md:grid-cols-[1.1fr_0.9fr]">
			<section class="border-b border-slate-100 bg-slate-50/80 p-8 md:border-b-0 md:border-r md:p-10">
				<p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Perpustakaan Digital</p>
				<h1 class="mt-4 text-2xl font-semibold text-slate-900 md:text-3xl">Registrasi Admin</h1>
				<p class="mt-3 text-sm leading-relaxed text-slate-500">
					Buat akun admin untuk mengelola koleksi, peminjaman, dan data anggota. Gunakan kredensial resmi karena akses ini khusus petugas.
				</p>
				<div class="mt-10 space-y-3 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
					<p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Panduan singkat</p>
					<ul class="space-y-2 text-sm text-slate-500">
						<li>• Gunakan email institusi untuk verifikasi.</li>
						<li>• Sandi minimal 8 karakter dengan kombinasi huruf dan angka.</li>
					</ul>
				</div>
			</section>

			<main class="p-8 md:p-10">
				<div class="mb-8">
					<div class="flex items-center gap-3">
						<div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-200 text-sm font-semibold text-slate-700">ADM</div>
						<div>
							<p class="text-xs uppercase tracking-[0.3em] text-slate-400">Formulir</p>
							<h2 class="text-lg font-semibold text-slate-900">Detail akun admin</h2>
						</div>
					</div>
					<p class="mt-3 text-sm text-slate-500">Lengkapi data berikut untuk melanjutkan pendaftaran.</p>
				</div>

				@if (session('status'))
					<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
						{{ session('status') }}
					</div>
				@endif

				@if ($errors->any())
					<div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-600">
						<p class="font-semibold">Periksa kembali isian Anda:</p>
						<ul class="mt-2 list-disc space-y-1 pl-5 text-xs">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form method="POST" action="{{ $action ?? route('register.store') }}" class="space-y-6">
					@csrf

					<div class="grid gap-5 md:grid-cols-2">
						<div>
							<label for="name" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nama Lengkap *</label>
							<input
								id="name"
								type="text"
								name="name"
								value="{{ old('name') }}"
								required
								class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
								placeholder="Masukkan nama lengkap"
							>
							@error('name')
								<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email Admin *</label>
							<input
								id="email"
								type="email"
								name="email"
								value="{{ old('email') }}"
								required
								class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
								placeholder="nama@perpustakaan.ac.id"
							>
							@error('email')
								<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
							@enderror
						</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div class="md:col-span-2">
							<label for="username" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Username *</label>
							<input
								id="username"
								type="text"
								name="username"
								value="{{ old('username') }}"
								required
								class="mt-2 w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-700 placeholder:text-slate-400 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200"
								placeholder="admin.nama"
							>
							@error('username')
								<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
							@enderror
						</div>
					</div>

					<div class="grid gap-5 md:grid-cols-2">
						<div>
							<label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kata Sandi *</label>
							<div class="mt-2 rounded-lg border border-slate-300">
								<input
									id="password"
									type="password"
									name="password"
									required
									class="w-full bg-white px-4 py-2.5 text-sm text-slate-700 focus:outline-none"
									placeholder="Minimal 8 karakter"
								>
							</div>
							@error('password')
								<p class="mt-2 text-xs text-rose-500">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label for="password_confirmation" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Konfirmasi Kata Sandi *</label>
							<div class="mt-2 rounded-lg border border-slate-300">
								<input
									id="password_confirmation"
									type="password"
									name="password_confirmation"
									required
									class="w-full bg-white px-4 py-2.5 text-sm text-slate-700 focus:outline-none"
									placeholder="Ulangi kata sandi"
								>
							</div>
						</div>
					</div>
					<button type="submit" class="w-full rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
						Buat Akun Admin
					</button>
				</form>

				<div class="mt-6 text-center text-xs text-slate-500">
					Sudah memiliki akun admin?
					<a href="{{ route('admin.login') }}" class="font-semibold text-slate-700 hover:underline">Masuk di sini</a>
				</div>

				<div class="mt-3 text-center text-[11px] text-slate-400">
					<a href="{{ url('/') }}" class="hover:underline">← Kembali ke beranda</a>
				</div>
			</main>
		</div>
	</div>
</body>
</html>
