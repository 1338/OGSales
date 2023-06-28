<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028131948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE catalog_item_enchantment (catalog_item_id INT NOT NULL, enchantment_id INT NOT NULL, INDEX IDX_7D9EC7111DDDAF72 (catalog_item_id), INDEX IDX_7D9EC711F3927CF3 (enchantment_id), PRIMARY KEY(catalog_item_id, enchantment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enchantment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE catalog_item_enchantment ADD CONSTRAINT FK_7D9EC7111DDDAF72 FOREIGN KEY (catalog_item_id) REFERENCES catalog_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE catalog_item_enchantment ADD CONSTRAINT FK_7D9EC711F3927CF3 FOREIGN KEY (enchantment_id) REFERENCES enchantment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD dead_drop LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catalog_item_enchantment DROP FOREIGN KEY FK_7D9EC711F3927CF3');
        $this->addSql('DROP TABLE catalog_item_enchantment');
        $this->addSql('DROP TABLE enchantment');
        $this->addSql('ALTER TABLE orders DROP dead_drop');
    }
}
