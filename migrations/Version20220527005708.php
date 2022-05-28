<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220527005708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE id id CHAR(36) NOT NULL, CHANGE workstation_id workstation_id CHAR(36) NOT NULL, CHANGE user_id user_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE workstation CHANGE id id CHAR(36) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation CHANGE id id CHAR(36) NOT NULL, CHANGE workstation_id workstation_id CHAR(36) NOT NULL, CHANGE user_id user_id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE id id CHAR(36) NOT NULL');
        $this->addSql('ALTER TABLE workstation CHANGE id id CHAR(36) NOT NULL');
    }
}
