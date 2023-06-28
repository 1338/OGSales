<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028133851 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_dead_drop (id INT AUTO_INCREMENT NOT NULL, x INT NOT NULL, z INT NOT NULL, y INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD dead_drop_id INT DEFAULT NULL, DROP dead_drop');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE12E06DF0 FOREIGN KEY (dead_drop_id) REFERENCES order_dead_drop (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE12E06DF0 ON orders (dead_drop_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE12E06DF0');
        $this->addSql('DROP TABLE order_dead_drop');
        $this->addSql('DROP INDEX IDX_E52FFDEE12E06DF0 ON orders');
        $this->addSql('ALTER TABLE orders ADD dead_drop JSON DEFAULT NULL, DROP dead_drop_id');
    }
}
