# d7\_to\_d11\_migration

## Overview

This is a custom Drupal migration module designed to migrate the `article` content type from a Drupal 7 site to a Drupal 11 site. It utilizes the Migrate API to facilitate data migration.

## Features

- Migrates the `article` content type from Drupal 7 to Drupal 11.
- Uses a custom source plugin to extract article data.
- Supports migration of article body fields.
- Configurable via YAML migration files.

## Installation

1. Copy the `d7_to_d11_migration` module folder to `modules/custom/` in your Drupal 11 installation.
2. Ensure that the Drupal 7 database is accessible and configured in `settings.php`.
3. Enable the module using Drush:
   ```sh
   drush en d7_to_d11_migration -y
   ```

## Configuration

### Database Connection

Edit your `settings.php` file to add the Drupal 7 database connection:

```php
$databases['drupal_7']['default'] = [
  'database' => 'drupal7_db',
  'username' => 'db_user',
  'password' => 'db_pass',
  'host' => 'localhost',
  'driver' => 'mysql',
  'prefix' => '',
];
```

### Running the Migration

Run the following Drush command to execute the migration:

```sh
drush migrate:import d7_article_migration
```

To roll back the migration, use:

```sh
drush migrate:rollback d7_article_migration
```

## Files and Structure

- `d7_to_d11_migration.info.yml` - Module metadata.
- `d7_to_d11_migration.services.yml` - Service definitions.
- `d7_to_d11_migration.migrate_drupal.yml` - Migration dependencies.
- `migrations/d7_article.yml` - Migration configuration for articles.
- `src/Plugin/migrate/source/D7ArticleWithBody.php` - Custom migration source plugin for articles with body fields.

## Requirements

- Drupal 11
- Migrate, Migrate Drupal, and Migrate Plus modules enabled
- Access to the Drupal 7 database

## Troubleshooting

- If migration fails, check logs using:
  ```sh
  drush migrate:messages d7_article_migration
  ```
- Verify that the Drupal 7 database connection is correctly configured.
- Ensure required migration modules are enabled.
