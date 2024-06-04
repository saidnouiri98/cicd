# Utiliser l'image officielle php:apache comme base
FROM php:apache

# Installer les extensions nécessaires pour mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Ajouter le fichier index.php dans le répertoire web
COPY index.php /var/www/html/index.html

# Exposer le port 80 pour le serveur web
EXPOSE 80

# Démarrer Apache en mode foreground
CMD ["apache2-foreground"]
