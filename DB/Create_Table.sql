
CREATE TABLE IF NOT EXISTS public.region
(
    r_regionid integer NOT NULL DEFAULT nextval('region_r_regionid_seq'::regclass),
    r_name character(25) COLLATE pg_catalog."default" NOT NULL,
    r_comment character varying(125) COLLATE pg_catalog."default",
    CONSTRAINT region_pkey PRIMARY KEY (r_regionid)
)

CREATE TABLE IF NOT EXISTS public.country
(
    c_countryid integer NOT NULL DEFAULT nextval('country_c_countryid_seq'::regclass),
    c_name character(30) COLLATE pg_catalog."default" NOT NULL,
    c_regionid integer NOT NULL,
    c_comment character varying(125) COLLATE pg_catalog."default",
    CONSTRAINT country_pkey PRIMARY KEY (c_countryid),
    CONSTRAINT country_c_regionid_fkey FOREIGN KEY (c_regionid)
        REFERENCES public.region (r_regionid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION


)

CREATE TABLE IF NOT EXISTS public.employee
(
    e_employeeid integer NOT NULL DEFAULT nextval('employee_e_employeeid_seq'::regclass),
    e_firstname character(30) COLLATE pg_catalog."default" NOT NULL,
    e_lastname character(30) COLLATE pg_catalog."default" NOT NULL,
    e_preferredname character(30) COLLATE pg_catalog."default" NOT NULL,
    e_roleid integer NOT NULL,
    e_experience integer NOT NULL,
    e_countryid integer NOT NULL,
    CONSTRAINT employee_pkey PRIMARY KEY (e_employeeid),
    CONSTRAINT employee_e_countryid_fkey FOREIGN KEY (e_countryid)
        REFERENCES public.country (c_countryid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT employee_e_roleid_fkey FOREIGN KEY (e_roleid)
        REFERENCES public.roles (ro_roleid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

CREATE TABLE IF NOT EXISTS public.trainingsession
(
    ts_sessionid integer NOT NULL DEFAULT nextval('trainingsession_ts_sessionid_seq'::regclass),
    ts_name character(250) COLLATE pg_catalog."default" NOT NULL,
    ts_trainer_id integer NOT NULL,
    ts_minexp integer NOT NULL DEFAULT 0,
    ts_start date,
    ts_end date,
    ts_capacity integer DEFAULT 0,
    ts_countryid integer NOT NULL,
    CONSTRAINT trainingsession_pkey PRIMARY KEY (ts_sessionid),
    CONSTRAINT trainingsession_ts_countryid_fkey FOREIGN KEY (ts_countryid)
        REFERENCES public.country (c_countryid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT trainingsession_ts_trainer_id_fkey FOREIGN KEY (ts_trainer_id)
        REFERENCES public.employee (e_employeeid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)


CREATE TABLE IF NOT EXISTS public.employeetraining
(
    et_id integer NOT NULL DEFAULT nextval('employeetraining_et_id_seq'::regclass),
    et_employeeid integer NOT NULL,
    et_sessionid integer NOT NULL,
    et_comments character varying(125) COLLATE pg_catalog."default",
    CONSTRAINT employeetraining_pkey PRIMARY KEY (et_id),
    CONSTRAINT employeetraining_et_employeeid_fkey FOREIGN KEY (et_employeeid)
        REFERENCES public.employee (e_employeeid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION,
    CONSTRAINT employeetraining_et_sessionid_fkey FOREIGN KEY (et_sessionid)
        REFERENCES public.trainingsession (ts_sessionid) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)


CREATE TABLE IF NOT EXISTS public.region
(
    r_regionid integer NOT NULL DEFAULT nextval('region_r_regionid_seq'::regclass),
    r_name character(25) COLLATE pg_catalog."default" NOT NULL,
    r_comment character varying(125) COLLATE pg_catalog."default",
    CONSTRAINT region_pkey PRIMARY KEY (r_regionid)
)


