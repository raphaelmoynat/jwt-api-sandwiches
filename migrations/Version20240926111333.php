<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926111333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ingredient_sandwich (ingredient_id INT NOT NULL, sandwich_id INT NOT NULL, PRIMARY KEY(ingredient_id, sandwich_id))');
        $this->addSql('CREATE INDEX IDX_FA2158E6933FE08C ON ingredient_sandwich (ingredient_id)');
        $this->addSql('CREATE INDEX IDX_FA2158E64D566043 ON ingredient_sandwich (sandwich_id)');
        $this->addSql('ALTER TABLE ingredient_sandwich ADD CONSTRAINT FK_FA2158E6933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredient_sandwich ADD CONSTRAINT FK_FA2158E64D566043 FOREIGN KEY (sandwich_id) REFERENCES sandwich (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ingredient DROP CONSTRAINT fk_6baf78704d566043');
        $this->addSql('DROP INDEX idx_6baf78704d566043');
        $this->addSql('ALTER TABLE ingredient DROP sandwich_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ingredient_sandwich DROP CONSTRAINT FK_FA2158E6933FE08C');
        $this->addSql('ALTER TABLE ingredient_sandwich DROP CONSTRAINT FK_FA2158E64D566043');
        $this->addSql('DROP TABLE ingredient_sandwich');
        $this->addSql('ALTER TABLE ingredient ADD sandwich_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ingredient ADD CONSTRAINT fk_6baf78704d566043 FOREIGN KEY (sandwich_id) REFERENCES sandwich (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6baf78704d566043 ON ingredient (sandwich_id)');
    }
}
