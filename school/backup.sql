TRUNCATE table account;
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (1, 5, 1,  'Cash',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (2, 5, 1,  'Petty Cash',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (3, 5, 1,  'Bank',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (4, 10, 1,  'Sales',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (5, 5, 1,  'Inventory',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (6, 4, 1,  'VAT',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (7, 4, 1,  'WHT',  '',  '',  '2012-09-11', 0, 0);
INSERT INTO account(id, account_type_id, entity_id, name, code, description, d_created, parent, children) values (8, 3, 1,  'FOSLA ACADEMY',  '',  '',  '2012-09-11', 0, 0);
TRUNCATE table account_type;
INSERT INTO account_type(id, name) values (1, 'Fixed Assets');
INSERT INTO account_type(id, name) values (2, 'Account Payable');
INSERT INTO account_type(id, name) values (3, 'Account Receivable');
INSERT INTO account_type(id, name) values (4, 'Other Currrent Liabilities');
INSERT INTO account_type(id, name) values (5, 'Other Currrent Assets');
INSERT INTO account_type(id, name) values (6, 'Long Term Liabilities');
INSERT INTO account_type(id, name) values (7, 'Expenses');
INSERT INTO account_type(id, name) values (8, 'Equity');
INSERT INTO account_type(id, name) values (9, 'Sales Returns and Allowances');
INSERT INTO account_type(id, name) values (10, 'Income');
INSERT INTO account_type(id, name) values (11, 'Opening Stock');
INSERT INTO account_type(id, name) values (12, 'Purchases Returns and Allowances');
INSERT INTO account_type(id, name) values (13, 'Purchases');
INSERT INTO account_type(id, name) values (14, 'Closing Stock');
TRUNCATE table audit_trail;
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (1,  '2012-09-11 09:12:31',  '2',  'Date of Payment: 2012-09-11 
    Years of Subscription: 1 month
    Activation Date: 2012-09-11
    Expiration Date: 2012-10-11 1 month free subscription - 0',  '', '2012-09-11');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (2,  '2012-09-12 13:37:25',  '28',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (3,  '2012-09-12 13:49:23',  '30',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (4,  '2012-09-12 13:53:53',  '31',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (5,  '2012-09-12 13:55:02',  '32',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (6,  '2012-09-12 13:59:43',  '34',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (7,  '2012-09-12 14:09:41',  '35',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (8,  '2012-09-12 14:26:49',  '37',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (9,  '2012-09-12 14:29:52',  '38',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (10,  '2012-09-12 14:32:02',  '39',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (11,  '2012-09-12 09:42:23',  '40',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (12,  '2012-09-12 10:41:59',  '43',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (13,  '2012-09-12 13:26:55',  '46',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  '', '2012-09-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (14,  '2012-09-13 02:16:31',  '50',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (15,  '2012-09-13 02:21:45',  '52',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (16,  '2012-09-13 02:56:20',  '53',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (17,  '2012-09-13 04:15:08',  '54',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (18,  '2012-09-13 04:35:44',  '55',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (19,  '2012-09-13 10:11:50',  '58',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (20,  '2012-09-13 11:33:35',  '61',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (21,  '2012-09-13 15:13:51',  '66',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (22,  '2012-09-13 15:32:59',  '67',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (23,  '2012-09-13 15:40:30',  '68',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  '', '2012-09-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (24,  '2012-09-14 04:14:32',  '70',  'Date of Payment: 2012-09-14 
    Years of Subscription: 1 month
    Activation Date: 2012-09-14
    Expiration Date: 2012-10-14 1 month free subscription - 0',  '', '2012-09-14');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (25,  '2012-09-17 06:37:14',  '73',  'Date of Payment: 2012-09-17 
    Years of Subscription: 1 month
    Activation Date: 2012-09-17
    Expiration Date: 2012-10-17 1 month free subscription - 0',  '', '2012-09-17');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (26,  '2012-10-02 02:08:42',  '74',  'Date of Payment: 2012-10-02 
    Years of Subscription: 1 month
    Activation Date: 2012-10-02
    Expiration Date: 2012-11-02 1 month free subscription - 0',  '', '2012-10-02');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (27,  '2012-10-20 09:25:02',  '75',  'Date of Payment: 2012-10-20 
    Years of Subscription: 1 month
    Activation Date: 2012-10-20
    Expiration Date: 2012-11-20 1 month free subscription - 0',  '', '2012-10-20');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (28,  '2012-11-02 00:37:33',  '76',  'Date of Payment: 2012-11-02 
    Years of Subscription: 1 month
    Activation Date: 2012-11-02
    Expiration Date: 2012-12-02 1 month free subscription - 0',  '', '2012-11-02');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (29,  '2012-11-08 04:36:41',  '77',  'Date of Payment: 2012-11-08 
    Years of Subscription: 1 month
    Activation Date: 2012-11-08
    Expiration Date: 2012-12-08 1 month free subscription - 0',  '', '2012-11-08');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (30,  '2012-11-10 23:30:54',  '78',  'Date of Payment: 2012-11-10 
    Years of Subscription: 1 month
    Activation Date: 2012-11-10
    Expiration Date: 2012-12-10 1 month free subscription - 0',  '', '2012-11-10');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (31,  '2012-11-12 08:54:22',  '79',  'Date of Payment: 2012-11-12 
    Years of Subscription: 1 month
    Activation Date: 2012-11-12
    Expiration Date: 2012-12-12 1 month free subscription - 0',  '', '2012-11-12');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (32,  '2012-11-13 03:08:04',  '80',  'Date of Payment: 2012-11-13 
    Years of Subscription: 1 month
    Activation Date: 2012-11-13
    Expiration Date: 2012-12-13 1 month free subscription - 0',  '', '2012-11-13');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (33,  '2012-11-15 00:52:19',  '83',  'Date of Payment: 2012-11-15 
    Years of Subscription: 1 year
    Activation Date: 2012-11-15
    Expiration Date: 2013-11-15 1 month free subscription - 0',  '', '2012-11-15');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (34,  '2012-11-21 16:05:41',  '84',  'Date of Payment: 2012-11-21 
    Years of Subscription: 1 year
    Activation Date: 2012-11-21
    Expiration Date: 2013-11-21 1 month free subscription - 0',  '', '2012-11-21');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (35,  '2012-11-22 04:06:26',  '85',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (36,  '2012-11-22 04:11:15',  '86',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (37,  '2012-11-22 04:42:33',  '87',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (38,  '2012-11-22 05:55:38',  '88',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (39,  '2012-11-22 11:32:50',  '89',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (40,  '2012-11-22 14:42:23',  '90',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  '', '2012-11-22');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (41,  '2012-11-28 04:15:41',  '91',  'Date of Payment: 2012-11-28 
    Years of Subscription: 1 year
    Activation Date: 2012-11-28
    Expiration Date: 2013-11-28 1 month free subscription - 0',  '', '2012-11-28');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (42,  '2012-12-03 09:43:50',  '92',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  '', '2012-12-03');
INSERT INTO audit_trail(id, dt, staff_id, descr, ot, dt2) values (43,  '2012-12-03 10:09:19',  '95',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  '', '2012-12-03');
TRUNCATE table class;
INSERT INTO class(id, name, class_type_id, school_id) values (1,  'Nursery 1', 1, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (2,  'Class 1', 2, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (3,  'JSS1A', 3, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (4,  'JSS1B', 3, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (180,  'JSS2B', 3, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (179,  'JSS2A', 3, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (181,  'JSS3A', 3, 1);
INSERT INTO class(id, name, class_type_id, school_id) values (182,  'JSS3B', 3, 1);
TRUNCATE table class_type;
INSERT INTO class_type(id, name, description, school_id) values (1,  'Nursery',  'Nursery', 1);
INSERT INTO class_type(id, name, description, school_id) values (2,  'Primary',  'Primary', 1);
INSERT INTO class_type(id, name, description, school_id) values (3,  'JSS',  'Junior Secondary School', 1);
INSERT INTO class_type(id, name, description, school_id) values (4,  'SSS',  'Senior Secondary School', 1);
TRUNCATE table fee_class_1577972762;
INSERT INTO fee_class_1577972762(id, session_id, term_id, class_id, amount, school_id) values (1, 1, 1, 3,  '0', 1);
INSERT INTO fee_class_1577972762(id, session_id, term_id, class_id, amount, school_id) values (2, 1, 2, 3,  '0', 1);
INSERT INTO fee_class_1577972762(id, session_id, term_id, class_id, amount, school_id) values (3, 1, 3, 3,  '0', 1);
TRUNCATE table grade_settings;
INSERT INTO grade_settings(id, name, low, high, school_id) values (1,  'A',  '75',  '100', 1);
INSERT INTO grade_settings(id, name, low, high, school_id) values (2,  'B',  '60',  '74', 1);
INSERT INTO grade_settings(id, name, low, high, school_id) values (3,  'C',  '50',  '59', 1);
INSERT INTO grade_settings(id, name, low, high, school_id) values (4,  'D',  '45',  '49', 1);
INSERT INTO grade_settings(id, name, low, high, school_id) values (5,  'E',  '40',  '44', 1);
INSERT INTO grade_settings(id, name, low, high, school_id) values (6,  'F',  '0',  '39', 1);
TRUNCATE table journal;
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (1, 8, 1,  '2012-09-11',  'Date of Payment: 2012-09-11 
    Years of Subscription: 1 month
    Activation Date: 2012-09-11
    Expiration Date: 2012-10-11 1 month free subscription - 0',  'Debit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (2, 4, 1,  '2012-09-11',  'Date of Payment: 2012-09-11 
    Years of Subscription: 1 month
    Activation Date: 2012-09-11
    Expiration Date: 2012-10-11 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (3, 8, 1,  '2012-09-11',  'Date of Payment: 2012-09-11 
    Years of Subscription: 1 month
    Activation Date: 2012-09-11
    Expiration Date: 2012-10-11 1 month free subscription - 0',  'Credit',  '0', '4');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (4, 1, 1,  '2012-09-11',  'Date of Payment: 2012-09-11 
    Years of Subscription: 1 month
    Activation Date: 2012-09-11
    Expiration Date: 2012-10-11 1 month free subscription - 0',  'Debit',  '0', '3');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (6, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (8, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '7');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (10, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (12, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '11');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (14, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (16, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '15');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (18, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (20, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '19');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (22, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (24, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '23');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (26, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (28, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '27');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (30, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (32, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '31');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (34, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (36, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '35');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (38, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (40, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '39');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (42, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (82, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (44, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '43');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (46, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (84, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '83');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (48, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '47');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (50, 4, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (78, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (52, 1, 1,  '2012-09-12',  'Date of Payment: 2012-09-12 
    Years of Subscription: 1 month
    Activation Date: 2012-09-12
    Expiration Date: 2012-10-12 1 month free subscription - 0',  'Debit',  '0', '51');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (54, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (56, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '55');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (76, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '75');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (74, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (58, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (60, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '59');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (72, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '71');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (62, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (70, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (64, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '63');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (66, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (80, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '79');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (68, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '67');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (86, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (88, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '87');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (90, 4, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (92, 1, 1,  '2012-09-13',  'Date of Payment: 2012-09-13 
    Years of Subscription: 1 month
    Activation Date: 2012-09-13
    Expiration Date: 2012-10-13 1 month free subscription - 0',  'Debit',  '0', '91');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (94, 4, 1,  '2012-09-14',  'Date of Payment: 2012-09-14 
    Years of Subscription: 1 month
    Activation Date: 2012-09-14
    Expiration Date: 2012-10-14 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (96, 1, 1,  '2012-09-14',  'Date of Payment: 2012-09-14 
    Years of Subscription: 1 month
    Activation Date: 2012-09-14
    Expiration Date: 2012-10-14 1 month free subscription - 0',  'Debit',  '0', '95');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (98, 4, 1,  '2012-09-17',  'Date of Payment: 2012-09-17 
    Years of Subscription: 1 month
    Activation Date: 2012-09-17
    Expiration Date: 2012-10-17 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (100, 1, 1,  '2012-09-17',  'Date of Payment: 2012-09-17 
    Years of Subscription: 1 month
    Activation Date: 2012-09-17
    Expiration Date: 2012-10-17 1 month free subscription - 0',  'Debit',  '0', '99');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (102, 4, 1,  '2012-10-02',  'Date of Payment: 2012-10-02 
    Years of Subscription: 1 month
    Activation Date: 2012-10-02
    Expiration Date: 2012-11-02 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (104, 1, 1,  '2012-10-02',  'Date of Payment: 2012-10-02 
    Years of Subscription: 1 month
    Activation Date: 2012-10-02
    Expiration Date: 2012-11-02 1 month free subscription - 0',  'Debit',  '0', '103');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (106, 4, 1,  '2012-10-20',  'Date of Payment: 2012-10-20 
    Years of Subscription: 1 month
    Activation Date: 2012-10-20
    Expiration Date: 2012-11-20 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (108, 1, 1,  '2012-10-20',  'Date of Payment: 2012-10-20 
    Years of Subscription: 1 month
    Activation Date: 2012-10-20
    Expiration Date: 2012-11-20 1 month free subscription - 0',  'Debit',  '0', '107');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (110, 4, 1,  '2012-11-02',  'Date of Payment: 2012-11-02 
    Years of Subscription: 1 month
    Activation Date: 2012-11-02
    Expiration Date: 2012-12-02 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (112, 1, 1,  '2012-11-02',  'Date of Payment: 2012-11-02 
    Years of Subscription: 1 month
    Activation Date: 2012-11-02
    Expiration Date: 2012-12-02 1 month free subscription - 0',  'Debit',  '0', '111');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (114, 4, 1,  '2012-11-08',  'Date of Payment: 2012-11-08 
    Years of Subscription: 1 month
    Activation Date: 2012-11-08
    Expiration Date: 2012-12-08 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (116, 1, 1,  '2012-11-08',  'Date of Payment: 2012-11-08 
    Years of Subscription: 1 month
    Activation Date: 2012-11-08
    Expiration Date: 2012-12-08 1 month free subscription - 0',  'Debit',  '0', '115');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (118, 4, 1,  '2012-11-10',  'Date of Payment: 2012-11-10 
    Years of Subscription: 1 month
    Activation Date: 2012-11-10
    Expiration Date: 2012-12-10 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (120, 1, 1,  '2012-11-10',  'Date of Payment: 2012-11-10 
    Years of Subscription: 1 month
    Activation Date: 2012-11-10
    Expiration Date: 2012-12-10 1 month free subscription - 0',  'Debit',  '0', '119');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (122, 4, 1,  '2012-11-12',  'Date of Payment: 2012-11-12 
    Years of Subscription: 1 month
    Activation Date: 2012-11-12
    Expiration Date: 2012-12-12 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (124, 1, 1,  '2012-11-12',  'Date of Payment: 2012-11-12 
    Years of Subscription: 1 month
    Activation Date: 2012-11-12
    Expiration Date: 2012-12-12 1 month free subscription - 0',  'Debit',  '0', '123');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (126, 4, 1,  '2012-11-13',  'Date of Payment: 2012-11-13 
    Years of Subscription: 1 month
    Activation Date: 2012-11-13
    Expiration Date: 2012-12-13 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (128, 1, 1,  '2012-11-13',  'Date of Payment: 2012-11-13 
    Years of Subscription: 1 month
    Activation Date: 2012-11-13
    Expiration Date: 2012-12-13 1 month free subscription - 0',  'Debit',  '0', '127');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (130, 4, 1,  '2012-11-15',  'Date of Payment: 2012-11-15 
    Years of Subscription: 1 year
    Activation Date: 2012-11-15
    Expiration Date: 2013-11-15 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (132, 1, 1,  '2012-11-15',  'Date of Payment: 2012-11-15 
    Years of Subscription: 1 year
    Activation Date: 2012-11-15
    Expiration Date: 2013-11-15 1 month free subscription - 0',  'Debit',  '0', '131');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (134, 4, 1,  '2012-11-21',  'Date of Payment: 2012-11-21 
    Years of Subscription: 1 year
    Activation Date: 2012-11-21
    Expiration Date: 2013-11-21 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (136, 1, 1,  '2012-11-21',  'Date of Payment: 2012-11-21 
    Years of Subscription: 1 year
    Activation Date: 2012-11-21
    Expiration Date: 2013-11-21 1 month free subscription - 0',  'Debit',  '0', '135');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (138, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (140, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '139');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (142, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (144, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '143');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (146, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (148, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '147');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (150, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (152, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '151');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (154, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (156, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '155');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (158, 4, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (160, 1, 1,  '2012-11-22',  'Date of Payment: 2012-11-22 
    Years of Subscription: 1 year
    Activation Date: 2012-11-22
    Expiration Date: 2013-11-22 1 month free subscription - 0',  'Debit',  '0', '159');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (162, 4, 1,  '2012-11-28',  'Date of Payment: 2012-11-28 
    Years of Subscription: 1 year
    Activation Date: 2012-11-28
    Expiration Date: 2013-11-28 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (164, 1, 1,  '2012-11-28',  'Date of Payment: 2012-11-28 
    Years of Subscription: 1 year
    Activation Date: 2012-11-28
    Expiration Date: 2013-11-28 1 month free subscription - 0',  'Debit',  '0', '163');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (166, 4, 1,  '2012-12-03',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (168, 1, 1,  '2012-12-03',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  'Debit',  '0', '167');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (170, 4, 1,  '2012-12-03',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  'Credit',  '0', '');
INSERT INTO journal(id, account_id, entity_id, d_entry, descr, t_type, amt, folio) values (172, 1, 1,  '2012-12-03',  'Date of Payment: 2012-12-03 
    Years of Subscription: 1 year
    Activation Date: 2012-12-03
    Expiration Date: 2013-12-03 1 month free subscription - 0',  'Debit',  '0', '171');
TRUNCATE table mail_alert;
INSERT INTO mail_alert(ip, date, subject, comment) values ( '41.203.64.130',  '2012-09-13 09:43:43',  'Test Subject', 'Test Comment');
TRUNCATE table non_academic;
INSERT INTO non_academic(id, name, school_id) values (1,  'Handwriting', 1);
INSERT INTO non_academic(id, name, school_id) values (2,  'Fluency', 1);
INSERT INTO non_academic(id, name, school_id) values (3,  'Punctuality', 1);
INSERT INTO non_academic(id, name, school_id) values (4,  'Reliability', 1);
INSERT INTO non_academic(id, name, school_id) values (5,  'Neatness', 1);
INSERT INTO non_academic(id, name, school_id) values (6,  'Politeness', 1);
INSERT INTO non_academic(id, name, school_id) values (7,  'Honesty', 1);
INSERT INTO non_academic(id, name, school_id) values (8,  'Self Control', 1);
INSERT INTO non_academic(id, name, school_id) values (9,  'Spirit of Cooperation', 1);
INSERT INTO non_academic(id, name, school_id) values (10,  'Sense Of Responsibility', 1);
INSERT INTO non_academic(id, name, school_id) values (11,  'Attentiveness In Class', 1);
INSERT INTO non_academic(id, name, school_id) values (12,  'Perseverance', 1);
TRUNCATE table permissions;
INSERT INTO permissions(id, name) values (1, 'Administrator');
INSERT INTO permissions(id, name) values (2, 'Accounts');
INSERT INTO permissions(id, name) values (3, 'Expenditure');
INSERT INTO permissions(id, name) values (4, 'Exams');
INSERT INTO permissions(id, name) values (5, 'Records');
INSERT INTO permissions(id, name) values (6, 'Student');
INSERT INTO permissions(id, name) values (7, 'Proprietor');
TRUNCATE table school;
INSERT INTO school(id, name, address, phone, email, website, logo, other_information, account_id, signup_date) values (1,  'FOSLA ACADEMY',  'Along Karshi/Karu Road Opp. Karshi Police Station Beside S.C.C Karshi F.C.T Abuja Nigeria',  '+2348076748877',  'foslaacademy@yahoo.com',  'www.foslaacademy.com',  'fosla_Logo.jpg',  '', 8, '2012-09-11');
TRUNCATE table school_account;
INSERT INTO school_account(id, school_id, years_of_subscription, payment_date, activation_date, expiry_date, status) values (1, 1, 1,  '2012-09-11',  '2012-09-11',  '2014-10-10', 'Active');
TRUNCATE table session;
INSERT INTO session(id, name, begin_date, end_date, school_id) values (1,  '2011/2012',  '2011-09-16',  '2012-07-12', 1);
INSERT INTO session(id, name, begin_date, end_date, school_id) values (59,  '2012/2013',  '2012-09-16',  '2013-07-31', 1);
INSERT INTO session(id, name, begin_date, end_date, school_id) values (60,  '2013/2014',  '2013-11-07',  '2013-11-07', 1);
TRUNCATE table student;
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (1,  '011',  '2011-09-16',  'Musa',  'Abdullahi',  '2001-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (2,  '008',  '2011-09-16',  'Jibrin',  'Dauda',  '2001-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (3,  '024',  '2011-09-16',  'Philemon',  'Elisha',  '2001-09-11', 179,  'Male',  '',  '',  'No',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (4,  '021',  '2011-09-16',  'Stephen',  'Emmanuel',  '1999-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (5,  '005',  '2011-09-16',  'Ali',  'Friday',  '2000-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  'FOSLA LOGO.docx', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (6,  '022',  '2011-09-16',  'Usman',  'Jibrin',  '1999-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (7,  '006',  '2011-09-16',  'Ejeh',  'Joseph',  '2000-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (8,  '018',  '2011-09-16',  'Onyeke Andrew',  'Junior',  '2000-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (9,  '012',  '2011-09-16',  'Mustapha',  'Kehinde',  '2000-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (11,  '015',  '2011-09-16',  'Okafor',  'Prosper',  '2000-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (12,  '003',  '2011-09-16',  'Abraham',  'Solomon',  '1999-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (13,  '013',  '2011-09-16',  'Nabala',  'Vincent',  '1999-09-11', 179,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (14,  '023',  '2011-09-16',  'Yusuf',  'Abdulazeez',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (15,  '001',  '2011-09-16',  'Abdullahi A.',  'Abdullahi',  '2000-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (16,  '007',  '2011-09-16',  'Haruna',  'Allayi',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (17,  '016',  '2011-09-16',  'Omagu',  'Augustine',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (18,  '019',  '2011-09-16',  'Peter',  'Emmanuel',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (19,  '017',  '2011-09-16',  'Omodunusi Azeez',  'Ganiyu',  '1997-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (20,  '010',  '2011-09-16',  'Joshua',  'Issac',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (21,  '002',  '2011-09-16',  'Abdullahi',  'Mohammed',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (22,  '009',  '2011-09-16',  'John',  'Philemon',  '2000-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (23,  '004',  '2011-09-16',  'Adamu',  'Rabiu',  '1998-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (24,  '020',  '2011-09-16',  'Peter',  'Shedrack',  '1999-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (25,  '014',  '2011-09-16',  'Ofozie',  'ThankGod',  '2000-09-12', 180,  'Male',  '',  '',  'Yes',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (55,  'FA/ADM/029',  '2012-09-16',  'Hassan',  'Abdulsalam',  '2000-06-29', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (54,  'FA/ADM/028',  '2012-12-03',  'Ibrahim A.',  'Gimba',  '1999-01-20', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (53,  'FA/ADM/027',  '2012-09-16',  'Mishark',  'Awoje',  '1999-02-05', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (52,  'FA/ADM/026',  '2012-09-16',  'Achu Gabriel',  'Egbo',  '2000-01-08', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (56,  'FA/ADM/030',  '2012-09-16',  'Danladi Isah',  'Ileanwa',  '1999-09-15', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (57,  'FA/ADM/031',  '2012-09-16',  'Sabo Manasseh',  'Moses',  '1999-01-01', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (58,  'FA/ADM/032',  '2012-09-16',  'Abubakar',  'Suleiman',  '2000-03-18', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (59,  'FA/ADM/033',  '2012-09-16',  'Yunusa',  'Usman',  '2012-12-03', 3,  'Male',  '',  '',  '',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (60,  'FA/ADM/034',  '2012-09-16',  'Izuchukwu',  'Okoro',  '1999-07-03', 3,  'Male',  '',  '',  'YES',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (61,  'FA/ADM/035',  '2012-09-16',  'Ezeangwuna',  'Emeka',  '2001-07-03', 3,  'Male',  '',  '',  '',  '',  '',  '',  '',  '',  '', 1);
INSERT INTO student(id, admission_number, date_of_admission, firstname, lastname, date_of_birth, class_id, gender, house, state_of_origin, scholarship, parent_guardian_name, parent_guardian_email, parent_guardian_phone, parent_guardian_address, any_other_information, passport_image, school_id) values (63,  '036',  '2012-09-16',  'Nzube',  'Okeke',  '1996-09-11', 180,  'Male',  '',  '',  '',  '',  '',  '',  '',  '',  '', 1);
TRUNCATE table student_comment_1577972762;
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (1, 1, 1, 3,  '003',  'Very good performance, keep it up',  'A serious student with leadership qualities', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (2, 1, 1, 3,  '005',  'Settle down next term and adjust yourself',  'There is still room for improvement', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (3, 1, 1, 3,  '006',  'Good performance',  'A good start. Keep it up', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (4, 1, 1, 3,  '008',  'Very poor performance, settle down next term',  'Sit up next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (5, 1, 1, 3,  '011',  'Very poor result, adjust yourself next term',  'Must improve next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (6, 1, 1, 3,  '012',  'Good result, but there is room for improvement next term',  'Respectful student, but learn harder', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (7, 1, 1, 3,  '013',  'Weak result, try improved next term',  'Performance not encouraging enough', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (8, 1, 1, 3,  '015',  'Good performance but you need to study harder next term',  'A good start but work harder still', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (9, 1, 1, 3,  '018',  'Very good result, keep it up',  'A very good term&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;#039;s work. Keep it up', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (10, 1, 1, 3,  '021',  'Good result',  'Could do bettet next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (11, 1, 1, 3,  '022',  'You can improve better next term',  'Work extra harder next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (12, 1, 1, 3,  '024',  'An excellent result, keep it up',  'A serious and selfless student. Keep it up', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (13, 1, 1, 3,  '025',  'Weak result, adjust next term',  'There&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;#039;s still enough room for improvement', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (14, 1, 2, 3,  '003',  'Very Good performance, keep it up next term',  'An active Head Boy. Keep it up', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (15, 1, 2, 3,  '005',  'Put in extra effort next term',  'There is still room for improvement', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (16, 1, 2, 3,  '006',  'You could do better next term',  'A good term&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;#039;s work', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (17, 1, 2, 3,  '008',  'Settle down next term to learn',  'Jibrin, sit up. You can improve.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (18, 1, 2, 3,  '011',  'Improve yourself next term',  'Abysmal performance, but can do better still', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (19, 1, 2, 3,  '012',  'Try to adjust yourself next term',  'Don&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;#039;t relax. Keep learning harder', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (20, 1, 2, 3,  '013',  'Settle down very well next term',  'Vincent can do better than this. Sit up', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (21, 1, 2, 3,  '015',  'Good performance, but improve next term',  'An accurate bell boy. Work harder next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (22, 1, 2, 3,  '018',  'Good result. Keep it up',  'An efficient Sports Prefect. Keep working harder', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (23, 1, 2, 3,  '021',  'Improved next term',  'Could still do better', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (24, 1, 2, 3,  '022',  'Adjust next term',  'Performance not good enough', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (25, 1, 2, 3,  '024',  'Excellent result. Keep it up',  'A hardworking House Captain', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (26, 1, 2, 3,  '025',  'Improvememnt, but work harder next term',  'Put in extra effort next term', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (27, 1, 3, 3,  '003',  'V. Good performance keep it up.',  'An excellent performance. Promoted to JSSII', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (28, 1, 3, 3,  '005',  'Work harder and adjust yourself next term.',  'Not encouraging enough. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (29, 1, 3, 3,  '006',  'Joseph should be encouraged next term',  'There is still room for improvement. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (30, 1, 3, 3,  '008',  'Dauda settle down and work harder, Poor result.',  'An abysmal performance. Wake up. Promoted to JSSII', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (31, 1, 3, 3,  '011',  'V. Poor performance settle dwon and study harder next term.',  'Retrogressing. Sit up and learn. Promoted to JSSII on trial.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (32, 1, 3, 3,  '012',  'Kehinde improve your studies next term.',  'Could still do better. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (33, 1, 3, 3,  '013',  'Fair performance, sttle down and work harder next term.',  'Work extra harder next year. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (34, 1, 3, 3,  '015',  'Good result keep it up.',  'Can do better than this. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (35, 1, 3, 3,  '018',  'V. Good performance keep it up.',  'A very good term&amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;amp;#039;s work. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (36, 1, 3, 3,  '021',  'Emmanuel work harder and improve yourself next term',  'There is still enough room for imporvement. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (37, 1, 3, 3,  '022',  'Weak result, try to settle down with your studies next term.',  'Must sit up and improve. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (38, 1, 3, 3,  '024',  'An exccellent result keep it up.',  'An excellent performance. A promissing student. Promoted to JSSII.', 1);
INSERT INTO student_comment_1577972762(id, session_id, term_id, class_id, admission_number, teacher, principal, school_id) values (39, 1, 3, 3,  '025',  'Weak result, work harder next term.',  'Could still improve. Work harder. Promoted to JSSII.', 1);
TRUNCATE table student_fees_1577972762;
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (26, 1, 1, 3,  '025',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (25, 1, 1, 3,  '024',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (24, 1, 1, 3,  '022',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (23, 1, 1, 3,  '021',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (22, 1, 1, 3,  '018',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (21, 1, 1, 3,  '015',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (20, 1, 1, 3,  '013',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (19, 1, 1, 3,  '012',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (18, 1, 1, 3,  '011',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (17, 1, 1, 3,  '008',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (16, 1, 1, 3,  '006',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (15, 1, 1, 3,  '005',  '2012-09-13',  '0', 1);
INSERT INTO student_fees_1577972762(id, session_id, term_id, class_id, admission_number, date, amount_paid, school_id) values (14, 1, 1, 3,  '003',  '2012-09-13',  '0', 1);
TRUNCATE table student_non_academic_1577972762;
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (1,  '25', 1, 3, 3, 1,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (2,  '25', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (3,  '25', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (4,  '25', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (5,  '25', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (6,  '25', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (7,  '25', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (8,  '25', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (9,  '25', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (10,  '25', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (11,  '25', 1, 3, 3, 11,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (12,  '25', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (13,  '3', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (14,  '3', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (15,  '3', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (16,  '3', 1, 3, 3, 4,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (17,  '3', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (18,  '3', 1, 3, 3, 6,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (19,  '3', 1, 3, 3, 7,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (20,  '3', 1, 3, 3, 8,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (21,  '3', 1, 3, 3, 9,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (22,  '3', 1, 3, 3, 10,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (23,  '3', 1, 3, 3, 11,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (24,  '3', 1, 3, 3, 12,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (25,  '5', 1, 3, 3, 1,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (26,  '5', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (27,  '5', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (28,  '5', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (29,  '5', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (30,  '5', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (31,  '5', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (32,  '5', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (33,  '5', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (34,  '5', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (35,  '5', 1, 3, 3, 11,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (36,  '5', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (37,  '8', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (38,  '8', 1, 3, 3, 2,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (39,  '8', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (40,  '8', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (41,  '8', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (42,  '8', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (43,  '8', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (44,  '8', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (45,  '8', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (46,  '8', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (47,  '8', 1, 3, 3, 11,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (48,  '8', 1, 3, 3, 12,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (49,  '12', 1, 3, 3, 1,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (50,  '12', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (51,  '12', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (52,  '12', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (53,  '12', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (54,  '12', 1, 3, 3, 6,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (55,  '12', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (56,  '12', 1, 3, 3, 8,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (57,  '12', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (58,  '12', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (59,  '12', 1, 3, 3, 11,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (60,  '12', 1, 3, 3, 12,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (61,  '6', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (62,  '6', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (63,  '6', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (64,  '6', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (65,  '6', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (66,  '6', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (67,  '6', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (68,  '6', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (69,  '6', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (70,  '6', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (71,  '6', 1, 3, 3, 11,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (72,  '6', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (73,  '13', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (74,  '13', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (75,  '13', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (76,  '13', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (77,  '13', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (78,  '13', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (79,  '13', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (80,  '13', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (81,  '13', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (82,  '13', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (83,  '13', 1, 3, 3, 11,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (84,  '13', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (85,  '15', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (86,  '15', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (87,  '15', 1, 3, 3, 3,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (88,  '15', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (89,  '15', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (90,  '15', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (91,  '15', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (92,  '15', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (93,  '15', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (94,  '15', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (95,  '15', 1, 3, 3, 11,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (96,  '15', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (97,  '21', 1, 3, 3, 1,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (98,  '21', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (99,  '21', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (100,  '21', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (101,  '21', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (102,  '21', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (103,  '21', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (104,  '21', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (105,  '21', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (106,  '21', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (107,  '21', 1, 3, 3, 11,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (108,  '21', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (109,  '22', 1, 3, 3, 1,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (110,  '22', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (111,  '22', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (112,  '22', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (113,  '22', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (114,  '22', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (115,  '22', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (116,  '22', 1, 3, 3, 8,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (117,  '22', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (118,  '22', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (119,  '22', 1, 3, 3, 11,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (120,  '22', 1, 3, 3, 12,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (121,  '18', 1, 3, 3, 1,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (122,  '18', 1, 3, 3, 2,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (123,  '18', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (124,  '18', 1, 3, 3, 4,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (125,  '18', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (126,  '18', 1, 3, 3, 6,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (127,  '18', 1, 3, 3, 7,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (128,  '18', 1, 3, 3, 8,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (129,  '18', 1, 3, 3, 9,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (130,  '18', 1, 3, 3, 10,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (131,  '18', 1, 3, 3, 11,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (132,  '18', 1, 3, 3, 12,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (133,  '24', 1, 3, 3, 1,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (134,  '24', 1, 3, 3, 2,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (135,  '24', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (136,  '24', 1, 3, 3, 4,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (137,  '24', 1, 3, 3, 5,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (138,  '24', 1, 3, 3, 6,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (139,  '24', 1, 3, 3, 7,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (140,  '24', 1, 3, 3, 8,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (141,  '24', 1, 3, 3, 9,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (142,  '24', 1, 3, 3, 10,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (143,  '24', 1, 3, 3, 11,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (144,  '24', 1, 3, 3, 12,  '4', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (145,  '11', 1, 3, 3, 1,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (146,  '11', 1, 3, 3, 2,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (147,  '11', 1, 3, 3, 3,  '5', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (148,  '11', 1, 3, 3, 4,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (149,  '11', 1, 3, 3, 5,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (150,  '11', 1, 3, 3, 6,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (151,  '11', 1, 3, 3, 7,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (152,  '11', 1, 3, 3, 8,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (153,  '11', 1, 3, 3, 9,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (154,  '11', 1, 3, 3, 10,  '3', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (155,  '11', 1, 3, 3, 11,  '2', 1);
INSERT INTO student_non_academic_1577972762(id, admission_number, session_id, term_id, class_id, non_academic_id, score, school_id) values (156,  '11', 1, 3, 3, 12,  '3', 1);
TRUNCATE table student_subject_1577972762;
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (425, 1, 1, 3,  '005', 15,  '16',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (265, 1, 1, 3,  '003', 15,  '25',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (218, 1, 1, 3,  '003', 9,  '26',  '67', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (170, 1, 1, 3,  '003', 5,  '21',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (277, 1, 1, 3,  '003', 21,  '9',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (206, 1, 1, 3,  '003', 10,  '30',  '68', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (381, 1, 1, 3,  '005', 10,  '19',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (194, 1, 1, 3,  '003', 11,  '24',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (13, 1, 1, 3,  '025', 6,  '15',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (253, 1, 1, 3,  '003', 12,  '26',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (301, 1, 1, 3,  '003', 17,  '28',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (182, 1, 1, 3,  '003', 6,  '25',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (26, 1, 1, 3,  '025', 5,  '10',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (403, 1, 1, 3,  '005', 13,  '21',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (39, 1, 1, 3,  '025', 11,  '19',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (52, 1, 1, 3,  '025', 10,  '18',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (65, 1, 1, 3,  '025', 9,  '11',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (78, 1, 1, 3,  '025', 13,  '14',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (91, 1, 1, 3,  '025', 12,  '18',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (104, 1, 1, 3,  '025', 15,  '17',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (117, 1, 1, 3,  '025', 21,  '13',  '10', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (130, 1, 1, 3,  '025', 22,  '17',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (143, 1, 1, 3,  '025', 17,  '9',  '14', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (156, 1, 1, 3,  '025', 16,  '21',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (169, 1, 1, 3,  '025', 14,  '16',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (469, 1, 1, 3,  '005', 16,  '21',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (241, 1, 1, 3,  '003', 13,  '21',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (447, 1, 1, 3,  '005', 22,  '20',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (325, 1, 1, 3,  '003', 14,  '21',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (509, 1, 1, 3,  '024', 6,  '22',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (289, 1, 1, 3,  '003', 22,  '28',  '68', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (313, 1, 1, 3,  '003', 16,  '26',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (359, 1, 1, 3,  '005', 5,  '4',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (348, 1, 1, 3,  '005', 6,  '14',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (492, 1, 1, 3,  '008', 6,  '13',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (370, 1, 1, 3,  '005', 11,  '16',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (505, 1, 1, 3,  '015', 6,  '21',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (392, 1, 1, 3,  '005', 9,  '20',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (508, 1, 1, 3,  '022', 6,  '18',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (414, 1, 1, 3,  '005', 12,  '20',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (507, 1, 1, 3,  '021', 6,  '18',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (436, 1, 1, 3,  '005', 21,  '10',  '13', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (504, 1, 1, 3,  '013', 6,  '14',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (458, 1, 1, 3,  '005', 17,  '10',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (506, 1, 1, 3,  '018', 6,  '23',  '41', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (480, 1, 1, 3,  '005', 14,  '19',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (501, 1, 1, 3,  '006', 6,  '24',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (502, 1, 1, 3,  '011', 6,  '12',  '9', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (503, 1, 1, 3,  '012', 6,  '18',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (510, 1, 1, 3,  '006', 5,  '28',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (511, 1, 1, 3,  '008', 5,  '6',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (512, 1, 1, 3,  '011', 5,  '7',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (513, 1, 1, 3,  '012', 5,  '20',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (514, 1, 1, 3,  '013', 5,  '8',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (515, 1, 1, 3,  '015', 5,  '16',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (516, 1, 1, 3,  '018', 5,  '16',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (517, 1, 1, 3,  '021', 5,  '20',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (518, 1, 1, 3,  '022', 5,  '13',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (519, 1, 1, 3,  '024', 5,  '29',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (520, 1, 1, 3,  '006', 11,  '21',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (521, 1, 1, 3,  '008', 11,  '17',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (522, 1, 1, 3,  '011', 11,  '16',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (523, 1, 1, 3,  '012', 11,  '16',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (524, 1, 1, 3,  '013', 11,  '18',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (525, 1, 1, 3,  '015', 11,  '24',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (526, 1, 1, 3,  '018', 11,  '14',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (527, 1, 1, 3,  '021', 11,  '18',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (528, 1, 1, 3,  '022', 11,  '18',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (529, 1, 1, 3,  '024', 11,  '25',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (530, 1, 1, 3,  '006', 9,  '26',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (531, 1, 1, 3,  '008', 9,  '8',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (532, 1, 1, 3,  '011', 9,  '12',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (533, 1, 1, 3,  '012', 9,  '12',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (534, 1, 1, 3,  '013', 9,  '13',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (535, 1, 1, 3,  '015', 9,  '24',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (536, 1, 1, 3,  '018', 9,  '26',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (537, 1, 1, 3,  '021', 9,  '19',  '64', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (538, 1, 1, 3,  '022', 9,  '22',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (539, 1, 1, 3,  '024', 9,  '30',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (540, 1, 1, 3,  '006', 10,  '24',  '66', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (541, 1, 1, 3,  '008', 10,  '12',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (542, 1, 1, 3,  '011', 10,  '11',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (543, 1, 1, 3,  '012', 10,  '25',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (544, 1, 1, 3,  '013', 10,  '15',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (545, 1, 1, 3,  '015', 10,  '29',  '67', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (546, 1, 1, 3,  '018', 10,  '28',  '69', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (547, 1, 1, 3,  '021', 10,  '23',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (548, 1, 1, 3,  '022', 10,  '24',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (549, 1, 1, 3,  '024', 10,  '28',  '68', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (563, 1, 1, 3,  '015', 12,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (551, 1, 1, 3,  '008', 12,  '18',  '17', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (553, 1, 1, 3,  '012', 12,  '22',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (560, 1, 1, 3,  '006', 12,  '24',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (561, 1, 1, 3,  '011', 12,  '15',  '9', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (562, 1, 1, 3,  '013', 12,  '15',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (564, 1, 1, 3,  '018', 12,  '25',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (565, 1, 1, 3,  '021', 12,  '23',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (566, 1, 1, 3,  '022', 12,  '19',  '41', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (567, 1, 1, 3,  '024', 12,  '27',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (568, 1, 1, 3,  '006', 13,  '18',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (569, 1, 1, 3,  '008', 13,  '15',  '5', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (570, 1, 1, 3,  '011', 13,  '17',  '6', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (571, 1, 1, 3,  '012', 13,  '26',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (572, 1, 1, 3,  '013', 13,  '14',  '24', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (573, 1, 1, 3,  '015', 13,  '22',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (574, 1, 1, 3,  '018', 13,  '18',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (575, 1, 1, 3,  '021', 13,  '12',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (576, 1, 1, 3,  '022', 13,  '20',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (577, 1, 1, 3,  '024', 13,  '24',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (578, 1, 1, 3,  '006', 14,  '23',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (579, 1, 1, 3,  '008', 14,  '15',  '24', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (580, 1, 1, 3,  '011', 14,  '15',  '19', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (581, 1, 1, 3,  '012', 14,  '19',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (582, 1, 1, 3,  '013', 14,  '15',  '9', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (583, 1, 1, 3,  '015', 14,  '25',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (584, 1, 1, 3,  '018', 14,  '26',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (585, 1, 1, 3,  '021', 14,  '20',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (586, 1, 1, 3,  '022', 14,  '16',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (587, 1, 1, 3,  '024', 14,  '24',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (588, 1, 1, 3,  '006', 15,  '15',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (589, 1, 1, 3,  '008', 15,  '17',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (590, 1, 1, 3,  '011', 15,  '19',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (591, 1, 1, 3,  '012', 15,  '20',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (592, 1, 1, 3,  '013', 15,  '18',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (593, 1, 1, 3,  '015', 15,  '17',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (594, 1, 1, 3,  '018', 15,  '23',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (595, 1, 1, 3,  '021', 15,  '18',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (596, 1, 1, 3,  '022', 15,  '17',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (597, 1, 1, 3,  '024', 15,  '22',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (598, 1, 1, 3,  '006', 16,  '24',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (599, 1, 1, 3,  '008', 16,  '21',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (600, 1, 1, 3,  '011', 16,  '21',  '8', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (601, 1, 1, 3,  '012', 16,  '22',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (602, 1, 1, 3,  '013', 16,  '22',  '16', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (603, 1, 1, 3,  '015', 16,  '24',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (604, 1, 1, 3,  '018', 16,  '22',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (605, 1, 1, 3,  '021', 16,  '21',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (606, 1, 1, 3,  '022', 16,  '20',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (607, 1, 1, 3,  '024', 16,  '22',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (608, 1, 1, 3,  '006', 17,  '17',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (609, 1, 1, 3,  '008', 17,  '9',  '7', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (610, 1, 1, 3,  '011', 17,  '6',  '7', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (611, 1, 1, 3,  '012', 17,  '19',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (612, 1, 1, 3,  '013', 17,  '11',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (613, 1, 1, 3,  '015', 17,  '22',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (614, 1, 1, 3,  '018', 17,  '20',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (615, 1, 1, 3,  '021', 17,  '18',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (616, 1, 1, 3,  '022', 17,  '15',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (617, 1, 1, 3,  '024', 17,  '26',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (618, 1, 1, 3,  '006', 22,  '23',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (619, 1, 1, 3,  '008', 22,  '18',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (620, 1, 1, 3,  '011', 22,  '15',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (621, 1, 1, 3,  '012', 22,  '23',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (622, 1, 1, 3,  '013', 22,  '16',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (623, 1, 1, 3,  '015', 22,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (624, 1, 1, 3,  '018', 22,  '27',  '67', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (625, 1, 1, 3,  '021', 22,  '24',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (626, 1, 1, 3,  '022', 22,  '21',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (627, 1, 1, 3,  '024', 22,  '27',  '66', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (628, 1, 1, 3,  '006', 21,  '15',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (629, 1, 1, 3,  '008', 21,  '18',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (630, 1, 1, 3,  '011', 21,  '15',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (631, 1, 1, 3,  '012', 21,  '15',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (632, 1, 1, 3,  '013', 21,  '15',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (633, 1, 1, 3,  '015', 21,  '7',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (634, 1, 1, 3,  '018', 21,  '18',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (635, 1, 1, 3,  '021', 21,  '15',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (636, 1, 1, 3,  '022', 21,  '20',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (637, 1, 1, 3,  '024', 21,  '15',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (638, 1, 2, 3,  '003', 6,  '20',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (639, 1, 2, 3,  '005', 6,  '13',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (640, 1, 2, 3,  '006', 6,  '21',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (641, 1, 2, 3,  '008', 6,  '11',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (642, 1, 2, 3,  '011', 6,  '8',  '10', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (643, 1, 2, 3,  '012', 6,  '17',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (644, 1, 2, 3,  '013', 6,  '14',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (645, 1, 2, 3,  '015', 6,  '17',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (646, 1, 2, 3,  '018', 6,  '18',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (647, 1, 2, 3,  '021', 6,  '17',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (648, 1, 2, 3,  '022', 6,  '16',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (649, 1, 2, 3,  '024', 6,  '22',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (650, 1, 2, 3,  '025', 6,  '12',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (651, 1, 2, 3,  '003', 5,  '22',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (652, 1, 2, 3,  '005', 5,  '6',  '19', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (653, 1, 2, 3,  '006', 5,  '21',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (654, 1, 2, 3,  '008', 5,  '8',  '19', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (655, 1, 2, 3,  '011', 5,  '8',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (656, 1, 2, 3,  '012', 5,  '18',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (657, 1, 2, 3,  '013', 5,  '10',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (658, 1, 2, 3,  '015', 5,  '13',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (659, 1, 2, 3,  '018', 5,  '18',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (660, 1, 2, 3,  '021', 5,  '14',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (661, 1, 2, 3,  '022', 5,  '9',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (662, 1, 2, 3,  '024', 5,  '25',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (663, 1, 2, 3,  '025', 5,  '7',  '13', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (664, 1, 2, 3,  '003', 9,  '23',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (665, 1, 2, 3,  '005', 9,  '18',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (666, 1, 2, 3,  '006', 9,  '18',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (667, 1, 2, 3,  '008', 9,  '12',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (668, 1, 2, 3,  '011', 9,  '8',  '20', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (669, 1, 2, 3,  '012', 9,  '18',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (670, 1, 2, 3,  '013', 9,  '12',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (671, 1, 2, 3,  '015', 9,  '19',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (672, 1, 2, 3,  '018', 9,  '26',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (673, 1, 2, 3,  '021', 9,  '16',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (674, 1, 2, 3,  '022', 9,  '13',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (675, 1, 2, 3,  '024', 9,  '26',  '69', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (676, 1, 2, 3,  '025', 9,  '9',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (677, 1, 2, 3,  '003', 10,  '21',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (678, 1, 2, 3,  '005', 10,  '18',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (679, 1, 2, 3,  '006', 10,  '14',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (680, 1, 2, 3,  '008', 10,  '9',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (681, 1, 2, 3,  '011', 10,  '6',  '7', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (682, 1, 2, 3,  '012', 10,  '15',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (683, 1, 2, 3,  '013', 10,  '12',  '14', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (684, 1, 2, 3,  '015', 10,  '17',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (685, 1, 2, 3,  '018', 10,  '21',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (686, 1, 2, 3,  '021', 10,  '17',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (687, 1, 2, 3,  '022', 10,  '19',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (688, 1, 2, 3,  '024', 10,  '20',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (689, 1, 2, 3,  '025', 10,  '11',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (690, 1, 2, 3,  '003', 11,  '19',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (691, 1, 2, 3,  '005', 11,  '8',  '16', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (692, 1, 2, 3,  '006', 11,  '19',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (693, 1, 2, 3,  '008', 11,  '9',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (694, 1, 2, 3,  '011', 11,  '8',  '10', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (695, 1, 2, 3,  '012', 11,  '10',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (696, 1, 2, 3,  '013', 11,  '12',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (697, 1, 2, 3,  '015', 11,  '12',  '41', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (698, 1, 2, 3,  '018', 11,  '18',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (699, 1, 2, 3,  '021', 11,  '12',  '16', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (700, 1, 2, 3,  '022', 11,  '11',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (701, 1, 2, 3,  '024', 11,  '14',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (702, 1, 2, 3,  '025', 11,  '8',  '17', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (703, 1, 2, 3,  '003', 12,  '28',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (704, 1, 2, 3,  '005', 12,  '18',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (705, 1, 2, 3,  '006', 12,  '24',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (706, 1, 2, 3,  '008', 12,  '16',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (707, 1, 2, 3,  '011', 12,  '16',  '20', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (708, 1, 2, 3,  '012', 12,  '22',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (709, 1, 2, 3,  '013', 12,  '17',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (710, 1, 2, 3,  '015', 12,  '23',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (711, 1, 2, 3,  '018', 12,  '22',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (712, 1, 2, 3,  '021', 12,  '22',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (713, 1, 2, 3,  '022', 12,  '20',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (714, 1, 2, 3,  '024', 12,  '26',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (715, 1, 2, 3,  '025', 12,  '16',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (716, 1, 2, 3,  '003', 13,  '23',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (717, 1, 2, 3,  '005', 13,  '24',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (718, 1, 2, 3,  '006', 13,  '21',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (719, 1, 2, 3,  '008', 13,  '13',  '20', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (720, 1, 2, 3,  '011', 13,  '16',  '9', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (721, 1, 2, 3,  '012', 13,  '21',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (722, 1, 2, 3,  '013', 13,  '13',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (723, 1, 2, 3,  '015', 13,  '21',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (724, 1, 2, 3,  '018', 13,  '21',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (725, 1, 2, 3,  '021', 13,  '13',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (726, 1, 2, 3,  '022', 13,  '17',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (727, 1, 2, 3,  '024', 13,  '27',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (728, 1, 2, 3,  '025', 13,  '12',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (729, 1, 2, 3,  '003', 15,  '22',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (730, 1, 2, 3,  '005', 15,  '21',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (731, 1, 2, 3,  '006', 15,  '24',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (732, 1, 2, 3,  '008', 15,  '16',  '19', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (733, 1, 2, 3,  '011', 15,  '18',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (734, 1, 2, 3,  '012', 15,  '23',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (735, 1, 2, 3,  '013', 15,  '22',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (736, 1, 2, 3,  '015', 15,  '24',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (737, 1, 2, 3,  '018', 15,  '25',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (738, 1, 2, 3,  '021', 15,  '22',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (739, 1, 2, 3,  '022', 15,  '21',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (740, 1, 2, 3,  '024', 15,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (741, 1, 2, 3,  '025', 15,  '13',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (742, 1, 2, 3,  '003', 21,  '22',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (743, 1, 2, 3,  '005', 21,  '14',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (744, 1, 2, 3,  '006', 21,  '19',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (745, 1, 2, 3,  '008', 21,  '21',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (746, 1, 2, 3,  '011', 21,  '22',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (747, 1, 2, 3,  '012', 21,  '12',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (748, 1, 2, 3,  '013', 21,  '16',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (749, 1, 2, 3,  '015', 21,  '17',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (750, 1, 2, 3,  '018', 21,  '23',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (751, 1, 2, 3,  '021', 21,  '20',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (752, 1, 2, 3,  '022', 21,  '21',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (753, 1, 2, 3,  '024', 21,  '24',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (754, 1, 2, 3,  '025', 21,  '23',  '17', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (755, 1, 2, 3,  '003', 14,  '23',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (756, 1, 2, 3,  '005', 14,  '22',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (757, 1, 2, 3,  '006', 14,  '23',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (758, 1, 2, 3,  '008', 14,  '21',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (759, 1, 2, 3,  '011', 14,  '18',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (760, 1, 2, 3,  '012', 14,  '26',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (761, 1, 2, 3,  '013', 14,  '19',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (762, 1, 2, 3,  '015', 14,  '23',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (763, 1, 2, 3,  '018', 14,  '24',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (764, 1, 2, 3,  '021', 14,  '20',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (765, 1, 2, 3,  '022', 14,  '25',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (766, 1, 2, 3,  '024', 14,  '28',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (767, 1, 2, 3,  '025', 14,  '19',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (768, 1, 2, 3,  '003', 22,  '28',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (769, 1, 2, 3,  '005', 22,  '22',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (770, 1, 2, 3,  '006', 22,  '21',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (771, 1, 2, 3,  '008', 22,  '16',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (772, 1, 2, 3,  '011', 22,  '16',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (773, 1, 2, 3,  '012', 22,  '24',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (774, 1, 2, 3,  '013', 22,  '13',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (775, 1, 2, 3,  '015', 22,  '24',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (776, 1, 2, 3,  '018', 22,  '27',  '64', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (777, 1, 2, 3,  '021', 22,  '23',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (778, 1, 2, 3,  '022', 22,  '20',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (779, 1, 2, 3,  '024', 22,  '29',  '63', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (780, 1, 2, 3,  '025', 22,  '16',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (781, 1, 2, 3,  '003', 17,  '26',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (782, 1, 2, 3,  '005', 17,  '19',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (783, 1, 2, 3,  '006', 17,  '19',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (784, 1, 2, 3,  '008', 17,  '11',  '15', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (785, 1, 2, 3,  '011', 17,  '15',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (786, 1, 2, 3,  '012', 17,  '19',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (787, 1, 2, 3,  '013', 17,  '14',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (788, 1, 2, 3,  '015', 17,  '18',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (789, 1, 2, 3,  '018', 17,  '23',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (790, 1, 2, 3,  '021', 17,  '18',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (791, 1, 2, 3,  '022', 17,  '17',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (792, 1, 2, 3,  '024', 17,  '26',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (793, 1, 2, 3,  '025', 17,  '15',  '24', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (794, 1, 2, 3,  '003', 16,  '20',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (795, 1, 2, 3,  '005', 16,  '20',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (796, 1, 2, 3,  '006', 16,  '20',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (797, 1, 2, 3,  '008', 16,  '11',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (798, 1, 2, 3,  '011', 16,  '7',  '14', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (799, 1, 2, 3,  '012', 16,  '19',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (800, 1, 2, 3,  '013', 16,  '10',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (801, 1, 2, 3,  '015', 16,  '17',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (802, 1, 2, 3,  '018', 16,  '20',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (803, 1, 2, 3,  '021', 16,  '16',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (804, 1, 2, 3,  '022', 16,  '17',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (805, 1, 2, 3,  '024', 16,  '21',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (806, 1, 2, 3,  '025', 16,  '10',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (807, 1, 3, 3,  '003', 22,  '28',  '66', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (808, 1, 3, 3,  '005', 22,  '26',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (809, 1, 3, 3,  '006', 22,  '24',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (810, 1, 3, 3,  '008', 22,  '20',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (811, 1, 3, 3,  '011', 22,  '18',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (812, 1, 3, 3,  '012', 22,  '26',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (813, 1, 3, 3,  '013', 22,  '23',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (814, 1, 3, 3,  '015', 22,  '26',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (815, 1, 3, 3,  '018', 22,  '26',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (816, 1, 3, 3,  '021', 22,  '25',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (817, 1, 3, 3,  '022', 22,  '24',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (818, 1, 3, 3,  '024', 22,  '30',  '66', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (819, 1, 3, 3,  '025', 22,  '26',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (820, 1, 3, 3,  '003', 21,  '26',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (821, 1, 3, 3,  '005', 21,  '20',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (822, 1, 3, 3,  '006', 21,  '23',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (823, 1, 3, 3,  '008', 21,  '25',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (824, 1, 3, 3,  '011', 21,  '22',  '24', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (825, 1, 3, 3,  '012', 21,  '24',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (826, 1, 3, 3,  '013', 21,  '21',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (827, 1, 3, 3,  '015', 21,  '5',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (828, 1, 3, 3,  '018', 21,  '10',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (829, 1, 3, 3,  '021', 21,  '25',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (830, 1, 3, 3,  '022', 21,  '22',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (831, 1, 3, 3,  '024', 21,  '27',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (832, 1, 3, 3,  '025', 21,  '13',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (833, 1, 3, 3,  '003', 20,  '19',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (834, 1, 3, 3,  '005', 20,  '19',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (835, 1, 3, 3,  '006', 20,  '19',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (836, 1, 3, 3,  '008', 20,  '19',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (837, 1, 3, 3,  '011', 20,  '19',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (838, 1, 3, 3,  '012', 20,  '19',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (839, 1, 3, 3,  '013', 20,  '19',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (840, 1, 3, 3,  '015', 20,  '19',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (841, 1, 3, 3,  '018', 20,  '19',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (842, 1, 3, 3,  '021', 20,  '19',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (843, 1, 3, 3,  '022', 20,  '19',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (844, 1, 3, 3,  '024', 20,  '19',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (845, 1, 3, 3,  '025', 20,  '19',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (846, 1, 3, 3,  '003', 19,  '23',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (847, 1, 3, 3,  '005', 19,  '25',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (848, 1, 3, 3,  '006', 19,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (849, 1, 3, 3,  '008', 19,  '18',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (850, 1, 3, 3,  '011', 19,  '21',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (851, 1, 3, 3,  '012', 19,  '25',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (852, 1, 3, 3,  '013', 19,  '19',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (853, 1, 3, 3,  '015', 19,  '23',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (854, 1, 3, 3,  '018', 19,  '25',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (855, 1, 3, 3,  '021', 19,  '21',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (856, 1, 3, 3,  '022', 19,  '22',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (857, 1, 3, 3,  '024', 19,  '30',  '69', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (858, 1, 3, 3,  '025', 19,  '18',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (859, 1, 3, 3,  '003', 18,  '29',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (860, 1, 3, 3,  '005', 18,  '24',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (861, 1, 3, 3,  '006', 18,  '27',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (862, 1, 3, 3,  '008', 18,  '17',  '19', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (863, 1, 3, 3,  '011', 18,  '15',  '13', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (864, 1, 3, 3,  '012', 18,  '24',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (865, 1, 3, 3,  '013', 18,  '16',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (866, 1, 3, 3,  '015', 18,  '20',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (867, 1, 3, 3,  '018', 18,  '25',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (868, 1, 3, 3,  '021', 18,  '23',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (869, 1, 3, 3,  '022', 18,  '23',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (870, 1, 3, 3,  '024', 18,  '30',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (871, 1, 3, 3,  '025', 18,  '17',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (872, 1, 3, 3,  '003', 17,  '25',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (873, 1, 3, 3,  '005', 17,  '19',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (874, 1, 3, 3,  '006', 17,  '21.5',  '42.5', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (875, 1, 3, 3,  '008', 17,  '18',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (876, 1, 3, 3,  '011', 17,  '14',  '7', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (877, 1, 3, 3,  '012', 17,  '22',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (878, 1, 3, 3,  '013', 17,  '16',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (879, 1, 3, 3,  '015', 17,  '23',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (880, 1, 3, 3,  '018', 17,  '27',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (881, 1, 3, 3,  '021', 17,  '20.5',  '44.5', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (882, 1, 3, 3,  '022', 17,  '22.5',  '42.5', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (883, 1, 3, 3,  '024', 17,  '27',  '65', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (884, 1, 3, 3,  '025', 17,  '18.5',  '31.5', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (885, 1, 3, 3,  '003', 16,  '18',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (886, 1, 3, 3,  '005', 16,  '20',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (887, 1, 3, 3,  '006', 16,  '22',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (888, 1, 3, 3,  '008', 16,  '19',  '41', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (889, 1, 3, 3,  '011', 16,  '18',  '20', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (890, 1, 3, 3,  '012', 16,  '20',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (891, 1, 3, 3,  '013', 16,  '14',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (892, 1, 3, 3,  '015', 16,  '15',  '44', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (893, 1, 3, 3,  '018', 16,  '16',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (894, 1, 3, 3,  '021', 16,  '15',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (895, 1, 3, 3,  '022', 16,  '17',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (896, 1, 3, 3,  '024', 16,  '23',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (897, 1, 3, 3,  '025', 16,  '9',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (898, 1, 3, 3,  '003', 15,  '26',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (899, 1, 3, 3,  '005', 15,  '23',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (900, 1, 3, 3,  '006', 15,  '24',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (901, 1, 3, 3,  '008', 15,  '21',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (902, 1, 3, 3,  '011', 15,  '18',  '13', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (903, 1, 3, 3,  '012', 15,  '22',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (904, 1, 3, 3,  '013', 15,  '21',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (905, 1, 3, 3,  '015', 15,  '24',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (906, 1, 3, 3,  '018', 15,  '24',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (907, 1, 3, 3,  '021', 15,  '23',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (908, 1, 3, 3,  '022', 15,  '21',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (909, 1, 3, 3,  '024', 15,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (910, 1, 3, 3,  '025', 15,  '21',  '30', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (911, 1, 3, 3,  '003', 14,  '25',  '63', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (912, 1, 3, 3,  '005', 14,  '23',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (913, 1, 3, 3,  '006', 14,  '24',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (914, 1, 3, 3,  '008', 14,  '23',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (915, 1, 3, 3,  '011', 14,  '25',  '26', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (916, 1, 3, 3,  '012', 14,  '25',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (917, 1, 3, 3,  '013', 14,  '21',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (918, 1, 3, 3,  '015', 14,  '23',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (919, 1, 3, 3,  '018', 14,  '25',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (920, 1, 3, 3,  '021', 14,  '23',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (921, 1, 3, 3,  '022', 14,  '25',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (922, 1, 3, 3,  '024', 14,  '26',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (923, 1, 3, 3,  '025', 14,  '22',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (924, 1, 3, 3,  '003', 13,  '24',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (925, 1, 3, 3,  '005', 13,  '22',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (926, 1, 3, 3,  '006', 13,  '24',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (927, 1, 3, 3,  '008', 13,  '14',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (928, 1, 3, 3,  '011', 13,  '10',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (929, 1, 3, 3,  '012', 13,  '19',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (930, 1, 3, 3,  '013', 13,  '13',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (931, 1, 3, 3,  '015', 13,  '24',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (932, 1, 3, 3,  '018', 13,  '25',  '48', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (933, 1, 3, 3,  '021', 13,  '20',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (934, 1, 3, 3,  '022', 13,  '17',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (935, 1, 3, 3,  '024', 13,  '29',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (936, 1, 3, 3,  '025', 13,  '17',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (937, 1, 3, 3,  '003', 12,  '28',  '63', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (938, 1, 3, 3,  '005', 12,  '27',  '56', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (939, 1, 3, 3,  '006', 12,  '27',  '59', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (940, 1, 3, 3,  '008', 12,  '24',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (941, 1, 3, 3,  '011', 12,  '18',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (942, 1, 3, 3,  '012', 12,  '25',  '57', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (943, 1, 3, 3,  '013', 12,  '22',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (944, 1, 3, 3,  '015', 12,  '25',  '60', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (945, 1, 3, 3,  '018', 12,  '27',  '61', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (946, 1, 3, 3,  '021', 12,  '26',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (947, 1, 3, 3,  '022', 12,  '22',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (948, 1, 3, 3,  '024', 12,  '28',  '64', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (949, 1, 3, 3,  '025', 12,  '20',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (950, 1, 3, 3,  '003', 11,  '25',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (951, 1, 3, 3,  '005', 11,  '13',  '21', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (952, 1, 3, 3,  '006', 11,  '23',  '28', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (953, 1, 3, 3,  '008', 11,  '17',  '16', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (954, 1, 3, 3,  '011', 11,  '13',  '14', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (955, 1, 3, 3,  '012', 11,  '20',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (956, 1, 3, 3,  '013', 11,  '16',  '25', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (957, 1, 3, 3,  '015', 11,  '22',  '39', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (958, 1, 3, 3,  '018', 11,  '23',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (959, 1, 3, 3,  '021', 11,  '20',  '31', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (960, 1, 3, 3,  '022', 11,  '15',  '24', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (961, 1, 3, 3,  '024', 11,  '27',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (962, 1, 3, 3,  '025', 11,  '14',  '11', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (963, 1, 3, 3,  '003', 10,  '24',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (964, 1, 3, 3,  '005', 10,  '19',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (965, 1, 3, 3,  '006', 10,  '15',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (966, 1, 3, 3,  '008', 10,  '14',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (967, 1, 3, 3,  '011', 10,  '11',  '7', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (968, 1, 3, 3,  '012', 10,  '17',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (969, 1, 3, 3,  '013', 10,  '11',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (970, 1, 3, 3,  '015', 10,  '17',  '52', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (971, 1, 3, 3,  '018', 10,  '19',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (972, 1, 3, 3,  '021', 10,  '19',  '47', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (973, 1, 3, 3,  '022', 10,  '11',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (974, 1, 3, 3,  '024', 10,  '25',  '63', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (975, 1, 3, 3,  '025', 10,  '11',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (976, 1, 3, 3,  '003', 9,  '23',  '53', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (977, 1, 3, 3,  '005', 9,  '21',  '43', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (978, 1, 3, 3,  '006', 9,  '17',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (979, 1, 3, 3,  '008', 9,  '7',  '23', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (980, 1, 3, 3,  '011', 9,  '5',  '12', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (981, 1, 3, 3,  '012', 9,  '19',  '51', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (982, 1, 3, 3,  '013', 9,  '8',  '33', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (983, 1, 3, 3,  '015', 9,  '16',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (984, 1, 3, 3,  '018', 9,  '23',  '58', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (985, 1, 3, 3,  '021', 9,  '21',  '46', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (986, 1, 3, 3,  '022', 9,  '12',  '34', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (987, 1, 3, 3,  '024', 9,  '22',  '63', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (988, 1, 3, 3,  '025', 9,  '6',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (989, 1, 3, 3,  '003', 5,  '25',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (990, 1, 3, 3,  '005', 5,  '14',  '17', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (991, 1, 3, 3,  '006', 5,  '26',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (992, 1, 3, 3,  '008', 5,  '15',  '20', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (993, 1, 3, 3,  '011', 5,  '12',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (994, 1, 3, 3,  '012', 5,  '19',  '32', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (995, 1, 3, 3,  '013', 5,  '15',  '38', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (996, 1, 3, 3,  '015', 5,  '21',  '40', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (997, 1, 3, 3,  '018', 5,  '26',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (998, 1, 3, 3,  '021', 5,  '21',  '37', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (999, 1, 3, 3,  '022', 5,  '16',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1000, 1, 3, 3,  '024', 5,  '27',  '49', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1001, 1, 3, 3,  '025', 5,  '15',  '18', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1002, 1, 3, 3,  '003', 6,  '20',  '54', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1003, 1, 3, 3,  '005', 6,  '15',  '36', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1004, 1, 3, 3,  '006', 6,  '20',  '50', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1005, 1, 3, 3,  '008', 6,  '14',  '27', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1006, 1, 3, 3,  '011', 6,  '12',  '22', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1007, 1, 3, 3,  '012', 6,  '22',  '41', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1008, 1, 3, 3,  '013', 6,  '15',  '29', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1009, 1, 3, 3,  '015', 6,  '18',  '45', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1010, 1, 3, 3,  '018', 6,  '23',  '55', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1011, 1, 3, 3,  '021', 6,  '19',  '42', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1012, 1, 3, 3,  '022', 6,  '14',  '35', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1013, 1, 3, 3,  '024', 6,  '25',  '62', 1);
INSERT INTO student_subject_1577972762(id, session_id, term_id, class_id, admission_number, subject_id, test, exam, school_id) values (1014, 1, 3, 3,  '025', 6,  '16',  '30', 1);
TRUNCATE table student_temp_1577972762;
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (1, 1, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (2, 2, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (3, 3, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (4, 4, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (5, 5, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (6, 6, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (7, 7, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (8, 8, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (9, 9, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (10, 10, 3,  '85 days',  'Nil',  '',  '',  '108 days', '2 days');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (11, 11, 3,  '85 days',  'Nil',  '',  '',  '110 days', 'Nil');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (12, 12, 3,  '85 days',  'Nil',  '110 days',  '5 days',  '108 days', '2 days');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (13, 13, 3,  '85 days',  'Nil',  '',  '',  '108 days', '2 days');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (14, 64, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (15, 65, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (16, 66, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (17, 67, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (18, 68, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (19, 69, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (20, 70, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (21, 71, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (22, 72, 3,  '',  '',  '',  '',  '', '');
INSERT INTO student_temp_1577972762(id, student_id, class_id, first_term_times_present, first_term_times_absent, second_term_times_present, second_term_times_absent, third_term_times_present, third_term_times_absent) values (23, 73, 3,  '',  '',  '',  '',  '', '');
TRUNCATE table subject;
INSERT INTO subject(id, name, class_type_id, school_id) values (1,  'Mathematics',  '1', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (2,  'English Language',  '1', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (3,  'Mathematics',  '2', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (4,  'English Language',  '2', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (5,  'Mathematics',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (6,  'English Language',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (7,  'Mathematics',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (8,  'English Language',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (9,  'Business Studies',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (10,  'Agricultural Science',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (11,  'French',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (12,  'Computer Education',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (13,  'Home Economics',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (14,  'CRS/IRK',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (15,  'Physical and Health Education',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (16,  'Basic Technology',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (17,  'Basic Science',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (18,  'Civic Education',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (19,  'Creative Art',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (21,  'Hausa/Igbo/Yoruba',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (22,  'Social Studies',  '3', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (23,  'Information Tech',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (24,  'Government',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (25,  'French',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (26,  'Christian Religious Knowledge/Islamic Religious Knowledge',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (27,  'Further Mathematics',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (28,  'Biology',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (29,  'Literature In English',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (30,  'Health Science',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (31,  'Physics',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (32,  'Chemistry',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (33,  'History',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (34,  'Religious Studies',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (35,  'Geography',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (36,  'Hausa or a major Nigerian Language',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (37,  'Agricultural Science',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (38,  'Book-keeping and Accounting',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (39,  'Commerce',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (40,  'Home Management',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (41,  'Computer Education',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (42,  'Food and Nutrition',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (43,  'Hausa/Igbo/Yoruba',  '4', 1);
INSERT INTO subject(id, name, class_type_id, school_id) values (386,  'Arabic Language',  '3', 1);
TRUNCATE table term;
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (1,  'FIRST',  '2011-09-16',  '2011-12-09', 1,  '85 days', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (2,  'SECOND',  '2012-01-09',  '2012-03-03', 1,  '110 days', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (3,  'THIRD',  '2012-04-22',  '2012-07-12', 1,  '110 days', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (177,  'THIRD',  '2012-09-16',  '2013-12-01', 59,  '0', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (176,  'SECOND',  '2013-01-13',  '2013-01-13', 59,  '0', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (175,  'FIRST',  '2012-09-16',  '2012-12-13', 59,  '116 Days', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (178,  'FIRST',  '2013-11-07',  '2013-11-07', 60,  '0', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (179,  'SECOND',  '2013-11-07',  '2013-11-07', 60,  '0', 1);
INSERT INTO term(id, name, begin_date, end_date, session_id, times_school_open, school_id) values (180,  'THIRD',  '2013-11-07',  '2013-11-07', 60,  '0', 1);
TRUNCATE table user;
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (1,  'accounting',  'b31debbb5ee59cfd2948f299b4a8c3a1c2bfb847',  '',  '', 0);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (2,  'admin',  '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',  '',  '', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (3,  '011',  '282565635',  'Musa',  'Abdullahi', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (4,  '008',  '1982571466',  'Jibrin',  'Dauda', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (5,  '024',  '1935966614',  'Philemon',  'Elisha', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (6,  '021',  '1908699227',  'Stephen',  'Emmanuel', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (7,  '005',  '1581146210',  'Ali',  'Friday', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (8,  '022',  '1901426476',  'Usman',  'Jibrin', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (9,  '006',  '1420549966',  'Ejeh',  'Joseph', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (10,  '018',  '1205449578',  'Onyeke Andrew',  'Junior', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (11,  '012',  '1497723732',  'Mustapha',  'Kehinde', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (12,  '025',  '120641427',  'Uche',  'Obey', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (13,  '015',  '1678546278',  'Okafor',  'Prosper', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (14,  '003',  '1496037388',  'Abraham',  'Solomon', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (15,  '013',  '1901388032',  'Nabala',  'Vincent', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (16,  '023',  '627235222',  'Yusuf',  'Abdulazeez', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (17,  '001',  '881549729',  'Abdullahi A.',  'Abdullahi', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (18,  '007',  '284103366',  'Haruna',  'Allayi', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (19,  '016',  '310869255',  'Omagu',  'Augustine', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (20,  '019',  '1414549819',  'Peter',  'Emmanuel', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (21,  '017',  '1531022722',  'Omodunusi Azeez',  'Ganiyu', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (22,  '010',  '1864582178',  'Joshua',  'Issac', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (23,  '002',  '65252639',  'Abdullahi',  'Mohammed', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (24,  '009',  '892025365',  'John',  'Philemon', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (25,  '004',  '550430799',  'Adamu',  'Rabiu', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (26,  '020',  '277417654',  'Peter',  'Shedrack', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (27,  '014',  '92005537',  'Ofozie',  'ThankGod', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (101,  'FA/ADM/031',  '1076385380',  'Sabo Manasseh',  'Moses', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (100,  'FA/ADM/030',  '1775244207',  'Danladi Isah',  'Ileanwa', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (96,  'FA/ADM/026',  '1355138222',  'Achu Gabriel',  'Egbo', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (99,  'FA/ADM/029',  '106289295',  'Hassan',  'Abdulsalam', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (98,  'FA/ADM/028',  '103623952',  'Ibrahim A.',  'Gimba', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (97,  'FA/ADM/027',  '1261944147',  'Mishark',  'Awoje', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (102,  'FA/ADM/032',  '1146079927',  'Abubakar',  'Suleiman', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (103,  'FA/ADM/033',  '1854017530',  'Yunusa',  'Usman', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (104,  'FA/ADM/034',  '1359707405',  'Izuchukwu',  'Okoro', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (105,  'FA/ADM/035',  '1157154413',  'Ezeangwuna',  'Emeka', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (106,  '037',  '984876337',  'Adam Tunde',  'Adigum', 1);
INSERT INTO user(id, name, passwd, firstname, lastname, school_id) values (107,  '036',  '1811240369',  'Nzube',  'Okeke', 1);
TRUNCATE table user_permissions;
INSERT INTO user_permissions(id, uid, pid, school_id) values (1, 1, 1, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (2, 2, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (3, 3, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (4, 4, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (5, 5, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (6, 6, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (7, 7, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (8, 8, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (9, 9, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (10, 10, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (11, 11, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (12, 12, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (13, 13, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (14, 14, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (15, 15, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (16, 16, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (17, 17, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (18, 18, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (19, 19, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (20, 20, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (21, 21, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (22, 22, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (23, 23, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (24, 24, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (25, 25, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (26, 26, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (27, 27, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (28, 28, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (29, 29, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (30, 30, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (31, 31, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (32, 32, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (33, 33, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (34, 34, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (35, 35, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (36, 36, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (37, 37, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (38, 38, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (39, 39, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (40, 40, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (41, 41, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (42, 42, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (43, 43, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (44, 44, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (45, 45, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (46, 46, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (47, 47, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (48, 48, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (49, 49, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (50, 50, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (51, 51, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (52, 52, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (53, 53, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (54, 54, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (55, 55, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (56, 56, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (57, 57, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (58, 58, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (59, 59, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (60, 60, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (61, 61, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (62, 62, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (63, 63, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (64, 64, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (65, 65, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (66, 66, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (67, 67, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (68, 68, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (69, 69, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (70, 70, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (71, 71, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (72, 72, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (73, 73, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (74, 74, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (75, 75, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (76, 76, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (77, 77, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (78, 78, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (79, 79, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (80, 80, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (81, 81, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (82, 82, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (83, 83, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (84, 84, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (85, 85, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (86, 86, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (87, 87, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (88, 88, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (89, 89, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (90, 90, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (91, 91, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (92, 92, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (93, 93, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (94, 94, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (95, 95, 7, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (96, 96, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (97, 97, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (98, 98, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (99, 99, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (100, 100, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (101, 101, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (102, 102, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (103, 103, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (104, 104, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (105, 105, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (106, 106, 6, );
INSERT INTO user_permissions(id, uid, pid, school_id) values (107, 107, 6, );
