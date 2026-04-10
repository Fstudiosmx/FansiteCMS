<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\Database\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Migración inicial para PostgreSQL
 * FansiteCMS - Fansite Habbo en Español Latinoamérica
 * Generado: 2026-04-10
 */
final class Version20260410000001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Esquema inicial de FansiteCMS para PostgreSQL - Habbo Hotel Español';
    }

    public function up(Schema $schema): void
    {
        // Tabla de usuarios
        $this->addSql('
            CREATE TABLE "user" (
                id SERIAL NOT NULL,
                username VARCHAR(180) NOT NULL,
                email VARCHAR(180) NOT NULL,
                roles JSON NOT NULL DEFAULT \'[]\',
                password VARCHAR(255) NOT NULL,
                habbo_nombre VARCHAR(100) DEFAULT NULL,
                avatar_url VARCHAR(500) DEFAULT NULL,
                is_active BOOLEAN NOT NULL DEFAULT true,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');

        // Tabla de noticias
        $this->addSql('
            CREATE TABLE news (
                id SERIAL NOT NULL,
                author_id INT DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                content TEXT NOT NULL,
                resumen VARCHAR(500) DEFAULT NULL,
                imagen_portada VARCHAR(500) DEFAULT NULL,
                published_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DD399503EE4B093 ON news (slug)');
        $this->addSql('CREATE INDEX IDX_1DD39950F675F31B ON news (author_id)');
        $this->addSql('ALTER TABLE news ADD CONSTRAINT FK_news_user FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Tabla de habitaciones Habbo
        $this->addSql('
            CREATE TABLE room (
                id SERIAL NOT NULL,
                owner_id INT DEFAULT NULL,
                name VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                habbo_room_id VARCHAR(100) DEFAULT NULL,
                habbo_url VARCHAR(500) DEFAULT NULL,
                es_publica BOOLEAN NOT NULL DEFAULT true,
                visitas INT NOT NULL DEFAULT 0,
                puntaje INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX IDX_ROOM_OWNER ON room (owner_id)');
        $this->addSql('ALTER TABLE room ADD CONSTRAINT FK_room_user FOREIGN KEY (owner_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Tabla de equipos
        $this->addSql('
            CREATE TABLE team (
                id SERIAL NOT NULL,
                name VARCHAR(255) NOT NULL,
                slug VARCHAR(255) NOT NULL,
                description TEXT DEFAULT NULL,
                color_badge VARCHAR(7) DEFAULT \'#0099FF\',
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_TEAM_SLUG ON team (slug)');

        // Tabla de miembros de equipo
        $this->addSql('
            CREATE TABLE team_member (
                id SERIAL NOT NULL,
                team_id INT NOT NULL,
                user_id INT NOT NULL,
                rol VARCHAR(50) NOT NULL DEFAULT \'miembro\',
                joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX IDX_TEAM_MEMBER_TEAM ON team_member (team_id)');
        $this->addSql('CREATE INDEX IDX_TEAM_MEMBER_USER ON team_member (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_TEAM_USER ON team_member (team_id, user_id)');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_tm_team FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE team_member ADD CONSTRAINT FK_tm_user FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Tabla de videos
        $this->addSql('
            CREATE TABLE video (
                id SERIAL NOT NULL,
                author_id INT DEFAULT NULL,
                title VARCHAR(255) NOT NULL,
                url VARCHAR(500) NOT NULL,
                description TEXT DEFAULT NULL,
                vistas INT NOT NULL DEFAULT 0,
                me_gusta INT NOT NULL DEFAULT 0,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE INDEX IDX_VIDEO_AUTHOR ON video (author_id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_video_user FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');

        // Tabla de configuración del sitio
        $this->addSql('
            CREATE TABLE site_config (
                id SERIAL NOT NULL,
                config_key VARCHAR(100) NOT NULL,
                config_value TEXT DEFAULT NULL,
                descripcion VARCHAR(255) DEFAULT NULL,
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id)
            )
        ');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_SITE_CONFIG_KEY ON site_config (config_key)');

        // Datos iniciales de configuración
        $this->addSql("INSERT INTO site_config (config_key, config_value, descripcion) VALUES
            ('site_name', 'FansiteCMS Habbo', 'Nombre del sitio'),
            ('site_locale', 'es_419', 'Idioma del sitio - Español Latinoamérica'),
            ('habbo_hotel', 'habbo.es', 'Hotel de Habbo utilizado'),
            ('habbo_hotel_url', 'https://www.habbo.es', 'URL del hotel de Habbo'),
            ('habbo_avatar_api', 'https://www.habbo.es/habbo-imaging/avatarimage', 'URL base para imágenes de avatares'),
            ('habbo_profile_url', 'https://www.habbo.es/es/profile', 'URL base para perfiles de Habbo')
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE team_member DROP CONSTRAINT FK_tm_team');
        $this->addSql('ALTER TABLE team_member DROP CONSTRAINT FK_tm_user');
        $this->addSql('ALTER TABLE news DROP CONSTRAINT FK_news_user');
        $this->addSql('ALTER TABLE room DROP CONSTRAINT FK_room_user');
        $this->addSql('ALTER TABLE video DROP CONSTRAINT FK_video_user');
        $this->addSql('DROP TABLE IF EXISTS site_config');
        $this->addSql('DROP TABLE IF EXISTS team_member');
        $this->addSql('DROP TABLE IF EXISTS video');
        $this->addSql('DROP TABLE IF EXISTS room');
        $this->addSql('DROP TABLE IF EXISTS news');
        $this->addSql('DROP TABLE IF EXISTS team');
        $this->addSql('DROP TABLE IF EXISTS "user"');
    }
}
