#!/bin/sh

### Script d'entrée du conteneur backend
###
### N.B. : Ce script est fait pour une initialisation pour le développement en local
### Il ne doit jamais être utilisé en production !!

set -e

echo "==============================="
echo "=== Conteneur Backend (PHP) ==="
echo "==============================="

echo ""
echo "== Installation des dépendances =="
echo ""

composer install

echo ""
echo "== Mise à jour forcée de la base de données =="
echo ""

bin/console doctrine:schema:update --force

# echo ""
# echo "== Génération des clés SSH pour JWT =="
# echo ""

# Génération des clés, en écrasant les anciennes
# Ne doit pas être fait en production pour ne pas invalider les tokens existants
# bin/console lexik:jwt:generate-keypair --overwrite

echo ""
echo "== Le conteneur est prêt =="

# On laisse le conteneur tourner indéfiniment
tail -f /dev/null
