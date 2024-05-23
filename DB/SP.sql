--Stored Procedure to Add or Update Employee Details
CREATE OR REPLACE PROCEDURE public.add_employee(
	IN first_name character,
	IN last_name character,
	IN preferred_name character,
	IN role_name character,
	IN experience integer,
	IN country_name character,
	IN employee_id integer DEFAULT '-1'::integer)
LANGUAGE 'plpgsql'
AS $BODY$
DECLARE role_id INTEGER;
DECLARE country_id INTEGER;
BEGIN

	SELECT RO_ROLEID FROM ROLES WHERE LOWER(RO_NAME)=LOWER(role_name) INTO role_id;
	SELECT C_COUNTRYID FROM COUNTRY WHERE LOWER(C_NAME)=LOWER(country_name) INTO country_id;
	
	IF employee_id <> -1 THEN
		UPDATE public.employee
		SET e_firstname=first_name, e_lastname=last_name, e_preferredname=preferred_name, e_roleid=role_id, e_experience=experience, e_countryid=country_id
		WHERE e_employeeid=employee_id;
	
	ELSE
	
    	INSERT INTO EMPLOYEE (E_FIRSTNAME, E_LASTNAME, E_PREFERREDNAME, E_ROLEID, E_EXPERIENCE, E_COUNTRYID)
    	VALUES (first_name, last_name, preferred_name, role_id, experience, country_id);
	
    END IF;
END;
$BODY$;





-- Stored Procedure to Add or Update Country Details
CREATE OR REPLACE PROCEDURE public.upsert_country(
	IN country_name character,
	IN region_name character,
	IN country_comment character varying,
	IN country_id integer DEFAULT NULL::integer)
LANGUAGE 'plpgsql'
AS $BODY$
DECLARE region_id INTEGER;

BEGIN
	SELECT r_regionid FROM public.region where r_name=region_name INTO region_id;
	IF country_id <> -1 THEN
		UPDATE public.country
		SET c_name=country_name, c_regionid=region_id, c_comment=country_comment
		WHERE c_countryid=country_id;
	ELSE
		INSERT INTO public.country(c_name, c_regionid, c_comment)
		VALUES (country_name, region_id, country_comment);

	END IF;
END;
$BODY$;

--Stored Procedure to Add or Update Roles
CREATE OR REPLACE PROCEDURE public.upsert_roles(
	IN role_name character,
	IN department_name character,
	IN role_comments character varying,
	IN role_id integer)
LANGUAGE 'plpgsql'
AS $BODY$
BEGIN
	IF role_id <> -1 THEN
		UPDATE public.roles
		SET  ro_name=role_name, ro_department=department_name, ro_comment=role_comments
		WHERE  ro_roleid=role_id;
	
	ELSE
		INSERT INTO public.roles(ro_name, ro_department, ro_comment)
		VALUES (role_name, department_name, role_comments);
	END IF;
END;
$BODY$;

--Stored Procedure to Add or Update Traing Sessions
CREATE OR REPLACE PROCEDURE public.upsert_training_session(
	IN session_name character,
	IN trainer_id integer,
	IN min_experience integer,
	IN session_start date,
	IN session_end date,
	IN session_capacity integer,
	IN country_name character,
	IN session_id integer DEFAULT '-1'::integer)
LANGUAGE 'plpgsql'
AS $BODY$
DECLARE country_id INTEGER;
BEGIN
	SELECT C_COUNTRYID FROM COUNTRY WHERE LOWER(C_NAME)=LOWER(country_name) INTO country_id;
IF session_id <> -1 THEN
	UPDATE public.TRAININGSESSION
	SET TS_NAME = session_name, TS_TRAINER_ID = trainer_id, TS_MINEXP = min_experience, TS_START = session_start, TS_END = session_end, TS_CAPACITY =session_capacity,TS_COUNTRYID = country_id WHERE TS_SESSIONID = session_id;
ELSE
	INSERT INTO TRAININGSESSION (TS_NAME, TS_TRAINER_ID, TS_MINEXP, TS_START,TS_END, TS_CAPACITY, TS_COUNTRYID) VALUES (session_name, trainer_id, min_experience, session_start, session_end,session_capacity, country_id);
END IF;
END;
$BODY$;

--Stored Procedure to Map Employees to Training Sessions
CREATE OR REPLACE PROCEDURE public.upsert_employee_training(
	IN employee_id integer,
	IN session_name character,
	IN e_comments character varying)
LANGUAGE 'plpgsql'
AS $BODY$
DECLARE
    employee_country_id INTEGER;
    session_country_id INTEGER;
	session_id INTEGER;
BEGIN
    
	SELECT TS_SESSIONID FROM TRAININGSESSION WHERE LOWER(TS_NAME)= LOWER(session_name) INTO session_id;
    SELECT E_COUNTRYID FROM EMPLOYEE WHERE E_EMPLOYEEID = employee_id INTO employee_country_id;
    SELECT TS_COUNTRYID FROM TRAININGSESSION WHERE TS_SESSIONID = session_id INTO session_country_id;

    
    IF (employee_country_id = session_country_id) AND EXISTS (SELECT 1 FROM EmployeeTraining WHERE ET_EMPLOYEEID = employee_id AND ET_SESSIONID = session_id) THEN

        UPDATE EmployeeTraining
        SET ET_EMPLOYEEID = employee_id, ET_SESSIONID = session_id, ET_COMMENTS = e_comments
        WHERE ET_EMPLOYEEID = employee_id AND ET_SESSIONID=session_id;
		
		
    ELSE
        
        IF employee_country_id = session_country_id THEN    
            INSERT INTO EmployeeTraining (ET_EMPLOYEEID, ET_SESSIONID, ET_COMMENTS)
            VALUES (employee_id, session_id, e_comments);
        ELSE
            RAISE EXCEPTION 'Employee and training session are not in the same country.';
        END IF;
    END IF;
END;
$BODY$;