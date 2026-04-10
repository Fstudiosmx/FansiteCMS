<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\Database\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migración PostgreSQL — FansiteCMS
 * Traducción Español Latinoamérica (es_419)
 * Generada: 2026-04-10
 */
final class Version20260410PostgreSQL extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Esquema inicial para PostgreSQL — FansiteCMS ES-419';
    }

    public function up(Schema $schema): void
    {
        // Tabla de usuarios
        $this->addSql('
            CREATE TABLE "user" (
                id SERIAL PRIMARY KEY,
                username VARCHAR(180) NOT NULL,
                email VARCHAR(180) NOT NULL,
                roles JSON NOT NULL DEFAULT \'[]\'::json,
                password VARCHAR(255) NOT NULL,
                habbo_nombre VARCHAR(100) DEFAULT NULL,
                avatar_url VARCHAR(500) DEFAULT NULL,
                is_verified BOOLEAN NOT NULL DEFAULT FALSE,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT UNIQ_8D93D649F85E0677 UNIQUE (username),
                CONSTRAINT UNIQ_8D93D649E7927C74 UNIQUE (email)
            )
        ');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:json)\'');

        // Tabla de noticias
        $this->addSql('
            CREATE TABLE news (
                id SERIAL PRIMARY KEY,
                author_id INT DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                image_name VARCHAR(255) DEFAULT NULL,
                published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                is_published BOOLEAN NOT NULL DEFAULT FALSE,
                CONSTRAINT UNIQ_1DD39950989D9B62 UNIQUE (slug),
                CONSTRAINT FK_1DD39950F675F31B FOREIGN KEY (author_id)
                    REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ');
        $this->addSql('CREATE INDEX IDX_NEWS_AUTHOR ON news (author_id)');
        $this->addSql('CREATE INDEX IDX_NEWS_PUBLISHED ON news (published_at)');

        // Tabla de habitaciones
        $this->addSql('
            CREATE TABLE room (
                id SERIAL PRIMARY KEY,
                owner_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                habbo_room_id VARCHAR(100) DEFAULT NULL,
                image_name VARCHAR(255) DEFAULT NULL,
                visits INT NOT NULL DEFAULT 0,
                rating NUMERIC(3,1) NOT NULL DEFAULT 0.0,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT FK_729F519B7E3C61F9 FOREIGN KEY (owner_id)
                    REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ');
        $this->addSql('CREATE INDEX IDX_ROOM_OWNER ON room (owner_id)');

        // Tabla de equipos
        $this->addSql('
            CREATE TABLE team (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                image_name VARCHAR(255) DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP
            )
        ');

        // Tabla de miembros de equipo
        $this->addSql('
            CREATE TABLE team_member (
                id SERIAL PRIMARY KEY,
                team_id INT NOT NULL,
                user_id INT NOT NULL,
                cargo VARCHAR(100) DEFAULT NULL,
                joined_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT FK_6FFE7A8296CD8AE FOREIGN KEY (team_id)
                    REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE,
                CONSTRAINT FK_6FFE7A82A76ED395 FOREIGN KEY (user_id)
                    REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ');
        $this->addSql('CREATE INDEX IDX_TEAM_MEMBER_TEAM ON team_member (team_id)');
        $this->addSql('CREATE INDEX IDX_TEAM_MEMBER_USER ON team_member (user_id)');

        // Tabla de videos
        $this->addSql('
            CREATE TABLE video (
                id SERIAL PRIMARY KEY,
                author_id INT DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                url VARCHAR(500) NOT NULL,
                description TEXT DEFAULT NULL,
                thumbnail VARCHAR(500) DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT FK_7CC7DA2CF675F31B FOREIGN KEY (author_id)
                    REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ');
        $this->addSql('CREATE INDEX IDX_VIDEO_AUTHOR ON video (author_id)');

        // Tabla de insignias
        $this->addSql('
            CREATE TABLE badge (
                id SERIAL PRIMARY KEY,
                user_id INT NOT NULL,
                code VARCHAR(100) NOT NULL,
                name VARCHAR(255) NOT NULL,
                obtained_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT FK_FEF0481DA76ED395 FOREIGN KEY (user_id)
                    REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
            )
        ');
        $this->addSql('CREATE INDEX IDX_BADGE_USER ON badge (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS badge CASCADE');
        $this->addSql('DROP TABLE IF EXISTS video CASCADE');
        $this->addSql('DROP TABLE IF EXISTS team_member CASCADE');
        $this->addSql('DROP TABLE IF EXISTS team CASCADE');
        $this->addSql('DROP TABLE IF EXISTS room CASCADE');
        $this->addSql('DROP TABLE IF EXISTS news CASCADE');
        $this->addSql('DROP TABLE IF EXISTS "user" CASCADE');
    }
}
