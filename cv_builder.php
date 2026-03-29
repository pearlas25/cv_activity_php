<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $job_title = htmlspecialchars($_POST['job_title']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $summary = nl2br(htmlspecialchars($_POST['summary']));
    $skills = htmlspecialchars($_POST['skills']);

    // Handle Timelines
    $exp_lines = explode("\n", trim($_POST['experience']));
    $edu_lines = explode("\n", trim($_POST['education']));

    // File Upload
    $target_file = "https://via.placeholder.com/150"; 
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }

    if (isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["error"] == 0) {
        $file_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $target_path = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_path)) {
            $target_file = $target_path;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="cv-page-pro">
    <div class="cv-paper">
        <header class="pro-header">
            <img src="<?php echo $target_file; ?>" class="pro-photo">
            <div class="header-text-block">
                <h1 class="pro-name"><?php echo $first_name . " " . $last_name; ?></h1>
                <p class="pro-title"><?php echo $job_title; ?></p>
            </div>
        </header>

        <div class="pro-grid">
            <aside class="left-column">
                <section class="pro-section">
                    <h2 class="section-heading">About Me</h2>
                    <p class="about-text"><?php echo $summary; ?></p>
                </section>
                <div class="contact-info">
                    <div class="contact-item"><i class="fa fa-phone"></i><span><?php echo $phone; ?></span></div>
                    <div class="contact-item"><i class="fa fa-envelope"></i><span><?php echo $email; ?></span></div>
                    <div class="contact-item"><i class="fa fa-map-marker"></i><span><?php echo $address; ?></span></div>
                </div>
            </aside>

            <main class="right-column">
                <h2 class="pro-heading-alt">EXPERIENCE</h2>
                <div class="timeline-container">
                    <?php foreach ($exp_lines as $line): if(trim($line)): $p = explode('|', $line); ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <h3 class="exp-company"><?php echo $p[0] ?? ''; ?></h3>
                            <p class="exp-subline"><?php echo ($p[1] ?? '') . " | " . ($p[3] ?? ''); ?></p>
                            <p class="exp-desc"><?php echo $p[4] ?? ''; ?></p>
                        </div>
                    <?php endif; endforeach; ?>
                </div>

                <h2 class="pro-heading-alt">EDUCATION</h2>
                <div class="timeline-container">
                    <?php foreach ($edu_lines as $line): if(trim($line)): $p = explode('|', $line); ?>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <h3 class="exp-company"><?php echo $p[0] ?? ''; ?></h3>
                            <p class="exp-subline">
                                <?php echo ($p[1] ?? '') . " | " . ($p[3] ?? ''); ?>
                            </p>
                            <p class="exp-desc"><?php echo $p[4] ?? ''; ?></p>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </main>
        </div>
    </div>
</body>
</html>