--
-- PostgreSQL database 
--


CREATE TABLE public.archive (
    id_archive bigint NOT NULL,
    type character varying(255),
    nom_client character varying(255),
    dates date,
    id_reservation bigint,
    id_location bigint
);

--
-- Name: chaines_hotelières; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public."chaines_hotelières" (
    id_chaine bigint NOT NULL,
    nom_chaine character varying(255),
    adresse_siege_social character varying(255),
    num_hotels integer,
    email character varying(255),
    telephone character varying(20)
);


--
-- Name: chambre; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.chambre (
    num_chambre integer NOT NULL,
    id_hotel bigint NOT NULL,
    id_chaine bigint NOT NULL,
    prix double precision,
    commodites text,
    capacite integer,
    vue character varying(255),
    ajoute_lit boolean,
    etat text
);


--
-- Name: client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.client (
    id_client bigint NOT NULL,
    nom_complet character varying(255),
    adresse character varying(255),
    nas_client character varying(20),
    date_inscription timestamp without time zone,
    email character varying(255),
    telephone character varying(20)
);


--
-- Name: employe; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.employe (
    id_employe bigint NOT NULL,
    nom_complet character varying(255),
    adresse character varying(255),
    nas_employe character varying(20),
    role character varying(255),
    id_hotel bigint
);

--
-- Name: hotel; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.hotel (
    id_hotel bigint NOT NULL,
    id_chaine bigint,
    adresse character varying(255),
    no_chambre integer,
    email character varying(255),
    telephone character varying(20),
    id_gestionnaire bigint,
    categorie integer
);


--
-- Name: location; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.location (
    id_location bigint NOT NULL,
    date_check_in date,
    date_check_out date,
    status character varying(255),
    num_chambre integer,
    id_reservation bigint,
    id_employe bigint,
    id_client bigint,
    id_hotel bigint,
    id_chaine bigint
);

--
-- Name: reservation; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservation (
    id_reservation bigint NOT NULL,
    date_debut date,
    date_fin date,
    status character varying(255),
    num_chambre integer,
    id_client bigint,
    id_hotel bigint,
    id_chaine bigint
);


--
-- Data for Name: archive; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.archive (id_archive, type, nom_client, dates, id_reservation, id_location) FROM stdin;
\.


--
-- Data for Name: chaines_hotelières; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public."chaines_hotelières" (id_chaine, nom_chaine, adresse_siege_social, num_hotels, email, telephone) FROM stdin;
1	Hilton	123 rue Principale, Montreal	8	contact@hilton.com	514-000-0001
2	Marriott	456 rue Parlement, Ottawa	12	contact@marriot.com	613-000-0001
3	Best Western	789 rue Scotiabank, Toronto	10	contact@bestwestern.com	416-000-0001
4	Hyatt	368 avenue Bridgeport, Vancouver	8	contact@hyatt.com	604-000-0001
5	Wyndham	246 promenade Memorial, Calgary	11	contact@wyndham.com	403-000-0001
\.


