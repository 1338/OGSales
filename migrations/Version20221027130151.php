<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221027130151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE basket_line_catalog_item (basket_line_id INT NOT NULL, catalog_item_id INT NOT NULL, INDEX IDX_BC3BFD7489DC655B (basket_line_id), INDEX IDX_BC3BFD741DDDAF72 (catalog_item_id), PRIMARY KEY(basket_line_id, catalog_item_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE basket_line_catalog_item ADD CONSTRAINT FK_BC3BFD7489DC655B FOREIGN KEY (basket_line_id) REFERENCES basket_line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_line_catalog_item ADD CONSTRAINT FK_BC3BFD741DDDAF72 FOREIGN KEY (catalog_item_id) REFERENCES catalog_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE basket_line ADD basket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE basket_line ADD CONSTRAINT FK_1A9BADC31BE1FB52 FOREIGN KEY (basket_id) REFERENCES basket (id)');
        $this->addSql('CREATE INDEX IDX_1A9BADC31BE1FB52 ON basket_line (basket_id)');
        $this->addSql('ALTER TABLE catalog_item ADD price NUMERIC(14, 4) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE basket_line_catalog_item');
        $this->addSql('ALTER TABLE basket_line DROP FOREIGN KEY FK_1A9BADC31BE1FB52');
        $this->addSql('DROP INDEX IDX_1A9BADC31BE1FB52 ON basket_line');
        $this->addSql('ALTER TABLE basket_line DROP basket_id');
        $this->addSql('ALTER TABLE catalog_item DROP price');
    }
}
