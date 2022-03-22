<?php

declare(strict_types=1);

namespace App\Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322172206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Instert products initial data';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO app.products VALUES("000001", "BV Lean leather ankle boots", "boots", 89000)');
        $this->addSql('INSERT INTO app.products VALUES("000002", "BV Lean leather ankle boots", "boots", 99000)');
        $this->addSql('INSERT INTO app.products VALUES("000003", "Ashlington leather ankle boots", "boots", 71000)');
        $this->addSql('INSERT INTO app.products VALUES("000004", "Naima embellished suede sandals", "sandals", 79500)');
        $this->addSql('INSERT INTO app.products VALUES("000005", "Nathane leather sneakers", "sneakers", 59000)');
        $this->addSql('INSERT INTO app.products VALUES("000006", "Leather Derby shoes", "sneakers", 40000)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DELETE FROM app.products');
    }
}
