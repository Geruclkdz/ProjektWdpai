--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1 (Debian 16.1-1.pgdg120+1)

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
-- Name: insert_into_users_details(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.insert_into_users_details() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_users_details_id INTEGER;
BEGIN
    INSERT INTO users_details (name, surname, age, profile_picture, description)
    VALUES (NULL, NULL, NULL, NULL, NULL)
    RETURNING id INTO new_users_details_id;

    -- Check if the foreign key is not NULL before updating
    IF NEW.id_user_details IS NULL THEN
        UPDATE users SET id_user_details = new_users_details_id WHERE id = NEW.id;
    END IF;

    RETURN NEW;
END;
$$;


ALTER FUNCTION public.insert_into_users_details() OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name character varying(100) NOT NULL
);


ALTER TABLE public.categories OWNER TO docker;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO docker;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: categories_id_seq1; Type: SEQUENCE; Schema: public; Owner: docker
--

ALTER TABLE public.categories ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.categories_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: reports; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.reports (
    id integer NOT NULL,
    id_users integer NOT NULL,
    title character varying NOT NULL,
    type character varying NOT NULL,
    description character varying NOT NULL
);


ALTER TABLE public.reports OWNER TO docker;

--
-- Name: reports_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.reports_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reports_id_seq OWNER TO docker;

--
-- Name: reports_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.reports_id_seq OWNED BY public.reports.id;


--
-- Name: users_details; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users_details (
    id integer NOT NULL,
    name character varying(100),
    surname character varying(100),
    age integer,
    profile_picture character varying,
    description character varying
);


ALTER TABLE public.users_details OWNER TO docker;

--
-- Name: user_details_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.user_details_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.user_details_id_seq OWNER TO docker;

--
-- Name: user_details_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.user_details_id_seq OWNED BY public.users_details.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    password character varying(100) NOT NULL,
    id_user_details integer,
    role character varying
);


ALTER TABLE public.users OWNER TO docker;

--
-- Name: users_categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users_categories (
    id_users integer NOT NULL,
    id_categories integer
);


ALTER TABLE public.users_categories OWNER TO docker;

--
-- Name: users_details_view; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.users_details_view AS
 SELECT u.id AS user_id,
    u.username,
    u.email,
    u.role,
    ud.id AS details_id,
    ud.name,
    ud.surname,
    ud.age,
    ud.profile_picture,
    ud.description
   FROM (public.users u
     JOIN public.users_details ud ON ((u.id_user_details = ud.id)));


ALTER VIEW public.users_details_view OWNER TO docker;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: videos; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.videos (
    id integer NOT NULL,
    id_user integer NOT NULL,
    title character varying(100) NOT NULL,
    video character varying(100) NOT NULL
);


ALTER TABLE public.videos OWNER TO docker;

--
-- Name: videos_categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.videos_categories (
    id_videos integer NOT NULL,
    id_categories integer NOT NULL
);


ALTER TABLE public.videos_categories OWNER TO docker;

--
-- Name: video_categories_view; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.video_categories_view AS
 SELECT v.id AS video_id,
    v.id_user AS user_id,
    v.title AS video_title,
    v.video AS video_path,
    c.id AS category_id,
    c.name AS category_name
   FROM ((public.videos v
     JOIN public.videos_categories vc ON ((v.id = vc.id_videos)))
     JOIN public.categories c ON ((vc.id_categories = c.id)));


ALTER VIEW public.video_categories_view OWNER TO docker;

--
-- Name: videos_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

ALTER TABLE public.videos ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.videos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: reports id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reports ALTER COLUMN id SET DEFAULT nextval('public.reports_id_seq'::regclass);


--
-- Name: users_details id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users_details ALTER COLUMN id SET DEFAULT nextval('public.user_details_id_seq'::regclass);


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.categories (id, name) FROM stdin;
28	Footwork
30	Toprock
33	Drop
34	Spin
35	Spin
36	1
37	2
38	3
\.


--
-- Data for Name: reports; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.reports (id, id_users, title, type, description) FROM stdin;
1	6	competitions	Suggest Functionality	Add functionality designed for competitions.
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users (id, username, email, password, id_user_details, role) FROM stdin;
6	Gerard_Grzyb	ggerard.krk@gmail.com	$2y$10$1qFmK4IQzEjaqihx5Nm7re14ch8PlNOxL6Qp6Bi8ccxBue/e5IAUm	3	admin
10	John_Snow	jsnow@pk.edu.pl	$2y$10$bE9saQuESJiNMVyS9PaBluFnlcJBdG8E6yoSEbSHEIL0VKg.7pkt.	8	user
11	LastTest	LastTest@test.test	$2y$10$bO.FGj55Gl98KVAoxEZEnurU.R9wzLyqC0r9oWdmfXBYToLLO/aem	9	user
17	LASTLASTTEST	LAAAAST@Test.test	$2y$10$Q0eFmXIivmpZlT.WUaa9eOU7aVZ67neo4YfpwNtKXV6LlkgUP.30m	13	user
\.


