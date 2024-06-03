# Utiliser l'image officielle php:apache comme base
FROM php:apache

# Ajouter le fichier index.html dans le répertoire web
COPY index.html /var/www/html/index.html

# Exposer le port 80 pour le serveur web
EXPOSE 80

# Démarrer Apache en mode foreground
CMD ["apache2-foreground"]
