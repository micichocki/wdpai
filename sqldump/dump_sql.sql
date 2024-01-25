--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-25 13:54:45 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3409 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 225 (class 1255 OID 41105)
-- Name: set_date_of_join(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.set_date_of_join() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.date_of_join := NOW(); -- Ustawia date_of_join na aktualną datę i godzinę
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.set_date_of_join() OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 41068)
-- Name: participants; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.participants (
    participant_id integer NOT NULL,
    user_id integer NOT NULL,
    tutoring_id integer NOT NULL
);


ALTER TABLE public.participants OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 41067)
-- Name: participants_participant_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.participants_participant_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.participants_participant_id_seq OWNER TO docker;

--
-- TOC entry 3410 (class 0 OID 0)
-- Dependencies: 223
-- Name: participants_participant_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.participants_participant_id_seq OWNED BY public.participants.participant_id;


--
-- TOC entry 216 (class 1259 OID 32793)
-- Name: subjects; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.subjects (
    subject_id integer NOT NULL,
    name character varying(255)
);


ALTER TABLE public.subjects OWNER TO docker;

--
-- TOC entry 215 (class 1259 OID 32792)
-- Name: subjects_subject_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.subjects_subject_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.subjects_subject_id_seq OWNER TO docker;

--
-- TOC entry 3411 (class 0 OID 0)
-- Dependencies: 215
-- Name: subjects_subject_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.subjects_subject_id_seq OWNED BY public.subjects.subject_id;


--
-- TOC entry 222 (class 1259 OID 41054)
-- Name: tutoring; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.tutoring (
    tutoring_id integer NOT NULL,
    date timestamp(0) without time zone NOT NULL,
    price numeric(10,2) NOT NULL,
    creator_id integer NOT NULL,
    subject_id integer NOT NULL,
    description text,
    duration time without time zone
);


ALTER TABLE public.tutoring OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 41053)
-- Name: tutoring_tutoring_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.tutoring_tutoring_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tutoring_tutoring_id_seq OWNER TO docker;

--
-- TOC entry 3412 (class 0 OID 0)
-- Dependencies: 221
-- Name: tutoring_tutoring_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.tutoring_tutoring_id_seq OWNED BY public.tutoring.tutoring_id;


--
-- TOC entry 218 (class 1259 OID 32873)
-- Name: usercredentials; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.usercredentials (
    user_credentials_id integer NOT NULL,
    name character varying(255) NOT NULL,
    surname character varying(255) NOT NULL,
    address character varying(255),
    date_of_join timestamp with time zone DEFAULT CURRENT_TIMESTAMP,
    city character varying(255)
);


ALTER TABLE public.usercredentials OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 32872)
-- Name: usercredentials_user_credentials_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.usercredentials_user_credentials_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usercredentials_user_credentials_id_seq OWNER TO docker;

--
-- TOC entry 3413 (class 0 OID 0)
-- Dependencies: 217
-- Name: usercredentials_user_credentials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.usercredentials_user_credentials_id_seq OWNED BY public.usercredentials.user_credentials_id;


--
-- TOC entry 220 (class 1259 OID 32883)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    user_id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    user_credentials_id integer,
    privileged boolean DEFAULT false
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 32882)
-- Name: users_user_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.users_user_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_user_id_seq OWNER TO docker;

--
-- TOC entry 3414 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.users_user_id_seq OWNED BY public.users.user_id;


--
-- TOC entry 3230 (class 2604 OID 41071)
-- Name: participants participant_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.participants ALTER COLUMN participant_id SET DEFAULT nextval('public.participants_participant_id_seq'::regclass);


--
-- TOC entry 3224 (class 2604 OID 32796)
-- Name: subjects subject_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.subjects ALTER COLUMN subject_id SET DEFAULT nextval('public.subjects_subject_id_seq'::regclass);


--
-- TOC entry 3229 (class 2604 OID 41057)
-- Name: tutoring tutoring_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.tutoring ALTER COLUMN tutoring_id SET DEFAULT nextval('public.tutoring_tutoring_id_seq'::regclass);


--
-- TOC entry 3225 (class 2604 OID 32876)
-- Name: usercredentials user_credentials_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.usercredentials ALTER COLUMN user_credentials_id SET DEFAULT nextval('public.usercredentials_user_credentials_id_seq'::regclass);


--
-- TOC entry 3227 (class 2604 OID 32886)
-- Name: users user_id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users ALTER COLUMN user_id SET DEFAULT nextval('public.users_user_id_seq'::regclass);