--
-- Data for Name: users_categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users_categories (id_users, id_categories) FROM stdin;
6	28
6	30
6	33
6	34
6	35
11	36
11	37
11	38
\.


--
-- Data for Name: users_details; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users_details (id, name, surname, age, profile_picture, description) FROM stdin;
3	Gerard	Grzyb	0	/public/uploads/profile_pictures/IMG_5225.JPG	I'm happy!
8	John	Snow	22	/public/uploads/profile_pictures/IMG_5754 (1).JPG	SNOOOOOW!
9	Test	Testowy	22	/public/uploads/profile_pictures/IMG_5212.JPG	TESTING
13	\N	\N	\N	\N	\N
\.


--
-- Data for Name: videos; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.videos (id, id_user, title, video) FROM stdin;
4	6	headspin	/public/uploads/videos/HEAD_SPIN_NEW_WORLD_RECORD.mp4
1	6	test1	/public/uploads/videos/CHRE6902.MOV
5	6	airflare	/public/uploads/videos/video1.mp4
6	6	shoulder spin	/public/uploads/videos/CKSR0934 (1).MOV
7	11	1	/public/uploads/videos/DIPQ6882.MOV
8	11	2	/public/uploads/videos/EKMVE4359.MOV
\.


--
-- Data for Name: videos_categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.videos_categories (id_videos, id_categories) FROM stdin;
4	28
4	30
1	28
4	28
4	34
6	34
1	30
7	36
7	36
7	37
8	37
\.


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.categories_id_seq', 1, false);


--
-- Name: categories_id_seq1; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.categories_id_seq1', 38, true);


--
-- Name: reports_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.reports_id_seq', 1, true);


--
-- Name: user_details_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.user_details_id_seq', 13, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.users_id_seq', 17, true);


--
-- Name: videos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.videos_id_seq', 8, true);


--
-- Name: categories categories_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pk PRIMARY KEY (id);


--
-- Name: reports reports_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reports
    ADD CONSTRAINT reports_pk PRIMARY KEY (id);


--
-- Name: users_details user_details_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users_details
    ADD CONSTRAINT user_details_pk PRIMARY KEY (id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: videos videos_pk; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.videos
    ADD CONSTRAINT videos_pk PRIMARY KEY (id);


--
-- Name: categories_id_index; Type: INDEX; Schema: public; Owner: docker
--

CREATE INDEX categories_id_index ON public.categories USING btree (id);


--
-- Name: user_details_id_index; Type: INDEX; Schema: public; Owner: docker
--

CREATE INDEX user_details_id_index ON public.users_details USING btree (id);


--
-- Name: videos_id_index; Type: INDEX; Schema: public; Owner: docker
--

CREATE INDEX videos_id_index ON public.videos USING btree (id);


--
-- Name: users after_insert_users; Type: TRIGGER; Schema: public; Owner: docker
--

CREATE TRIGGER after_insert_users AFTER INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.insert_into_users_details();


--
-- Name: users_categories category_users_categories___fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users_categories
    ADD CONSTRAINT category_users_categories___fk FOREIGN KEY (id_categories) REFERENCES public.categories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: videos_categories category_videos_categories___fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.videos_categories
    ADD CONSTRAINT category_videos_categories___fk FOREIGN KEY (id_categories) REFERENCES public.categories(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: reports reports_users_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reports
    ADD CONSTRAINT reports_users_id_fk FOREIGN KEY (id_users) REFERENCES public.users(id);


--
-- Name: users_categories user_users_categories___fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users_categories
    ADD CONSTRAINT user_users_categories___fk FOREIGN KEY (id_users) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: users users_users_details_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_users_details_id_fk FOREIGN KEY (id_user_details) REFERENCES public.users_details(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: videos_categories video_videos_categories___fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.videos_categories
    ADD CONSTRAINT video_videos_categories___fk FOREIGN KEY (id_videos) REFERENCES public.videos(id);


--
-- Name: videos videos_users_id_fk; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.videos
    ADD CONSTRAINT videos_users_id_fk FOREIGN KEY (id_user) REFERENCES public.users(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

