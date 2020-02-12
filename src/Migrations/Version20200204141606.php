<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200204141606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments CHANGE Tricks_ID Tricks_ID INT DEFAULT NULL, CHANGE User_ID User_ID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE medias CHANGE Tricks_ID Tricks_ID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks ADD filename VARCHAR(255) NOT NULL, DROP Image_home, CHANGE Groupe_ID Groupe_ID INT DEFAULT NULL, CHANGE User_ID User_ID INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tricks RENAME INDEX user_id_modify TO IDX_E1D902C1606E6DEB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comments CHANGE Tricks_ID Tricks_ID INT NOT NULL, CHANGE User_ID User_ID INT NOT NULL');
        $this->addSql('ALTER TABLE medias CHANGE Tricks_ID Tricks_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tricks ADD Image_home VARCHAR(500) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP filename, CHANGE Groupe_ID Groupe_ID INT NOT NULL, CHANGE User_ID User_ID INT NOT NULL');
        $this->addSql('ALTER TABLE tricks RENAME INDEX idx_e1d902c1606e6deb TO User_ID_Modify');
    }
}
