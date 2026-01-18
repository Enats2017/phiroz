@echo off
color 0A
echo ========================================================
echo   AUTO-FIX SERVER TOOL (phiroz_2020)
echo ========================================================
echo.
echo This script will connect to root@91.99.229.154 and perform:
echo  1. Git Pull (Update Code)
echo  2. Fix Permissions (vQmod logs & cache)
echo  3. Clear Cache
echo  4. Run Virus Cleaner
echo.
echo --------------------------------------------------------
echo  PLEASE TYPE YOUR SERVER PASSWORD WHEN PROMPTED
echo --------------------------------------------------------
echo.

ssh root@91.99.229.154 "echo 'Connected!'; cd /var/www/html/phiroz_2020/ || cd /var/www/phiroz_2020/; echo '[1/4] Pulling latest code...'; git reset --hard HEAD; git pull origin master; echo '[2/4] Fixing Permissions...'; mkdir -p vqmod/logs; mkdir -p vqmod/vqcache; chmod -R 777 vqmod/; chmod -R 777 system/cache; chmod -R 777 system/logs; chmod -R 777 image/; chmod -R 777 download/; echo '[3/4] Clearing Cache...'; rm -rf vqmod/vqcache/*; rm -rf system/cache/*; echo '[4/4] Removing Virus...'; php clean_virus.php; php clean_js_server.php; echo '--------------------------------'; echo '       SUCCESSFULLY FIXED       '; echo '--------------------------------';"

echo.
echo Process Complete. Check your website now.
pause
