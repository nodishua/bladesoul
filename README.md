1. Install Windows server 2019 --- I am using the winserver installed on the virtual machine here

2. Install SQL Server 2019 Express -- Community Free Whoring Edition
Download address: https://go.microsoft.com/fwlink/?linkid=866658

3. Install SQL Server Management Studio
Download address: https://aka.ms/ssmsfullsetup

4. Install the php environment Xiaopi panel
Download address: https://www.xp.cn/download.html
apache 2.4
MySQL 5.7
Database user name password root root

5. Open the SqlServer 2019 Configuration Manager
- SQL server network configuration - sqlexpress protocol tcp/ip enabled
Double-click the tcp/ip ip address and change the bottom ipall tcp port to 1433

6. Open SQL Server Management Studio
Windows login
Security-login name-sa Double-click to change the password to libi@123
Right-click link-properties-security server authentication to open SqlServer and Windows authentication application
Restart the service Open SqlServer 2019 Configuration Manager SqlServer service -SqlServer(SQLEXPRESS) restart

7. Open SQL Server Management Studio
SqlServer authentication login
login name sa
Password libi@123
If you can log in, it means that there is no problem
Restore database after login
Right-click the database-restore database-source-device-select file
bnsm_accountdb_trunk_individual.bak
Need to restore one by one
bnsm_gamedb_trunk_individual.bak
bnsm_statistics.bak
bnsm_tooldb_full_190607.Bak


-------Do not change here can also
You can modify the ip without changing here
database bnsm_accountdb_trunk_individual
Table dbo.tb_server_group_list 1 line 127.0.0.1 changed to external network ip
-------

8. mysql create database
bnsmg_logdb_trunk
import sql bnsmg_logdb_trunk.sql
The other is the account database, which is temporarily unnecessary

Start the server
\bnsm\Bin\Asia has a launcher.exe run and then start
A total of five services
Can't start, flashback, install vc++ runtime library
Or the database tcp port is not open, anyway, it is a problem with the database and runtime

9. Small leather panel
Put the 8888 8080 folder in the www directory
Create two new websites, port 8888 and port 8080, and modify the corresponding directory
Modify the ip of serverlist.xml under the 8888 folder. This file must be utf-8 encoded

apk modification
lib/arm64-v8a/libUE4.so
010editor opens to find Unicode
139.196.32.250 replaces the IP

Port open 8080 8888 12020-12050
Telecom broadband cannot access 8080. Modify the so 8080 of the apk to 8081, and then map 8081 from the external network of the router to 8080 of the internal network.

When the apk enters the game and exits for the first time, it cannot enter. Clear the data and cache of the app and you can enter. I don’t know what the problem is.
