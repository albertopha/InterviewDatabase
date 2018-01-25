drop table jobSeeker cascade constraints;
drop table job cascade constraints;
drop table search cascade constraints;
drop table resume cascade constraints;
drop table coverLetter cascade constraints;
drop table criminalRecord cascade constraints;
drop table application cascade constraints;
drop table inR cascade constraints;
drop table HRemployee cascade constraints;
drop table interview cascade constraints;

create table jobSeeker
	(seeker_email char(50) not null,
	phone char(12) null,
	bday char(20) null,
	seeker_name char(12) null,
	country char(40) null,
	address char(20) null,
	seeker_id char(7) null,
	primary key (seeker_email));
 
grant select on jobSeeker to public;
 
create table HRemployee
	(employee_id char(8) not null,
	employee_email char(25)  null,
	employee_name char(20) null,
	primary key (employee_id));
 
grant select on HRemployee to public;
 
create table job
	(job_id char(6) not null,
	dueDate char (20) null,
	initDate char(20) null,
	salary int        null,
	location char(20) null,
    requirements char(50)  null,
    employee_id char(8) not null,
	primary key (job_id),
    foreign key (employee_id) references HRemployee
    ON DELETE CASCADE);
 
grant select on job to public;
 
create table search
	(seeker_email char(50) not null,
	job_id char(6)  not null,
	primary key (seeker_email, job_id),
    foreign key (seeker_email) references jobSeeker
    ON DELETE CASCADE,
    foreign key (job_id) references job
    ON DELETE CASCADE);
grant select on search to public;


create table resume
	(re_title char(50),
    re_date char(20),
    re_email char(25),
    re_award char(50),
    primary key (re_title),
    foreign key (re_email) references jobSeeker
    ON DELETE CASCADE);

grant select on resume to public;
 
create table coverLetter
	(cl_title char(50),
    cl_date char(20),
    cl_email char(25),
    cl_contactNumber char(12),
    primary key (cl_title),
    foreign key (cl_email) references jobSeeker
    ON DELETE CASCADE);

grant select on coverLetter to public;

create table criminalRecord
	(cr_title char(50),
    cr_date char(20),
    cr_email char(25),
    cr_fee int,
    primary key (cr_title),
    foreign key (cr_email) references jobSeeker
    ON DELETE CASCADE);

grant select on criminalRecord to public;


create table Application
	(app_id char(8) not null,
	app_date char(20) null,
	app_reviewed char(20) null,
	employee_id char(8) null,
	seeker_email char(50) null,
	job_id char(6) null,
	primary key (app_id),
	foreign key (employee_id) references HRemployee 
    ON DELETE CASCADE,
    foreign key (seeker_email) references jobSeeker
    ON DELETE CASCADE,
    foreign key (job_id) references job
    ON DELETE CASCADE);
 
grant select on application to public;
 
create table docInApp
	(seeker_email char(25) not null,
	app_id char(4) not null,
	app_date char(20) null,
	app_reviewed char(20) null,
	doc_title char(50) not null,
	doc_date char(20) null,
	primary key (seeker_email, doc_title, app_id),
    foreign key (app_id, app_date, app_reviewed) references application (app_id, app_date, app_reviewed)
	ON DELETE CASCADE,
    foreign key (seeker_email) references jobSeeker
    ON DELETE CASCADE);
 
grant select on docInApp to public;
 
create table interview
	(intID char(4) not null,
	int_time char(5)  null,
	int_type char(20) null,
	int_location char(40) null,
	int_length char(4) null,
    int_date char(25) null,
    app_id char(8)  not null,
	primary key (intID),
	foreign key (app_id) references application 
    ON DELETE CASCADE);

grant select on interview to public;

insert into jobSeeker values('albertoh@hotmail.com', '415 658 9932', '1993 July 7th',
'Albert Oh', 'Korea', 'Seoul', '5160908');
 
insert into jobSeeker
values ('godotbianyuan@hotmail.com', '415 986 7020', '1994 July 15th',
'Godot Yuan', 'China', 'Beijing', '5452834');
 
insert into jobSeeker
values('derek@ugrad.cs.ubc.ca', '415 548 7723', '1995 Aug 2nd',
'Derek Lio', 'Canada', 'Vancouver', '1234056');
 
insert into jobSeeker
values('williamzeng@ugrad.cs.ubc.ca', '801 826 0752', '1998 Sept 3rd',
'William Zeng', 'Canada', 'Richmond', '9014385');
 
insert into jobSeeker
values('jane.smith@ugrad.cs.ubc.ca', '506 825 0752', '1995 July 28th',
'Jane Smith', 'America', 'Oklahoma', '0394120');

insert into HRemployee
values('50342120', 'jessica@ugrad.cs.ubc.ca', 'Jessica');

insert into HRemployee
values('52131050', 'damien@gmail.com', 'Damien');

insert into HRemployee
values('54521096', 'jason@hotmail.com', 'Jason');

insert into HRemployee
values('58230940', 'mike@ugrad.cs.ubc.ca', 'Mike');

insert into HRemployee
values('51023047', 'sam@hotmail.com', 'Sam');

insert into job
values('918090', '2016 Aug 9th', '2015 Sep 10th', 1000000,
 'Seoul', 'Resume', '50342120');
 
insert into job
values('900102', '2017 Oct 10th', '2012 July 5th', 50000,
 'Beijing', 'Resume', '52131050');
 
