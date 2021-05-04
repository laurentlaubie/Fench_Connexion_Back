<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504073047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_hobby (user_id INT NOT NULL, hobby_id INT NOT NULL, INDEX IDX_DBA6086FA76ED395 (user_id), INDEX IDX_DBA6086F322B2123 (hobby_id), PRIMARY KEY(user_id, hobby_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_service (user_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_B99084D8A76ED395 (user_id), INDEX IDX_B99084D8ED5CA9E6 (service_id), PRIMARY KEY(user_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_hobby ADD CONSTRAINT FK_DBA6086FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_hobby ADD CONSTRAINT FK_DBA6086F322B2123 FOREIGN KEY (hobby_id) REFERENCES hobby (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_service ADD CONSTRAINT FK_B99084D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_service ADD CONSTRAINT FK_B99084D8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25A76ED395 ON answer (user_id)');
        $this->addSql('ALTER TABLE question ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EA76ED395 ON question (user_id)');
        $this->addSql('ALTER TABLE travel ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE travel ADD CONSTRAINT FK_2D0B6BCEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2D0B6BCEA76ED395 ON travel (user_id)');
        $this->addSql('ALTER TABLE user ADD cities_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CAC75398 FOREIGN KEY (cities_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649CAC75398 ON user (cities_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_hobby');
        $this->addSql('DROP TABLE user_service');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25A76ED395');
        $this->addSql('DROP INDEX IDX_DADD4A25A76ED395 ON answer');
        $this->addSql('ALTER TABLE answer DROP user_id');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('DROP INDEX IDX_B6F7494EA76ED395 ON question');
        $this->addSql('ALTER TABLE question DROP user_id');
        $this->addSql('ALTER TABLE travel DROP FOREIGN KEY FK_2D0B6BCEA76ED395');
        $this->addSql('DROP INDEX IDX_2D0B6BCEA76ED395 ON travel');
        $this->addSql('ALTER TABLE travel DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CAC75398');
        $this->addSql('DROP INDEX IDX_8D93D649CAC75398 ON user');
        $this->addSql('ALTER TABLE user DROP cities_id');
    }
}
