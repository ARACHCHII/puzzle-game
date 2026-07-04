@echo off
cd C:\xampp\htdocs\puzzle
echo // Auto update %date% %time% > last_update.txt
git add .
git commit -m "Auto update: Day %date%"
git push