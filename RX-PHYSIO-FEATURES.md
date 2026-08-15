# Rx Physio - Complete Features & Functions

**Brand:** Rx Physio  
**Platform:** Web (Laravel 10 + AdminLTE 3)  
**Database:** MySQL  
**Auth:** Role-Based Access Control (Spatie Laravel Permissions)  
**Roles:** Super-Admin, Owner, DIRECTOR, Admin, HomePhysiotherapist

---

## 1. Dashboard & Financial Overview

| Feature | Description |
|---|---|
| **Dashboard Overview** | Today's stats: new patients, cash/online collections, refunds, cash/online expenses, total dues, net cash, service-type breakdown |
| **Active Packages Panel** | Lists all active treatment packages with branch, patient, sitting progress |
| **Today's New Patients List** | Latest 20 patients registered today |
| **Payment Mode Breakdown** | Today's totals per payment mode (cash, online, etc.) |
| **Financial Year Totals** | Year-to-date totals for payments, collections, discounts, dues (Apr-Mar financial year) |
| **Profit Report** | Date-range based profit = collections - expenses |
| **Patient Lists (by date range)** | List patients registered in a date range |
| **Custom Daily Report** | Single-day report with cash/online collections, expenses, refunds by branch |
| **Range Daily Report** | Date-range report for collections/expenses |
| **Today's Drill-down Reports** | Cash today, online today, patient today, cash/online expenses, total expenses, refund today, net cash today, branch details |
| **Service Detail** | Today's collections for a specific service type |
| **Collection Detail** | Today's collections for a specific payment mode |
| **Dues Details** | Patients with outstanding dues |
| **Today Branch Details** | Per-branch breakdown: cash, online, refunds, expenses, service types, payment modes |
| **Discontinued Patients** | Patients past due date (for tele-calling/re-engagement) |
| **Hide Patients** | Bulk-hide selected patients from lists |
| **Hidden Patients List** | View all hidden patients |

---

## 2. OPD Registration (Out Patient Department)

| Feature | Description |
|---|---|
| **Register New Patient** | Full registration: name, age, mobile, DOB, address, branch, diagnosis, image upload; auto-creates payment + collection + schedule |
| **Old OPD Patient** | Register a follow-up visit for existing patient; creates new payment + collection + schedule |
| **Smart Sitting Scheduler** | Auto-generates sitting dates based on daily visits, total sessions, day gaps, and weekend rules |
| **AJAX Service Lookup** | Quick service type retrieval |

---

## 3. Patient Management

| Feature | Description |
|---|---|
| **Patients List** | Paginated list with branch & date filters; role-restricted viewing |
| **Patient Profile** | Full profile: active payment, schedules, attendance count, uploaded images |
| **Edit/Update Patient** | Update name, age, mobile, address, image |
| **Soft Delete Patient** | Moves to trash with audit logging |
| **Patient Schedule View** | View schedules for active payment |
| **Change Branch** | Change patient's branch (3 modes: current payment / all payments / everything) |
| **Hide/Unhide Patient** | Toggle patient visibility |
| **Live Search (AJAX)** | Search by name, phone, mobile, or patient ID |
| **Search by Registration Date** | Find patients registered between two dates |
| **Today's Patients** | Patients who attended today |
| **Trash: View/Restore/Force Delete** | Manage soft-deleted patients with bulk operations |

---

## 4. Payments & Collections

| Feature | Description |
|---|---|
| **Create Payment** | Record payment linked to a treatment package |
| **View Payment** | Payment details with collections |
| **Edit Payment Date** | Change payment date |
| **Make Payment Active** | Set one payment active, deactivate others |
| **Delete Payment** | Soft-deletes payment + its collections |
| **Create Collection (Deposit)** | Record receipt/payment collection against a payment |
| **Edit/Update Collection** | Modify collection amount, date |
| **Delete Collection** | Soft-deletes |
| **Collection Print Receipt** | Formatted receipt for any collection |
| **Full Refund** | Creates refund record, marks payment inactive |
| **Refund Detail View** | Shows schedules for refund calculation |
| **Cash of Day** | Cash collections for today |
| **Today Cash Report** | Detailed today's cash report with all modes |
| **Month-wise Collections** | Monthly aggregation of all collections |
| **Trash/Bulk Operations** | Soft-delete, restore, force-delete with bulk support |

---

## 5. Scheduling & Attendance

