# TaskTracker

A web application for task management with role-based access control, built with PHP and PostgreSQL.

## What it does

TaskTracker allows users to:
- **Create and manage tasks** with titles, descriptions, deadlines, and priorities
- **Assign different roles** to users for each task (Owner, Assigned, Viewer)
- **Track task progress** with status updates (To do, In progress, Done)
- **Break down tasks** into subtasks
- **View task details** with role-based permissions

## Key Features

- User authentication (login/registration)
- Task creation, editing, and deletion
- Priority levels (High, Medium, Low) with visual indicators
- Role-based access control (Owner can delete, Assigned can edit, Viewer can only view)
- Responsive design for desktop and mobile
- Subtasks support
- Session management

## Technology Stack

- **Backend**: PHP with MVC architecture
- **Database**: PostgreSQL
- **Frontend**: HTML, CSS, JavaScript
- **Deployment**: Docker ready

## Database

The application uses PostgreSQL with the following main tables:
- `users` - User accounts
- `tasks` - Task information
- `user_tasks` - User-task relationships with roles
- `subtasks` - Task breakdown components

**Database dump**: [backup.sql](./docs/backup.sql)

## Database ERD

![ERD Diagram](./docs/dbERD.drawio.svg)

## Initial Design

[📄 See the initial application design created in Figma (PDF)](docs\initialAppProjectFigma.pdf)

## Future Enhancements

- Calendar integration
- Email notifications
- File attachments
- Team collaboration features
- Advanced reporting
