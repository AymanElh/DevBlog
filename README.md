# DevBlog - A PHP Blogging Platform  

**DevBlog** is a feature-rich, PHP-based blogging platform leveraging Object-Oriented Programming (OOP) principles. Designed for simplicity and scalability, it provides robust content management features and role-based access control.  

---

## Features  

### Front Office  
- **Authentication System**:  
  - Secure login and registration.
- **User Roles**:  
  - **Guest/User**: Browse and read published articles.
- **Responsive UI**: Modern design using Bootstrap.  
- **Content Interaction**:  
  - Search articles by keyword.  
  - Track article views dynamically.  
- **Profile Management**:  
  - View, update, and delete user profiles.  

### Back Office  
- **Role-Specific Dashboards**:  
  - **Admin**: Full control over users, articles, tags, and categories.  
  - **Author**: Manage personal articles.  
- **Content Management**:  
  - Articles: Create, update, delete, and manage article status (draft/published).  
  - Categories and Tags: Full CRUD functionality.  
  - Users: Manage user accounts and roles.  
- **Access Control**:  
  - Restricts unauthorized access to pages based on roles.  

---

## Technologies  

### Frontend  
- **HTML5**  
- **CSS3 / Bootstrap**  
- **JavaScript**  
  - jQuery  
  - Chart.js  
  - DataTables  

### Backend  
- **PHP 8.0+**  
- **MySQL**  
- **Composer**  
- **Apache (via Laragon)**  

---

## Installation  

### Prerequisites  
1. PHP (8.0+)  
2. MySQL Server  
3. Composer  

### Steps  
1. Clone the repository:  
   ```sh
   git clone https://github.com/yourusername/devblog.git
   cd devblog
   ```  
2. Install dependencies using Composer:  
   ```sh
   composer install
   ```  
3. Import the database schema:  
   ```sh
   mysql -u yourusername -p yourpassword devblog < Database/schema.sql
   ```  
4. Configure your `.env` file:  
   ```sh
   cp .example.env .env
   ```  
   Update database credentials and other settings.  

5. Start your local server and navigate to `http://localhost/devblog`.  

---

## Usage  

- **Admins**: Manage all aspects of the platform, including articles, users, categories, and tags.  
- **Authors**: Create and manage personal articles.  
- **Guests**: Read published articles and sign up to access additional features.  

Default login credentials for testing:  
- **Admin**: `admin@example.com` / `admin123456`  
- **Author**: `author@example.com` / `author123456`  

---

## Folder Structure  

```sh
└── DevBlog
    ├── README.md
    ├── Database/
    │   └── schema.sql
    ├── auth/
    │   └── auth.php
    ├── classes/
    ├── config/
    ├── handlers/
    ├── public/
    ├── views/
    │   └── components/
    └── assets/
```  

---

## Contributions  
Contributions are welcome! Please fork this repository, create a branch, and submit a pull request.  

## License  
This project is licensed under the [MIT License](LICENSE).  
