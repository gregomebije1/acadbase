
alter table student drop column times_present;
alter table student drop column times_absent;

alter table student add column scholarship varchar(100) after third_term_times_absent;
alter table student add column first_term_times_present varchar(100);
alter table student add column first_term_times_absent varchar(100);
alter table student add column second_term_times_present varchar(100);
alter table student add column second_term_times_absent varchar(100);
alter table student add column third_term_times_present varchar(100);
alter table student add column third_term_times_absent varchar(100);