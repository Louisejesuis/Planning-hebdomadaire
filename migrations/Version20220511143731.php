<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511143731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rememberme_token (series VARCHAR(88) NOT NULL, value VARCHAR(88) NOT NULL, lastUsed DATETIME NOT NULL, class VARCHAR(100) NOT NULL, username VARCHAR(200) NOT NULL, PRIMARY KEY(series)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE step RENAME INDEX fk_step_1_idx TO IDX_43B9FE3C139187C2');
        $this->addSql('ALTER TABLE user_steps RENAME INDEX fk_d6e0f12a73b21e9c_idx TO IDX_D6E0F12A73B21E9C');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE rememberme_token');
        $this->addSql('ALTER TABLE step RENAME INDEX idx_43b9fe3c139187c2 TO fk_step_1_idx');
        $this->addSql('ALTER TABLE user_steps RENAME INDEX idx_d6e0f12a73b21e9c TO FK_D6E0F12A73B21E9C_idx');
    }
}
