<?php
require_once __DIR__ . '/partials/header.php';
$messageSent = false;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$csrf->validate($_POST['csrf'] ?? '')) {
        $error = 'Token invalid. Reîncearcă.';
    } elseif (!empty($_POST['website'])) {
        $error = 'Spam detectat.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $message = trim($_POST['message'] ?? '');
        if ($name && $email && $message) {
            $db->execute(
                'INSERT INTO contact_messages (name, email, message, created_at) VALUES (:name, :email, :message, NOW())',
                [':name' => $name, ':email' => $email, ':message' => $message]
            );
            Mailer::send($config['site']['email'], 'Mesaj contact Quantumix', $message, $config['mail']['from']);
            $messageSent = true;
        } else {
            $error = 'Completează toate câmpurile.';
        }
    }
}
?>
<section class="page-hero">
    <div class="container">
        <h1>Contact</h1>
        <p>Spune-ne despre proiectul tău și revenim rapid cu un răspuns.</p>
    </div>
</section>
<section class="section">
    <div class="container grid-2">
        <div>
            <h2>Trimite un mesaj</h2>
            <?php if ($messageSent): ?>
                <p class="success">Mesajul a fost trimis.</p>
            <?php else: ?>
                <?php if ($error): ?>
                    <p class="error"><?= Utils::e($error) ?></p>
                <?php endif; ?>
                <form method="post" class="form">
                    <input type="hidden" name="csrf" value="<?= $csrf->token() ?>">
                    <input type="text" name="website" class="hidden" tabindex="-1" autocomplete="off">
                    <input type="text" name="name" placeholder="Nume" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <textarea name="message" placeholder="Mesaj" required></textarea>
                    <button class="btn" type="submit">Trimite</button>
                </form>
            <?php endif; ?>
        </div>
        <div>
            <h2>Ne găsești aici</h2>
            <div class="map">
                <iframe
                    src="https://maps.google.com/maps?q=Bucharest&t=&z=13&ie=UTF8&iwloc=&output=embed"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/partials/footer.php'; ?>