--
-- Data for Name: chambre; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.chambre (num_chambre, id_hotel, id_chaine, prix, commodites, capacite, vue, ajoute_lit, etat) FROM stdin;
101	1	1	150	TV, Climatisation, WiFi	1	Ville	f	bon état
102	1	1	200	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
103	1	1	250	TV, Climatisation, WiFi, Minibar	2	Jardin	t	légères égratignures
104	1	1	350	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
105	1	1	500	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	2	1	140	TV, Climatisation, WiFi	1	Ville	f	bon état
102	2	1	190	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	2	1	240	TV, Climatisation, WiFi, Minibar	2	Ville	t	robinet cassé
104	2	1	300	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	2	1	400	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	2	1	520	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	légères égratignures
101	3	1	160	TV, Climatisation, WiFi	1	Ville	f	bon état
102	3	1	210	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
103	3	1	260	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
105	3	1	400	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	3	1	480	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	3	1	600	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	4	1	130	TV, Climatisation, WiFi	1	Jardin	f	bon état
102	4	1	180	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
103	4	1	230	TV, Climatisation, WiFi, Minibar	2	Mer	t	bon état
104	4	1	300	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	légères égratignures
105	4	1	450	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	5	1	120	TV, Climatisation, WiFi	1	Ville	f	bon état
102	5	1	170	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	5	1	220	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	5	1	280	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	robinet cassé
105	5	1	370	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	5	1	490	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	6	1	100	TV, Climatisation, WiFi	1	Ville	f	bon état
102	6	1	140	TV, Climatisation, WiFi, Minibar	2	Jardin	f	légères égratignures
103	6	1	180	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	6	1	230	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
106	6	1	380	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	6	1	500	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	7	1	90	TV, Climatisation, WiFi	1	Ville	f	bon état
102	7	1	120	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	7	1	160	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	7	1	210	TV, Climatisation, WiFi, Minibar, Balcon	4	Montagne	t	légères égratignures
105	7	1	300	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	8	1	110	TV, Climatisation, WiFi	1	Mer	f	bon état
102	8	1	155	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	8	1	200	TV, Climatisation, WiFi, Minibar	2	Jardin	t	robinet cassé
104	8	1	260	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	8	1	340	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	8	1	460	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	9	2	145	TV, Climatisation, WiFi	1	Ville	f	bon état
102	9	2	195	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	9	2	245	TV, Climatisation, WiFi, Minibar	2	Ville	t	légères égratignures
104	9	2	310	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	9	2	400	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	9	2	600	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	10	2	135	TV, Climatisation, WiFi	1	Jardin	f	bon état
102	10	2	185	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
103	10	2	235	TV, Climatisation, WiFi, Minibar	2	Mer	t	bon état
104	10	2	310	TV, Climatisation, WiFi, Minibar, Balcon	4	Ville	t	légères égratignures
105	10	2	460	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	11	2	125	TV, Climatisation, WiFi	1	Ville	f	bon état
102	11	2	170	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	11	2	215	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	11	2	280	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	robinet cassé
105	11	2	370	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	11	2	490	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	12	2	155	TV, Climatisation, WiFi	1	Ville	f	bon état
102	12	2	205	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
103	12	2	255	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
105	12	2	400	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	12	2	480	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	12	2	600	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	13	2	115	TV, Climatisation, WiFi	1	Mer	f	bon état
102	13	2	160	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	13	2	205	TV, Climatisation, WiFi, Minibar	2	Jardin	t	légères égratignures
104	13	2	275	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	bon état
105	13	2	395	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	14	2	105	TV, Climatisation, WiFi	1	Ville	f	bon état
102	14	2	145	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	14	2	185	TV, Climatisation, WiFi, Minibar	2	Ville	t	robinet cassé
104	14	2	245	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	14	2	320	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	14	2	440	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	15	2	95	TV, Climatisation, WiFi	1	Mer	f	bon état
102	15	2	130	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	15	2	165	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
104	15	2	215	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	légères égratignures
105	15	2	280	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	15	2	350	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	15	2	460	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	16	2	110	TV, Climatisation, WiFi	1	Ville	f	bon état
102	16	2	155	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
104	16	2	270	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	bon état
105	16	2	390	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	17	3	115	TV, Climatisation, WiFi	1	Ville	f	bon état
102	17	3	160	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	17	3	205	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	17	3	265	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	légères égratignures
105	17	3	345	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	17	3	465	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	18	3	175	TV, Climatisation, WiFi	1	Ville	f	bon état
102	18	3	225	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	18	3	275	TV, Climatisation, WiFi, Minibar	2	Mer	t	bon état
104	18	3	340	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	robinet cassé
105	18	3	420	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	18	3	500	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	18	3	630	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	19	3	160	TV, Climatisation, WiFi	1	Ville	f	bon état
102	19	3	210	TV, Climatisation, WiFi, Minibar	2	Ville	f	bon état
104	19	3	330	TV, Climatisation, WiFi, Minibar, Balcon	4	Mer	t	bon état
105	19	3	480	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	20	3	145	TV, Climatisation, WiFi	1	Ville	f	bon état
102	20	3	195	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	20	3	245	TV, Climatisation, WiFi, Minibar	2	Mer	t	bon état
104	20	3	310	TV, Climatisation, WiFi, Minibar, Balcon	3	Panoramique	t	légères égratignures
105	20	3	400	TV, Climatisation, WiFi, Minibar	4	Montagne	t	bon état
106	20	3	520	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	21	3	130	TV, Climatisation, WiFi	1	Ville	f	bon état
102	21	3	175	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	21	3	220	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	21	3	280	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	robinet cassé
105	21	3	360	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	21	3	440	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	21	3	560	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	22	3	105	TV, Climatisation, WiFi	1	Ville	f	bon état
102	22	3	145	TV, Climatisation, WiFi, Minibar	2	Jardin	f	légères égratignures
103	22	3	185	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	22	3	245	TV, Climatisation, WiFi, Minibar, Balcon	4	Montagne	t	bon état
103	16	2	200	TV, Climatisation, WiFi, Minibar	2	Ville	t	tache sur tapis
105	22	3	355	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	23	3	120	TV, Climatisation, WiFi	1	Mer	f	bon état
102	23	3	165	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	23	3	210	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
105	23	3	350	TV, Climatisation, WiFi, Minibar	4	Montagne	t	bon état
106	23	3	470	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	24	3	95	TV, Climatisation, WiFi	1	Ville	f	bon état
102	24	3	130	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	24	3	165	TV, Climatisation, WiFi, Minibar	2	Ville	t	légères égratignures
104	24	3	215	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	24	3	280	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	24	3	350	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	24	3	450	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	25	4	95	TV, Climatisation, WiFi	1	Ville	f	bon état
102	25	4	130	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	25	4	165	TV, Climatisation, WiFi, Minibar	2	Ville	t	robinet cassé
104	25	4	215	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	bon état
105	25	4	310	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	26	4	90	TV, Climatisation, WiFi	1	Ville	f	bon état
102	26	4	125	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	26	4	160	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	26	4	210	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	légères égratignures
105	26	4	275	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	26	4	375	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	27	4	100	TV, Climatisation, WiFi	1	Ville	f	bon état
102	27	4	140	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
104	27	4	235	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	27	4	305	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	27	4	385	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	27	4	490	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	28	4	85	TV, Climatisation, WiFi	1	Ville	f	bon état
102	28	4	115	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	28	4	150	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	28	4	195	TV, Climatisation, WiFi, Minibar, Balcon	4	Montagne	t	légères égratignures
105	28	4	280	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	29	4	110	TV, Climatisation, WiFi	1	Mer	f	bon état
102	29	4	150	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	29	4	190	TV, Climatisation, WiFi, Minibar	2	Jardin	t	robinet cassé
104	29	4	250	TV, Climatisation, WiFi, Minibar, Balcon	3	Panoramique	t	bon état
105	29	4	325	TV, Climatisation, WiFi, Minibar	4	Montagne	t	bon état
106	29	4	435	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	30	4	155	TV, Climatisation, WiFi	1	Mer	f	bon état
102	30	4	205	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	30	4	255	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
105	30	4	410	TV, Climatisation, WiFi, Minibar	4	Montagne	t	bon état
106	30	4	490	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	30	4	620	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	31	4	80	TV, Climatisation, WiFi	1	Ville	f	bon état
102	31	4	110	TV, Climatisation, WiFi, Minibar	2	Jardin	f	légères égratignures
103	31	4	145	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	31	4	190	TV, Climatisation, WiFi, Minibar, Balcon	4	Montagne	t	bon état
105	31	4	270	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	32	4	115	TV, Climatisation, WiFi	1	Ville	f	bon état
102	32	4	155	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	32	4	195	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
104	32	4	255	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	robinet cassé
105	32	4	330	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	32	4	445	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	33	5	80	TV, Climatisation, WiFi	1	Mer	f	bon état
102	33	5	110	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	33	5	140	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
104	33	5	185	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	légères égratignures
105	33	5	240	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	33	5	305	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	33	5	390	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	34	5	75	TV, Climatisation, WiFi	1	Mer	f	bon état
103	34	5	135	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
104	34	5	175	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	bon état
105	34	5	250	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	35	5	165	TV, Climatisation, WiFi	1	Ville	f	bon état
102	35	5	215	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	35	5	265	TV, Climatisation, WiFi, Minibar	2	Ville	t	légères égratignures
104	35	5	330	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	35	5	425	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
106	35	5	545	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
101	36	5	100	TV, Climatisation, WiFi	1	Ville	f	bon état
102	36	5	135	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	36	5	170	TV, Climatisation, WiFi, Minibar	2	Ville	t	robinet cassé
104	36	5	220	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	36	5	285	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	36	5	360	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	bon état
107	36	5	460	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	37	5	120	TV, Climatisation, WiFi	1	Ville	f	bon état
102	37	5	160	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	37	5	200	TV, Climatisation, WiFi, Minibar	2	Ville	t	bon état
105	37	5	370	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	38	5	95	TV, Climatisation, WiFi	1	Ville	f	bon état
102	38	5	130	TV, Climatisation, WiFi, Minibar	2	Jardin	f	bon état
103	38	5	165	TV, Climatisation, WiFi, Minibar	2	Ville	t	légères égratignures
104	38	5	215	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	bon état
105	38	5	280	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
106	38	5	375	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	39	5	135	TV, Climatisation, WiFi	1	Mer	f	bon état
102	39	5	180	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	39	5	225	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
104	39	5	285	TV, Climatisation, WiFi, Minibar, Balcon	3	Panoramique	t	robinet cassé
105	39	5	365	TV, Climatisation, WiFi, Minibar	4	Montagne	t	bon état
106	39	5	445	TV, Climatisation, WiFi, Minibar	4	Mer	t	bon état
107	39	5	565	TV, Climatisation, WiFi, Minibar, Salon	6	Panoramique	t	bon état
101	40	5	110	TV, Climatisation, WiFi	1	Mer	f	bon état
102	40	5	150	TV, Climatisation, WiFi, Minibar	2	Mer	f	bon état
103	40	5	190	TV, Climatisation, WiFi, Minibar	2	Jardin	t	bon état
104	40	5	245	TV, Climatisation, WiFi, Minibar, Balcon	4	Panoramique	t	légères égratignures
105	40	5	350	TV, Climatisation, WiFi, Minibar, Salon	6	Mer	t	bon état
104	3	1	320	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	tache sur tapis
105	6	1	300	TV, Climatisation, WiFi, Minibar	4	Mer	t	tache sur tapis
106	9	2	480	TV, Climatisation, WiFi, Minibar	4	Panoramique	t	tache sur tapis
104	12	2	320	TV, Climatisation, WiFi, Minibar, Balcon	3	Montagne	t	tache sur tapis
103	19	3	260	TV, Climatisation, WiFi, Minibar	2	Jardin	t	tache sur tapis
104	23	3	270	TV, Climatisation, WiFi, Minibar, Balcon	3	Panoramique	t	tache sur tapis
103	27	4	180	TV, Climatisation, WiFi, Minibar	2	Ville	t	tache sur tapis
104	30	4	320	TV, Climatisation, WiFi, Minibar, Balcon	3	Panoramique	t	tache sur tapis
102	34	5	105	TV, Climatisation, WiFi, Minibar	2	Mer	f	tache sur tapis
104	37	5	260	TV, Climatisation, WiFi, Minibar, Balcon	4	Montagne	t	tache sur tapis
\.