| Feature | Description |
|---|---|
| **Create Schedule** | Create sitting entries for a payment |
| **Edit/Update Schedule** | Change sitting date/attendance |
| **Mark Absent** | Marks sitting absent, auto-creates extra sitting on next valid date (handles weekend rules, per-day caps, total session limits) |
| **Revert Absent** | Reverts absence, removes auto-created extra sitting |
| **Delete Schedule** | Soft-deletes |
| **Today's Patients** | All patients scheduled today with branch filter & search |
| **Daily Patients (Date Range)** | Patients attended between two dates |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 6. Expenses & Expense Categories

| Feature | Description |
|---|---|
| **Expenses List** | Paginated list scoped to user's branches |
| **Create Expense** | Title, date, amount, category, branch, payment mode |
| **Edit/Update Expense** | Modify expense details |
| **Delete Expense** | Soft-deletes |
| **Filtered Expense Data** | Filter by branch, category, date range |
| **Expense Report** | Predefined filters: today, yesterday, week, month, year |
| **Expense Custom Report** | Custom date range |
| **Expense Categories CRUD** | Add/edit/delete expense categories |
| **Trash Operations** | Soft-delete, restore, force-delete for expenses and categories |

---

## 7. Invoices & Bills

| Feature | Description |
|---|---|
| **Auto-Generate Invoice** | Creates invoice from patient's payments with package details and discounts |
| **Manual Invoice Creation** | Select specific payments to include |
| **Invoices List** | Paginated invoice listing |
| **Invoice Detail View** | Full invoice with all bill line-items |
| **Delete Invoice** | Soft-deletes invoice + bills |
| **Trash Operations** | Soft-delete, restore, force-delete for invoices and bills |

---

## 8. Multi-Branch Management

| Feature | Description |
|---|---|
| **Branches List** | All branches |
| **Create Branch** | Name, address, phone, email, logo |
| **Edit/Update Branch** | Modify branch details |
| **Delete Branch** | Soft-deletes |
| **API Endpoint** | JSON branch list for front-end forms |
| **Trash/Bulk Operations** | Soft-delete, restore, force-delete with bulk support |

---

## 9. Service Types

| Feature | Description |
|---|---|
| **Service Types List** | Hierarchical (parent-child) service types |
| **Create Service Type** | Name, amount, discount, days, note, parent service |
| **Edit/Update Service Type** | Modify service details |
| **Delete Service Type** | Soft-deletes |
| **AJAX Search** | Autocomplete service lookup |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 10. Payment Modes

| Feature | Description |
|---|---|
| **Payment Modes List** | All modes (cash, online, etc.) |
| **Create Mode** | Name + optional note |
| **Delete Mode** | Soft-deletes |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 11. Tele-Calling & Call Logs

| Feature | Description |
|---|---|
| **Calls List** | All call records (paginated) |
| **Create Call** | Record call: patient, mobile, time, response, detail, note |
| **Patient Calls View** | All calls for a specific patient |
| **Edit/Update Call** | Modify call details |
| **Delete Call** | Soft-deletes |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 12. User Administration & RBAC

| Feature | Description |
|---|---|
| **Users List** | All system users |
| **Create User** | Name, email, password, role assignment, branch assignment |
| **Edit/Update User** | Update details, roles, branches |
| **Delete User** | Soft-deletes |
| **Roles List** | All roles (paginated) |
| **Create/Edit/Delete Role** | Full role CRUD |
| **Assign Permissions to Role** | Checkbox-based permission assignment |
| **Permissions List** | All permissions |
| **Create/Edit/Delete Permission** | Full permission CRUD |
| **Trash/Bulk (Users)** | Soft-delete, restore, force-delete with bulk operations |
| **HomePhysiotherapist Restriction** | Auto-scopes data to own records only |

---

## 13. Website Settings (CMS)

| Feature | Description |
|---|---|
| **General Settings** | Site name and basic configuration |
| **Home Page Settings** | Home page content management |
| **Social Login Settings** | Social authentication config |
| **Payment Settings** | Payment gateway configuration |
| **Ad & Pricing Settings** | Advertisement and pricing management |
| **Storage Settings** | File storage configuration |
| **Social Media Links** | Social network URLs |
| **reCAPTCHA Settings** | Google reCAPTCHA config |
| **Blog Settings** | Blog configuration |
| **Theme Settings** | Theme customization |
| **Key-Value Store** | All settings saved as key-value pairs |

---

## 14. Blog System

| Feature | Description |
|---|---|
| **Blog Posts CRUD** | Full admin CRUD with categories, tags, SEO fields, scheduling |
| **Blog Categories** | Hierarchical categories with order and status |
| **Blog Tags** | Tags with post count |
| **Comments Management** | List, approve, delete blog comments |
| **Public Blog Listing** | Paginated front-end with categories, tags, popular/recent posts |
| **Single Post View** | Full post with related posts and comment form |
| **Category Filter** | Posts filtered by category |
| **Tag Filter** | Posts filtered by tag |
| **Post Comment** | Public comment submission |
| **SEO Management** | Meta title, description, keywords, OG tags per post |
| **Trash Operations** | Soft-delete, restore, force-delete for posts, categories, tags |

