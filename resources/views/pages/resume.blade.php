<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>{{ $name }} - Resume</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css?family=DM+Sans&display=swap" rel="stylesheet">
</head>
    
<body>
  <form method="POST" action="{{ route('logout') }}" class="logout-form"> 
      @csrf
      <button type="submit" class="logout-button">Log out</button> 
    </form>
  <div class = "resume-page">
  <div class="profile">
    <img src="assets/images/profile.png" alt="Profile Picture" class="profile-pic">
    <div class="profile-info">
      <div class="profile-details">
        <h1>{{ $name }}</h1>
        <p>
          <span class="location-icon" aria-label="Location">
            <svg width="1em" height="1em" viewBox="0 0 24 24" fill="none" style="vertical-align: middle;">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5z" fill="#fff"/>
            </svg>
          </span>
          <span class="location-text"></span>{{ $location }}</span>
        </p>
        <h2>{{ $title }}</h2>
      </div>
      <div class="contact-info">
        <div>
          <p><i class="fas fa-phone"></i>{{ $contact_number }}</p>
          <p><i class="fas fa-envelope"></i>{{ $contact_email }}</p>
        </div>
        <div class="contact-buttons">
          <a class="github-button" href="https://github.com/hubertsangil" target="_blank" class="github-button">
    <svg width="1em" height="1em" viewBox="0 0 24 24" fill="currentColor">
      <path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.44 9.8 8.2 11.39.6.11.82-.26.82-.58 0-.29-.01-1.04-.02-2.05-3.34.73-4.04-1.61-4.04-1.61-.55-1.41-1.34-1.79-1.34-1.79-1.09-.75.08-.73.08-.73 1.2.08 1.83 1.23 1.83 1.23 1.07 1.83 2.8 1.3 3.48.99.11-.77.42-1.3.76-1.6-2.66-.3-5.46-1.33-5.46-5.92 0-1.31.47-2.38 1.23-3.22-.12-.3-.54-1.52.12-3.17 0 0 1-.32 3.3 1.23a11.5 11.5 0 0 1 6 0c2.3-1.55 3.3-1.23 3.3-1.23.66 1.65.24 2.87.12 3.17.77.84 1.23 1.91 1.23 3.22 0 4.6-2.8 5.62-5.47 5.92.43.37.82 1.1.82 2.22 0 1.6-.01 2.89-.01 3.28 0 .32.21.7.82.58C20.57 21.8 24 17.3 24 12c0-6.63-5.37-12-12-12z"/>
    </svg>
    GitHub
    </a>
      <a href="assets/files/hubertsangil_resume.pdf" download class="resume-button">
      Download Resume
    </a>
    </div>
      </div>
    </div>
  </div>

  <div class="bento">
    <section class="about">
      <h3>About</h3>
      <p>{{ $about }}</p>
    </section>


    <section class="tech-stack">
      <h3>Tech Stack</h3>
      <ul>
        @foreach ($tech_stack as $tech)
          <li>{{ $tech }}</li>
        @endforeach
      </ul>
    </section>


    <section class="experience">
      <h3> Organization Experience</h3>
      <ul class="timeline">
        @foreach ($experience as $exp)
          <li @if($exp['current']) class="current" @endif>
            <div class="timeline-content">
              <div class="timeline-meta">
                <span class="timeline-year">{{ $exp['year'] }}</span>
                <div class="timeline-info">
                  <h4>{{ $exp['title'] }}</h4>
                  <span class="timeline-org">{{ $exp['org'] }}</span>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </section>


    <section class="education">
      <h3>Education</h3>
      <ul class="timeline">
        @foreach ($education as $edu)
          <li @if($edu['current']) class="current" @endif>
            <div class="timeline-content">
              <div class="timeline-meta">
                <span class="timeline-year">{{ $edu['year'] }}</span>
                <div class="timeline-info">
                  <h4>{{ $edu['title'] }}</h4>
                  <span class="timeline-org">{{ $edu['org'] }}</span>
                </div>
              </div>
            </div>
          </li>
        @endforeach
      </ul>
    </section>

    <section class="projects">
    <h3>Projects</h3>
    <div class="project-list">
      <ul>
        @foreach ($projects as $project)
          <li>
            <a href="{{ $project['link'] }}" target="_blank" class="project-link">
              <h4>{{ $project['title'] }}</h4>
              <p>{{ $project['description'] }}</p>
            </a>
          </li>
        @endforeach
      </ul>
    </div>
  </section>
  </div>
</div>
    <footer>
    <p>&copy; 2025 {{ $name }}. All rights reserved.</p>
  </footer>
</body>
</html>