--
-- Data for Name: client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.client (id_client, nom_complet, adresse, nas_client, date_inscription, email, telephone) FROM stdin;
\.


--
-- Data for Name: employe; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.employe (id_employe, nom_complet, adresse, nas_employe, role, id_hotel) FROM stdin;
\.


--
-- Data for Name: hotel; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.hotel (id_hotel, id_chaine, adresse, no_chambre, email, telephone, id_gestionnaire, categorie) FROM stdin;
1	1	111 boulevard René-Lévesque, Montréal	5	h1@marriott.com	514-001-0001	1	5
2	1	222 rue Sherbrooke, Montréal	6	h2@marriott.com	514-001-0002	1	5
3	1	333 rue King, Toronto	7	h3@marriott.com	416-001-0003	1	5
4	1	444 avenue Victoria, Vancouver	5	h4@marriott.com	604-001-0004	1	4
5	1	555 rue Rideau, Ottawa	6	h5@marriott.com	613-001-0005	1	3
6	1	666 avenue Décarie, Calgary	7	h6@marriott.com	403-001-0006	1	2
7	1	777 rue Saint-Jean, Québec	5	h7@marriott.com	418-001-0007	1	1
8	1	888 rue Main, Halifax	6	h8@marriott.com	902-001-0008	1	4
9	2	123 rue Sainte-Catherine, Montréal	7	h1@hilton.com	514-002-0001	2	4
10	2	234 rue Peel, Montréal	5	h2@hilton.com	514-002-0002	2	4
11	2	345 avenue Portage, Winnipeg	6	h3@hilton.com	204-002-0003	2	4
12	2	456 rue University, Toronto	7	h4@hilton.com	416-002-0004	2	5
13	2	567 rue Granville, Vancouver	5	h5@hilton.com	604-002-0005	2	3
14	2	678 avenue Laurier, Ottawa	6	h6@hilton.com	613-002-0006	2	2
15	2	789 rue Spring Garden, Halifax	7	h7@hilton.com	902-002-0007	2	1
16	2	890 rue Victoria, Regina	5	h8@hilton.com	306-002-0008	2	5
17	3	101 rue Drummond, Montréal	6	h1@hyatt.com	514-003-0001	3	3
18	3	202 avenue du Mont-Royal, Montréal	7	h2@hyatt.com	514-003-0002	3	5
19	3	303 rue Yonge, Toronto	5	h3@hyatt.com	416-003-0003	3	5
20	3	404 avenue Robson, Vancouver	6	h4@hyatt.com	604-003-0004	3	5
21	3	505 rue Wellington, Ottawa	7	h5@hyatt.com	613-003-0005	3	4
22	3	606 avenue 17th, Calgary	5	h6@hyatt.com	403-003-0006	3	3
23	3	707 rue Whyte, Edmonton	6	h7@hyatt.com	780-003-0007	3	2
24	3	808 rue Notre-Dame, Winnipeg	7	h8@hyatt.com	204-003-0008	3	1
25	4	111 rue Saint-Urbain, Toronto	5	h1@bestwestern.com	416-004-0001	4	2
26	4	222 avenue Bay, Toronto	6	h2@bestwestern.com	416-004-0002	4	2
27	4	333 rue Rideau, Ottawa	7	h3@bestwestern.com	613-004-0003	4	2
28	4	444 rue Saint-Jean, Québec	5	h4@bestwestern.com	418-004-0004	4	3
29	4	555 avenue Ste-Anne, Halifax	6	h5@bestwestern.com	902-004-0005	4	4
30	4	666 rue Granville, Vancouver	7	h6@bestwestern.com	604-004-0006	4	5
31	4	777 avenue Macleod, Calgary	5	h7@bestwestern.com	403-004-0007	4	1
32	4	888 rue Jasper, Edmonton	6	h8@bestwestern.com	780-004-0008	4	4
33	5	123 rue de la Montagne, Vancouver	7	h1@wyndham.com	604-005-0001	5	1
34	5	234 avenue Burrard, Vancouver	5	h2@wyndham.com	604-005-0002	5	1
35	5	345 rue Principale, Québec	6	h3@wyndham.com	418-005-0003	5	5
36	5	456 boulevard Décarie, Montréal	7	h4@wyndham.com	514-005-0004	5	4
37	5	567 rue King, Hamilton	5	h5@wyndham.com	905-005-0005	5	3
38	5	678 avenue des Pins, Ottawa	6	h6@wyndham.com	613-005-0006	5	2
39	5	789 rue Princess, Winnipeg	7	h7@wyndham.com	204-005-0007	5	3
40	5	890 rue South Park, Halifax	5	h8@wyndham.com	902-005-0008	5	3
\.


