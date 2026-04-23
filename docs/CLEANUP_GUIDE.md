# 🧹 CLEANUP & MAINTENANCE GUIDE

## 📋 FILES TO REMOVE (SAMPAH)

### Root Directory - DELETE THESE:
1. **diagnostic.php** - Debug file, tidak dipakai
2. **get-logo-base64.php** - Helper script, sudah tidak perlu
3. **logo_base64.txt** - Temporary output
4. **logo-base64-output.txt** - Duplicate temporary output
5. **php_modules.txt** - Temporary file dari info gathering

### Resources - DELETE THESE:
6. **resources/views/KartuAnggotapdf.blade.php** - File tercecer, bukan di folder yang benar
   - Note: File yang benar seharusnya di: `resources/views/KartuAnggota/`

---

## 📂 DUPLICATE/CONFLICTING FILES

### Layout System Duplication:
Ada 2 layout folder yang berbeda:

```
resources/views/layout/          ← Untuk ADMIN pages
  ├── app.blade.php              (with sidebar)
  ├── header.blade.php
  ├── sidebar.blade.php
  └── footer.blade.php

resources/views/layouts/         ← Untuk MEMBER pages
  ├── app.blade.php              (with navbar)
  ├── app-with-navbar.blade.php
  ├── navbar.blade.php
  └── footer.blade.php
```

**Status:** ✅ Sudah konsisten, keduanya dipakai (admin vs member interface)

**Recommendation:** KEEP BOTH (jangan dihapus!)

---

## 📚 DOCUMENTATION FILES

### Current Location (Good):
```
docs/
├── KTM_GUIDE.md                    ✅ Sudah di docs
├── TESTING_GUIDE.md                ✅ Sudah di docs
└── SYSTEM_FLOW.md                  ✅ BARU (di docs)
```

### In Root (Consider Moving):
- `UPDATE_LOG_2026_01_31.md` → Could move to `docs/CHANGELOG.md`
- `README.md` → Keep in root (project standard)

---

## 🗑️ RECOMMENDED CLEANUP ACTIONS

### STEP 1: Delete Garbage Files
```bash
rm diagnostic.php
rm get-logo-base64.php
rm logo_base64.txt
rm logo-base64-output.txt
rm php_modules.txt
rm resources/views/resourcesviewsKartuAnggotapdf.blade.php
```

### STEP 2: Optional - Consolidate Update Log
```bash
# Move to docs folder and rename to CHANGELOG.md
mv UPDATE_LOG_2026_01_31.md docs/CHANGELOG_2026.md
```

### STEP 3: Verify No Broken References
These files should be checked (confirm they're NOT referenced anywhere):
- Search in codebase for references to deleted files
- Verify all imports/requires are still valid

---

## 📖 DOCUMENTATION STRUCTURE (After Cleanup)

```
docs/
├── SYSTEM_FLOW.md              ✅ NEW - Complete system flow documentation
├── KTM_GUIDE.md                - Kartu Tanda Member guide
├── TESTING_GUIDE.md            - Testing procedures
├── CHANGELOG_2026.md           - Updates & changes log (optional)

Root Project:
├── README.md                   - Project overview
├── vite.config.js              - Vite config
├── composer.json               - PHP dependencies
├── package.json                - Node dependencies
├── .env.example                - Environment template
├── phpunit.xml                 - PHPUnit config
├── [app/, config/, routes/, resources/, ...]
```

---

## ✅ CLEANUP CHECKLIST

- [ ] Read & understand SYSTEM_FLOW.md
- [ ] Backup project (git commit)
- [ ] Delete 6 garbage files
- [ ] Search codebase for any references to deleted files
- [ ] Run `php artisan` to verify no broken imports
- [ ] Test main flows (peminjaman, pengembalian, laporan)
- [ ] Commit cleanup changes

---

## 🎯 AFTER CLEANUP

Your project akan lebih clean dan organized:
- ✅ No garbage files
- ✅ Clear documentation in docs/
- ✅ Consistent layout system (admin vs member)
- ✅ Easy to maintain dan onboard new developers

---

## 📝 NOTES

**Storage Logs:**
- `storage/logs/` - Keep! (Laravel error logs)

**Package Files:**
- `vendor/` - Keep! (PHP dependencies)
- `node_modules/` - Keep! (Node dependencies)
- `composer.lock` & `package-lock.json` - Keep! (Dependency locks)

**Git Files:**
- `.git/`, `.gitignore`, `.gitattributes` - Keep! (Version control)

**Config Files:**
- `.env` - Keep! (Environment variables, GITIGNORED)
- `.env.example` - Keep! (Template)
- `.editorconfig` - Keep! (Editor settings)
