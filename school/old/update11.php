CREATE TABLE directory (
  id int(11) NOT NULL auto_increment,
  name varchar(300),
  address text,
  phone varchar(100),
  email varchar(100),
  web varchar(100),
  logo varchar(100), 
  other_information text
);

alter table fee_class drop column fee_id;

alter table student drop parent_guardian_email_phone_address;
alter table student add column parent_guardian_email varchar(100) after scholarship;
alter table student add column parent_guardian_phone varchar(100) after parent_guardian_email;
alter table student add column parent_guardian_address text after parent_guardian_phone;

		 
	     