--
-- Data for Name: location; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.location (id_location, date_check_in, date_check_out, status, num_chambre, id_reservation, id_employe, id_client, id_hotel, id_chaine) FROM stdin;
\.


--
-- Data for Name: reservation; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservation (id_reservation, date_debut, date_fin, status, num_chambre, id_client, id_hotel, id_chaine) FROM stdin;
\.


--
-- Name: archive archive_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.archive
    ADD CONSTRAINT archive_pkey PRIMARY KEY (id_archive);


--
-- Name: chaines_hotelières chaines_hotelières_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public."chaines_hotelières"
    ADD CONSTRAINT "chaines_hotelières_pkey" PRIMARY KEY (id_chaine);


--
-- Name: chambre chambre_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre
    ADD CONSTRAINT chambre_pkey PRIMARY KEY (num_chambre, id_hotel, id_chaine);


--
-- Name: client client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.client
    ADD CONSTRAINT client_pkey PRIMARY KEY (id_client);


--
-- Name: employe employe_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employe
    ADD CONSTRAINT employe_pkey PRIMARY KEY (id_employe);


--
-- Name: hotel hotel_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hotel
    ADD CONSTRAINT hotel_pkey PRIMARY KEY (id_hotel);


--
-- Name: location location_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_pkey PRIMARY KEY (id_location);


