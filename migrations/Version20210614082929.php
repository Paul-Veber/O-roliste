<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614082929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game ADD image VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD link VARCHAR(255) DEFAULT NULL, ADD frequency VARCHAR(255) NOT NULL, ADD next_date DATE DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD open TINYINT(1) NOT NULL, ADD max_player SMALLINT NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game DROP image, DROP description, DROP address, DROP link, DROP frequency, DROP next_date, DROP active, DROP open, DROP max_player, DROP created_at, DROP updated_at');
    }
}
