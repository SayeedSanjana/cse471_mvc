# University Hub / Student Portal MVP

## Overview

The **University Hub** is a web application designed to facilitate communication, information sharing, and academic management within a university setting. This MVP version focuses on key features such as user authentication, faculty directory, advising information, grade management, and a simple homepage for student users.

The project follows the **Model-View-Controller (MVC)** architecture pattern and uses the **PHP** programming language with **MySQL** for database management (with an option to switch to **SQLite** for simplicity). The frontend utilizes **HTML**, **CSS**, **JavaScript**, and **Bootstrap** for basic styling.

## Features

### Core Features (MVP):
1. **User Authentication**: 
   - Simple login and signup system.
   - Passwords are securely hashed for storage.
   - Basic input validation to prevent common vulnerabilities.

2. **Faculty Directory**:
   - Displays a static list of faculty members with basic information (name, department, contact email).

3. **Advising Information**:
   - Placeholder page for advising information. No database integration yet; will be linked to official channels in future iterations.

4. **Grade Management**:
   - Mock grade report showing course names, grades, and GPA calculation. This data is hardcoded for now.

5. **Homepage**:
   - Welcomes the user and provides links to the core features: Faculty Directory and Grade Report.

### Additional Features for Future Iterations:
- Chat functionality
- Recommendations system
- Dynamic database-driven faculty and advising data
- Real-time grade management and GPA calculation

## Tech Stack

- **Backend**: PHP (MVC framework)
- **Frontend**: HTML, CSS, JavaScript, Bootstrap
- **Database**: MySQL (option for SQLite in the MVP for simplicity)
- **Version Control**: Git

## Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/yourusername/university-hub.git
