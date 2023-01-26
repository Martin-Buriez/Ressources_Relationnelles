<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126110134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment_concern_publication (id INT AUTO_INCREMENT NOT NULL, comment_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_93726568F8697D13 (comment_id), INDEX IDX_9372656838B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_93726568F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_9372656838B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_93726568F8697D13');
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_9372656838B217A7');
        $this->addSql('DROP TABLE comment_concern_publication');
    }
}
