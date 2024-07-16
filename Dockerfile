# Utiliser une image de base officielle PHP avec Apache
FROM php:8.0-apache

# Installer les extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copier le contenu de votre application dans le répertoire racine du serveur web
COPY . /var/www/html/

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer Apache
CMD ["apache2-foreground"]


# Commande pour démarrer Apache
CMD ["apache2-foreground"]
