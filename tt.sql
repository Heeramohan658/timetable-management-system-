
mysql> use timetablesystem;
Database changed
mysql> show tables;
+---------------------------+
| Tables_in_timetablesystem |
+---------------------------+
| timetable                 |
+---------------------------+
1 row in set (0.02 sec)

mysql> DESC timetable;
+-----------+--------------+------+-----+---------+----------------+
| Field     | Type         | Null | Key | Default | Extra          |
+-----------+--------------+------+-----+---------+----------------+
| id        | int          | NO   | PRI | NULL    | auto_increment |
| course    | varchar(100) | YES  |     | NULL    |                |
| division  | varchar(5)   | YES  |     | NULL    |                |
| day       | varchar(20)  | YES  |     | NULL    |                |
| time_slot | varchar(50)  | YES  |     | NULL    |                |
| subject   | varchar(100) | YES  |     | NULL    |                |
| faculty   | varchar(100) | YES  |     | NULL    |                |
| room      | varchar(50)  | YES  |     | NULL    |                |
| type      | varchar(10)  | YES  |     | CR      |                |
+-----------+--------------+------+-----+---------+----------------+
9 rows in set (0.00 sec)

mysql> select *from timetable;
+----+--------+----------+-----------+--------------------+-----------------+--------------------------+-------+------+
| id | course | division | day       | time_slot          | subject         | faculty                  | room  | type |
+----+--------+----------+-----------+--------------------+-----------------+--------------------------+-------+------+
|  4 | BCA    | A        | Wednesday | Break: 3:50 - 4:10 | Data Structures | Dr. Manoj Chandra Lohani | Lab 1 | CR   |
|  5 | BCA    | B        | Monday    | 1st: 9:00 - 9:55   | Data Structures | Ms. Neha Sharma          | CR17  | CR   |
+----+--------+----------+-----------+--------------------+-----------------+--------------------------+-------+------+
2 rows in set (0.00 sec)

mysql>

































































































































