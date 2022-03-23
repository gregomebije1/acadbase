alter table student drop column parent_guardian_email_phone_address;
alter table student add column parent_guardian_address text;
alter table student add column parent_guardian_email varchar(100);
alter table student add column parent_guardian_phone varchar(100);
alter table student drop column any_other_information;
alter table student add column any_other_information text;


INSERT INTO subject(name, class_type_id, school_id) values ('Mathematics',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('English',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('French',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Agricultural Science',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Business Studies',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Home Economics',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Computer Education',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('CRS/IRK',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Physical and Health Education',  '1', 1);

INSERT INTO subject(name, class_type_id, school_id) values ('Mathematics',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('English',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Biology',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Chemistry',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Physics',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Health Science',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Literature in English',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('History',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Geography',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Religious Studies',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Hausa or a major Nigerian Language',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Agricultural Science',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Book-keeping and Accounting',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Commerce',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Computer Education',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Home Management',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Food and Nutrition',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Further Mathematics',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('French',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Christian Religious Knowledge/Islamic Religious Knowledge',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Government',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Information Tech',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Hausa/Igbo/ Yoruba',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Social Studies',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Basic Science',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Basic Technology',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Hausa/Igbo/ Yoruba',  '2', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Civic Education',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Creative Art',  '1', 1);
INSERT INTO subject(name, class_type_id, school_id) values ('Arabic Language',  '1', 1);

