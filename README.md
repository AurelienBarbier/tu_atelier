#Atelier Les TESTS dans Symfony.
==
*A Symfony project created on July 11, 2017, 1:34 pm.*

## SUJET

Créer un projet symfony (parameter.yml, créer un bundle)

Créer une entity Tirelire et son CRUD
date
montant  (le montant peut être positif pour un crédit, négatif pour un débit)

La page list du CRUD doit indiquer “il reste xxx € dans votre tirelire”
Un message d’erreur “Le prélèvement est trop important” doit être retournée si le montant débité (via le formulaire du CRUD) est supérieur au contenu de la tirelire.

Effectuer les tests :
Réponse des pages du CRUD,
Remplissage du formulaire avec des données correctes (crédits et débits),
Simuler un prélèvement trop important.

## Fichiers concernés

* src/AppBundle/
  * Controller/TirelireController.php
  * Service/TransactionChecker.php
* tests/
  * AppBundle/Service/TransactionCheckerTest.php
  * ApplicationAvailabilityFunctionalTest.php


