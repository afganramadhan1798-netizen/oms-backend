# Overtime Management System (OMS) – Lenna.ai

**Overtime Management System (OMS)** is a web-based application designed to digitalize and centralize the employee overtime management process at Lenna.ai.

The system aims to improve overtime visibility, tracking, and monitoring, particularly from the Product Management perspective. It helps managers track overtime activities, monitor working hours, review overtime requests, and access structured historical data for evaluation and decision-making.

---

## 1. Project Overview

### Background

Overtime activities require proper documentation and monitoring to ensure transparency and effective workforce management.

One of the main challenges at Lenna.ai is the difficulty of tracking overtime activities from the Product Management perspective. Without a centralized system, it becomes challenging to identify employees involved in overtime, monitor total overtime hours, review historical records, and evaluate overtime activities across teams or projects.

To address these challenges, the Overtime Management System (OMS) is developed as a centralized platform that digitalizes the overtime workflow.

### Objectives

- Centralize all overtime records in one system.
- Improve overtime tracking and monitoring for Product Management.
- Provide clear visibility of employee overtime activities.
- Simplify overtime submission and approval processes.
- Maintain structured overtime history and approval records.
- Support management evaluation through accurate overtime data.

---

## 2. Core Problems

The system addresses several key problems:

1. **Limited Overtime Visibility**  
   Product Managers have difficulty identifying and monitoring employees who participate in overtime activities.

2. **Unstructured Overtime Records**  
   Overtime information is not centralized, making historical tracking difficult.

3. **Difficult Working Hour Monitoring**  
   There is no convenient way to review total overtime hours per employee or team.

4. **Limited Approval Transparency**  
   Tracking approval progress and identifying responsible approvers can be challenging.

5. **Inefficient Evaluation**  
   Management needs structured historical data to evaluate overtime activities and workforce efficiency.

---

## 3. User Roles & Permissions

OMS implements a role-based access control system (RBAC), where each user has different permissions based on their responsibilities.

| Role | Main Responsibilities |
|---|---|
| Employee | View personal overtime records, status, and history. |
| Product Manager (PM) | Create overtime requests, review submissions, and monitor team overtime activities. |
| Human Resources (HR) | Review overtime requests and validate them according to company policies. |
| Finance | Review overtime information and support bonus or compensation calculations. |
| Management (HOP/HOO) | Provide required approvals and monitor overtime activities across teams. |

---

## 4. Main Features

### 4.1 Authentication & User Management
- Secure login using email and password.
- Role-based access control.
- User profile management.
- Different dashboard access based on user roles.
- User account activation and deactivation.

### 4.2 Overtime Request Management
- Create overtime requests through a structured form.
- Select team members involved in overtime.
- Specify overtime date and working hours.
- Provide overtime descriptions and business justifications.
- Automatically calculate overtime duration.
- Validate overtime submission based on business rules.

### 4.3 Overtime Review & Approval
- Internal review by Product Manager.
- HR review and validation.
- Finance review for compensation calculations.
- Management approval when required.
- Approve or reject overtime requests.
- Store approval history, including approver identity, timestamp, and notes.

### 4.4 Overtime Tracking
This is one of the core features of OMS, particularly for Product Management.

- Monitor employees participating in overtime.
- Track total overtime hours.
- View overtime activities by team or project.
- Identify the responsible Product Manager.
- Monitor overtime request statuses.
- View approval history.
- Access historical overtime records.

### 4.5 Employee Dashboard
- View personal overtime activities.
- Monitor overtime approval status.
- View total overtime hours.
- Access personal overtime history.
- View overtime details and relevant approval information.

### 4.6 Reporting & Monitoring
- View overtime summaries.
- Monitor total overtime hours by employee.
- Monitor overtime activities by team.
- Filter records by date, employee, or project.
- Support management evaluation and reporting.

---

## 5. Overtime Workflow

The main overtime workflow consists of the following steps:

```text
USER LOGIN
    |
    v
ROLE IDENTIFICATION
    |
    v
PRODUCT MANAGER
    |
    v
CREATE OVERTIME REQUEST
    |
    v
INTERNAL PM REVIEW
    |
    v
SUBMIT REQUEST
    |
    v
HR & FINANCE REVIEW
    |
    v
MANAGEMENT APPROVAL
(When Required)
    |
    v
OVERTIME STATUS UPDATED
    |
    v
OVERTIME EXECUTION
    |
    v
DATA RECORDING & TRACKING
    |
    v
REPORTING & EVALUATION
```

Employees can access their relevant overtime information through their personal dashboard, while Product Management and authorized management users can monitor overtime activities according to their access permissions.

---

## 6. Business Rules

The system follows these initial business rules:

- Overtime must start at 19:00 or later on weekdays.
- Minimum overtime duration is 4 hours.
- Every overtime request must include a clear work description and justification.
- Every request must go through the required review and approval process.
- Approval activities must be recorded in the system.
- Employees can only access overtime records relevant to their accounts.
- Users can only access features permitted by their assigned roles.

*Note: Final overtime policies, including weekend scheduling and approval requirements, should follow the official company regulations.*

---

## 7. Technology Stack

The following technologies are intended for the application development:

| Category | Technology |
|---|---|
| Frontend | Vue.js |
| Styling | CSS / Tailwind CSS |
| Backend | Laravel |
| Database | MySQL |
| API | REST API |
| Authentication | Laravel Sanctum |
| Development Environment | Laragon |
| API Testing | Postman |
| Version Control | Git & GitHub |

---

## 8. Project Scope

The project focuses on four main development areas:

1. **Overtime Form Development**  
   Designing the overtime submission form based on HR and Product Management requirements.

2. **System Requirements**  
   Defining system functionality, business rules, and technical requirements.

3. **Product Requirement Document (PRD)**  
   Documenting user needs, system objectives, workflows, and feature specifications.

4. **User Management**  
   Implementing user roles, permissions, authentication, and access control.

---

## 9. Project Timeline

| Information | Details |
|---|---|
| Project Duration | 5 Weeks |
| Development Team | 2 People |
| Target Deadline | 31 May |
| Consultation | Lenna.ai Team |

### Development Phases

- Week 1: Research, requirement gathering, and PRD.
- Week 2: UI/UX design and system planning.
- Week 3–4: Frontend and backend development.
- Week 5: Integration, testing, and improvements.

---

## 10. Expected Outcomes

Through the implementation of OMS, Lenna.ai is expected to achieve:

- More structured overtime documentation.
- Better overtime visibility for Product Management.
- Easier monitoring of employee overtime activities.
- Transparent approval workflows.
- More accessible historical overtime data.
- Better workforce evaluation and management decisions.

---

## 11. Future Development

Potential improvements for future iterations include:

- Automated email and in-app notifications.
- Overtime attendance verification.
- Export reports to Excel and PDF.
- Advanced analytics and overtime trends.
- Calendar integration.
- Automated compensation summaries.

---

## 12. Project Team

**Development Team:** 2 Members  
**Project Consultation:** Lenna.ai Team

---

## 13. Conclusion

Overtime Management System (OMS) is designed to transform the overtime management process at Lenna.ai into a more structured, transparent, and trackable digital workflow.

By centralizing overtime requests, approval records, employee activities, and historical data, OMS aims to help Product Management monitor team overtime more effectively while providing employees with better visibility into their personal overtime records.

**The main focus is not only managing overtime requests, but also ensuring that every overtime activity can be properly tracked, monitored, and evaluated.**

---

*Overtime Management System (OMS) – Lenna.ai*  
*Project Documentation*
