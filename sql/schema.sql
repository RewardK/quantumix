CREATE DATABASE IF NOT EXISTS quantumix CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quantumix;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin','editor','client') DEFAULT 'client',
    email_verified_at DATETIME NULL,
    last_login_at DATETIME NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE email_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(120) NOT NULL,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ro VARCHAR(150) NOT NULL,
    name_en VARCHAR(150),
    name_de VARCHAR(150),
    name_fr VARCHAR(150),
    slug VARCHAR(160) UNIQUE NOT NULL,
    icon VARCHAR(60),
    description_ro TEXT NOT NULL,
    description_en TEXT,
    description_de TEXT,
    description_fr TEXT,
    benefits TEXT,
    created_at DATETIME NOT NULL
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ro VARCHAR(150) NOT NULL,
    name_en VARCHAR(150),
    name_de VARCHAR(150),
    name_fr VARCHAR(150),
    slug VARCHAR(160) UNIQUE NOT NULL,
    category VARCHAR(120),
    description_ro TEXT NOT NULL,
    description_en TEXT,
    description_de TEXT,
    description_fr TEXT,
    created_at DATETIME NOT NULL
);

CREATE TABLE project_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    file VARCHAR(190) NOT NULL,
    FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_ro VARCHAR(190) NOT NULL,
    title_en VARCHAR(190),
    title_de VARCHAR(190),
    title_fr VARCHAR(190),
    slug VARCHAR(190) UNIQUE NOT NULL,
    excerpt_ro TEXT NOT NULL,
    excerpt_en TEXT,
    excerpt_de TEXT,
    excerpt_fr TEXT,
    content_ro TEXT NOT NULL,
    content_en TEXT,
    content_de TEXT,
    content_fr TEXT,
    published TINYINT(1) DEFAULT 0,
    published_at DATETIME NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL
);

CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL
);

CREATE TABLE post_tags (
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);

CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    name VARCHAR(120) NOT NULL,
    message TEXT NOT NULL,
    approved TINYINT(1) DEFAULT 1,
    created_at DATETIME NOT NULL,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);

CREATE TABLE team_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    role VARCHAR(120) NOT NULL,
    photo VARCHAR(190) NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE timelines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    year VARCHAR(10) NOT NULL,
    description VARCHAR(255) NOT NULL
);

CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    company VARCHAR(120) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE tech_logos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    file VARCHAR(190) NOT NULL
);

CREATE TABLE faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(190) NOT NULL,
    answer TEXT NOT NULL,
    position INT DEFAULT 0
);

CREATE TABLE pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_ro VARCHAR(190) NOT NULL,
    title_en VARCHAR(190),
    title_de VARCHAR(190),
    title_fr VARCHAR(190),
    slug VARCHAR(190) UNIQUE NOT NULL,
    content_ro TEXT NOT NULL,
    content_en TEXT,
    content_de TEXT,
    content_fr TEXT,
    created_at DATETIME NOT NULL
);

CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(190) NOT NULL UNIQUE,
    value TEXT NOT NULL
);

CREATE TABLE audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(190) NOT NULL,
    details TEXT NOT NULL,
    created_at DATETIME NOT NULL
);

CREATE TABLE media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    file VARCHAR(190) NOT NULL,
    created_at DATETIME NOT NULL
);

INSERT INTO users (name, email, password_hash, role, created_at) VALUES
('Admin Quantumix', 'admin@quantumix.com', '$2y$12$RLAvMYVYDWQJIM/3bnXIVOWQYgsOLpc3SUSTzWk/ep4Wv278aNyXS', 'admin', NOW());

INSERT INTO services (name_ro, name_en, name_de, name_fr, slug, icon, description_ro, description_en, description_de, description_fr, benefits, created_at) VALUES
('Dezvoltare software personalizat', 'Custom software development', 'Individuelle Softwareentwicklung', 'Développement logiciel sur mesure', 'dezvoltare-software', 'code', 'Construim aplicații web și mobile scalabile, integrate cu sistemele tale existente.', 'We build scalable web and mobile apps integrated with your systems.', 'Wir entwickeln skalierbare Web- und Mobile-Anwendungen.', 'Nous construisons des applications web et mobiles évolutives.', 'Analiză, UX/UI, implementare, mentenanță', NOW()),
('Audit securitate', 'Security audit', 'Sicherheitsaudit', 'Audit de sécurité', 'audit-securitate', 'shield', 'Identificăm vulnerabilități și livrăm planuri clare de remediere.', 'We identify vulnerabilities and deliver remediation plans.', 'Wir identifizieren Schwachstellen.', 'Nous identifions les vulnérabilités.', 'Teste penetrare, rapoarte, hardening', NOW()),
('DevOps & Cloud', 'DevOps & Cloud', 'DevOps & Cloud', 'DevOps & Cloud', 'devops-cloud', 'cloud', 'Automatizăm infrastructura și livrarea continuă.', 'We automate infrastructure and CI/CD.', 'Wir automatisieren Infrastruktur und CI/CD.', 'Nous automatisons l’infrastructure et CI/CD.', 'CI/CD, IaC, monitorizare', NOW());

