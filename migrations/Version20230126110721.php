<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126110721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_create_publication (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, publication_id INT NOT NULL, is_creator TINYINT(1) NOT NULL, INDEX IDX_A40CEA51A76ED395 (user_id), INDEX IDX_A40CEA5138B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA5138B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA51A76ED395');
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA5138B217A7');
        $this->addSql('DROP TABLE user_create_publication');
    }
}
