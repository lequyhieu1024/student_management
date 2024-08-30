-- - viết sql:
-- + tạo một sinh viên thuộc khoa B có điểm tất cả các môn học = 5 và tuổi = 50;

INSERT INTO users(name, email,password) VALUES ('Lê Hiếu', 'lqh@gmail.com','12312312312');

SET @user_id = LAST_INSERT_ID();

INSERT INTO students (user_id, student_code, phone, gender, birthday, address, department_id)
SELECT @user_id, CONCAT(YEAR(NOW()), @user_id), '0123456789', 1, DATE_SUB(CURDATE(), INTERVAL 50 YEAR), '68 cầu giấy', id
FROM departments
WHERE name = 'Khoa CNTT';

SET @student_id = LAST_INSERT_ID();

INSERT INTO student_subject (student_id, subject_id, score)
SELECT @student_id, id, 5
FROM subjects;



-- + cập nhật sinh viên có điểm trung bình thấp nhất thành 10;

UPDATE student_subject
SET score = 10
WHERE student_id IN (
    SELECT student_id
    FROM student_subject
    GROUP BY student_id
    HAVING AVG(score) = (
        SELECT MIN(avg_score)
        FROM (
                 SELECT student_id, AVG(score) AS avg_score
                 FROM student_subject
                 GROUP BY student_id
             ) AS avg_scores
    )
);


-- + xóa tất cả thông tin của sinh viên tuổi >= 30; (students + users)

DELETE FROM users
WHERE id IN (
    SELECT user_id
    FROM students
    WHERE TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >= 30
);
-- set ondele cascade nên chỉ chạy lệnh trên đã xóa cả student, nếu không cascade thì thêm lệnh dưới
-- DELETE FROM students
-- WHERE TIMESTAMPDIFF(YEAR, birthday, CURDATE()) >= 30;



-- + tìm các sinh viên thuộc khoa A và có điểm trung bình > 5;

SELECT s.*
FROM students s
JOIN (
    SELECT student_id, AVG(score) AS avg_score
    FROM student_subject
    GROUP BY student_id
    HAVING COUNT(*) = COUNT(score)
) ss ON s.id = ss.student_id
WHERE s.department_id = (
    SELECT id
    FROM departments
    WHERE name = 'Khoa CNTT'
)
AND ss.avg_score > 5;




-- + tìm các sinh viên có SDT viettel + có tuổi từ 18 -> 25 và có điểm thi > 5;

SELECT * FROM students s JOIN (
    SELECT student_id, AVG(score) AS avg_score
    FROM student_subject
    GROUP BY student_id
    HAVING COUNT(*) = COUNT(score)
) ss ON s.id = ss.student_id
WHERE
ss.avg_score > 5
AND phone REGEXP '^03[2-9]|^09[0-9]|^086'
AND TIMESTAMPDIFF(YEAR, birthday, CURDATE()) BETWEEN 18 AND 25



-- + Giả sử A chưa học hết các môn, tìm các môn này
-- giả sử student_id của A là 2

SELECT * FROM subjects
WHERE id NOT IN (
    SELECT subject_id
    FROM student_subject
    WHERE student_id = 2
);



