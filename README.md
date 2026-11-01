# R.O.S MATE

R.O.S MATE (Republic of Skate Mate) is a skateboard community and product showcase.

## Run in GitHub Codespaces

This repository is configured for GitHub Codespaces. You do **not** need to install XAMPP, MySQL, or a database server.

1. Open this repository on GitHub.
2. Select **Code → Codespaces → Create codespace** (choose the `repair/ros-mate-recovery` branch while reviewing this repair).
3. Wait for the PHP environment to finish building.
4. In the Codespaces terminal, run:

   ```bash
   php -S 0.0.0.0:8000 -t .
   ```

5. Open the forwarded port **8000** when Codespaces prompts you, or use the **Ports** tab and open port 8000.

The app homepage is `/`. SQLite creates `storage/ros_mate.sqlite` automatically on first request. No seeded account or hardcoded password is provided: create your own account at **Create account**.

## Features

- Public home, about, contact, and skateboard catalogue pages.
- Account registration and login with PHP password hashing.
- SQLite persistence (users and contact messages).
- Prepared SQL statements, CSRF validation, session ID rotation, secure session cookies, and output escaping.
- Member dashboard and POST-only logout.
- GitHub Actions PHP syntax checks.

## Data and configuration

- SQLite database: `storage/ros_mate.sqlite` (created automatically).
- Keep the database and secrets out of Git. The database is ignored by `.gitignore`.
- To reset local development data, stop the PHP server and delete `storage/ros_mate.sqlite`. This permanently deletes locally stored test accounts and contact messages.

## Notes

GitHub itself stores source code; it does not execute PHP pages in the repository viewer. Use Codespaces to run the PHP app. GitHub Pages is not suitable for this PHP backend. This configuration is for development/testing inside Codespaces, not production hosting.
