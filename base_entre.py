import sqlite3

connexion = sqlite3.connect("Candiapp.db")
cursor = connexion.cursor()

cursor.execute("""
CREATE TABLE IF NOT EXISTS utilisateur(
               id_utilisateur INTEGER PRIMARY KEY AUTOINCREMENT,
               nom_utilisateur TEXT NOT NULL,
               motdepasse TEXT NOT NULL)

""")

cursor.execute("""
CREATE TABLE IF NOT EXISTS entreprise (
    id_entreprise INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_entreprise TEXT NOT NULL,
    adresse TEXT NOT NULL,
    date_envoie TEXT NOT NULL,
    statut_candidature TEXT NOT NULL,
    commentaire_candidature TEXT NOT NULL,
    utilisateur_id INTEGER NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id_utilisateur)
)
""")

connexion.commit()
connexion.close()





