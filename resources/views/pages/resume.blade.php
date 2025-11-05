<?php

session_start(); 

if (empty($_SESSION['user_id'])) { 
  header('Location: login.php'); 
  exit; }

// Personal Info
$name = "Hubert San Gil";
$title = "3rd Year | BS Computer Science";
$location = "Lucena City, Quezon, Philippines";
$about = "I'm currently a third-year student taking up BS Computer Science in Batangas State University Alangilan.
I have a strong passion for technology and programming, and I'm always eager to learn new skills and improve my knowledge in the field. In addition to my academic pursuits,
In my free time I like to do graphic design and explore creative-related technologies.";
$contact_number = "0947 7464 585";
$contact_email = "sangilhubertross@gmail.com";

// Tech Stack
$tech_stack = [
  "Java",
  "Python",
  "HTML",
  "CSS",
  "C++",
  "C#",
];

// Organization Experience
$experience = [
  [
    "year" => "2025",
    "title" => "Committee Head on Technical Affairs",
    "org" => "CICS-SC Alangilan",
    "current" => true
  ],
  [
    "year" => "2025",
    "title" => "Senior Media & Creatives Officer",
    "org" => "ADSS BatStateU Alangilan",
    "current" => true
  ],
  [
    "year" => "2024",
    "title" => "Director for Marketing & Publications",
    "org" => "Junior Philippine Computer Society - BatStateU Alangilan",
    "current" => false
  ]
];

// Education
$education = [
  [
    "year" => "2023 - Present",
    "title" => "Bachelor of Science in Computer Science",
    "org" => "Batangas State University - Alangilan Campus",
    "current" => true
  ],

  [
    "year" => "2017 - 2023",
    "title" => "Senior High School - STEM Strand",
    "org" => "Quezon National High School",
    "current" => false
  ],

    [
    "year" => "2010 - 2017",
    "title" => "Primary School",
    "org" => "Lucena West 1 Elementary School",
    "current" => false
  ]
];


$projects = [
    [
        'title' => 'RememBert',
        'description' => 'A simple Java console-based task tracker',
        'link' => 'https://github.com/hubertsangil/RememBert'
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $name; ?> - Resume</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">
</head>
    
<body>
  <form method="post" action="logout.php" class="logout-form"> 
      <button type="submit" class="logout-button">Log out</button> 
    </form>
  <div class = "resume-page">
  <div class="profile">
    <img src="../assets/images/profile.png" alt="Profile Picture" class="profile-pic">
    <div class="profile-info">
      <div class="profile-details">
        <h1><?php echo $name; ?></h1>
        <p>
          <span class="location-icon" aria-label="Location">
            <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" style="vertical-align: middle;">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z" fill="#fff"/>
            </svg>
          </span>
          <?php echo $location; ?>
        </p>
        <h2><?php echo $title; ?></h2>
      </div>
      <div class="contact-info">
        <p><i class="fas fa-phone"></i><?php echo $contact_number; ?></p>
        <p><i class="fas fa-envelope"></i><?php echo $contact_email; ?></p>
        <div class="contact-buttons">
          <a href="https://github.com/hubertsangil" target="_blank" class="github-button">
    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.82-.26.82-.58 0-.29-.01-1.04-.02-2.05-3.34.73-4.04-1.61-4.04-1.61-.55-1.41-1.34-1.79-1.34-1.79-1.09-.75.08-.73.08-.73 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48.99.11-.77.42-1.3.76-1.6-2.66-.3-5.46-1.33-5.46-5.92 0-1.31.47-2.38 1.23-3.22-.12-.3-.54-1.52.12-3.17 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.3-1.55 3.3-1.23 3.3-1.23.66 1.65.24 2.87.12 3.17.77.84 1.23 1.91 1.23 3.22 0 4.6-2.8 5.62-5.47 5.92.43.37.82 1.1.82 2.22 0 1.6-.01 2.89-.01 3.28 0 .32.21.7.82.58C20.57 21.8 24 17.3 24 12c0-6.63-5.37-12-12-12z"/>
    </svg>
    GitHub
    </a>
      <a href="../public/hubertsangil_resume.pdf" download class="resume-button">
      Download Resume
    </a>
    </div>
      </div>
    </div>
  </div>

  <div class="bento">
    <section class="about">
      <h3>About</h3>
      <p><?php echo $about; ?></p>
    </section>


    <section class="tech-stack">
      <h3>Tech Stack</h3>
      <ul>
        <?php foreach ($tech_stack as $tech): ?>
          <li><?php echo $tech; ?></li>
        <?php endforeach; ?>
      </ul>
    </section>


    <section class="experience">
      <h3> Organization Experience</h3>
      <ul class="timeline">
        <?php foreach ($experience as $exp): ?>
          <li<?php if ($exp['current']) echo ' class="current"'; ?>>
            <div class="timeline-content">
              <div class="timeline-meta">
                <span class="timeline-year"><?php echo $exp['year']; ?></span>
                <div class="timeline-info">
                  <h4><?php echo $exp['title']; ?></h4>
                  <span class="timeline-org"><?php echo $exp['org']; ?></span>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>


    <section class="education">
      <h3>Education</h3>
      <ul class="timeline">
        <?php foreach ($education as $edu): ?>
          <li<?php if ($edu['current']) echo ' class="current"'; ?>>
            <div class="timeline-content">
              <div class="timeline-meta">
                <span class="timeline-year"><?php echo $edu['year']; ?></span>
                <div class="timeline-info">
                  <h4><?php echo $edu['title']; ?></h4>
                  <span class="timeline-org"><?php echo $edu['org']; ?></span>
                </div>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </section>

    <section class="projects">
    <h3>Projects</h3>
    <div class="project-list">
      <ul>
        <?php foreach ($projects as $project): ?>
          <li>
            <a href="<?php echo $project['link']; ?>" target="_blank" class="project-link">
              <h4><?php echo htmlspecialchars($project['title']); ?></h4>
              <p><?php echo htmlspecialchars($project['description']); ?></p>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>
  </div>
</div>
    <footer>
    <p>&copy; 2025 Hubert San Gil. All rights reserved.</p>
  </footer>
</body>
</html>
