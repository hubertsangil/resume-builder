<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Resume Builder</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
  <div class="builder-container">
    <div class="builder-header">
      <h1>Resume Builder</h1>
      <div class="builder-header-buttons">
        @if($resume)
          <a href="{{ route('resume.public', ['slug' => $resume->slug]) }}" target="_blank" class="view-resume-btn">View Public Resume</a>
        @endif
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
          @csrf
          <button type="submit" class="builder-logout-button">Logout</button>
        </form>
      </div>
    </div>
    
    @if(session('success'))
      <div class="success-alert">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('builder.store') }}" id="resumeForm">
      @csrf

      <!-- Personal Info -->
      <div class="form-section">
        <h2>Personal Information</h2>
        <div class="form-group">
          <label>Full Name *</label>
          <input type="text" name="name" value="{{ old('name', $resume->name ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Title/Position *</label>
          <input type="text" name="title" value="{{ old('title', $resume->title ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Location *</label>
          <input type="text" name="location" value="{{ old('location', $resume->location ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>About *</label>
          <textarea name="about" required>{{ old('about', $resume->about ?? '') }}</textarea>
        </div>
        <div class="form-group">
          <label>Contact Number *</label>
          <input type="text" name="contact_number" value="{{ old('contact_number', $resume->contact_number ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>Email *</label>
          <input type="email" name="contact_email" value="{{ old('contact_email', $resume->contact_email ?? '') }}" required>
        </div>
        <div class="form-group">
          <label>GitHub URL</label>
          <input type="url" name="github_url" value="{{ old('github_url', $resume->github_url ?? '') }}">
        </div>
        <div class="form-group">
          <label>Resume PDF URL</label>
          <input type="url" name="resume_pdf_url" value="{{ old('resume_pdf_url', $resume->resume_pdf_url ?? '') }}">
        </div>
      </div>

      <!-- Tech Stack -->
      <div class="form-section">
        <h2>Tech Stack</h2>
        <div class="form-group">
          <label>Technologies (comma-separated)</label>
          <input type="text" name="tech_stack" value="{{ old('tech_stack', $resume ? implode(', ', json_decode($resume->tech_stack, true) ?: []) : '') }}" placeholder="Java, Python, HTML, CSS">
        </div>
      </div>

      <!-- Experience -->
      <div class="form-section">
        <h2>Experience</h2>
        <div id="experience-container">
          @php
            $experiences = $resume ? json_decode($resume->experience, true) ?: [] : [];
            if (empty($experiences)) $experiences = [['year' => '', 'title' => '', 'org' => '', 'current' => false]];
          @endphp
          @foreach($experiences as $index => $exp)
            <div class="array-item" data-index="{{ $index }}">
              <div class="form-group">
                <label>Year</label>
                <input type="text" name="experience[{{ $index }}][year]" value="{{ $exp['year'] ?? '' }}" placeholder="2025">
              </div>
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="experience[{{ $index }}][title]" value="{{ $exp['title'] ?? '' }}" placeholder="Job Title">
              </div>
              <div class="form-group">
                <label>Organization</label>
                <input type="text" name="experience[{{ $index }}][org]" value="{{ $exp['org'] ?? '' }}" placeholder="Company Name">
              </div>
              <div class="form-group">
                <label>
                  <input type="checkbox" name="experience[{{ $index }}][current]" value="1" {{ ($exp['current'] ?? false) ? 'checked' : '' }}>
                  Current Position
                </label>
              </div>
              @if($index > 0)
                <button type="button" class="remove-item-btn" onclick="removeExperience(this)">Remove</button>
              @endif
            </div>
          @endforeach
        </div>
        <button type="button" class="add-item-btn" onclick="addExperience()">Add Experience</button>
      </div>

      <!-- Education -->
      <div class="form-section">
        <h2>Education</h2>
        <div id="education-container">
          @php
            $educations = $resume ? json_decode($resume->education, true) ?: [] : [];
            if (empty($educations)) $educations = [['year' => '', 'title' => '', 'org' => '', 'current' => false]];
          @endphp
          @foreach($educations as $index => $edu)
            <div class="array-item" data-index="{{ $index }}">
              <div class="form-group">
                <label>Year</label>
                <input type="text" name="education[{{ $index }}][year]" value="{{ $edu['year'] ?? '' }}" placeholder="2023 - Present">
              </div>
              <div class="form-group">
                <label>Degree/Title</label>
                <input type="text" name="education[{{ $index }}][title]" value="{{ $edu['title'] ?? '' }}" placeholder="Bachelor of Science">
              </div>
              <div class="form-group">
                <label>Institution</label>
                <input type="text" name="education[{{ $index }}][org]" value="{{ $edu['org'] ?? '' }}" placeholder="University Name">
              </div>
              <div class="form-group">
                <label>
                  <input type="checkbox" name="education[{{ $index }}][current]" value="1" {{ ($edu['current'] ?? false) ? 'checked' : '' }}>
                  Current
                </label>
              </div>
              @if($index > 0)
                <button type="button" class="remove-item-btn" onclick="removeEducation(this)">Remove</button>
              @endif
            </div>
          @endforeach
        </div>
        <button type="button" class="add-item-btn" onclick="addEducation()">Add Education</button>
      </div>

      <!-- Projects -->
      <div class="form-section">
        <h2>Projects</h2>
        <div id="projects-container">
          @php
            $projects = $resume ? json_decode($resume->projects, true) ?: [] : [];
            if (empty($projects)) $projects = [['title' => '', 'description' => '', 'link' => '']];
          @endphp
          @foreach($projects as $index => $project)
            <div class="array-item" data-index="{{ $index }}">
              <div class="form-group">
                <label>Title</label>
                <input type="text" name="projects[{{ $index }}][title]" value="{{ $project['title'] ?? '' }}" placeholder="Project Name">
              </div>
              <div class="form-group">
                <label>Description</label>
                <textarea name="projects[{{ $index }}][description]">{{ $project['description'] ?? '' }}</textarea>
              </div>
              <div class="form-group">
                <label>Link</label>
                <input type="url" name="projects[{{ $index }}][link]" value="{{ $project['link'] ?? '' }}" placeholder="https://github.com/...">
              </div>
              @if($index > 0)
                <button type="button" class="remove-item-btn" onclick="removeProject(this)">Remove</button>
              @endif
            </div>
          @endforeach
        </div>
        <button type="button" class="add-item-btn" onclick="addProject()">Add Project</button>
      </div>

      <button type="submit" class="submit-btn">Save Resume</button>
    </form>
  </div>

  <script>
    let expIndex = {{ count($experiences ?? []) }};
    let eduIndex = {{ count($educations ?? []) }};
    let projIndex = {{ count($projects ?? []) }};

    function addExperience() {
      const container = document.getElementById('experience-container');
      const item = document.createElement('div');
      item.className = 'array-item';
      item.innerHTML = `
        <div class="form-group">
          <label>Year</label>
          <input type="text" name="experience[${expIndex}][year]" placeholder="2025">
        </div>
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="experience[${expIndex}][title]" placeholder="Job Title">
        </div>
        <div class="form-group">
          <label>Organization</label>
          <input type="text" name="experience[${expIndex}][org]" placeholder="Company Name">
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" name="experience[${expIndex}][current]" value="1">
            Current Position
          </label>
        </div>
        <button type="button" class="remove-item-btn" onclick="removeExperience(this)">Remove</button>
      `;
      container.appendChild(item);
      expIndex++;
    }

    function removeExperience(btn) {
      btn.closest('.array-item').remove();
    }

    function addEducation() {
      const container = document.getElementById('education-container');
      const item = document.createElement('div');
      item.className = 'array-item';
      item.innerHTML = `
        <div class="form-group">
          <label>Year</label>
          <input type="text" name="education[${eduIndex}][year]" placeholder="2023 - Present">
        </div>
        <div class="form-group">
          <label>Degree/Title</label>
          <input type="text" name="education[${eduIndex}][title]" placeholder="Bachelor of Science">
        </div>
        <div class="form-group">
          <label>Institution</label>
          <input type="text" name="education[${eduIndex}][org]" placeholder="University Name">
        </div>
        <div class="form-group">
          <label>
            <input type="checkbox" name="education[${eduIndex}][current]" value="1">
            Current
          </label>
        </div>
        <button type="button" class="remove-item-btn" onclick="removeEducation(this)">Remove</button>
      `;
      container.appendChild(item);
      eduIndex++;
    }

    function removeEducation(btn) {
      btn.closest('.array-item').remove();
    }

    function addProject() {
      const container = document.getElementById('projects-container');
      const item = document.createElement('div');
      item.className = 'array-item';
      item.innerHTML = `
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="projects[${projIndex}][title]" placeholder="Project Name">
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="projects[${projIndex}][description]"></textarea>
        </div>
        <div class="form-group">
          <label>Link</label>
          <input type="url" name="projects[${projIndex}][link]" placeholder="https://github.com/...">
        </div>
        <button type="button" class="remove-item-btn" onclick="removeProject(this)">Remove</button>
      `;
      container.appendChild(item);
      projIndex++;
    }

    function removeProject(btn) {
      btn.closest('.array-item').remove();
    }
  </script>
</body>
</html>

