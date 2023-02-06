<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230206091203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA5138B217A7');
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA51A76ED395');
        $this->addSql('DROP TABLE user_create_publication');
        $this->addSql('ALTER TABLE publication ADD created_by_id INT NOT NULL, ADD created_at DATETIME NOT NULL, CHANGE title title VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(5000) NOT NULL');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_AF3C6779B03A8386 ON publication (created_by_id)');
        $this->addSql('ALTER TABLE user CHANGE postal_code postal_code VARCHAR(255) NOT NULL, CHANGE phone_number phone_number VARCHAR(255) NOT NULL, CHANGE birthday birthday DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_create_publication (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, publication_id INT NOT NULL, is_creator TINYINT(1) NOT NULL, INDEX IDX_A40CEA5138B217A7 (publication_id), INDEX IDX_A40CEA51A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA5138B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779B03A8386');
        $this->addSql('DROP INDEX IDX_AF3C6779B03A8386 ON publication');
        $this->addSql('ALTER TABLE publication DROP created_by_id, DROP created_at, CHANGE title title VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE postal_code postal_code INT NOT NULL, CHANGE phone_number phone_number INT NOT NULL, CHANGE birthday birthday DATE NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