--
-- Name: reservation reservation_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_pkey PRIMARY KEY (id_reservation);


--
-- Name: archive archive_id_location_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.archive
    ADD CONSTRAINT archive_id_location_fkey FOREIGN KEY (id_location) REFERENCES public.location(id_location);


--
-- Name: archive archive_id_reservation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.archive
    ADD CONSTRAINT archive_id_reservation_fkey FOREIGN KEY (id_reservation) REFERENCES public.reservation(id_reservation);


--
-- Name: chambre chambre_id_chaine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre
    ADD CONSTRAINT chambre_id_chaine_fkey FOREIGN KEY (id_chaine) REFERENCES public."chaines_hotelières"(id_chaine);


--
-- Name: chambre chambre_id_hotel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.chambre
    ADD CONSTRAINT chambre_id_hotel_fkey FOREIGN KEY (id_hotel) REFERENCES public.hotel(id_hotel);


--
-- Name: employe employe_id_hotel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.employe
    ADD CONSTRAINT employe_id_hotel_fkey FOREIGN KEY (id_hotel) REFERENCES public.hotel(id_hotel);


--
-- Name: hotel hotel_id_chaine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.hotel
    ADD CONSTRAINT hotel_id_chaine_fkey FOREIGN KEY (id_chaine) REFERENCES public."chaines_hotelières"(id_chaine);


