<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126164939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ProductStock (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, stockStatus SMALLINT DEFAULT NULL, restockDate DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_420BF0264584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ProductStock ADD CONSTRAINT FK_420BF0264584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ProductStock DROP FOREIGN KEY FK_420BF0264584665A');
        $this->addSql('DROP TABLE ProductStock');
    }
}
