<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218135128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reported_status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment_concern_publication (id INT AUTO_INCREMENT NOT NULL, comment_id INT NOT NULL, publication_id INT NOT NULL, INDEX IDX_93726568F8697D13 (comment_id), INDEX IDX_9372656838B217A7 (publication_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE communicate_user (id INT AUTO_INCREMENT NOT NULL, user_sender_id INT NOT NULL, user_receive_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_24E0F3B6F6C43E79 (user_sender_id), INDEX IDX_24E0F3B6EBDEAB20 (user_receive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, theme_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', reward VARCHAR(255) DEFAULT NULL, planned_date DATETIME NOT NULL, INDEX IDX_3BAE0AA759027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filter (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filter_concern_category (id INT AUTO_INCREMENT NOT NULL, filter_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_51891D12D395B25E (filter_id), INDEX IDX_51891D1212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, theme_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(50) NOT NULL, description VARCHAR(5000) NOT NULL, state_validated TINYINT(1) NOT NULL, state_private TINYINT(1) NOT NULL, like_number INT NOT NULL, sharing_number INT NOT NULL, view_number INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_AF3C6779B03A8386 (created_by_id), INDEX IDX_AF3C677959027487 (theme_id), INDEX IDX_AF3C677912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE publication_include_image (id INT AUTO_INCREMENT NOT NULL, publication_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_670FDA3A38B217A7 (publication_id), INDEX IDX_670FDA3A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, created_at DATETIME NOT NULL, state_validated TINYINT(1) NOT NULL, state_suspended TINYINT(1) NOT NULL, identity_card_location VARCHAR(255) DEFAULT NULL, identity_card_validated TINYINT(1) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_belong_group (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, groupe_id INT NOT NULL, is_supervisor TINYINT(1) NOT NULL, INDEX IDX_8BB81113A76ED395 (user_id), INDEX IDX_8BB811137A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_communicate_group (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, user_send_message_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B87463467A45358C (groupe_id), INDEX IDX_B87463465EA7EDDD (user_send_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_create_filter (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, filter_id INT NOT NULL, INDEX IDX_ABCB4CFBA76ED395 (user_id), INDEX IDX_ABCB4CFBD395B25E (filter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_edit_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, comment_id INT NOT NULL, INDEX IDX_AE4695D4A76ED395 (user_id), INDEX IDX_AE4695D4F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_manage_event (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT NOT NULL, is_participant TINYINT(1) NOT NULL, is_organizer TINYINT(1) NOT NULL, INDEX IDX_5B7CB22FA76ED395 (user_id), INDEX IDX_5B7CB22F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_relationship (id INT AUTO_INCREMENT NOT NULL, user_sender_id INT NOT NULL, user_receive_id INT NOT NULL, state TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A0C838A2F6C43E79 (user_sender_id), INDEX IDX_A0C838A2EBDEAB20 (user_receive_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_93726568F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE comment_concern_publication ADD CONSTRAINT FK_9372656838B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE communicate_user ADD CONSTRAINT FK_24E0F3B6F6C43E79 FOREIGN KEY (user_sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE communicate_user ADD CONSTRAINT FK_24E0F3B6EBDEAB20 FOREIGN KEY (user_receive_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA759027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE filter_concern_category ADD CONSTRAINT FK_51891D12D395B25E FOREIGN KEY (filter_id) REFERENCES filter (id)');
        $this->addSql('ALTER TABLE filter_concern_category ADD CONSTRAINT FK_51891D1212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C6779B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677959027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE publication ADD CONSTRAINT FK_AF3C677912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE publication_include_image ADD CONSTRAINT FK_670FDA3A38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('ALTER TABLE publication_include_image ADD CONSTRAINT FK_670FDA3A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE user_belong_group ADD CONSTRAINT FK_8BB81113A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_belong_group ADD CONSTRAINT FK_8BB811137A45358C FOREIGN KEY (groupe_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE user_communicate_group ADD CONSTRAINT FK_B87463467A45358C FOREIGN KEY (groupe_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE user_communicate_group ADD CONSTRAINT FK_B87463465EA7EDDD FOREIGN KEY (user_send_message_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_create_filter ADD CONSTRAINT FK_ABCB4CFBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_create_filter ADD CONSTRAINT FK_ABCB4CFBD395B25E FOREIGN KEY (filter_id) REFERENCES filter (id)');
        $this->addSql('ALTER TABLE user_edit_comment ADD CONSTRAINT FK_AE4695D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_edit_comment ADD CONSTRAINT FK_AE4695D4F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE user_manage_event ADD CONSTRAINT FK_5B7CB22FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_manage_event ADD CONSTRAINT FK_5B7CB22F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2F6C43E79 FOREIGN KEY (user_sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_relationship ADD CONSTRAINT FK_A0C838A2EBDEAB20 FOREIGN KEY (user_receive_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_93726568F8697D13');
        $this->addSql('ALTER TABLE comment_concern_publication DROP FOREIGN KEY FK_9372656838B217A7');
        $this->addSql('ALTER TABLE communicate_user DROP FOREIGN KEY FK_24E0F3B6F6C43E79');
        $this->addSql('ALTER TABLE communicate_user DROP FOREIGN KEY FK_24E0F3B6EBDEAB20');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA759027487');
        $this->addSql('ALTER TABLE filter_concern_category DROP FOREIGN KEY FK_51891D12D395B25E');
        $this->addSql('ALTER TABLE filter_concern_category DROP FOREIGN KEY FK_51891D1212469DE2');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C6779B03A8386');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677959027487');
        $this->addSql('ALTER TABLE publication DROP FOREIGN KEY FK_AF3C677912469DE2');
        $this->addSql('ALTER TABLE publication_include_image DROP FOREIGN KEY FK_670FDA3A38B217A7');
        $this->addSql('ALTER TABLE publication_include_image DROP FOREIGN KEY FK_670FDA3A3DA5256D');
        $this->addSql('ALTER TABLE user_belong_group DROP FOREIGN KEY FK_8BB81113A76ED395');
        $this->addSql('ALTER TABLE user_belong_group DROP FOREIGN KEY FK_8BB811137A45358C');
        $this->addSql('ALTER TABLE user_communicate_group DROP FOREIGN KEY FK_B87463467A45358C');
        $this->addSql('ALTER TABLE user_communicate_group DROP FOREIGN KEY FK_B87463465EA7EDDD');
        $this->addSql('ALTER TABLE user_create_filter DROP FOREIGN KEY FK_ABCB4CFBA76ED395');
        $this->addSql('ALTER TABLE user_create_filter DROP FOREIGN KEY FK_ABCB4CFBD395B25E');
        $this->addSql('ALTER TABLE user_edit_comment DROP FOREIGN KEY FK_AE4695D4A76ED395');
        $this->addSql('ALTER TABLE user_edit_comment DROP FOREIGN KEY FK_AE4695D4F8697D13');
        $this->addSql('ALTER TABLE user_manage_event DROP FOREIGN KEY FK_5B7CB22FA76ED395');
        $this->addSql('ALTER TABLE user_manage_event DROP FOREIGN KEY FK_5B7CB22F71F7E88B');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2F6C43E79');
        $this->addSql('ALTER TABLE user_relationship DROP FOREIGN KEY FK_A0C838A2EBDEAB20');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE comment_concern_publication');
        $this->addSql('DROP TABLE communicate_user');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE filter');
        $this->addSql('DROP TABLE filter_concern_category');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE publication_include_image');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_belong_group');
        $this->addSql('DROP TABLE user_communicate_group');
        $this->addSql('DROP TABLE user_create_filter');
        $this->addSql('DROP TABLE user_edit_comment');
        $this->addSql('DROP TABLE user_manage_event');
        $this->addSql('DROP TABLE user_relationship');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