---

## 15. Front-End Website Pages

| Feature | Description |
|---|---|
| **Homepage** | Sliders, hero section, services showcase |
| **About Us Page** | Clinic information |
| **Services Page** | Public services listing |
| **Contact Page** | Contact form with email notification |
| **Public Appointment Booking** | Branch selection + appointment form |
| **Appointment Confirmation** | Confirmation with calendar links |

---

## 16. Appointment System

| Feature | Description |
|---|---|
| **Appointments CRUD** | Create, edit, view, delete with status (booked/cancelled/completed) |
| **Quick Status Update** | Change appointment status |
| **Appointment Types CRUD** | Name, duration, price, active status |
| **Availability Windows CRUD** | Per-branch, per-type, per-day-of-week: time range, slot duration, capacity |
| **Holidays CRUD** | Named holidays per branch: full/partial day, recurring option |
| **Branch-Appointment-Type Assignment** | Link appointment types to branches |
| **Available Slots AJAX** | Returns available time slots for branch + type + date |
| **Smart Slot Calculation** | Respects availability windows, capacity, holidays |
| **Trash Operations** | Soft-delete, restore, force-delete for all appointment entities |

---

## 17. Zoom Meetings Integration

| Feature | Description |
|---|---|
| **Meetings List** | All Zoom meetings |
| **Create Meeting** | Creates via Zoom API: topic, agenda, start time, duration, timezone |
| **Edit/Update Meeting** | Updates on Zoom via API |
| **Start Meeting** | Activates meeting, redirects to join URL |
| **End Meeting** | Ends meeting on Zoom via API |
| **Sync Meeting** | Pulls latest data from Zoom API |
| **Delete Meeting** | Deletes on Zoom + soft-deletes locally |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 18. Sliders (Hero/Slideshow)

| Feature | Description |
|---|---|
| **Sliders List** | Ordered list of all sliders |
| **Create Slider** | Sub-title, title, highlight word, description, button text/link, video URL, image |
| **Edit/Update Slider** | Modify all slider fields |
| **Delete Slider** | Soft-deletes |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 19. Contact Messages (Inbox)

| Feature | Description |
|---|---|
| **Messages Inbox** | List with status/search/unread filters |
| **View Message** | Detail view, auto-mark as read |
| **Mark Read/Unread** | Toggle read status |
| **Delete Message** | Soft-deletes |
| **Trash Operations** | Soft-delete, restore, force-delete |

---

## 20. Audit Logs

| Feature | Description |
|---|---|
| **Audit Logs List** | Filterable by action (soft_delete/restore/force_delete), user, model type, date range |
| **Auto-Logging** | Every soft-delete, restore, force-delete automatically logged with user, IP, user agent, details |
| **Role-Based Access** | Protected by `view-audit-logs` permission |

---

## 21. Image Uploads

| Feature | Description |
|---|---|
| **Upload Patient Images** | Upload & auto-resize (1000x1000) for patient records |
| **Generic Image Upload** | Upload with thumbnail generation |

---

## 22. SMS System

| Feature | Description |
|---|---|
| **Send Single SMS** | Via Android gateway |
| **Send Bulk SMS** | Send to multiple numbers |
| **SMS Templates** | Configurable templates with placeholder replacement |
| **SMS Logging** | Every SMS tracked with status, attempts, delivery |
| **Rate Limiting** | Configurable per-hour limit |
| **Duplicate Prevention** | Prevents duplicates within configurable window |
| **SMS Toggle** | Enable/disable SMS on OPD registration & collection forms |
| **Balance Check** | Check remaining SMS credits |

---

## 23. Soft Delete & Trash System

| Feature | Description |
|---|---|
| **Custom Soft Delete Trait** | Tracks who deleted, when, with audit log entry |
| **View Trash** | Only accessible with specific `view-trash-{resource}` permission |
| **Restore** | Only accessible with `restore-{resource}` permission |
| **Force Delete (Permanent)** | Only accessible with `force-delete-{resource}` permission |
| **Bulk Operations** | Bulk destroy, restore, force-delete |
| **Trash Center** | Centralized navigation hub for all trash resources |

---

## 24. Website Services (Front-End)

