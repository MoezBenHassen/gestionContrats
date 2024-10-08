<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240928134202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, num_fournisseur_id INT NOT NULL, type_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, preavis INT NOT NULL, montant DOUBLE PRECISION NOT NULL, num_enregistrement INT NOT NULL, periodicite_entretien VARCHAR(255) NOT NULL, periodicite_facturation VARCHAR(255) NOT NULL, augmentation DOUBLE PRECISION DEFAULT NULL, libelle_pdf VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, suivi TINYINT(1) NOT NULL, repetitive TINYINT(1) NOT NULL, INDEX IDX_60349993554AD3A2 (num_fournisseur_id), INDEX IDX_60349993C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE convention (id INT AUTO_INCREMENT NOT NULL, num_fournisseur_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, montant DOUBLE PRECISION NOT NULL, libelle_pdf VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, objet VARCHAR(255) NOT NULL, INDEX IDX_8556657E554AD3A2 (num_fournisseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fournisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, code_fournisseur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_contrat (id INT AUTO_INCREMENT NOT NULL, choix VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993554AD3A2 FOREIGN KEY (num_fournisseur_id) REFERENCES fournisseur (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993C54C8C93 FOREIGN KEY (type_id) REFERENCES types_contrat (id)');
        $this->addSql('ALTER TABLE convention ADD CONSTRAINT FK_8556657E554AD3A2 FOREIGN KEY (num_fournisseur_id) REFERENCES fournisseur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993554AD3A2');
        $this->addSql('ALTER TABLE convention DROP FOREIGN KEY FK_8556657E554AD3A2');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993C54C8C93');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE convention');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE types_contrat');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
