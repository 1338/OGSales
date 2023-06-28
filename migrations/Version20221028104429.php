<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028104429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_delivery_type ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE orders ADD status_id INT DEFAULT NULL, ADD delivery_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEECF52334D FOREIGN KEY (delivery_type_id) REFERENCES order_delivery_type (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE6BF700BD ON orders (status_id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEECF52334D ON orders (delivery_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_delivery_type DROP name');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6BF700BD');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEECF52334D');
        $this->addSql('DROP INDEX IDX_E52FFDEE6BF700BD ON orders');
        $this->addSql('DROP INDEX IDX_E52FFDEECF52334D ON orders');
        $this->addSql('ALTER TABLE orders DROP status_id, DROP delivery_type_id');
    }
}