| Feature | Description |
|---|---|
| **Services CRUD** | Admin management of front-end services with title, slug, banner, images, descriptions |
| **Public Services Page** | Front-end service listing |
| **Service Detail Page** | Public service detail by slug |

---

## 25. Role-Based Access Control (Spatie Permissions)

| Permission Group | Example Permissions |
|---|---|
| **Patients** | `list-Patient`, `show-PatientProfile`, `edit-PatientProfile`, `delete-PatientProfile`, `view-trash-patient`, `restore-patient`, `force-delete-patient` |
| **Expenses** | `list-Expense`, `create-Expense`, `edit-Expense`, `delete-Expense`, `Exp-Report`, `view-trash-expense`, `restore-expense`, `force-delete-expense` |
| **Branches** | `list-branch`, `create-branch`, `edit-branch`, `delete-branch`, `view-trash-branch`, `restore-branch`, `force-delete-branch` |
| **Users** | `list-user`, `create-user`, `edit-user`, `delete-user`, `view-trash-user`, `restore-user`, `force-delete-user` |
| **Roles/Permissions** | `list-role`, `create-role`, `edit-role`, `delete-role`, `list-permission`, etc. |
| **Collections** | `create-Collection`, `collection-lst`, `deleteCollection`, `view-trash-collection`, `restore-collection`, `force-delete-collection` |
| **Payments** | `view-trash-payment`, `restore-payment`, `force-delete-payment` |
| **Invoices** | `viewInvoice`, `deleteInvoice`, `view-trash-invoice`, `restore-invoice`, `force-delete-invoice` |
| **Service Types** | `list-ServiceType`, ... , `view-trash-servicetype`, `restore-servicetype`, `force-delete-servicetype` |
| **Payment Modes** | `list-PaymentMode`, ... , `view-trash-mode`, `restore-mode`, `force-delete-mode` |
| **Expense Categories** | `list-ExpenseCategory`, ... , `view-trash-ecat`, `restore-ecat`, `force-delete-ecat` |
| **Reports** | `view-collectionReport`, `view-CustomCollectionReport`, `Exp-ReportShow`, `rangeDailyReport`, `DueReport` |
| **Audit Logs** | `view-audit-logs` |
| **Misc** | `Opd-Registration`, `Hide-Patients`, `manage-blog` |

---

## Sidebar Navigation Structure

| Menu | Sub-items | Access Roles |
|---|---|---|
| Dashboard | — | All authenticated users |
| OPD | Register Patient, Old OPD Patient | All (Old OPD hidden for HomePhysio) |
| Patients | Patients List, Trash, Search By Reg. Date | All (HomePhysio: My Patients only) |
| Expenses | My Expenses, Trash, Add Expense, Categories, Category Trash | Users with `list-Expense` |
| Hide Patients | Search Patients, Hidden Patients | Users with `Hide-Patients` |
| Roles & Permissions | Roles, Add Role, Permissions, Add Permission | Super-Admin/Owner/DIRECTOR |
| Users | User List, Trash, Add User | Super-Admin/Owner/DIRECTOR |
| Invoices | Invoices, Trash, Bills Trash | All authenticated users |
| Branches | Branch List, Trash, Add Branch | Super-Admin/Owner/DIRECTOR |
| Payment Modes | Payment Modes List, Trash, Add | Super-Admin/Owner/DIRECTOR |
| Tele Calling | — | Non-HomePhysio |
| Service Types | Service Type List, Trash, Add | Non-HomePhysio |
| Reports | Collection, Expense, Refund, Due's, Daily (×6 sub-reports) | All authenticated users |
| Website Settings | Appointment Types, Branch Appt Types, Availability Windows, Holidays, Appointments, Contacts, Sliders | Non-HomePhysio |
| Zoom Meetings | All Meetings, Create, Trash | Non-HomePhysio |
| Contact Messages | Inbox, Trash | Non-HomePhysio |
| **Audit Log** | — | Users with `view-audit-logs` |
| **Trash Center** | Patients, Payments, Collections, Schedules, Calls | Users with respective `view-trash-*` |
| Settings | Base Settings | Non-HomePhysio |

---

## Technical Architecture

- **37 Models** with Eloquent ORM relationships
- **38 Controllers** (~350+ public methods)
- **Spatie Laravel Permission** for granular RBAC
- **Custom SoftDeleteWithUser Trait** tracking who deleted each record
- **Audit Logging** for all soft-delete/restore/force-delete operations
- **AdminLTE 3** dashboard interface
- **Responsive front-end** for public website
- **SMS Gateway Integration** for patient notifications
- **Zoom API Integration** for virtual meetings
- **Intervention Image** for image processing
- **Eloquent Sluggable** for SEO-friendly URLs
