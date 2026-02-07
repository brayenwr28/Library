# 🚀 Quick Commands - PDF System Management

## Health Check (Run Regularly)
```bash
php artisan pdf:health-check
```
Output: Cek status semua sistem requirements

## View Error Logs
```bash
# Last 50 lines
tail -50 storage/logs/laravel.log

# Real-time monitoring
tail -f storage/logs/laravel.log

# Filter PDF errors only
grep -i "pdf" storage/logs/laravel.log | tail -20
```

## Restart Apache (Windows XAMPP)
```powershell
# Stop Apache
Stop-Process -Name "httpd" -Force

# Wait 2 seconds
Start-Sleep -Seconds 2

# Start Apache again
Start-Process "C:\xampp\apache\bin\httpd.exe" -NoNewWindow
```

## Clear Laravel Cache (if needed)
```bash
php artisan cache:clear
php artisan config:cache
php artisan view:cache
```

## Check GD Extension Status
```bash
php -m | findstr gd
# Output: gd (jika active)
```

## Create Missing Directories
```bash
mkdir storage/fonts
mkdir storage/app
```

## Set Folder Permissions (Linux/Mac)
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

## Set Folder Permissions (Windows - PowerShell as Admin)
```powershell
icacls "D:\Perpus_Digital\storage" /grant:r Everyone:F /T /C
icacls "D:\Perpus_Digital\bootstrap\cache" /grant:r Everyone:F /T /C
```

## Database Diagnostics
```bash
php artisan tinker

# Check if member data valid
$member = App\Models\Member::find(26);
$member->member_id; // Should have value
$member->name;      // Should have value

# Exit with: exit
```

## Force Restart Laravel (if using Artisan server)
```bash
# Kill existing server
Get-Process php | Stop-Process -Force

# Start new
php artisan serve
```

## Test PDF Generation Manually
```bash
php artisan tinker

$pdf = PDF::loadView('auth.member-card-pdf', [
    'member' => App\Models\Member::find(26),
    'logoBase64' => 'data:image/png;base64,...',
    'stempelBase64' => '',
    'ttdBase64' => ''
]);
$pdf->save('test.pdf');
exit
```

## Useful Configurations

### Increase Memory Limit (php.ini)
```ini
memory_limit = 512M  # or higher
max_execution_time = 300
```

### Production Setup (improve performance)
```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Development Setup (best for debugging)
```bash
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
```