--
-- TOC entry 3403 (class 0 OID 41068)
-- Dependencies: 224
-- Data for Name: participants; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (223, 48, 28);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (224, 48, 27);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (225, 48, 22);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (213, 45, 28);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (217, 47, 28);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (221, 47, 22);
INSERT INTO public.participants (participant_id, user_id, tutoring_id) VALUES (222, 47, 29);


--
-- TOC entry 3395 (class 0 OID 32793)
-- Dependencies: 216
-- Data for Name: subjects; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.subjects (subject_id, name) VALUES (1, 'Mathematics');
INSERT INTO public.subjects (subject_id, name) VALUES (2, 'Physics');
INSERT INTO public.subjects (subject_id, name) VALUES (3, 'Chemistry');
INSERT INTO public.subjects (subject_id, name) VALUES (5, 'English');
INSERT INTO public.subjects (subject_id, name) VALUES (4, 'History');
INSERT INTO public.subjects (subject_id, name) VALUES (6, 'Geography');
INSERT INTO public.subjects (subject_id, name) VALUES (7, 'Science');


--
-- TOC entry 3401 (class 0 OID 41054)
-- Dependencies: 222
-- Data for Name: tutoring; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (22, '2024-02-12 12:59:00', 60.00, 44, 1, 'I will teach you about the history of art', '01:35:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (25, '2024-02-15 15:00:00', 80.00, 44, 7, 'Wanna know something more about physics?', '01:00:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (27, '2024-02-12 19:00:00', 70.00, 41, 4, 'This is very nice tutoring', '01:00:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (28, '2024-02-10 13:55:00', 120.00, 41, 1, 'This is very nice tutoring', '02:00:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (30, '2024-02-28 11:00:00', 120.00, 47, 5, 'What a lovely day to learn something new', '02:00:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (31, '2024-02-06 12:30:00', 40.00, 48, 1, 'Hey, the best teacher here!', '00:45:00');
INSERT INTO public.tutoring (tutoring_id, date, price, creator_id, subject_id, description, duration) VALUES (29, '2024-05-05 12:12:00', 25.00, 45, 3, 'I will teach you something difficult in easy way', '02:30:00');


--
-- TOC entry 3397 (class 0 OID 32873)
-- Dependencies: 218
-- Data for Name: usercredentials; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (74, 'Tadeusz', 'Kościuszko', NULL, '2024-01-25 12:44:59.586904+00', '');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (71, 'Jan', 'Kowalski', NULL, '2024-01-25 12:43:05.34498+00', 'London');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (75, 'Kevin', 'Alonehome', NULL, '2024-01-25 13:16:32.038658+00', '');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (76, 'Szymon', 'Buzek', NULL, '2024-01-25 13:18:42.358103+00', 'Helsinki');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (78, 'Admin', 'Adminowski', NULL, '2024-01-25 13:36:33.522357+00', 'Toronto');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (69, 'Michał', 'Besser', NULL, '2024-01-25 12:27:22.486891+00', 'Stalowa Wola');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (77, 'Michał', 'Grabski', NULL, '2024-01-25 13:19:14.155194+00', 'Stalowa Wola');
INSERT INTO public.usercredentials (user_credentials_id, name, surname, address, date_of_join, city) VALUES (73, 'Will ', 'Smith', NULL, '2024-01-25 12:44:09.686608+00', 'Warsaw');


--
-- TOC entry 3399 (class 0 OID 32883)
-- Dependencies: 220
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (43, 'a@gmail.com', '$2y$10$A3L9EeIfJyIdL1D8oONkq.QNV5OdhGWUNO5MMqb6XWVWUaZYbEHCy', 73, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (48, 'admin@example.com', '$2y$10$la8avdZXNMGzeL2cG/q4n.arHlFG1.xpsVlj68KpnOt2kGcAXtkS.', 78, false);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (45, 'admin@example.org', '$2y$10$LyOCvYeCNbkoL09AvAqtWu0trQa49YVd45FGi.p8fulbAhpyVjdIK', 75, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (41, 'malpa@gmail.com', '$2y$10$koQ7HZ5I1dTW/RSzqbO4wOuJIo8vrk3NBrfScs3qnVxZ4mTepw3KW', 71, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (44, 'a00@gmail.com', '$2y$10$eTWVj.940oeR.S2CG72xHOraU3sE0gZFHe4LAMXy6wfY50VPwWiKi', 74, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (46, 'kolega@gmail.com', '$2y$10$P5n7AHxoqwnxKbE8fki2qOD8YYnyByGwxFczKyDmy.pPoyCAm0VUC', 76, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (39, 'mici7@gmail.com', '$2y$10$IA0xihAMFzsxrEraBFu.T.IKZfspsdO6qP/RMBhbI4OHJ19MSObNu', 69, true);
INSERT INTO public.users (user_id, email, password, user_credentials_id, privileged) VALUES (47, 'mici8@gmail.com', '$2y$10$iBdmeG.Gg.qZePFuHqdEB.tiR3R2VxANlkFVaOTU6/zzaZnuqgHjS', 77, true);


--
-- TOC entry 3415 (class 0 OID 0)
-- Dependencies: 223
-- Name: participants_participant_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.participants_participant_id_seq', 225, true);


--
-- TOC entry 3416 (class 0 OID 0)
-- Dependencies: 215
-- Name: subjects_subject_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.subjects_subject_id_seq', 6, true);


--
-- TOC entry 3417 (class 0 OID 0)
-- Dependencies: 221
-- Name: tutoring_tutoring_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.tutoring_tutoring_id_seq', 31, true);


--
-- TOC entry 3418 (class 0 OID 0)
-- Dependencies: 217
-- Name: usercredentials_user_credentials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.usercredentials_user_credentials_id_seq', 78, true);


--
-- TOC entry 3419 (class 0 OID 0)
-- Dependencies: 219
-- Name: users_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.users_user_id_seq', 48, true);


--
-- TOC entry 3242 (class 2606 OID 41073)
-- Name: participants participants_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.participants
    ADD CONSTRAINT participants_pkey PRIMARY KEY (participant_id);


--
-- TOC entry 3244 (class 2606 OID 41075)
-- Name: participants participants_user_id_tutoring_id_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.participants
    ADD CONSTRAINT participants_user_id_tutoring_id_key UNIQUE (user_id, tutoring_id);


--
-- TOC entry 3232 (class 2606 OID 32798)
-- Name: subjects subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (subject_id);


--
-- TOC entry 3240 (class 2606 OID 41061)
-- Name: tutoring tutoring_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.tutoring
    ADD CONSTRAINT tutoring_pkey PRIMARY KEY (tutoring_id);


--
-- TOC entry 3234 (class 2606 OID 32881)
-- Name: usercredentials usercredentials_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.usercredentials
    ADD CONSTRAINT usercredentials_pkey PRIMARY KEY (user_credentials_id);


--
-- TOC entry 3236 (class 2606 OID 32890)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (user_id);


--
-- TOC entry 3238 (class 2606 OID 32892)
-- Name: users users_user_credentials_id_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_user_credentials_id_key UNIQUE (user_credentials_id);


--
-- TOC entry 3250 (class 2620 OID 41106)
-- Name: usercredentials trigger_set_date_of_join; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER trigger_set_date_of_join BEFORE INSERT ON public.usercredentials FOR EACH ROW EXECUTE FUNCTION public.set_date_of_join();


--
-- TOC entry 3245 (class 2606 OID 41100)
-- Name: users fk_usercredentials; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT fk_usercredentials FOREIGN KEY (user_credentials_id) REFERENCES public.usercredentials(user_credentials_id) ON DELETE CASCADE;


--
-- TOC entry 3248 (class 2606 OID 41107)
-- Name: participants participants_tutoring_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.participants
    ADD CONSTRAINT participants_tutoring_id_fkey FOREIGN KEY (tutoring_id) REFERENCES public.tutoring(tutoring_id) ON DELETE CASCADE;


--
-- TOC entry 3249 (class 2606 OID 41076)
-- Name: participants participants_user_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.participants
    ADD CONSTRAINT participants_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(user_id);


--
-- TOC entry 3247 (class 2606 OID 41062)
-- Name: tutoring tutoring_subject_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.tutoring
    ADD CONSTRAINT tutoring_subject_id_fkey FOREIGN KEY (subject_id) REFERENCES public.subjects(subject_id);


--
-- TOC entry 3246 (class 2606 OID 32893)
-- Name: users users_user_credentials_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_user_credentials_id_fkey FOREIGN KEY (user_credentials_id) REFERENCES public.usercredentials(user_credentials_id);


-- Completed on 2024-01-25 13:54:45 UTC

--
-- PostgreSQL database dump complete
--

