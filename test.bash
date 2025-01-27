


# Exécuter les tests PHPUnit
docker compose exec php bin/phpunit
PHPUNIT_EXIT_CODE=$?

# Exécuter phpcs
docker compose exec php vendor/bin/phpcs
PHPCS_EXIT_CODE=$?

# Exécuter phpstan
docker compose exec php vendor/bin/phpstan analyse
PHPSTAN_EXIT_CODE=$?

# Vérifier si les tests ont réussi
if [ $PHPUNIT_EXIT_CODE -eq 0 ] && [ $PHPCS_EXIT_CODE -eq 0 ] && [ $PHPSTAN_EXIT_CODE -eq 0 ]; then
  echo "Tous les tests ont réussi."
else
  echo "Certains tests ont échoué."
  exit 1
fi