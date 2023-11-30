## Installation


 >*We work on stable, supported, and up-to-date versions of packages. We recommend you do the same.*
 <p>an ancient saying</p>
 
1. Go to your Shop project directory. Run the following
```bash
$  composer config repositories.0 git https://github.com/simha-grey/sylius_plugin_g/
```
   or add to your Sylius shop composer.json
```json
        "repositories": [{
            "type": "git",
            "url": "https://github.com/simha-grey/sylius_plugin_g/"
        }]
```
That must be the same. You may check the presence of the "repositories" block in the composer.json.
2. run:
```bash
composer require roma/sylius-product-variant-plugin
composer update
```
2. Add plugin dependencies to your `config/bundles.php` file:

```php
return [
    ...
    Roma\SyliusProductVariantPlugin\RomaSyliusProductVariantPlugin::class => ['all' => true],,
];
```

3. Import the required config in your `config/packages/_sylius.yaml` file:
```yaml
imports:
    ...
    
    - { resource: "@RomaSyliusProductVariantPlugin/src/Resources/config/config.yml" }
```
   And also add the new repository for the sylius_product entity.
```yaml
   Please check the new repository entry in such code context:
   sylius_product:
    resources:
        product:
            classes:
                model: App\Entity\Product\Product
                repository: Roma\SyliusProductVariantPlugin\Repository\ProductWithStockRepository
```

4. Import routing in your `config/routes.yaml` file:

```yaml
roma_sylius_product_variant_plugin:
    resource: "@RomaSyliusProductVariantPlugin/src/Resources/config/routing.yml"
```

5. Add a new migrations path in config/packages/doctrine_migrations.yaml
   ```php
    'Roma\Migrations': "%kernel.project_dir%/vendor/roma/sylius-product-variant-plugin/migrations/"
   ```
   It must be a new subitem of migrations_paths: entry
   
5. Finish the installation by updating the database schema and installing assets:

I tried only migrations:migrate. This is only for you info
```bash
$ bin/console cache:clear   
$ bin/console doctrine:migrations:migrate  
$ bin/console assets:install --symlink    
$ bin/console sylius:theme:assets:install --symlink 
```

