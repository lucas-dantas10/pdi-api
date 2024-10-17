<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017121218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE s_user (nu_seq_user INT NOT NULL, ds_full_name VARCHAR(255) NOT NULL, ds_email VARCHAR(255) NOT NULL, co_cpf VARCHAR(11) NOT NULL, ds_password VARCHAR(255) NOT NULL, json_roles JSON NOT NULL, PRIMARY KEY(nu_seq_user))');
        $this->addSql('CREATE UNIQUE INDEX unique_email ON s_user (ds_email)');
        $this->addSql('CREATE UNIQUE INDEX unique_cpf ON s_user (co_cpf)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE s_wallet (nu_seq_wallet INT NOT NULL, nu_seq_user INT DEFAULT NULL, nu_balance NUMERIC(10, 2) DEFAULT \'0.00\' NOT NULL, PRIMARY KEY(nu_seq_wallet))');
        $this->addSql('CREATE UNIQUE INDEX uniq_5fcae3f8f915b6b3 ON s_wallet (nu_seq_user)');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('CREATE TABLE s_transaction (nu_seq_transaction INT NOT NULL, nu_seq_sender_wallet INT DEFAULT NULL, nu_seq_receiver_wallet INT DEFAULT NULL, nu_amount NUMERIC(10, 2) NOT NULL, dt_created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(nu_seq_transaction))');
        $this->addSql('CREATE INDEX idx_5f152788c5195ca7 ON s_transaction (nu_seq_receiver_wallet)');
        $this->addSql('CREATE INDEX idx_5f1527882ae5d5a0 ON s_transaction (nu_seq_sender_wallet)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE s_user');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE s_wallet');
        $this->abortIf(
            !$this->connection->getDatabasePlatform() instanceof \Doctrine\DBAL\Platforms\PostgreSQL120Platform,
            "Migration can only be executed safely on '\Doctrine\DBAL\Platforms\PostgreSQL120Platform'."
        );

        $this->addSql('DROP TABLE s_transaction');
    }
}
