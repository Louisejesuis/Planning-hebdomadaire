<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220503124357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE step (id INT AUTO_INCREMENT NOT NULL, step_category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_43B9FE3C139187C2 (step_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE step_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_steps (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, step_id INT NOT NULL, date DATE NOT NULL, duration TIME NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_D6E0F12AA76ED395 (user_id), INDEX IDX_D6E0F12A73B21E9C (step_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C139187C2 FOREIGN KEY (step_category_id) REFERENCES step_category (id)');
        $this->addSql('ALTER TABLE user_steps ADD CONSTRAINT FK_D6E0F12AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_steps ADD CONSTRAINT FK_D6E0F12A73B21E9C FOREIGN KEY (step_id) REFERENCES step (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_steps DROP FOREIGN KEY FK_D6E0F12A73B21E9C');
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C139187C2');
        $this->addSql('ALTER TABLE user_steps DROP FOREIGN KEY FK_D6E0F12AA76ED395');
        $this->addSql('DROP TABLE step');
        $this->addSql('DROP TABLE step_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_steps');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
