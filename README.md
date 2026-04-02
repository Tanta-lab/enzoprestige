Projet EnzoPrestige — Site e-commerce

-- Description --

Site e-commerce permettant :
	•	consultation de produits
	•	filtrage par catégories
	•	ajout au panier
	•	commande
	•	gestion admin

-- Technologies --

	•	Laravel
	•	MySQL
	•	Blade / Tailwind

 -- Installation --
 
git clone https://github.com/Tanta-lab/enzo-prestige.git
cd enzo-prestige
composer install
npm install

-- Configuration --

php artisan key:generate
php artisan migrate

-- Comptes --

Admin :

email: admin@enzo.test
password: Admin123!

User :

Créer un compte via le site

-- Fonctionnalités --

	•	Catalogue produits
	•	Recherche / filtres
	•	Page produit avec images
	•	Panier
	•	Commande
	•	Authentification
	•	Admin CRUD produits / catégories

-- Diagrammes des cas d'utilisation --

<img width="525" height="344" alt="Capture d’écran 2026-04-02 à 08 26 46" src="https://github.com/user-attachments/assets/b2d2ca19-ecae-4ed1-a01f-4b273acc1fac" />


<img width="554" height="352" alt="Capture d’écran 2026-04-02 à 08 28 12" src="https://github.com/user-attachments/assets/529096c6-4846-474d-a096-44ae68980bad" />


<img width="543" height="375" alt="Capture d’écran 2026-04-02 à 08 29 37" src="https://github.com/user-attachments/assets/f2dbc95e-c998-4b28-a573-f176b5f6fd37" />



-- MCD --

<img width="913" height="579" alt="Capture d’écran 2026-04-02 à 09 06 52" src="https://github.com/user-attachments/assets/13ea5c6e-fe5b-4d36-947f-f4cab3b41f27" />



