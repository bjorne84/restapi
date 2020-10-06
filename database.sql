CREATE TABLE Courses (
Course_ID           INT(4),
Course_name         VARCHAR(70) NOT NULL,
Code                VARCHAR(6) NOT NULL,
Progression         VARCHAR(1) NOT NULL,
Course_syllabus     VARCHAR(250) NOT NULL
);

/* Sets primary-key and auto increment*/
ALTER TABLE Courses ADD CONSTRAINT Course_PK PRIMARY KEY (Course_ID );
ALTER TABLE Courses MODIFY Course_ID INTEGER AUTO_INCREMENT;
ALTER TABLE Courses AUTO_INCREMENT=1001;



/*Insert */
INSERT INTO Courses (Course_name, Code,
 Progression ,Course_syllabus) 
 VALUES('Webbutveckling I', 'DT057G', 'A', 'https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=22782');


INSERT INTO Courses (Course_name, Code,
 Progression ,Course_syllabus) 
 VALUES('Introduktion till programmering med JavaScript', 'DT084G', 'A', 'https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=23932');

INSERT INTO Courses (Course_name, Code,
 Progression ,Course_syllabus) 
 VALUES('Digital bildbehandling för webbt', 'DT163G', 'A', 'https://www.miun.se/utbildning/kursplaner-och-utbildningsplaner/Sok-kursplan/kursplan/?kursplanid=24403');


/* Update */
UPDATE Courses
	SET Course_name = '?', Code = '?', Progression = '?', Course_syllabus = '?'
WHERE Course_ID = '?';

/* Fungerade */
UPDATE Courses
	SET Progression = 'C'
WHERE Course_ID = 1003;

/* SELECT*/
SELECT * FROM courses;


/* Specifikt id*/
SELECT * FROM courses WHERE Course_ID = 1001;