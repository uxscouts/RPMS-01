# tomato-database

How to Connect the Extension Inside VS Code

1. Click the new Database plug icon that appears in your VS Code left sidebar.

2. Click Create Connection (or the + icon) and select MySQL.

3. Use these connection details inside the extension form:

Host: mysql
Port: 3306
User: dev_user (or root)
Password: dev_password (or rootpassword)
Database: my_database


--------------------------------

To import your SQL file using the Database Client extension you just installed, you can run it directly inside VS Code with a few clicks.

Step 1: Locate and Run the SQL File

1. Open the VS Code file explorer.
2. Expand your databases folder.
3. Right-click on your .sql file.
4. Select Execute SQL (or Run SQL Query) from the context menu.
5. The extension will ask you which database connection to use. Select your active MySQL connection (my_database).

Alternative way to upload SQL file:

Step 2: Alternative Way (Via the Database Sidebar)

If you prefer dragging and dropping or using the database tab:

1. Click the Database plug icon in the left sidebar.
2. Right-click on your database name (my_database).
3. Select Import (or Open Query / Import SQL).
4. Choose your SQL file from the file picker and confirm.

Step 3: Terminal Way (Fast Backup Method)

If your SQL file is massive and the extension struggles with it, you can run it instantly from your VS Code terminal because your workspace shares a network. Run this single command:

docker compose exec -T mysql mysql -u dev_user -p dev_password my_database < ./databases/tomato.sql

// log into mysql to query database via CLI

docker exec -it f6d239e9c718 mysql -u dev_user -p
(then) dev_password

// format return values for entire session
docker exec -it f6d239e9c718 mysql -u dev_user -p -t -E 



f6d239e9c718 = mysql container id

// oops dont have permission as just a dev_user so need to log in as root
 docker exec -it f6d239e9c718 mysql -u root -p

 // then grant all privileges to dev_user
 GRANT ALL PRIVILEGES ON *.* TO 'dev_user'@'%' WITH GRANT OPTION;
 FLUSH PRIVILEGES;

CREATE DATABASE tomato;
SHOW DATABASE tomato;
USE DATABASE tomato;



*************************** 9. row ***************************
        id: 18
    userid: 1001
     title: Create new github for Tomato220
   tomdate: 2018-01-03
datestring: NULL
 timestamp: 
 weekdayno: 4
   tomweek: 2018-W01
     count: 1
  category: 1
     notes: Create new github for Tomato220
       URL: NULL
  nowstamp: 2018-01-03 13:04:36

  ******************************************************


  // insert a row

INSERT INTO tomato (
    userid, title, tomdate, datestring, timestamp, 
    weekdayno, tomweek, count, category, notes, URL, nowstamp
) VALUES (
    1001, 'Test Entry 1001', '2026-06-26', 6, 26, 
    4, '2026-W26', 1, 1, 'Test Entry 1001', NULL, '2026-06-26'
);

// select last created
SELECT * FROM tomato ORDER BY id DESC LIMIT 1;