--
-- Name: location location_id_chaine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_id_chaine_fkey FOREIGN KEY (id_chaine) REFERENCES public."chaines_hotelières"(id_chaine);


--
-- Name: location location_id_client_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_id_client_fkey FOREIGN KEY (id_client) REFERENCES public.client(id_client);


--
-- Name: location location_id_employe_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_id_employe_fkey FOREIGN KEY (id_employe) REFERENCES public.employe(id_employe);


--
-- Name: location location_id_hotel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_id_hotel_fkey FOREIGN KEY (id_hotel) REFERENCES public.hotel(id_hotel);


--
-- Name: location location_id_reservation_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.location
    ADD CONSTRAINT location_id_reservation_fkey FOREIGN KEY (id_reservation) REFERENCES public.reservation(id_reservation);


--
-- Name: reservation reservation_id_chaine_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_chaine_fkey FOREIGN KEY (id_chaine) REFERENCES public."chaines_hotelières"(id_chaine);


--
-- Name: reservation reservation_id_client_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_client_fkey FOREIGN KEY (id_client) REFERENCES public.client(id_client);


--
-- Name: reservation reservation_id_hotel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_hotel_fkey FOREIGN KEY (id_hotel) REFERENCES public.hotel(id_hotel);


--
-- PostgreSQL database dump complete
--

