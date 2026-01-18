
# Remove-MaliciousJS.ps1
# Scans all .js files for malicious hex redirect code and removes it.

$RootPath = "c:\xampp\htdocs\phiroz_2020_18_01_2026\phiroz_2020"
$MaliciousHex = "\\x68\\x74\\x74\\x70\\x73\\x3a\\x2f\\x2f\\x75\\x73\\x68\\x6f\\x72\\x74\\x2e\\x74\\x6f\\x64\\x61\\x79\\x2f\\x79\\x4b\\x7a\\x30\\x72\\x33"
$MaliciousPattern = [regex]::Escape($MaliciousHex)
$RedirectPattern = "window\.location\.href\s*=\s*`"$MaliciousPattern`";"

Write-Host "Scanning for malicious JS files in: $RootPath" -ForegroundColor Cyan

$Files = Get-ChildItem -Path $RootPath -Recurse -Filter "*.js"

foreach ($File in $Files) {
    try {
        $Content = Get-Content -Path $File.FullName -Raw -ErrorAction Stop
        
        # Check for Hex String
        if ($Content -match "(\\x68\\x74\\x74\\x70)") {
            Write-Host "FOUND INFECTED FILE: $($File.FullName)" -ForegroundColor Red
            
            # Backup
            Copy-Item -Path $File.FullName -Destination "$($File.FullName).infected"
            
            # Clean: Remove the hex connection string
            # We try to remove the whole line first
            $CleanContent = $Content -replace "window\.location\.href\s*=\s*`".*?`";", ""
            
            # If still present (maybe just the string), remove the string
            $CleanContent = $CleanContent -replace $MaliciousHex, ""
            
            # Remove empty script tags that might remain <script></script>
            $CleanContent = $CleanContent -replace "<script>\s*</script>", ""
            
            Set-Content -Path $File.FullName -Value $CleanContent -NoNewline
            Write-Host " - CLEANED!" -ForegroundColor Green
        }
    }
    catch {
        Write-Host "Error reading file: $($File.FullName)" -ForegroundColor Yellow
    }
}

Write-Host "Javascript cleanup scan complete." -ForegroundColor Cyan
