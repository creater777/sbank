echo off
SET API_KEY=%1
SET BASE_URI=%2
%~dp0vendor\bin\phpunit.bat .\tests

pause