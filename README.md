# TaskFlow

A lightweight Laravel project and task management application. Users can create and manage projects, assign tasks, comment on tasks, and receive email notifications when tasks are updated.

Built with Laravel (Blade + web routes), featuring events, listeners, observers, notifications, policies, console commands, and seeders. The app is Dockerized with Laravel Sail and uses **Mailpit** (Laravel 12 default) to capture outgoing mail.

---

## Prerequisites

- **Docker** (and Docker Compose)
- **Make**
- **Composer** (for initial `composer install` before Sail)

---

## Setup

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd taskFlow
   ```

2. **Initialize the environment** (installs dependencies, copies `.env`, starts Sail, runs migrations and seeders)
   ```bash
   make init
   ```
   Wait for MySQL to be ready; the command will run `migrate` and `db:seed` for you.

3. **Optional: rebuild from scratch**
   ```bash
   make reset
   ```
   Stops containers with volumes, brings them back up, and runs `migrate:fresh --seed`.

---

## Access URLs

| What        | URL                      |
|------------|---------------------------|
| **App**    | http://localhost          |
| **Mail UI (Mailpit)** | http://localhost:8025 |

Mailpit is used to capture all outgoing mail (e.g. task-updated notifications). Open the Mailpit UI to inspect emails sent by the app.

---

## Running console commands

Use the Makefile to run Artisan inside Sail:

```bash
# Tasks report table in the terminal
make artisan cmd="report:tasks"

# Export tasks report to Excel (storage/app/reports/, timestamped filename)
make artisan cmd="report:export"
```

Or run Sail directly:

```bash
./vendor/bin/sail artisan report:tasks
./vendor/bin/sail artisan report:export
```

---

## Seeded credentials

After `make init` or `make reset`:

| Login / purpose | Email                | Password   |
|-----------------|----------------------|------------|
| Demo user       | demo@taskflow.test   | **password** |
| Other Faker users | (various emails)   | **password** |
| Juan            | juan@julura.co.za    | *(see seeder)* |

Demo and Faker-generated users use **password**. Juan has a separate password (defined in the seeders).

---

## Implemented features

- **Authentication** – Laravel Breeze (register, login, password reset, email verification).
- **Dashboard** – `/dashboard` lists only projects you own or are a member of.
- **Projects** – Full CRUD (create, view, edit, delete). Only owners can edit/delete; members can create tasks.
- **Tasks** – Create (title, description; status defaults to Pending), edit, update status/assignee, delete. Task list and per-project task management with status (Pending, In Progress, Completed).
- **Comments** – Add comments on tasks (store on task show page).
- **Task history** – `TaskObserver` records create/update/delete in `task_histories`.
- **Notifications** – On task update, `TaskUpdated` is dispatched; `NotifyProjectMembers` notifies the project owner and task assignee via `TaskUpdatedNotification` (mail channel, queued). Mail is captured in Mailpit.
- **Project stats** – On each project’s detail page: total tasks, completed, pending, completion % (using Laravel Collections).
- **Policies** – `ProjectPolicy` (owner edit/delete; owner or member create tasks), `TaskPolicy` (owner/member/assignee can view and modify tasks).
- **Console** – `report:tasks` (terminal table: Project, Total Tasks, Completed, Pending, Completion %); `report:export` (Excel export to `storage/app/reports/tasks_report_{timestamp}.xlsx` via Laravel Excel).
- **Seeders** – Users, Projects, Tasks, Comments (Faker); all user passwords set to **password** for demos.
- **Docker / Sail** – `compose.yaml` with `laravel.test`, `mysql`, and **Mailpit**. Makefile targets: `up`, `down`, `init`, `artisan`, `reset`.

---

## Makefile reference

| Target   | Description                                      |
|----------|--------------------------------------------------|
| `make up`     | Start Sail containers in the background          |
| `make down`   | Stop containers                                  |
| `make init`   | Install deps, copy `.env`, start Sail, migrate & seed |
| `make artisan cmd="..."` | Run an Artisan command (e.g. `report:tasks`)   |
| `make reset`  | Tear down with volumes, bring up again, migrate:fresh --seed |

---

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