insert into job
values('901264', '2011 Feb 2nd', '2010 Dec 12th', 65000,
 'Vancover', 'CoverLetter', '54521096');
 
insert into job
values('956423', '2012 Nov 15th', '2009 May 20th', 95000,
 'Richmond', 'CoverLetter', '58230940');
 
insert into job
values('913241', '2018 Mar 9th', '2015 Jun 4th', 55000,
 'Oklahoma', 'CriminalRecord', '51023047');

 insert into application
values('8108', '2015 Sep 1st', '1', '50342120',
 'albertoh@hotmail.com', '918090');

insert into application
values('8209', '2011 Dec 25th' ,'1', '52131050',
 'godotbianyuan@hotmail.com', '900102');

insert into application
values('8811', '2010 Nov 22nd', '2', '54521096',
 'derek@ugrad.cs.ubc.ca', '901264');

insert into application
values('8712', '2008 Dec 28th', '2', '58230940',
 'williamzeng@ugrad.cs.ubc.ca', '956423');

insert into application
values('8651', '2015 Apr 12th', '2', '51023047',
 'jane.smith@ugrad.cs.ubc.ca', '913241');

insert into interview
values('4351', '14:00', 'inperson', 'Seoul', '30', '2015 Oct 11th', '8108');

insert into interview
values('4561', '13:30', 'phone', 'Beijing', '45', '2012 Jun 5th', '8209');

insert into interview
values('4012', '14:50', 'phone', 'Vancover', '45', '2010 Nov 25th', '8811');

insert into interview
values('3105', '15:30', 'inperson', 'Richmond', '60', '2009 Jan 6th', '8712');

insert into interview
values('3256', '15:30', 'phone', 'Oklahoma', '25', '2015 May 12th', '8651');




insert into search
values('albertoh@hotmail.com', '918090');

insert into search
values('godotbianyuan@hotmail.com', '900102');

insert into search
values('derek@ugrad.cs.ubc.ca', '901264');

insert into search
values('williamzeng@ugrad.cs.ubc.ca', '956423');

insert into search
values('jane.smith@ugrad.cs.ubc.ca', '913241');


insert into resume
values('10+ combined yrs of HR, Executive Assistant, 
Marketing, Meeting Management; seeking flexibility',
 '2013 Apr 10th', 'albertoh@hotmail.com', 'Award for Management');

insert into resume
values('Licensed Mental Health Social Worker (LCSW), 
Treating mental and emotional disorders', '2010 Nov 15th',
'godotbianyuan@hotmail.com', 'Award for LCSW');

insert into resume
values('Customer Service Representative/Supervisor, 
specialty in installation and technical support', 
'2009 Mar 3rd','derek@ugrad.cs.ubc.ca', 'Award for Customer Service');

insert into resume
values('Apparel Merchandising Professional seeking 
positions in a virtual working environment', 
'2008 Aug 27th','williamzeng@ugrad.cs.ubc.ca', 'Award for working environment');

insert into resume
values('Writer, editor, and PR specialist with six years’ 
communications experience—Telecommuting', 
'2014 Jun 24th','jane.smith@ugrad.cs.ubc.ca', 'Award for best Journalist');


insert into coverLetter
values('10+ combined yrs of HR, Executive Assistant, 
Marketing, Meeting Management; seeking flexibility',
 '2013 Apr 10th', 'albertoh@hotmail.com', '415 658 9932');

insert into coverLetter
values('Licensed Mental Health Social Worker (LCSW), 
Treating mental and emotional disorders', '2010 Nov 15th',
'godotbianyuan@hotmail.com', '415 986 7020');

insert into coverLetter
values('Customer Service Representative/Supervisor, 
specialty in installation and technical support', 
'2009 Mar 3rd','derek@ugrad.cs.ubc.ca', '415 548 7723');

insert into coverLetter
values('Apparel Merchandising Professional seeking 
positions in a virtual working environment', 
'2008 Aug 27th','williamzeng@ugrad.cs.ubc.ca', '801 826 0752');

insert into coverLetter
values('Writer, editor, and PR specialist with six years’ 
communications experience—Telecommuting', 
'2014 Jun 24th','jane.smith@ugrad.cs.ubc.ca', '506 825 0752');


insert into criminalRecord
values('CONSENT TO A CRIMINAL RECORD CHECK FOR BUSINESS',
 '2013 Mar 10th', 'albertoh@hotmail.com', 30);

insert into criminalRecord
values('CONSENT TO A CRIMINAL RECORD CHECK FOR WORKING WITH VULNERABLE ADULTS',
 '2010 Nov 20th', 'godotbianyuan@hotmail.com', 30);

insert into criminalRecord
values('CONSENT TO A CRIMINAL RECORD CHECK FOR CUSTOMER SERVICE', 
'2009 Mar 4th','derek@ugrad.cs.ubc.ca', 50);

insert into criminalRecord
values('CONSENT TO A CRIMINAL RECORD CHECK FOR WORKING ENVIRONMENT', 
'2008 Aug 27th','williamzeng@ugrad.cs.ubc.ca', 25);

insert into criminalRecord
values('CONSENT TO A CRIMINAL RECORD CHECK FOR COMPANY', 
'2014 Jun 24th','jane.smith@ugrad.cs.ubc.ca', 15);