INSERT INTO projects (name_ro, name_en, name_de, name_fr, slug, category, description_ro, description_en, description_de, description_fr, created_at) VALUES
('Platformă fintech', 'Fintech platform', 'Fintech-Plattform', 'Plateforme fintech', 'platforma-fintech', 'Fintech', 'Implementare platformă de plăți cu onboarding digital.', 'Payment platform with digital onboarding.', 'Zahlungsplattform mit digitalem Onboarding.', 'Plateforme de paiement avec onboarding digital.', NOW()),
('Dashboard IoT', 'IoT Dashboard', 'IoT-Dashboard', 'Tableau de bord IoT', 'dashboard-iot', 'IoT', 'Dashboard pentru monitorizarea infrastructurii smart.', 'Dashboard for smart infrastructure monitoring.', 'Dashboard für Smart-Infrastruktur.', 'Tableau de bord pour l’infrastructure intelligente.', NOW());

INSERT INTO posts (title_ro, title_en, title_de, title_fr, slug, excerpt_ro, excerpt_en, excerpt_de, excerpt_fr, content_ro, content_en, content_de, content_fr, published, published_at, created_at) VALUES
('Cum pregătești infrastructura pentru scalare', 'Scaling infrastructure checklist', 'Skalierungs-Checkliste', 'Checklist de scalabilité', 'infrastructura-scalare', 'Strategii și best practices pentru scalarea infrastructurii.', 'Strategies and best practices for scaling infrastructure.', 'Strategien für die Skalierung.', 'Stratégies de montée en charge.', 'Conținut detaliat despre scalare, monitorizare și optimizare.', 'Detailed content about scaling, monitoring and optimization.', 'Detaillierter Inhalt.', 'Contenu détaillé.', 1, NOW(), NOW());

INSERT INTO testimonials (name, company, message, created_at) VALUES
('Andrei Popescu', 'Fintech Labs', 'Echipa Quantumix a livrat un MVP în 6 săptămâni, fără compromisuri.', NOW()),
('Mara Ionescu', 'RetailNow', 'Colaborarea cu Quantumix a îmbunătățit stabilitatea platformei noastre.', NOW());

INSERT INTO team_members (name, role, photo, created_at) VALUES
('Alex Munteanu', 'CEO', 'team-ceo.jpg', NOW()),
('Ioana Pavel', 'CTO', 'team-cto.jpg', NOW());

INSERT INTO timelines (year, description) VALUES
('2010', 'Fondarea Quantumix cu focus pe software custom.'),
('2016', 'Extindere către servicii cloud și DevOps.'),
('2023', 'Lansare platformă internă de audit securitate.');

INSERT INTO faqs (question, answer, position) VALUES
('Ce tip de proiecte acceptați?', 'Proiecte web, mobile, infrastructură cloud și securitate.', 1),
('Lucrați cu startup-uri?', 'Da, avem pachete dedicate pentru MVP și scale-up.', 2);

INSERT INTO pages (title_ro, title_en, title_de, title_fr, slug, content_ro, content_en, content_de, content_fr, created_at) VALUES
('Termeni și condiții', 'Terms and conditions', 'Allgemeine Geschäftsbedingungen', 'Conditions générales', 'terms', 'Termeni și condiții pentru utilizarea site-ului Quantumix.', 'Terms for using the Quantumix website.', 'AGB für die Nutzung.', 'Conditions d’utilisation.', NOW()),
('Securitate', 'Security', 'Sicherheit', 'Sécurité', 'security', 'Politica de securitate Quantumix.', 'Quantumix security policy.', 'Quantumix Sicherheitsrichtlinie.', 'Politique de sécurité Quantumix.', NOW());

INSERT INTO settings (name, value) VALUES
('site_title', 'Quantumix'),
('seo_description', 'Servicii software & IT pentru companii moderne.'),
('contact_email', 'office@quantumix.com');
