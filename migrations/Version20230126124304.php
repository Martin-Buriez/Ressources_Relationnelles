<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126124304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reported_status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_concern_publication (id INT AUTO_INCREMENT NOT NULL, comment_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_93726568F8697D13 (comment_id), INDEX IDX_9372656838B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication_include_image (id INT AUTO_INCREMENT NOT NULL, publication_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_670FDA3A38B217A7 (publication_id), INDEX IDX_670FDA3A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_create_publication (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, publication_id INT NOT NULL, is_creator TINYINT(1) NOT NULL, INDEX IDX_A40CEA51A76ED395 (user_id), INDEX IDX_A40CEA5138B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_edit_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, comment_id INT NOT NULL, INDEX IDX_AE4695D4A76ED395 (user_id), INDEX IDX_AE4695D4F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_manage_event (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, is_participant TINYINT(1) NOT NULL, is_organizer TINYINT(1) NOT NULL, INDEX IDX_5B7CB22FA76ED395 (user_id), INDEX IDX_5B7CB22F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_93726568F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_9372656838B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_include_image ADD CONSTRAINT FK_670FDA3A38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_include_image ADD CONSTRAINT FK_670FDA3A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_create_publication ADD CONSTRAINT FK_A40CEA5138B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE user_edit_comment ADD CONSTRAINT FK_AE4695D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_edit_comment ADD CONSTRAINT FK_AE4695D4F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE user_manage_event ADD CONSTRAINT FK_5B7CB22FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_manage_event ADD CONSTRAINT FK_5B7CB22F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA759027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_93726568F8697D13');
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_9372656838B217A7');
        $this->addSql('ALTER TABLE publication_include_image DROP FOREIGN KEY FK_670FDA3A38B217A7');
        $this->addSql('ALTER TABLE publication_include_image DROP FOREIGN KEY FK_670FDA3A3DA5256D');
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA51A76ED395');
        $this->addSql('ALTER TABLE user_create_publication DROP FOREIGN KEY FK_A40CEA5138B217A7');
        $this->addSql('ALTER TABLE user_edit_comment DROP FOREIGN KEY FK_AE4695D4A76ED395');
        $this->addSql('ALTER TABLE user_edit_comment DROP FOREIGN KEY FK_AE4695D4F8697D13');
        $this->addSql('ALTER TABLE user_manage_event DROP FOREIGN KEY FK_5B7CB22FA76ED395');
        $this->addSql('ALTER TABLE user_manage_event DROP FOREIGN KEY FK_5B7CB22F71F7E88B');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_concern_publication');
        $this->addSql('DROP TABLE filter');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE publication_include_image');
        $this->addSql('DROP TABLE user_create_publication');
        $this->addSql('DROP TABLE user_edit_comment');
        $this->addSql('DROP TABLE user_manage_event');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA759027487');
    }
}
