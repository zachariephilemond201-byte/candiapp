--
-- PostgreSQL database dump
--

\restrict otHN2Jmq6aYqmQMXDBJOCPsGVDS7A5sPQa6cRknOsvUBmOirHo102Sbx3xFPoc4

-- Dumped from database version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.4 (Ubuntu 18.4-0ubuntu0.26.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: entreprise; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.entreprise (
    id_entreprise integer NOT NULL,
    nom_entreprise character varying(50) NOT NULL,
    adresse text,
    date_envoi date NOT NULL,
    statut_canditature character varying(50) NOT NULL,
    commentaire_candidature text,
    utilisateur_id integer NOT NULL,
    lettre_entreprise_pdf text
);


--
-- Name: entreprise_id_entreprise_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.entreprise ALTER COLUMN id_entreprise ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.entreprise_id_entreprise_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: utilisateur; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.utilisateur (
    id_utilisateur integer NOT NULL,
    nom_utilisateur character varying(100) NOT NULL,
    motdepasse text NOT NULL
);


--
-- Name: utilisateur_id_utilisateur_seq; Type: SEQUENCE; Schema: public; Owner: -
--

ALTER TABLE public.utilisateur ALTER COLUMN id_utilisateur ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.utilisateur_id_utilisateur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Data for Name: entreprise; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.entreprise (id_entreprise, nom_entreprise, adresse, date_envoi, statut_canditature, commentaire_candidature, utilisateur_id, lettre_entreprise_pdf) FROM stdin;
\.


--
-- Data for Name: utilisateur; Type: TABLE DATA; Schema: public; Owner: -
--

COPY public.utilisateur (id_utilisateur, nom_utilisateur, motdepasse) FROM stdin;
1	toto	toto
\.


--
-- Name: entreprise_id_entreprise_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.entreprise_id_entreprise_seq', 1, false);


--
-- Name: utilisateur_id_utilisateur_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.utilisateur_id_utilisateur_seq', 1, true);


--
-- Name: entreprise entreprise_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.entreprise
    ADD CONSTRAINT entreprise_pkey PRIMARY KEY (id_entreprise);


--
-- Name: utilisateur utilisateur_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.utilisateur
    ADD CONSTRAINT utilisateur_pkey PRIMARY KEY (id_utilisateur);


--
-- Name: entreprise fk_utilisateur; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.entreprise
    ADD CONSTRAINT fk_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES public.utilisateur(id_utilisateur) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict otHN2Jmq6aYqmQMXDBJOCPsGVDS7A5sPQa6cRknOsvUBmOirHo102Sbx3xFPoc4

