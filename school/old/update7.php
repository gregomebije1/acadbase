Student
==========
alter table student change parent_guardian_info parent_guardian_email_phone_address text;
alter table student_comment admission_number admission_number varchar(100);

update student_non_academic set school_id=55;
update student_non_academic set class_id=169;
update student_non_academic set session_id=58;
update  student_non_academic set term_id=171;