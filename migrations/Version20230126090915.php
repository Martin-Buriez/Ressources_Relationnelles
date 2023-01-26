<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126090915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD state_validated TINYINT(1) NOT NULL, ADD identity_card_location VARCHAR(255) DEFAULT NULL, ADD identity_card_validated TINYINT(1) NOT NULL, ADD profile_picture VARCHAR(255) NOT NULL, DROP address, DROP state_validate, DROP avatar, DROP identity_card, DROP identity_card_validate, CHANGE username username VARCHAR(255) NOT NULL, CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE postal_code postal_code INT NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE birthday_date birthday DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD state_validate TINYINT(1) NOT NULL, ADD avatar VARCHAR(255) NOT NULL, ADD identity_card VARCHAR(255) NOT NULL, ADD identity_card_validate TINYINT(1) NOT NULL, DROP state_validated, DROP identity_card_location, DROP identity_card_validated, CHANGE username username VARCHAR(50) NOT NULL, CHANGE first_name first_name VARCHAR(50) NOT NULL, CHANGE last_name last_name VARCHAR(50) NOT NULL, CHANGE postal_code postal_code VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(100) NOT NULL, CHANGE profile_picture address VARCHAR(255) NOT NULL, CHANGE birthday birthday_date DATE NOT NULL');
    }
}
