<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511093544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE reservation ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_reservation_workstation_id FOREIGN KEY (workstation_id) REFERENCES workstation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_reservation_user_id FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_reservation_workstation_id');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_reservation_user_id');
        $this->addSql('ALTER TABLE reservation DROP is_active');
    }
}
