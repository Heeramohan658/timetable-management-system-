
mysql> CREATE DATABASE timetable_system;
Query OK, 1 row affected (0.01 sec)

mysql> USE timetable_system;
Database changed
mysql> CREATE TABLE timetable (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     course VARCHAR(100) NOT NULL,
    ->     division VARCHAR(5) NOT NULL,
    ->     day VARCHAR(20) NOT NULL,
    ->     time_slot VARCHAR(50) NOT NULL,
    ->     subject VARCHAR(100) NOT NULL,
    ->     faculty VARCHAR(100) NOT NULL,
    ->     faculty_type VARCHAR(50) NOT NULL,
    ->     room VARCHAR(50) NOT NULL,
    ->     type VARCHAR(20) DEFAULT 'CR',
    ->     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    -> );
Query OK, 0 rows affected (0.03 sec)

mysql> INSERT INTO timetable
    -> (course, division, day, time_slot, subject, faculty, faculty_type, room, type)
    -> VALUES
    -> ('BCA','A','Monday','1st: 9:00 - 9:55','Maths','Dr. Lohani','hod_cse','CR1','CR'),
    -> ('BCA','A','Monday','2nd: 9:55 - 10:50','Programming','Mr. Rajput','hod_cse','Lab 1','Lab');
Query OK, 2 rows affected (0.02 sec)
Records: 2  Duplicates: 0  Warnings: 0

mysql>


















































































































